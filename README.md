# Custom My Account Page for WooCommerce

Build the WooCommerce My Account menu your store needs: new pages, grouped tabs, links, role rules, avatars and colours, with no code.

## What it does

- **Custom endpoints:** add account pages with their own URL under My Account, filled with text, shortcodes or page builder output.
- **Groups and links:** put related items under a collapsible parent, and add links to any URL in the same tab or a new one.
- **Drag-and-drop order:** reorder every endpoint, group and link, including the WooCommerce defaults.
- **Rename or hide default tabs:** Orders, Downloads, Addresses, Account details and the rest.
- **Visible to roles:** show an item only to chosen user roles. The rule is enforced on the URL as well as the menu.
- **Avatar upload:** customers can upload a profile photo from My Account.
- **Layout and style:** sidebar or tab navigation, sidebar on the left or right, Font Awesome icons per item, and colour pickers for menu items and the log out button.
- **Shortcode and block:** place the account area anywhere with `[wcmp_my_account]` or the **Custom My Account** block.

## Who it is for

- Store owners who want a branded account area instead of the plain WooCommerce default.
- Membership and wholesale sites that show different tabs to different roles.
- Agencies whose My Account page has to match the rest of a custom store.

## Get it

Custom My Account Page for WooCommerce is free.

- Download: [wbcomdesigns.com/downloads/woocommerce-custom-my-account-page](https://wbcomdesigns.com/downloads/woocommerce-custom-my-account-page/)
- Releases: [GitHub releases](https://github.com/wbcomdesigns/woo-custom-my-account-page/releases)

## Documentation

- Docs: [docs.wbcomdesigns.com/woo-family/woocommerce-custom-my-account-page](https://docs.wbcomdesigns.com/woo-family/woocommerce-custom-my-account-page/)
- Release notes: [wbcomdesigns.com/release-notes/woocommerce-custom-my-account-page](https://wbcomdesigns.com/release-notes/woocommerce-custom-my-account-page/)

## Requirements

- WordPress 6.5 or later (tested up to 7.1)
- WooCommerce 6.0 or later (tested up to 11.2)
- PHP 8.1 or later (tested on 8.1 to 8.5)

## Installation

1. Download the zip from your Wbcom Designs account.
2. In WordPress go to **Plugins > Add New > Upload Plugin**, choose the zip and activate it. WooCommerce must be active.
3. Open **WB Plugins > Woo My Account** and build the menu on the **Endpoints** tab.

Step by step: [Requirements and installation](https://docs.wbcomdesigns.com/woo-family/woocommerce-custom-my-account-page/getting-started/02-requirements-and-installation/).

## For developers

- **Hooks:** every filter and action carries the `wcmp_` prefix. See the [filters](https://docs.wbcomdesigns.com/woo-family/woocommerce-custom-my-account-page/developer-guide/01-filters/) and [actions](https://docs.wbcomdesigns.com/woo-family/woocommerce-custom-my-account-page/developer-guide/02-actions/) reference, or [`docs/HOOKS.md`](docs/HOOKS.md) in this repo.
- **Templates:** the menu, menu item, group and avatar form load through `wc_get_template()`. Copy a file from `public/templates/` into `your-theme/woocommerce/` to override it. See [template overrides](https://docs.wbcomdesigns.com/woo-family/woocommerce-custom-my-account-page/developer-guide/03-template-overrides/).
- **Shortcodes and block:** `[wcmp_my_account]`, `[default_dashboard_content]` and the `wcmp/my-account` block. See [shortcodes](https://docs.wbcomdesigns.com/woo-family/woocommerce-custom-my-account-page/shortcodes-and-blocks/01-wcmp-my-account-shortcode/) and [the block](https://docs.wbcomdesigns.com/woo-family/woocommerce-custom-my-account-page/shortcodes-and-blocks/02-my-account-block/).
- **Text domain:** `woo-custom-my-account-page`.

## Support

- [Support ticket](https://wbcomdesigns.com/support/)
- [Bug reports and feature requests](https://github.com/wbcomdesigns/woo-custom-my-account-page/issues)

## License

GPL-2.0-or-later.
