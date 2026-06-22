<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Hook callbacks for local_floatingnews.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$callbacks = [
    [
        'hook' => \core\hook\output\before_standard_top_of_body_html_generation::class,
        'callback' => [\local_floatingnews\local\hook_callbacks::class, 'before_standard_top_of_body_html_generation'],
        'priority' => 500,
    ],
    [
        'hook' => \core\hook\output\before_footer_html_generation::class,
        'callback' => [\local_floatingnews\local\hook_callbacks::class, 'before_footer_html_generation'],
        'priority' => 500,
    ],
];
