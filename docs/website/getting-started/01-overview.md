# Overview

Custom My Account Page for WooCommerce changes the navigation on the WooCommerce My Account page. Instead of the fixed WooCommerce list, customers see the menu you build.

## The three kinds of menu item

| Type | What it is |
|------|------------|
| Endpoint | A page inside My Account with its own URL. Custom endpoints hold content you write. |
| Group | A parent item that holds other endpoints and links. |
| Link | A menu item that opens any URL. |

## What the plugin does for you

- Reads the standard WooCommerce account items (Dashboard, Orders, Downloads, Addresses, Account details, Log out) and lists them so you can rename, hide or reorder them.
- Registers each custom endpoint with WooCommerce, so it has a real URL under the My Account page.
- Applies your General and Style settings on the My Account page.
- Loads its CSS and JavaScript only on the My Account page, or on a page that contains the `[wcmp_my_account]` shortcode, the `wcmp/my-account` block or the `[woocommerce_my_account]` shortcode.

## Admin screen

The settings live at **WB Plugins > Woo My Account** and have five tabs:

| Tab | Use it to |
|-----|-----------|
| Overview | See the portal status and menu counts. |
| Endpoints | Build and order the menu. |
| General | Set avatar upload, menu layout, sidebar position and default endpoint. |
| Style | Override menu and log out colors. |
| FAQ | Read quick answers inside the admin. |

Only users who can manage options (Administrators) can open this screen.

## Next steps

- [Requirements and installation](02-requirements-and-installation.md)
- [Quick start](03-quick-start.md)
