<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Admin settings for local_floatingnews.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_floatingnews', get_string('pluginname', 'local_floatingnews'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_heading(
        'local_floatingnews/manageheading',
        get_string('manageheading', 'local_floatingnews'),
        html_writer::link(
            new moodle_url('/local/floatingnews/manage.php'),
            get_string('managenews', 'local_floatingnews'),
            ['class' => 'btn btn-primary']
        )
    ));

    $settings->add(new admin_setting_heading(
        'local_floatingnews/generalheading',
        get_string('generalheading', 'local_floatingnews'),
        ''
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_floatingnews/enabled',
        get_string('enabled', 'local_floatingnews'),
        get_string('enabled_desc', 'local_floatingnews'),
        1
    ));

    $settings->add(new admin_setting_configtext(
        'local_floatingnews/paneltitle',
        get_string('paneltitle', 'local_floatingnews'),
        get_string('paneltitle_desc', 'local_floatingnews'),
        'Latest news',
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configtext(
        'local_floatingnews/maxitems',
        get_string('maxitems', 'local_floatingnews'),
        get_string('maxitems_desc', 'local_floatingnews'),
        6,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configselect(
        'local_floatingnews/showmode',
        get_string('showmode', 'local_floatingnews'),
        get_string('showmode_desc', 'local_floatingnews'),
        'frontpage',
        [
            'frontpage' => get_string('showmode_frontpage', 'local_floatingnews'),
            'all' => get_string('showmode_all', 'local_floatingnews'),
        ]
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_floatingnews/showtoguests',
        get_string('showtoguests', 'local_floatingnews'),
        get_string('showtoguests_desc', 'local_floatingnews'),
        0
    ));

    $settings->add(new admin_setting_heading(
        'local_floatingnews/layoutheading',
        get_string('layoutheading', 'local_floatingnews'),
        get_string('layoutheading_desc', 'local_floatingnews')
    ));

    $settings->add(new admin_setting_configselect(
        'local_floatingnews/layout',
        get_string('layout', 'local_floatingnews'),
        get_string('layout_desc', 'local_floatingnews'),
        'fade',
        [
            'fade' => get_string('layout_fade', 'local_floatingnews'),
            'slide' => get_string('layout_slide', 'local_floatingnews'),
            'ticker' => get_string('layout_ticker', 'local_floatingnews'),
            'feed' => get_string('layout_feed', 'local_floatingnews'),
        ]
    ));

    $settings->add(new admin_setting_configtext(
        'local_floatingnews/interval',
        get_string('interval', 'local_floatingnews'),
        get_string('interval_desc', 'local_floatingnews'),
        5000,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_floatingnews/showdots',
        get_string('showdots', 'local_floatingnews'),
        get_string('showdots_desc', 'local_floatingnews'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_floatingnews/pauseonhover',
        get_string('pauseonhover', 'local_floatingnews'),
        get_string('pauseonhover_desc', 'local_floatingnews'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_floatingnews/startcollapsed',
        get_string('startcollapsed', 'local_floatingnews'),
        get_string('startcollapsed_desc', 'local_floatingnews'),
        0
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_floatingnews/rememberclose',
        get_string('rememberclose', 'local_floatingnews'),
        get_string('rememberclose_desc', 'local_floatingnews'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_floatingnews/opennewtab',
        get_string('opennewtab', 'local_floatingnews'),
        get_string('opennewtab_desc', 'local_floatingnews'),
        1
    ));

    $settings->add(new admin_setting_heading(
        'local_floatingnews/positionheading',
        get_string('positionheading', 'local_floatingnews'),
        ''
    ));

    $settings->add(new admin_setting_configselect(
        'local_floatingnews/position',
        get_string('position', 'local_floatingnews'),
        get_string('position_desc', 'local_floatingnews'),
        'right',
        [
            'right' => get_string('position_right', 'local_floatingnews'),
            'left' => get_string('position_left', 'local_floatingnews'),
        ]
    ));

    $settings->add(new admin_setting_configtext(
        'local_floatingnews/topoffset',
        get_string('topoffset', 'local_floatingnews'),
        get_string('topoffset_desc', 'local_floatingnews'),
        140,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'local_floatingnews/tabtopoffset',
        get_string('tabtopoffset', 'local_floatingnews'),
        get_string('tabtopoffset_desc', 'local_floatingnews'),
        220,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'local_floatingnews/panelwidth',
        get_string('panelwidth', 'local_floatingnews'),
        get_string('panelwidth_desc', 'local_floatingnews'),
        330,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'local_floatingnews/borderradius',
        get_string('borderradius', 'local_floatingnews'),
        get_string('borderradius_desc', 'local_floatingnews'),
        18,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'local_floatingnews/imageheight',
        get_string('imageheight', 'local_floatingnews'),
        get_string('imageheight_desc', 'local_floatingnews'),
        184,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_floatingnews/showshadow',
        get_string('showshadow', 'local_floatingnews'),
        get_string('showshadow_desc', 'local_floatingnews'),
        1
    ));

    $settings->add(new admin_setting_heading(
        'local_floatingnews/colourheading',
        get_string('colourheading', 'local_floatingnews'),
        get_string('colourheading_desc', 'local_floatingnews')
    ));

    $settings->add(new admin_setting_configcolourpicker(
        'local_floatingnews/headerbg',
        get_string('headerbg', 'local_floatingnews'),
        get_string('headerbg_desc', 'local_floatingnews'),
        '#2b7fd3'
    ));

    $settings->add(new admin_setting_configcolourpicker(
        'local_floatingnews/headertext',
        get_string('headertext', 'local_floatingnews'),
        get_string('headertext_desc', 'local_floatingnews'),
        '#ffffff'
    ));

    $settings->add(new admin_setting_configcolourpicker(
        'local_floatingnews/panelbg',
        get_string('panelbg', 'local_floatingnews'),
        get_string('panelbg_desc', 'local_floatingnews'),
        '#ffffff'
    ));

    $settings->add(new admin_setting_configcolourpicker(
        'local_floatingnews/titlecolor',
        get_string('titlecolor', 'local_floatingnews'),
        get_string('titlecolor_desc', 'local_floatingnews'),
        '#1f2937'
    ));

    $settings->add(new admin_setting_configcolourpicker(
        'local_floatingnews/textcolor',
        get_string('textcolor', 'local_floatingnews'),
        get_string('textcolor_desc', 'local_floatingnews'),
        '#4b5563'
    ));

    $settings->add(new admin_setting_configcolourpicker(
        'local_floatingnews/buttonbg',
        get_string('buttonbg', 'local_floatingnews'),
        get_string('buttonbg_desc', 'local_floatingnews'),
        '#f39200'
    ));

    $settings->add(new admin_setting_configcolourpicker(
        'local_floatingnews/buttontextcolor',
        get_string('buttontextcolor', 'local_floatingnews'),
        get_string('buttontextcolor_desc', 'local_floatingnews'),
        '#ffffff'
    ));

    $settings->add(new admin_setting_configcolourpicker(
        'local_floatingnews/accentcolor',
        get_string('accentcolor', 'local_floatingnews'),
        get_string('accentcolor_desc', 'local_floatingnews'),
        '#2b7fd3'
    ));
}
