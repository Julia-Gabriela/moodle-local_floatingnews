<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Toggle Floating News Panel item status from the management table.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$id = required_param('id', PARAM_INT);
confirm_sesskey();
require_login();

$context = context_system::instance();
require_capability('local/floatingnews:manage', $context);

$item = $DB->get_record('local_floatingnews_items', ['id' => $id], '*', MUST_EXIST);
$item->enabled = empty($item->enabled) ? 1 : 0;
$item->timemodified = time();
$DB->update_record('local_floatingnews_items', $item);

$desiredorder = !empty($item->enabled) ? 1 : max(1, (int)$item->sortorder);
\local_floatingnews\manager::normalise_sortorders($item->id, $desiredorder);
\local_floatingnews\manager::enforce_max_active_items();

$message = !empty($item->enabled) ? get_string('activated', 'local_floatingnews') : get_string('deactivated', 'local_floatingnews');
redirect(new moodle_url('/local/floatingnews/manage.php'), $message, null, \core\output\notification::NOTIFY_SUCCESS);
