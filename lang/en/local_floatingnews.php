<?php
// This file is part of Moodle - http://moodle.org/

/**
 * English strings for local_floatingnews.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Floating News Panel';
$string['privacy:metadata'] = 'The Floating News Panel plugin does not store user personal data.';
$string['floatingnews:manage'] = 'Manage Floating News Panel';
$string['manageheading'] = 'News management';
$string['managenews'] = 'Manage news';
$string['generalheading'] = 'General settings';
$string['enabled'] = 'Enable panel';
$string['enabled_desc'] = 'Display the floating quick news panel.';
$string['paneltitle'] = 'Panel title';
$string['paneltitle_desc'] = 'Title shown at the top of the floating panel.';
$string['interval'] = 'Rotation interval';
$string['interval_desc'] = 'Time in milliseconds between slides. Example: 5000 = 5 seconds.';
$string['maxitems'] = 'Maximum news items';
$string['maxitems_desc'] = 'Maximum active news items displayed in the panel.';
$string['position'] = 'Position';
$string['position_desc'] = 'Choose whether the panel appears on the right or left.';
$string['position_right'] = 'Right';
$string['position_left'] = 'Left';
$string['showmode'] = 'Where to display';
$string['showmode_desc'] = 'Choose whether the panel appears only on the front page or site-wide.';
$string['showmode_frontpage'] = 'Front page only';
$string['showmode_all'] = 'Whole site';
$string['showtoguests'] = 'Show to guests';
$string['showtoguests_desc'] = 'If unchecked, the panel appears only to authenticated users.';
$string['layoutheading'] = 'Layout and behaviour';
$string['layoutheading_desc'] = 'Control how news appears and how rotation works.';
$string['layout'] = 'Layout type';
$string['layout_desc'] = 'Choose the visual format for the panel.';
$string['layout_fade'] = 'Fade carousel';
$string['layout_slide'] = 'Horizontal sliding carousel';
$string['layout_ticker'] = 'Vertical rolling list';
$string['layout_feed'] = 'Static scrollable feed';
$string['showdots'] = 'Show indicators';
$string['showdots_desc'] = 'Show navigation dots below the news. Does not apply to static feed layout.';
$string['textoverflow'] = 'Long text behaviour';
$string['textoverflow_desc'] = 'Choose how titles and short text should behave when they contain long words, links or unbroken text.';
$string['textoverflow_wrap'] = 'Break text automatically';
$string['textoverflow_scroll'] = 'Allow horizontal scrolling';
$string['pauseonhover'] = 'Pause on hover';
$string['pauseonhover_desc'] = 'Pause rotation while the user hovers over the panel.';
$string['startcollapsed'] = 'Start collapsed';
$string['startcollapsed_desc'] = 'Initially show only the side tab. The user can open the panel by clicking it.';
$string['rememberclose'] = 'Remember close during session';
$string['rememberclose_desc'] = 'If the user closes the panel, it remains closed during the browser session.';
$string['opennewtab'] = 'Open links in a new tab';
$string['opennewtab_desc'] = 'Open news links in a new browser tab.';
$string['positionheading'] = 'Position and size';
$string['topoffset'] = 'Top offset';
$string['topoffset_desc'] = 'Distance in pixels between the top of the screen and the panel on desktop. Example: 140.';
$string['tabtopoffset'] = 'Collapsed tab top offset';
$string['tabtopoffset_desc'] = 'Distance in pixels between the top of the screen and the side tab when the panel is closed.';
$string['panelwidth'] = 'Panel width';
$string['panelwidth_desc'] = 'Desktop width in pixels. Example: 330.';
$string['borderradius'] = 'Border radius';
$string['borderradius_desc'] = 'Pixel value to make the panel more square or rounded.';
$string['imageheight'] = 'Image height';
$string['imageheight_desc'] = 'Desktop height in pixels for the news image.';
$string['showshadow'] = 'Show shadow';
$string['showshadow_desc'] = 'Add a shadow to make the panel stand out.';
$string['colourheading'] = 'Colours';
$string['colourheading_desc'] = 'Customize the panel colours without editing CSS.';
$string['headerbg'] = 'Header colour';
$string['headerbg_desc'] = 'Background colour of the panel header.';
$string['headertext'] = 'Header text colour';
$string['headertext_desc'] = 'Colour of the title and close button in the header.';
$string['panelbg'] = 'Panel background colour';
$string['panelbg_desc'] = 'Background colour of the news area.';
$string['titlecolor'] = 'News title colour';
$string['titlecolor_desc'] = 'Colour of news item titles.';
$string['textcolor'] = 'News text colour';
$string['textcolor_desc'] = 'Colour of the short news text.';
$string['buttonbg'] = 'Button colour';
$string['buttonbg_desc'] = 'Background colour of the news button.';
$string['buttontextcolor'] = 'Button text colour';
$string['buttontextcolor_desc'] = 'Text colour inside the button.';
$string['accentcolor'] = 'Accent colour';
$string['accentcolor_desc'] = 'Colour used for active indicators and small accents.';
$string['addnews'] = 'Add news';
$string['editnews'] = 'Edit news';
$string['deletenews'] = 'Delete news';
$string['confirmdelete'] = 'Are you sure you want to delete this news item?';
$string['nonews'] = 'No news items found.';
$string['title'] = 'Title';
$string['summary'] = 'Short text';
$string['image'] = 'Image';
$string['linkurl'] = 'Link';
$string['buttontext'] = 'Button text';
$string['sortorder'] = 'Order';
$string['enableditem'] = 'Enabled';
$string['timestart'] = 'Publish from';
$string['timeend'] = 'Publish until';
$string['actions'] = 'Actions';
$string['status'] = 'Status';
$string['active'] = 'Active';
$string['inactive'] = 'Inactive';
$string['expired'] = 'Expired';
$string['scheduled'] = 'Scheduled';
$string['saved'] = 'News item saved successfully.';
$string['deleted'] = 'News item deleted successfully.';
$string['invaliddate'] = 'The end date must be greater than the start date.';
$string['readmore'] = 'Read more';
$string['close'] = 'Close news';
$string['open'] = 'Open news';
$string['next'] = 'Next news';
$string['previous'] = 'Previous news';
$string['pluginsettings'] = 'Plugin settings';
$string['managenews_desc'] = 'Create, edit, enable and disable the quick news displayed in the floating panel.';
$string['maxitemsnotice'] = 'Current active/displayed news limit: {$a}. When saving or enabling a news item, positions above this limit are automatically disabled.';
$string['togglestatus'] = 'Click to enable or disable this news item';
$string['activated'] = 'News item enabled successfully.';
$string['deactivated'] = 'News item disabled successfully.';
$string['invalidsortorder'] = 'The order must start at 1.';
$string['sortorder_help'] = 'Use 1 for the first news item, 2 for the second, and so on. If an order already exists, the plugin automatically reorganises the other items.';
$string['menulabel'] = 'Floating News';
