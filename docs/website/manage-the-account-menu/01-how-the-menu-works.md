# How the Menu Works

You build the account menu on the **Endpoints** tab at **WB Plugins > Woo My Account**.

## The list

Each row is one menu item. A colored badge on the row shows its type: Endpoint, Group or Link. Items inside a group sit indented below the group.

The list starts with the standard WooCommerce account items. These items are read from WooCommerce's account menu when the admin screen loads. If another plugin adds an account item to that menu, it also appears in the list.

## What you can do with a row

| Action | How |
|--------|-----|
| Open the item's settings | Click the type badge or the arrow beside it. |
| Reorder | Drag the row by its title. |
| Hide or show | Use the eye icon, or the **Hide from menu** / **Show in menu** link in the settings. |
| Remove | Click **Remove** in the settings, then confirm. |
| Restrict by role | Pick roles in **Visible to roles**. |

## Changes apply when you save

Adding, reordering, hiding, removing and editing only change the screen. Click **Save Changes** at the bottom of the Endpoints tab to store them.

## What customers see

- Items appear in the order shown on the list.
- Hidden items and items restricted to other roles do not appear.
- The current page is marked active. The Orders item stays active on a single order page.
- On a custom endpoint, the page title becomes the item's label.
- On small screens the menu collapses behind an **Account menu** button.

## Default WooCommerce items

You can rename, hide, reorder and restrict the default items. You cannot remove them. Default endpoints have no content box, because WooCommerce supplies their content.

## In this section

- [Add an endpoint](02-add-an-endpoint.md)
- [Endpoint content](03-endpoint-content.md)
- [Groups](04-groups.md)
- [Links](05-links.md)
- [Reorder, hide and remove items](06-reorder-hide-and-remove.md)
- [Restrict items by user role](07-restrict-by-user-role.md)
- [Icons and CSS classes](08-icons-and-css-classes.md)
