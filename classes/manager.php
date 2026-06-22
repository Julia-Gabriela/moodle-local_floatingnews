<?php
// This file is part of Moodle - http://moodle.org/

namespace local_floatingnews;

use context_system;
use html_writer;
use moodle_url;

/**
 * Helper methods for local_floatingnews.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class manager {
    /** File options used by the news image filemanager. */
    public const IMAGE_OPTIONS = [
        'subdirs' => 0,
        'maxbytes' => 2097152,
        'maxfiles' => 1,
        'accepted_types' => ['.jpg', '.jpeg', '.png', '.webp'],
    ];

    /**
     * Check whether the panel should be displayed on the current page.
     *
     * @return bool
     */
    public static function should_display(): bool {
        global $PAGE;

        $showmode = get_config('local_floatingnews', 'showmode') ?: 'frontpage';
        if ($showmode === 'frontpage' && $PAGE->pagetype !== 'site-index') {
            return false;
        }

        if (!get_config('local_floatingnews', 'showtoguests') && (!isloggedin() || isguestuser())) {
            return false;
        }

        return true;
    }

    /**
     * Get active news records.
     *
     * @param int|null $limit Number of items to return.
     * @return array
     */
    public static function get_active_items(?int $limit = null): array {
        global $DB;

        $now = time();
        $limit = $limit ?? (int)(get_config('local_floatingnews', 'maxitems') ?: 6);
        $limit = min(max(1, $limit), 20);

        $sql = "SELECT *
                  FROM {local_floatingnews_items}
                 WHERE enabled = 1
                   AND (timestart = 0 OR timestart <= :nowstart)
                   AND (timeend = 0 OR timeend >= :nowend)
              ORDER BY sortorder ASC, timemodified DESC";

        return $DB->get_records_sql($sql, ['nowstart' => $now, 'nowend' => $now], 0, $limit);
    }



    /**
     * Get the default order for a new item. New news start at the first position.
     *
     * @return int
     */
    public static function get_default_sortorder(): int {
        return 1;
    }

    /**
     * Normalise all item orders so they start at 1 and do not repeat.
     * When a priority item is supplied, it is inserted at the requested position and the others shift down.
     *
     * @param int|null $priorityid Item that should receive the requested order.
     * @param int $desiredorder Desired 1-based order.
     * @return void
     */
    public static function normalise_sortorders(?int $priorityid = null, int $desiredorder = 1): void {
        global $DB;

        $desiredorder = max(1, $desiredorder);
        $priorityitem = null;
        if (!empty($priorityid)) {
            $priorityitem = $DB->get_record('local_floatingnews_items', ['id' => $priorityid]);
        }

        $params = [];
        $where = '';
        if ($priorityitem) {
            $where = 'id <> :priorityid';
            $params['priorityid'] = $priorityitem->id;
        }

        $items = $DB->get_records_select(
            'local_floatingnews_items',
            $where,
            $params,
            'sortorder ASC, timecreated DESC, id DESC'
        );

        $ordered = [];
        $position = 1;
        $priorityplaced = false;

        foreach ($items as $item) {
            if ($priorityitem && !$priorityplaced && $position === $desiredorder) {
                $ordered[] = $priorityitem;
                $priorityplaced = true;
                $position++;
            }
            $ordered[] = $item;
            $position++;
        }

        if ($priorityitem && !$priorityplaced) {
            $ordered[] = $priorityitem;
        }

        $sortorder = 1;
        foreach ($ordered as $item) {
            if ((int)$item->sortorder !== $sortorder) {
                $DB->set_field('local_floatingnews_items', 'sortorder', $sortorder, ['id' => $item->id]);
            }
            $sortorder++;
        }
    }

    /**
     * Keep only the configured number of enabled news items active.
     * Items after the visible limit are automatically marked as inactive.
     *
     * @return void
     */
    public static function enforce_max_active_items(): void {
        global $DB;

        $maxitems = (int)(get_config('local_floatingnews', 'maxitems') ?: 6);
        $maxitems = min(max(1, $maxitems), 20);
        $items = $DB->get_records('local_floatingnews_items', ['enabled' => 1], 'sortorder ASC, timecreated DESC, id DESC');

        $position = 1;
        foreach ($items as $item) {
            if ($position > $maxitems) {
                $DB->set_field('local_floatingnews_items', 'enabled', 0, ['id' => $item->id]);
            }
            $position++;
        }
    }

    /**
     * Get status label for a news item.
     *
     * @param \stdClass $item News item.
     * @return string
     */
    public static function get_status_label(\stdClass $item): string {
        $now = time();
        if (empty($item->enabled)) {
            return get_string('inactive', 'local_floatingnews');
        }
        if (!empty($item->timestart) && $item->timestart > $now) {
            return get_string('scheduled', 'local_floatingnews');
        }
        if (!empty($item->timeend) && $item->timeend < $now) {
            return get_string('expired', 'local_floatingnews');
        }
        return get_string('active', 'local_floatingnews');
    }

    /**
     * Return the image URL for a news item.
     *
     * @param \stdClass $item News item.
     * @return moodle_url|null
     */
    public static function get_image_url(\stdClass $item): ?moodle_url {
        $context = context_system::instance();
        $fs = get_file_storage();
        $files = $fs->get_area_files(
            $context->id,
            'local_floatingnews',
            'image',
            $item->id,
            'sortorder, itemid, filepath, filename',
            false
        );

        if (empty($files)) {
            return null;
        }

        $file = reset($files);
        return moodle_url::make_pluginfile_url(
            $context->id,
            'local_floatingnews',
            'image',
            $item->id,
            '/',
            $file->get_filename(),
            false
        );
    }

    /**
     * Render the floating panel HTML.
     *
     * @return string
     */
    public static function render_panel(): string {
        $items = self::get_active_items();
        if (empty($items)) {
            return '';
        }

        $position = get_config('local_floatingnews', 'position') ?: 'right';
        $positionclass = $position === 'left' ? 'local-floatingnews-left' : 'local-floatingnews-right';
        $paneltitle = get_config('local_floatingnews', 'paneltitle') ?: get_string('pluginname', 'local_floatingnews');
        $layout = self::get_layout();
        $showdots = self::get_bool_config('showdots', true) && !in_array($layout, ['feed', 'ticker'], true);
        $opennewtab = self::get_bool_config('opennewtab', true);
        $shadowclass = self::get_bool_config('showshadow', true) ? '' : ' local-floatingnews-no-shadow';

        $cards = [];
        $dots = [];
        $index = 0;
        foreach ($items as $item) {
            $imageurl = self::get_image_url($item);
            $classes = 'local-floatingnews-item' . ($index === 0 ? ' is-active' : '');
            $content = '';

            if ($imageurl) {
                $content .= html_writer::empty_tag('img', [
                    'src' => $imageurl->out(false),
                    'alt' => s($item->title),
                    'class' => 'local-floatingnews-image',
                    'loading' => 'lazy',
                ]);
            }

            $content .= html_writer::tag('h3', format_string($item->title), ['class' => 'local-floatingnews-title']);

            if (!empty($item->summary)) {
                $content .= html_writer::tag('div', format_text($item->summary, FORMAT_PLAIN), [
                    'class' => 'local-floatingnews-summary',
                ]);
            }

            if (!empty($item->linkurl)) {
                $buttontext = !empty($item->buttontext) ? $item->buttontext : get_string('readmore', 'local_floatingnews');
                $linkattrs = ['class' => 'local-floatingnews-link'];
                if ($opennewtab) {
                    $linkattrs['target'] = '_blank';
                    $linkattrs['rel'] = 'noopener noreferrer';
                }
                $content .= html_writer::link(new moodle_url($item->linkurl), format_string($buttontext), $linkattrs);
            }

            $cards[] = html_writer::tag('article', $content, [
                'class' => $classes,
                'data-index' => $index,
            ]);

            $dots[] = html_writer::tag('button', '', [
                'type' => 'button',
                'class' => 'local-floatingnews-dot' . ($index === 0 ? ' is-active' : ''),
                'data-index' => $index,
                'aria-label' => get_string('next', 'local_floatingnews') . ' ' . ($index + 1),
            ]);

            $index++;
        }

        $html = html_writer::start_tag('aside', [
            'id' => 'local-floatingnews-panel',
            'class' => 'local-floatingnews-panel ' . $positionclass . ' local-floatingnews-layout-' . $layout . $shadowclass,
            'aria-label' => s($paneltitle),
            'style' => self::get_inline_style(),
            'data-layout' => $layout,
        ]);
        $html .= html_writer::tag('button', '&times;', [
            'type' => 'button',
            'class' => 'local-floatingnews-close',
            'aria-label' => get_string('close', 'local_floatingnews'),
        ]);
        $html .= html_writer::tag('div', s($paneltitle), ['class' => 'local-floatingnews-heading']);
        $html .= html_writer::tag('div', implode("\n", $cards), ['class' => 'local-floatingnews-items']);
        if ($showdots && count($items) > 1) {
            $html .= html_writer::tag('div', implode("\n", $dots), ['class' => 'local-floatingnews-dots']);
        }
        $html .= html_writer::end_tag('aside');

        $html .= html_writer::tag('button', s($paneltitle), [
            'id' => 'local-floatingnews-tab',
            'type' => 'button',
            'class' => 'local-floatingnews-tab ' . $positionclass,
            'aria-label' => get_string('open', 'local_floatingnews'),
            'style' => self::get_tab_inline_style(),
        ]);

        return $html;
    }

    /**
     * Get selected layout, constrained to known values.
     *
     * @return string
     */
    public static function get_layout(): string {
        $layout = get_config('local_floatingnews', 'layout') ?: 'fade';
        return in_array($layout, ['fade', 'slide', 'ticker', 'feed'], true) ? $layout : 'fade';
    }

    /**
     * Read a boolean plugin setting with a safe default for existing installs.
     *
     * @param string $name Short setting name.
     * @param bool $default Default value when setting was not saved yet.
     * @return bool
     */
    public static function get_bool_config(string $name, bool $default): bool {
        $value = get_config('local_floatingnews', $name);
        if ($value === false) {
            return $default;
        }
        return (bool)$value;
    }

    /**
     * Build safe CSS variables from plugin settings.
     *
     * @return string
     */
    private static function get_inline_style(): string {
        $vars = [
            '--floatingnews-panel-bg' => self::clean_colour(get_config('local_floatingnews', 'panelbg'), '#ffffff'),
            '--floatingnews-header-bg' => self::clean_colour(get_config('local_floatingnews', 'headerbg'), '#2b7fd3'),
            '--floatingnews-header-text' => self::clean_colour(get_config('local_floatingnews', 'headertext'), '#ffffff'),
            '--floatingnews-title-color' => self::clean_colour(get_config('local_floatingnews', 'titlecolor'), '#1f2937'),
            '--floatingnews-text-color' => self::clean_colour(get_config('local_floatingnews', 'textcolor'), '#4b5563'),
            '--floatingnews-button-bg' => self::clean_colour(get_config('local_floatingnews', 'buttonbg'), '#f39200'),
            '--floatingnews-button-text' => self::clean_colour(get_config('local_floatingnews', 'buttontextcolor'), '#ffffff'),
            '--floatingnews-accent' => self::clean_colour(get_config('local_floatingnews', 'accentcolor'), '#2b7fd3'),
            '--floatingnews-width' => self::clean_px(get_config('local_floatingnews', 'panelwidth'), 330, 240, 560),
            '--floatingnews-top' => self::clean_px(get_config('local_floatingnews', 'topoffset'), 140, 40, 500),
            '--floatingnews-radius' => self::clean_px(get_config('local_floatingnews', 'borderradius'), 18, 0, 40),
            '--floatingnews-image-height' => self::clean_px(get_config('local_floatingnews', 'imageheight'), 184, 80, 320),
        ];

        $style = [];
        foreach ($vars as $name => $value) {
            $style[] = $name . ':' . $value;
        }
        return implode(';', $style) . ';';
    }

    /**
     * Build safe style for collapsed tab.
     *
     * @return string
     */
    private static function get_tab_inline_style(): string {
        return '--floatingnews-header-bg:' . self::clean_colour(get_config('local_floatingnews', 'headerbg'), '#2b7fd3') .
            ';--floatingnews-header-text:' . self::clean_colour(get_config('local_floatingnews', 'headertext'), '#ffffff') .
            ';--floatingnews-top:' . self::clean_px(get_config('local_floatingnews', 'tabtopoffset'), 220, 40, 600) . ';';
    }

    /**
     * Keep colour settings limited to simple HEX colours.
     *
     * @param mixed $value Stored colour value.
     * @param string $default Default colour.
     * @return string
     */
    private static function clean_colour($value, string $default): string {
        $value = is_string($value) ? trim($value) : '';
        if (preg_match('/^#[0-9a-fA-F]{6}$/', $value) || preg_match('/^#[0-9a-fA-F]{3}$/', $value)) {
            return $value;
        }
        return $default;
    }

    /**
     * Convert an admin integer setting to a clamped px value.
     *
     * @param mixed $value Stored setting.
     * @param int $default Default integer.
     * @param int $min Minimum integer.
     * @param int $max Maximum integer.
     * @return string
     */
    private static function clean_px($value, int $default, int $min, int $max): string {
        $value = (int)$value;
        if ($value <= 0) {
            $value = $default;
        }
        $value = min(max($value, $min), $max);
        return $value . 'px';
    }
}
