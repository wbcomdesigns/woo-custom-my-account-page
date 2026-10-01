# Filters

The plugin has 25 documented filters, all prefixed `wcmp_`. Each filter below is checked against the plugin source. Return the (possibly changed) first argument.

## Detection and redirect

| Filter | Arguments | What it does |
|--------|-----------|--------------|
| `wcmp_is_my_account_page` | `bool $is_myaccount` | Override whether the request counts as the My Account page. Runs on `template_redirect` at priority 1. By default it is true only for logged-in users on the account page. |
| `wcmp_get_current_endpoint` | `string $current` | Override which endpoint is the active tab. The default is `dashboard`. |
| `wcmp_my_account_have_menu` | `bool $have_menu` | Return `true` to skip the custom menu and print no menu. |
| `wcmp_default_endpoint` | `string $default_endpoint` | Change the endpoint customers are redirected to. |
| `wcmp_no_redirect_to_default` | `bool $no_redirect` (default `false`) | Return `true` to switch off the default endpoint redirect. |

## Endpoint lookup

| Filter | Arguments | What it does |
|--------|-----------|--------------|
| `wcmp_get_endpoint_by_accepted_key` | `array $keys` (default `array( 'key', 'slug' )`) | Change which keys `wcmp_get_endpoint_by()` accepts. |
| `wcmp_get_endpoint_by_result` | `array $find` | Change the matched endpoint before it is returned. |

## Defaults and new items

| Filter | Arguments | What it does |
|--------|-----------|--------------|
| `wcmp_default_endpoints_settings` | `array $endpoints` | Change the default endpoint list built from WooCommerce's account menu. |
| `wcmp_default_general_settings` | `array $settings` | Change the default General settings (`custom_avatar`, `menu_style`, `sidebar_position`, `default_endpoint`). |
| `wcmp_default_style_settings` | `array $settings` | Change the default Style colors. |
| `wcmp_get_default_endpoint_options` | `array $options` | Change the options of a newly added endpoint. |
| `wcmp_get_default_group_options` | `array $options` | Change the options of a newly added group. |
| `wcmp_get_default_link_options` | `array $options` | Change the options of a newly added link. |

## Menu markup

| Filter | Arguments | What it does |
|--------|-----------|--------------|
| `wcmp_endpoint_anchor_tag_class` | `string $class` (default `wcmp-{endpoint}`) | Change the class on a menu item's link. |
| `wcmp_endpoint_menu_class` | `array $classes, string $endpoint, array $options` | Change the classes on an endpoint or link list item. `$endpoint` is the item key. |
| `wcmp_endpoints_group_class` | `array $classes, string $endpoint, array $options` | Change the classes on a group list item. |
| `wcmp_filter_avatar_size` | `int $size` (default `120`) | Change the avatar size in pixels in the menu header. |
| `wcmp_filter_display_name` | `string $display_name` | Change the name shown in the menu header. |

## Assets, style and avatar

| Filter | Arguments | What it does |
|--------|-----------|--------------|
| `wcmp_load_public_assets` | `bool $load` (default `false`) | Return `true` to load the plugin CSS and JS on a page it does not detect. |
| `wcmp_get_custom_css` | `string $inline_css` | Change the inline CSS the plugin prints for your Style colors. |
| `wcmp_get_avatar_filter` | `bool $suppress` | Return `true` to stop the plugin replacing avatars. The default is true when **Member avatar upload** is off. |

## Dashboard shortcode

| Filter | Arguments | What it does |
|--------|-----------|--------------|
| `wcmp_dashboard_shortcode_template` | `string $template_name` (default `myaccount/dashboard.php`) | Change the WooCommerce template that `[default_dashboard_content]` loads. |

## Admin builder rows

| Filter | Arguments | What it does |
|--------|-----------|--------------|
| `wcmp_admin_print_endpoint_field` | `array $args` | Change the template arguments of an endpoint row in the Endpoints tab. |
| `wcmp_admin_print_endpoints_group` | `array $args` | Change the arguments of a group row. |
| `wcmp_admin_print_link_field` | `array $args` | Change the arguments of a link row. |

## More filters in the source

These three filters exist in the code and are not listed in the plugin's `docs/HOOKS.md`.

| Filter | Arguments | What it does |
|--------|-----------|--------------|
| `wcmp_myaccount_menu_template_args` | `array $args` with `endpoints`, `my_account_url`, `avatar` | Change the variables passed to the menu template. |
| `wcmp_print_single_endpoint_args` | `array $args` with `url`, `endpoint`, `options`, `classes` | Change the variables passed to the menu item template. |
| `wcmp_print_endpoints_group_group` | `array $args` with `endpoint`, `options`, `classes`, `class_icon` | Change the variables passed to the group template. |

## Examples

Turn off the redirect to the default endpoint:

```php
add_filter( 'wcmp_no_redirect_to_default', '__return_true' );
```

Make the menu avatar smaller:

```php
add_filter(
	'wcmp_filter_avatar_size',
	function () {
		return 96;
	}
);
```

Add a class to the Orders menu item:

```php
add_filter(
	'wcmp_endpoint_menu_class',
	function ( $classes, $endpoint ) {
		if ( 'orders' === $endpoint ) {
			$classes[] = 'is-featured';
		}
		return $classes;
	},
	10,
	2
);
```

Load the plugin assets on a custom page:

```php
add_filter(
	'wcmp_load_public_assets',
	function ( $load ) {
		return is_page( 'account-portal' ) ? true : $load;
	}
);
```
