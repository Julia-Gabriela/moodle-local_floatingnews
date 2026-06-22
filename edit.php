<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Add/edit Floating News Panel.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/formslib.php');

$id = optional_param('id', 0, PARAM_INT);

require_login();

$context = context_system::instance();
require_capability('local/floatingnews:manage', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/floatingnews/edit.php', ['id' => $id]));
$PAGE->set_pagelayout('admin');
$PAGE->set_title($id ? get_string('editnews', 'local_floatingnews') : get_string('addnews', 'local_floatingnews'));
$PAGE->set_heading(get_string('pluginname', 'local_floatingnews'));

$fileoptions = \local_floatingnews\manager::IMAGE_OPTIONS;
$item = null;
if ($id) {
    $item = $DB->get_record('local_floatingnews_items', ['id' => $id], '*', MUST_EXIST);
} else {
    $item = (object)[
        'id' => 0,
        'title' => '',
        'summary' => '',
        'linkurl' => '',
        'buttontext' => get_string('readmore', 'local_floatingnews'),
        'sortorder' => \local_floatingnews\manager::get_default_sortorder(),
        'enabled' => 1,
        'timestart' => 0,
        'timeend' => 0,
    ];
}

$draftitemid = file_get_submitted_draft_itemid('image_filemanager');
file_prepare_draft_area($draftitemid, $context->id, 'local_floatingnews', 'image', $item->id, $fileoptions);
$item->image_filemanager = $draftitemid;

$mform = new \local_floatingnews\form\news_form(null, ['fileoptions' => $fileoptions]);
$mform->set_data($item);

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/floatingnews/manage.php'));
}

if ($data = $mform->get_data()) {
    $now = time();
    $record = new stdClass();
    $record->title = trim($data->title);
    $record->summary = trim($data->summary ?? '');
    $record->linkurl = trim($data->linkurl ?? '');
    $record->buttontext = trim($data->buttontext ?? get_string('readmore', 'local_floatingnews'));
    $desiredorder = max(1, (int)($data->sortorder ?? 1));
    $record->sortorder = $desiredorder;
    $record->enabled = !empty($data->enabled) ? 1 : 0;
    $record->timestart = !empty($data->timestart) ? (int)$data->timestart : 0;
    $record->timeend = !empty($data->timeend) ? (int)$data->timeend : 0;
    $record->timemodified = $now;

    if (!empty($data->id)) {
        $record->id = (int)$data->id;
        $DB->update_record('local_floatingnews_items', $record);
        $itemid = $record->id;
    } else {
        $record->timecreated = $now;
        $itemid = $DB->insert_record('local_floatingnews_items', $record);
    }

    file_save_draft_area_files($data->image_filemanager, $context->id, 'local_floatingnews', 'image', $itemid, $fileoptions);
    \local_floatingnews\manager::normalise_sortorders($itemid, $desiredorder);
    \local_floatingnews\manager::enforce_max_active_items();
    redirect(new moodle_url('/local/floatingnews/manage.php'), get_string('saved', 'local_floatingnews'), null, \core\output\notification::NOTIFY_SUCCESS);
}

echo $OUTPUT->header();
echo $OUTPUT->heading($id ? get_string('editnews', 'local_floatingnews') : get_string('addnews', 'local_floatingnews'));
$mform->display();
echo $OUTPUT->footer();
