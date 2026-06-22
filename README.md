# Floating News Panel for Moodle

Floating News Panel is a Moodle local plugin that displays a customizable floating news panel with images, short text, links, buttons and multiple display modes.

It was created for Moodle sites that need a quick and visual way to publish announcements on the front page or across the whole site without depending on theme block regions.

## Features

- Floating panel displayed over the Moodle interface.
- Front page only or site-wide display mode.
- News items with title, short text, image, link and custom button text.
- Multiple layouts:
  - fade carousel;
  - horizontal sliding carousel;
  - vertical rolling list;
  - static scrollable feed.
- Configurable rotation interval.
- Option to pause rotation on hover.
- Option to start collapsed and remember close during the browser session.
- Right or left panel position.
- Custom panel width, top offset, image height and border radius.
- Custom colours for header, text, button, background and accent indicators.
- Quick management page for adding, editing and deleting news items.
- One-click status toggle from the management table.
- Automatic 1-based ordering.
- Automatic reordering when two items receive the same order.
- Maximum active item limit with automatic deactivation of items beyond the configured limit.
- Management shortcut injected into the page for users with permission.
- Uses Moodle File API for image storage.
- Uses Moodle capabilities to restrict management access.

## Requirements

- Moodle 5.0 or later.
- PHP version supported by the target Moodle version.

## Installation

### From ZIP

1. Download the plugin ZIP package.
2. Install it through **Site administration > Plugins > Install plugins**.
3. Select plugin type **Local plugin** if Moodle asks for it.
4. Complete the installation/upgrade process.
5. Purge Moodle caches.

### Manual installation

1. Copy the plugin folder to:

   ```text
   /local/floatingnews
   ```

2. Visit:

   ```text
   Site administration > Notifications
   ```

3. Complete the installation.
4. Purge all Moodle caches.

## Configuration

Go to:

```text
Site administration > Plugins > Local plugins > Floating News Panel
```

Main settings include:

- enable or disable the panel;
- panel title;
- maximum number of displayed news items;
- display mode: front page only or whole site;
- show or hide for guests;
- layout type;
- rotation interval;
- pause on hover;
- start collapsed;
- remember close during session;
- open links in a new tab;
- panel position, size and spacing;
- image height;
- border radius;
- shadow;
- panel colours.

## Managing news

Users with the `local/floatingnews:manage` capability can access the management page:

```text
/local/floatingnews/manage.php
```

From this page, managers can:

- add a news item;
- edit an existing news item;
- delete a news item;
- activate or deactivate an item directly from the table;
- define publication dates;
- define the display order.

## Ordering rules

The order starts at `1`.

When a new or edited item receives an order already used by another item, the plugin automatically reorganizes the remaining items to keep the order unique and sequential.

When the number of active items exceeds the configured maximum, items after the limit are automatically deactivated.

## Capabilities

| Capability | Description |
| --- | --- |
| `local/floatingnews:manage` | Allows users to manage Floating News Panel items. |

By default, this capability is allowed for the Moodle **Manager** role.

## Privacy

Floating News Panel stores news content configured by authorized managers. It does not store user personal data.

## Repository naming

Recommended GitHub repository name:

```text
moodle-local_floatingnews
```

Recommended Moodle plugin component:

```text
local_floatingnews
```

Recommended Moodle installation folder:

```text
floatingnews
```

## License

GNU GPL v3 or later.

See [LICENSE](LICENSE).
