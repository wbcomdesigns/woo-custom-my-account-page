# Developer hooks reference - Custom My Account Page for WooCommerce

**Plugin:** `woo-custom-my-account-page` · **Version:** 1.6.6 · **Requires:** WordPress 6.5+, PHP 8.0+

This is the integrator-facing list of every extension point the plugin exposes: 25 filters and 6 action
hooks, all prefixed `wcmp_`. Use filters to change a value the plugin computes, and actions to inject or
replace markup in the frontend menu. Templates can also be overridden the standard WooCommerce way (copy
from `public/templates/` into `yourtheme/woocommerce/`); the hooks below are for cases where an override is
more than you need.

Every hook is verified against the 1.6.6 source. File and line references point to where each one fires.

## How to read this

Each row shows the value or arguments passed to your callback and what changing it does. For filters, return
the (possibly modified) first argument. For actions, hook a callback that echoes or does work; the render
actions listed at the end already have a default callback at priority 10, so `remove_action` first if you
want to replace rather than add.

---

## Detection and redirect

These steer where the plugin thinks the My Account page is and where it sends a visitor by default.

| Filter | Passed | What it does |
|---|---|---|
| `wcmp_is_my_account_page` | `bool $is_myaccount` | Override whether the current request is treated as the My Account page. |
| `wcmp_get_current_endpoint` | `string $current` | Override which endpoint slug is treated as the active tab. |
| `wcmp_my_account_have_menu` | `bool $have_menu` | Override whether the custom menu renders in place of WooCommerce's default navigation. |
| `wcmp_default_endpoint` | `string $default_endpoint` | Override the endpoint a visitor lands on by default. |
| `wcmp_no_redirect_to_default` | `bool $no_redirect` (default `false`) | Return `true` to switch off the default-endpoint redirect entirely. |

## Endpoint lookup

| Filter | Passed | What it does |
|---|---|---|
| `wcmp_get_endpoint_by_accepted_key` | `array $keys` (default `['key','slug']`) | Change which option keys `wcmp_get_endpoint_by()` is allowed to match against. |
| `wcmp_get_endpoint_by_result` | `mixed $find` | Filter the matched endpoint before it is returned. |

## Seeded defaults and new-item shapes

Amend what is seeded on activation, and the option shape used when the owner adds a new builder item.

| Filter | Passed | What it does |
|---|---|---|
| `wcmp_default_endpoints_settings` | `array $endpoints` | Amend the endpoint / group / link set seeded on activation. |
| `wcmp_default_general_settings` | `array $settings` | Amend the default General settings (layout, sidebar position, avatar toggle, default endpoint). |
| `wcmp_default_style_settings` | `array $settings` | Amend the default Style colour values. |
| `wcmp_get_default_endpoint_options` | `array $options` | Amend the option shape for a newly added endpoint. |
| `wcmp_get_default_group_options` | `array $options` | Amend the option shape for a newly added group. |
| `wcmp_get_default_link_options` | `array $options` | Amend the option shape for a newly added link. |

## Frontend menu rendering

Filters that shape the markup and text of the account menu.

| Filter | Passed | What it does |
|---|---|---|
| `wcmp_endpoint_anchor_tag_class` | `string $class` (default `wcmp-{endpoint}`) | Filter the CSS class on a menu item's anchor tag. |
| `wcmp_endpoint_menu_class` | `array $classes, array $endpoint, array $options` | Filter the CSS classes on a single endpoint's list item. |
| `wcmp_endpoints_group_class` | `array $classes, array $endpoint, array $options` | Filter the CSS classes on a group's list item. |
| `wcmp_filter_avatar_size` | `int $size` (default `120`) | Change the avatar size in pixels shown in the menu header. |
| `wcmp_filter_display_name` | `string $display_name` | Change the member name shown in the menu header. |

## Assets, style, and avatar

| Filter | Passed | What it does |
|---|---|---|
| `wcmp_load_public_assets` | `bool $load` (default `false`) | Return `true` to force the portal's CSS and JS onto a surface that auto-detection misses. |
| `wcmp_get_custom_css` | `string $inline_css` | Amend the inline style-token CSS the plugin prints on the account page. |
| `wcmp_get_avatar_filter` | `bool $suppress` | Return `true` to suppress this plugin's uploaded avatar for the request. Default mirrors the Custom Avatar setting, so this is the seam for handing avatar rendering to another source. |

## Dashboard shortcode

| Filter | Passed | What it does |
|---|---|---|
| `wcmp_dashboard_shortcode_template` | `string $template_name` (default `myaccount/dashboard.php`) | Override the WooCommerce template rendered by the `[default_dashboard_content]` shortcode. |

## Admin builder rows

Fired while the endpoint builder prints each row in the admin.

| Filter | Passed | What it does |
|---|---|---|
| `wcmp_admin_print_endpoint_field` | `array $args` | Amend the template args for an endpoint row in the admin builder. |
| `wcmp_admin_print_endpoints_group` | `array $args` | Amend the template args for a group row in the admin builder. |
| `wcmp_admin_print_link_field` | `array $args` | Amend the template args for a link row in the admin builder. |

---

## Action hooks (frontend menu template)

These fire while `public/templates/wcmp-myaccount-menu.php` renders. The two render actions have a default
callback at priority 10 that outputs the item / group template; `remove_action` them if you want to replace
that markup rather than add to it.

| Action | Passed | When it fires |
|---|---|---|
| `wcmp_before_endpoints_menu` | none | Before the entire menu wrapper. |
| `wcmp_before_endpoints_items` | none | Before the list of menu items. |
| `wcmp_print_endpoints_group` | `array $endpoint, array $options` | To render one group and its children. Default callback prints the group template. |
| `wcmp_print_single_endpoint` | `array $endpoint, array $options` | To render one endpoint or link item. Default callback prints the item template. Also fired per child inside a group. |
| `wcmp_after_endpoints_items` | none | After the list of menu items. |
| `wcmp_after_endpoints_menu` | none | After the entire menu wrapper. |
