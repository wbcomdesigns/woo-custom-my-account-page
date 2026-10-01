# Actions

The plugin has six action hooks. They fire while the account menu template `public/templates/wcmp-myaccount-menu.php` renders.

| Action | Arguments | When it fires |
|--------|-----------|---------------|
| `wcmp_before_endpoints_menu` | none | Before the menu list. |
| `wcmp_before_endpoints_items` | none | Inside the list, before the first item. |
| `wcmp_print_endpoints_group` | `string $endpoint, array $options` | To print one group. `$endpoint` is the group key. |
| `wcmp_print_single_endpoint` | `string $endpoint, array $options` | To print one endpoint or link. Also fires for each item inside a group. |
| `wcmp_after_endpoints_items` | none | Inside the list, after the last item. |
| `wcmp_after_endpoints_menu` | none | After the menu list. |

## Default callbacks

The plugin hooks its own print functions to `wcmp_print_endpoints_group` and `wcmp_print_single_endpoint` at priority 10. Add your callback at another priority to add output. To replace the output, remove the plugin callback first.

## Examples

Print a notice above the menu list:

```php
add_action(
	'wcmp_before_endpoints_menu',
	function () {
		echo '<p class="my-menu-note">Need help? Contact support.</p>';
	}
);
```

Replace how single items are printed:

```php
add_action(
	'init',
	function () {
		$wcmp = instantiate_woo_custom_myaccount_functions();
		remove_action( 'wcmp_print_single_endpoint', array( $wcmp, 'wcmp_print_single_endpoint' ), 10 );
	},
	101
);

add_action(
	'wcmp_print_single_endpoint',
	function ( $endpoint, $options ) {
		echo '<li>' . esc_html( $options['label'] ) . '</li>';
	},
	10,
	2
);
```

The first block removes the plugin callback after the plugin has registered it. If you only need a different layout, copy the template instead. See [Template overrides](03-template-overrides.md).
