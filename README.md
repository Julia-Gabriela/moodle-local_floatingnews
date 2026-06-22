# Floating News Panel

**Floating News Panel** is a Moodle local plugin that displays a customizable floating news panel with images, text, links and multiple display modes.

The plugin was designed to provide a quick and visual way to publish announcements, highlights, events or institutional news without depending on the block regions available in the Moodle theme.

## Current version

**v1.0.0**

## Features

- Floating news panel displayed over the Moodle interface.
- Image, title, text and custom link for each news item.
- Multiple display modes:
  - Smooth carousel;
  - Horizontal sliding carousel;
  - Vertical scrolling list;
  - Fixed list with internal scroll.
- Custom colors for:
  - Header;
  - Header text;
  - Panel background;
  - News title;
  - News text;
  - Button;
  - Button text;
  - Indicators.
- Configurable layout options:
  - Panel width;
  - Top spacing;
  - Image height;
  - Border radius;
  - Shadow;
  - Left or right position.
- Active/inactive status control.
- Quick status toggle directly from the management table.
- Automatic news ordering.
- Maximum visible news limit.
- Automatic deactivation of news items outside the configured display limit.
- Long text behavior options:
  - Automatic text wrapping;
  - Horizontal scrolling.
- Admin management page for creating, editing and deleting news.
- Optional top navigation shortcut for easier access.
- Theme-independent display approach.

## Requirements

- Moodle 5.0 or later.
- PHP version compatible with your Moodle installation.

## Installation

1. Download the plugin ZIP file.
2. Extract or upload it into the following Moodle directory:

```text
/local/floatingnews
```

3. Access Moodle as an administrator.
4. Go to:

```text
Site administration > Notifications
```

5. Complete the installation process.
6. Purge Moodle caches.
7. Configure the plugin in:

```text
Site administration > Plugins > Local plugins > Floating News Panel
```

## Plugin folder structure

The final Moodle path must be:

```text
/local/floatingnews
```

The Moodle component is:

```text
local_floatingnews
```

## Usage

After installation, access the management page through:

```text
/local/floatingnews/manage.php
```

Depending on the site configuration and theme compatibility, a shortcut may also appear in the top navigation menu.

From the management page, administrators can:

- Add a new news item;
- Upload an image;
- Define a title and description;
- Add a custom link;
- Set the button text;
- Choose the display order;
- Activate or deactivate news;
- Edit existing items;
- Delete news items;
- Toggle the active/inactive status directly from the table.

## News item fields

Each news item supports:

- Image;
- Title;
- Short text or description;
- Link URL;
- Button text;
- Display order;
- Active/inactive status;
- Start date;
- End date.

## Display modes

The plugin supports different layout modes depending on the desired visual behavior.

### Smooth carousel

Displays one news item at a time with a smooth transition.

### Horizontal sliding carousel

Displays one news item at a time with a side sliding effect.

### Vertical scrolling list

Displays one news item as a card and allows navigation using mouse wheel scrolling inside the panel.

### Fixed list with internal scroll

Displays news items in a fixed list with internal panel scrolling.

## Long text behavior

The plugin includes a configurable option for handling long text content.

Available options:

```text
Wrap text automatically
Allow horizontal scrolling
```

Recommended setting for most sites:

```text
Wrap text automatically
```

This prevents long words or large text blocks from overflowing outside the panel.

## Configuration

Administrators can configure the plugin in:

```text
Site administration > Plugins > Local plugins > Floating News Panel
```

Available settings may include:

- Enable or disable the panel;
- Display location;
- Display mode;
- Maximum number of visible news items;
- Rotation interval;
- Panel position;
- Panel width;
- Image height;
- Border radius;
- Shadow;
- Header color;
- Button color;
- Text colors;
- Indicator colors;
- Long text behavior;
- Whether links open in the same tab or a new tab;
- Whether the panel starts opened or closed;
- Whether the plugin remembers when the user closes the panel.

## Permissions

The plugin includes a management capability that should be assigned only to users responsible for maintaining the news panel.

By default, this is intended for site administrators or trusted users.

## Repository

Recommended repository name:

```text
moodle-local_floatingnews
```

Recommended plugin name:

```text
Floating News Panel
```

Recommended Moodle component:

```text
local_floatingnews
```

## Release notes

### v1.0.0

- Initial public release.
- Added floating news panel for Moodle.
- Added support for image, title, text and custom link per news item.
- Added multiple display modes:
  - Smooth carousel;
  - Horizontal sliding carousel;
  - Vertical scrolling list;
  - Fixed list with internal scroll.
- Added configurable colors and layout settings.
- Added panel position settings.
- Added image height, panel width and border radius settings.
- Added active/inactive status control.
- Added quick status toggle directly from the management table.
- Added automatic news ordering.
- Added maximum visible news limit.
- Added automatic deactivation of news items outside the configured display limit.
- Added long text behavior configuration:
  - Automatic text wrapping;
  - Horizontal scrolling.
- Improved handling of long words and large text blocks to prevent panel overflow.
- Added admin management page for creating, editing and deleting news.
- Added optional top navigation shortcut for easier access.

## License

This plugin is licensed under the GNU General Public License v3.0 or later.

See the `LICENSE` file for more details.

## Author

Developed as an open-source Moodle local plugin project.

## Disclaimer

This plugin is not affiliated with Moodle HQ. Moodle is a registered trademark of Moodle Pty Ltd.