# Block Theme: My Account Menu Is Not Replaced

**Symptom:** on a block theme, the My Account page still shows the standard menu, or no custom menu.

**Cause:** the plugin replaces the menu that WooCommerce prints inside its My Account output. If the page does not render that output, there is nothing to replace.

## Fix

1. Go to **WB Plugins > Woo My Account > Overview**. Check **My Account page**. It shows **Classic shortcode**, **Block based** or **Not set**.
2. Edit the page that is your My Account page.
3. Add the **Custom My Account** block, or a Shortcode block with `[wcmp_my_account]`.
4. Update the page and reload it while logged in.

Only one Custom My Account block can sit on a page.

## If the Overview says Not set

No My Account page is assigned in WooCommerce. Assign one in WooCommerce settings, then add the block or shortcode to it.

## Styles missing

The plugin loads its CSS and JavaScript on the My Account page and on any page with the block, `[wcmp_my_account]` or `[woocommerce_my_account]`. If your page uses another method, developers can use the `wcmp_load_public_assets` filter. See [Filters](../developer-guide/01-filters.md).

## Theme prints its own menu

If your theme prints its own account menu outside WooCommerce's My Account output, the plugin cannot replace it. Switch that menu off in the theme, or use the block or shortcode on the page.

## Related

- [The Custom My Account block](../shortcodes-and-blocks/02-my-account-block.md)
- [The [wcmp_my_account] shortcode](../shortcodes-and-blocks/01-wcmp-my-account-shortcode.md)
