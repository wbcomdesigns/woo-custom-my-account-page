# Add Dialog and Save Problems

## "An item with the slug ... already exists."

Another item in the list already has that slug. Type a different name. See [Add an endpoint](../manage-the-account-menu/02-add-an-endpoint.md).

## "This field is required."

The Name field was empty. Type a name and click **Save**.

## "The item could not be added. Please try again."

The request to your server failed. Reload the Endpoints tab and try again. If it keeps failing, check that your account can manage WooCommerce and options, and that a security plugin or firewall is not blocking `admin-ajax.php`.

## My new item has a number as its slug

The name used a script the server could not convert to Latin letters, so the item was numbered, for example `endpoint-1`. Ask your host to enable the PHP `intl` extension to get readable slugs. You can also type your own slug in **Endpoint slug**.

## My changes are not stored

1. Click **Save Changes** at the bottom of the tab. Adding, reordering, hiding and removing do not save by themselves.
2. Each tab has its own Save Changes button. Save the tab you edited before moving to another.

## Drag and drop does not work

This is usually a JavaScript conflict with another plugin or the theme.

1. Open your browser console and look for errors.
2. Deactivate other plugins one by one to find the conflict.
3. Test with a default WordPress theme.

## Settings tab missing

The settings screen is at **WB Plugins > Woo My Account** and needs the Administrator role. If WooCommerce is inactive, the plugin deactivates itself.

## Turn on debug logging

Add this to `wp-config.php`:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
```

Check `wp-content/debug.log`. Turn debugging off when you finish.

## Still need help?

Contact [Wbcom Designs support](https://wbcomdesigns.com/support/) and include:

- WordPress, WooCommerce, PHP and plugin versions
- The theme you use
- The exact error message
- Steps to reproduce the problem
