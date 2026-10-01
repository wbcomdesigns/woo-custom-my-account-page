# The [wcmp_my_account] Shortcode

The `[wcmp_my_account]` shortcode places the full My Account portal on a page. The portal includes your custom menu, groups, links and the avatar.

## When to use it

- Your theme is a block theme and the account menu does not show.
- You want the portal on a page other than the one assigned in WooCommerce.

If your My Account page already contains `[woocommerce_my_account]`, you do not need it.

## Add it to a page

1. Edit the page in WordPress.
2. Add a **Shortcode** block.
3. Type `[wcmp_my_account]`.
4. Update the page.

## How it works

The shortcode runs WooCommerce's `[woocommerce_my_account]` shortcode. The plugin replaces the WooCommerce menu wherever that shortcode renders, so you get the full portal.

The shortcode has no attributes.

## Styles and scripts

The plugin loads its CSS and JavaScript on any page that contains `[wcmp_my_account]`, the `wcmp/my-account` block or `[woocommerce_my_account]`. For other cases, developers can use the [`wcmp_load_public_assets`](../developer-guide/01-filters.md) filter.

## Related

- [My Account block](02-my-account-block.md)
- [Block theme troubleshooting](../troubleshooting/04-block-theme-my-account.md)
