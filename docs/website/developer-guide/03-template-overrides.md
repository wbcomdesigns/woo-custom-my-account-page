# Template Overrides

The frontend templates load through `wc_get_template()`. Your theme can override them the standard WooCommerce way.

## Templates

| Template | What it prints |
|----------|----------------|
| `wcmp-myaccount-menu.php` | The menu wrapper: avatar header, account menu button and the list. |
| `wcmp-myaccount-menu-item.php` | One endpoint or link. |
| `wcmp-myaccount-menu-group.php` | One group and its sub-menu. |
| `wcmp-myaccount-avatar-form.php` | The avatar upload popup. |

The originals are in `woo-custom-my-account-page/public/templates/`.

## Override a template

1. Copy the file from `public/templates/` into your theme's `woocommerce` folder, for example `your-theme/woocommerce/wcmp-myaccount-menu-item.php`.
2. Edit the copy.

Use a child theme so updates do not overwrite your copy.

Some template files carry a comment that points to a `woo-custom-my-account-page` folder in your theme. The working location is your theme's `woocommerce` folder, because the plugin calls `wc_get_template()` with the default template path.

## Variables

| Template | Variables available |
|----------|---------------------|
| Menu | `$endpoints`, `$my_account_url`, `$avatar` |
| Menu item | `$url`, `$endpoint`, `$options`, `$classes` |
| Menu group | `$endpoint`, `$options`, `$classes`, `$class_icon` |

Keep the `do_action()` calls and the `aria-*` attributes in your copy so hooks and accessibility keep working.
