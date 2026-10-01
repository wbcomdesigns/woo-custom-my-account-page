# General Questions

## Does the plugin need WooCommerce?

Yes. If WooCommerce is not active, the plugin deactivates itself and shows an admin notice.

## What is the difference between an endpoint, a group and a link?

An **endpoint** is a page inside My Account with its own URL. A **group** is a parent item that holds other items. A **link** opens any URL and has no page of its own.

## Which themes does it work with?

The plugin is tested with Storefront, BuddyBoss Theme, BuddyX and standard WordPress themes. For block themes, place the [Custom My Account block](../shortcodes-and-blocks/02-my-account-block.md) or the [`[wcmp_my_account]` shortcode](../shortcodes-and-blocks/01-wcmp-my-account-shortcode.md) on the page.

## Can I rename the default WooCommerce tabs?

Yes. Open the item on the Endpoints tab and change **Endpoint label**. See [Reorder, hide and remove items](../manage-the-account-menu/06-reorder-hide-and-remove.md).

## Can I remove a default tab?

You can hide it, but not remove it. Hide it with the eye icon and save.

## Can I show a tab to some customers only?

Yes. Set **Visible to roles** on the item. See [Restrict items by user role](../manage-the-account-menu/07-restrict-by-user-role.md).

## Can I use it with membership or subscription plugins?

Role restrictions use WordPress user roles. If a plugin gives your customers a role, you can pick that role in **Visible to roles**.

## Does it work on multisite?

Yes, per site. Settings are stored for each site separately, so set up the menu on every site where you activate the plugin.

## How do I get updates?

Updates arrive in your WordPress dashboard like any other plugin update. The plugin sets a free license key for you, so you do not enter a key.

## What happens to my data if I delete the plugin?

Deleting the plugin removes its settings, the avatar images customers uploaded through it, and each user's avatar link. Deactivating the plugin keeps everything.

## Can developers extend it?

Yes. See the [Developer Guide](../developer-guide/01-filters.md).
