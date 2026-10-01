# Menu Questions

## Why is my new item missing on the store?

New items are only stored when you click **Save Changes** on the Endpoints tab. Add the item, then save.

## What name and slug does a new item get?

The menu label is exactly what you typed. The URL slug is generated from it. See [Add an endpoint](../manage-the-account-menu/02-add-an-endpoint.md).

## Why do I see "An item with the slug ... already exists."?

Another menu item already uses that slug. Choose a different name.

## Can I change an endpoint's URL?

Yes. Edit **Endpoint slug** on the item and save. The old URL stops working, so bookmarks and links to it break. Update any links you control.

## Can I put a group inside a group?

No. Groups hold endpoints and links, and the menu shows one level only.

## What happens to items when I remove a group?

They move up to the main list. They are not deleted.

## How do I get back to the standard WooCommerce menu?

Remove your custom endpoints, groups and links, unhide the default items, and clear the role settings and custom labels you added. You can also deactivate the plugin to see the standard menu.

## Do endpoints from other plugins appear in the list?

The list is built from WooCommerce's account menu when the admin screen loads. Account items that another plugin adds to that menu appear in the list, and you can rename, hide, reorder and restrict them.

## Can I add images or forms to an endpoint?

Yes. Use the editor's media button for images. For forms, use the form plugin's shortcode. Raw `<form>` and `<input>` tags are removed. See [Endpoint content](../manage-the-account-menu/03-endpoint-content.md).

## Can I add my own CSS to one item?

Yes. Add a class in the item's class field and style it in your theme. See [Icons and CSS classes](../manage-the-account-menu/08-icons-and-css-classes.md).

## Does the Log out button have its own colors?

Yes. Set them on the [Style tab](../settings/03-style-tab.md).
