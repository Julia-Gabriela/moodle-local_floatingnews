<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Manage Floating News Panel.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();

$context = context_system::instance();
require_capability('local/floatingnews:manage', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/floatingnews/manage.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('managenews', 'local_floatingnews'));
$PAGE->set_heading(get_string('pluginname', 'local_floatingnews'));

\local_floatingnews\manager::normalise_sortorders();
\local_floatingnews\manager::enforce_max_active_items();

$items = $DB->get_records('local_floatingnews_items', null, 'sortorder ASC, timecreated DESC, id DESC');
$maxitems = (int)(get_config('local_floatingnews', 'maxitems') ?: 6);

 echo $OUTPUT->header();
 echo $OUTPUT->heading(get_string('managenews', 'local_floatingnews'));
 echo html_writer::tag('p', get_string('managenews_desc', 'local_floatingnews'), ['class' => 'text-muted']);
 echo html_writer::link(new moodle_url('/local/floatingnews/edit.php'), get_string('addnews', 'local_floatingnews'), ['class' => 'btn btn-primary mb-3']);
 echo ' ' . html_writer::link(new moodle_url('/admin/settings.php', ['section' => 'local_floatingnews']), get_string('pluginsettings', 'local_floatingnews'), ['class' => 'btn btn-secondary mb-3']);
 echo $OUTPUT->notification(get_string('maxitemsnotice', 'local_floatingnews', $maxitems), 'info');

if (empty($items)) {
    echo $OUTPUT->notification(get_string('nonews', 'local_floatingnews'), 'info');
} else {
    $table = new html_table();
    $table->head = [
        get_string('image', 'local_floatingnews'),
        get_string('title', 'local_floatingnews'),
        get_string('status', 'local_floatingnews'),
        get_string('sortorder', 'local_floatingnews'),
        get_string('actions', 'local_floatingnews'),
    ];
    $table->attributes['class'] = 'generaltable local-floatingnews-manage-table';

    foreach ($items as $item) {
        $image = '-';
        $imageurl = \local_floatingnews\manager::get_image_url($item);
        if ($imageurl) {
            $image = html_writer::empty_tag('img', [
                'src' => $imageurl->out(false),
                'alt' => s($item->title),
                'style' => 'max-width: 90px; max-height: 55px; border-radius: 6px; object-fit: cover;',
            ]);
        }

        $editurl = new moodle_url('/local/floatingnews/edit.php', ['id' => $item->id]);
        $deleteurl = new moodle_url('/local/floatingnews/delete.php', ['id' => $item->id]);
        $toggleurl = new moodle_url('/local/floatingnews/toggle.php', ['id' => $item->id, 'sesskey' => sesskey()]);

        $statuslabel = \local_floatingnews\manager::get_status_label($item);
        $statusclass = !empty($item->enabled) ? 'btn-success' : 'btn-secondary';
        if ($statuslabel === get_string('scheduled', 'local_floatingnews')) {
            $statusclass = 'btn-info';
        } else if ($statuslabel === get_string('expired', 'local_floatingnews')) {
            $statusclass = 'btn-warning';
        }
        $statusbutton = html_writer::link($toggleurl, $statuslabel, [
            'class' => 'btn btn-sm ' . $statusclass . ' local-floatingnews-status-toggle',
            'title' => get_string('togglestatus', 'local_floatingnews'),
        ]);

        $actions = html_writer::link($editurl, get_string('edit')) . ' | ' .
            html_writer::link($deleteurl, get_string('delete'));

        $table->data[] = [
            $image,
            format_string($item->title),
            $statusbutton,
            html_writer::span((int)$item->sortorder, 'local-floatingnews-order-badge'),
            $actions,
        ];
    }

    echo html_writer::table($table);
}

echo $OUTPUT->footer();
