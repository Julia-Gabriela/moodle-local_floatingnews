<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Legacy callbacks required by local_floatingnews.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Serve files uploaded to Moodle news items.
 *
 * @param stdClass $course Course object.
 * @param stdClass|null $cm Course module object.
 * @param context $context Context object.
 * @param string $filearea File area.
 * @param array $args File path arguments.
 * @param bool $forcedownload Whether to force download.
 * @param array $options Additional options.
 * @return bool
 */
function local_floatingnews_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel !== CONTEXT_SYSTEM || $filearea !== 'image') {
        return false;
    }

    if (!get_config('local_floatingnews', 'showtoguests') && (!isloggedin() || isguestuser())) {
        return false;
    }

    if (empty($args)) {
        return false;
    }

    $itemid = (int)array_shift($args);
    $filename = array_pop($args);
    if (!$filename) {
        return false;
    }

    $filepath = '/';
    if (!empty($args)) {
        $filepath = '/' . implode('/', $args) . '/';
    }

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_floatingnews', 'image', $itemid, $filepath, $filename);
    if (!$file || $file->is_directory()) {
        return false;
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}

/**
 * Add a management shortcut to Moodle navigation where the active theme supports it.
 * The AMD code also injects a top-menu shortcut for themes that do not expose this node.
 *
 * @param global_navigation $navigation Navigation tree.
 * @return void
 */
function local_floatingnews_extend_navigation(global_navigation $navigation): void {
    if (!isloggedin() || isguestuser()) {
        return;
    }

    $context = context_system::instance();
    if (!has_capability('local/floatingnews:manage', $context)) {
        return;
    }

    $node = navigation_node::create(
        get_string('menulabel', 'local_floatingnews'),
        new moodle_url('/local/floatingnews/manage.php'),
        navigation_node::TYPE_CUSTOM,
        null,
        'local_floatingnews_manage'
    );
    $navigation->add_node($node);
}
