<?php
// This file is part of Moodle - http://moodle.org/

namespace local_floatingnews\local;

use context_system;
use core\hook\output\before_footer_html_generation;
use core\hook\output\before_standard_top_of_body_html_generation;
use local_floatingnews\manager;
use moodle_url;

/**
 * Hook callbacks for local_floatingnews.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {
    /** @var bool Prevents duplicate output when more than one hook is fired on the same page. */
    private static bool $rendered = false;

    /**
     * Add the floating news panel at the top of the body.
     *
     * @param before_standard_top_of_body_html_generation $hook The hook instance.
     * @return void
     */
    public static function before_standard_top_of_body_html_generation(before_standard_top_of_body_html_generation $hook): void {
        self::add_panel_html($hook);
    }

    /**
     * Fallback hook. Some themes/custom layouts may not output standard_top_of_body_html correctly.
     *
     * @param before_footer_html_generation $hook The hook instance.
     * @return void
     */
    public static function before_footer_html_generation(before_footer_html_generation $hook): void {
        self::add_panel_html($hook);
    }

    /**
     * Add panel HTML to an output hook and initialise the admin shortcut.
     *
     * @param object $hook Hook object with add_html method.
     * @return void
     */
    private static function add_panel_html(object $hook): void {
        global $CFG, $PAGE;

        if (self::$rendered || during_initial_install() || !empty($CFG->upgraderunning)) {
            return;
        }

        $context = context_system::instance();
        $canmanage = has_capability('local/floatingnews:manage', $context);
        $html = '';

        if (get_config('local_floatingnews', 'enabled') && manager::should_display()) {
            $html = manager::render_panel();
        }

        if ($html === '' && !$canmanage) {
            return;
        }

        self::$rendered = true;

        $interval = (int)(get_config('local_floatingnews', 'interval') ?: 5000);
        $PAGE->requires->js_call_amd('local_floatingnews/carousel', 'init', [[
            'interval' => max(1500, $interval),
            'layout' => manager::get_layout(),
            'pauseonhover' => manager::get_bool_config('pauseonhover', true),
            'rememberclose' => manager::get_bool_config('rememberclose', true),
            'startcollapsed' => manager::get_bool_config('startcollapsed', false),
            'canmanage' => $canmanage,
            'manageurl' => (new moodle_url('/local/floatingnews/manage.php'))->out(false),
            'menulabel' => get_string('menulabel', 'local_floatingnews'),
        ]]);

        if ($html !== '') {
            $hook->add_html($html);
        }
    }
}
