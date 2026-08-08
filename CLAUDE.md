# Custom My Account Page for WooCommerce (woo-custom-my-account-page)

## Plugin Identity
- **Plugin Name:** Custom My Account Page for WooCommerce
- **Main File:** `woo-custom-my-account-page.php`
- **Text Domain:** `woo-custom-my-account-page`
- **Version:** 1.6.3
- **Author:** Wbcom Designs
- **License:** GPL-2.0+
- **Requires WordPress:** 5.0+
- **Requires PHP:** 7.4+
- **Requires WooCommerce:** yes (hard dependency, self-deactivates)
- **Tested up to:** WordPress 6.9.1
- **Pro Version:** none (single tier)
- **Basecamp:** https://3.basecamp.com/5798509/projects/37614349

## What It Does
Turns the default WooCommerce My Account area into a configurable customer portal. Site owners add custom endpoints (new account pages), organize tabs into collapsible groups, insert external links, restrict any item by user role, allow custom avatars, and restyle the whole area.

## Architecture

### Pattern
WordPress Plugin Boilerplate (loader pattern). `Woo_Custom_My_Account_Page_Loader` registers hooks; `Woo_Custom_My_Account_Page::run()` executes them.

### Key Files

| File | Purpose |
|------|---------|
| `woo-custom-my-account-page.php` | Bootstrap, WooCommerce guard, constants |
| `includes/class-woo-custom-my-account-page.php` | Core class, dependency loading, hook definitions |
| `includes/class-woo-custom-my-account-page-loader.php` | Hook registration system |
| `includes/class-woo-custom-my-account-page-functions.php` | Shared helpers (endpoint resolution, ordering) |
| `includes/class-wcmp-error-handler.php` | Centralized error handling |
| `includes/class-woo-custom-my-account-page-activator.php` | Activation (endpoint registration, rewrite flush) |
| `includes/class-woo-custom-my-account-page-deactivator.php` | Deactivation routine |
| `admin/class-woo-custom-my-account-page-admin.php` | Endpoint builder, settings, styling |
| `public/class-woo-custom-my-account-page-public.php` | Front-end menu + endpoint content rendering |
| `admin/wbcom/` | Shared Wbcom admin header/nav framework |

### Assets
- `admin/assets/js/jquery.nestable.js` - drag-and-drop ordering of endpoints/groups
- `admin/assets/js/woo-custom-my-account-page-admin.js`
- `public/assets/js/woo-custom-my-account-page-public.js`
- Matching CSS under `admin/assets/css/` and `public/assets/css/`

Codebase: ~6,100 PHP LOC across 29 files.

## Constants

| Constant | Value |
|----------|-------|
| `WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION` | `'1.6.3'` |
| `WCMP_PLUGIN_NAME` | `'woo-custom-my-account-page'` |
| `WCMP_PLUGIN_FILE` | `__FILE__` |
| `WCMP_PLUGIN_PATH` | `plugin_dir_path( __FILE__ )` |
| `WCMP_PLUGIN_URL` | `plugin_dir_url( __FILE__ )` |

## Hooks & Filters (plugin-defined)

Prefix is `wcmp_`.

### Actions - front-end rendering seams
| Hook | Fired |
|------|-------|
| `wcmp_before_endpoints_menu` / `wcmp_after_endpoints_menu` | Around the account nav menu |
| `wcmp_before_endpoints_items` / `wcmp_after_endpoints_items` | Around the menu items |
| `wcmp_print_endpoints_group` | Rendering a group |
| `wcmp_print_single_endpoint` | Rendering one endpoint item |

### Filters
| Hook | Purpose |
|------|---------|
| `wcmp_default_general_settings` | Default general settings |
| `wcmp_default_endpoints_settings` | Default endpoint settings |
| `wcmp_default_endpoint` | Default single-endpoint definition |
| `wcmp_dashboard_shortcode_template` | Dashboard shortcode template |
| `wcmp_admin_print_endpoints_group` | Admin group row markup |
| `wcmp_admin_print_endpoint_field` | Admin endpoint field markup |
| `wcmp_admin_print_link_field` | Admin link field markup |

## Settings & Data

### Options (`wp_options`)
| Option | Purpose |
|--------|---------|
| `wcmp_general_settings` | General settings |
| `wcmp_endpoints_settings` | Endpoint definitions |
| `wcmp_style_settings` | Colors and styling |
| `wcmp_endpoint` | Endpoint registry |
| `wcmp_endpoint_order` | Display order |
| `wcmp_endpoint_backup_pre_` | Prefixed backup written before destructive endpoint edits |
| `wcmp_is_my_account` | My Account page detection flag |
| `wcmp-users-avatar-ids` | Custom avatar attachment IDs |

No custom tables, no CPTs.

### AJAX actions
`wcmp_add_field`, plus `wbcom_addons_cards` from the shared admin framework.

## Dependencies
- **WooCommerce** - hard dependency, enforced by a runtime guard plus an `active_plugins` check.

## Development Notes
- **Endpoints are rewrite rules.** Adding, renaming, or removing an endpoint requires a rewrite flush, or customers get 404s on their account pages. The activator handles install; any runtime change must flush too.
- **Role restriction is a security boundary, not just display.** Hiding a menu item is not enough - the endpoint content callback must re-check the role. Verify both layers when touching visibility.
- **Endpoint slugs are user-visible URLs.** Changing a default slug breaks existing bookmarks and links; migrate rather than rename. Note `wcmp_endpoint_backup_pre_` exists precisely because endpoint edits are destructive.
- **Test on a generic theme.** The account menu is heavily themed; Storefront and a block theme behave differently from Reign/BuddyX. Check hover/focus/visited states on the nav links - themes override `<a>` styling.
- This repo has **no `readme.txt`** despite being a free/wp.org-style plugin - packaging and the product index both read plugin headers instead. Confirm the intended distribution channel before adding one.
