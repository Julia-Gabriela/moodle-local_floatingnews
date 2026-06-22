<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Delete Floating News Panel.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$id = required_param('id', PARAM_INT);
$confirm = optional_param('confirm', 0, PARAM_BOOL);

require_login();

$context = context_system::instance();
require_capability('local/floatingnews:manage', $context);

$item = $DB->get_record('local_floatingnews_items', ['id' => $id], '*', MUST_EXIST);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/floatingnews/delete.php', ['id' => $id]));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('deletenews', 'local_floatingnews'));
$PAGE->set_heading(get_string('pluginname', 'local_floatingnews'));

if ($confirm) {
    require_sesskey();
    $fs = get_file_storage();
    $fs->delete_area_files($context->id, 'local_floatingnews', 'image', $id);
    $DB->delete_records('local_floatingnews_items', ['id' => $id]);
    redirect(new moodle_url('/local/floatingnews/manage.php'), get_string('deleted', 'local_floatingnews'), null, \core\output\notification::NOTIFY_SUCCESS);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('deletenews', 'local_floatingnews'));

$confirmurl = new moodle_url('/local/floatingnews/delete.php', [
    'id' => $id,
    'confirm' => 1,
    'sesskey' => sesskey(),
]);
$cancelurl = new moodle_url('/local/floatingnews/manage.php');

echo $OUTPUT->confirm(
    get_string('confirmdelete', 'local_floatingnews') . html_writer::tag('p', format_string($item->title)),
    $confirmurl,
    $cancelurl
);

echo $OUTPUT->footer();
