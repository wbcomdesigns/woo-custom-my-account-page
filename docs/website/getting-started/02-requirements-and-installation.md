# Requirements and Installation

## Requirements

- WordPress 6.5 or higher
- PHP 8.1 or higher
- WooCommerce 6.0 or higher (the plugin is tested with WooCommerce 11.1)

WooCommerce must be active. If it is not, the plugin deactivates itself and shows an admin notice.

## Install the plugin

1. Go to **Plugins > Add New Plugin > Upload Plugin**, or upload the `woo-custom-my-account-page` folder to `/wp-content/plugins/`.
2. Make sure WooCommerce is installed and active.
3. Activate **Custom My Account Page for WooCommerce** on the **Plugins** screen.

After you activate the plugin through the Plugins screen, WordPress takes you to the **Endpoints** tab at **WB Plugins > Woo My Account**.

## What activation sets up

- Default General and Style settings, saved only if they do not exist yet. An existing install keeps its settings.
- The list of WooCommerce account items, saved as your starting menu.
- A one-time rewrite rules refresh, so new endpoint URLs work.

The My Account page looks the same as before until you change something.

## Updates

The plugin updates from wbcomdesigns.com like any other plugin. It sets a free license key for you on activation, so you do not enter a key.

## Uninstall

Deleting the plugin from the Plugins screen removes its settings, every avatar image customers uploaded through it, and the avatar link on each user. Deactivating the plugin keeps all of this.

## Multisite

Settings are stored per site. Configure the menu on each site where the plugin is active.
