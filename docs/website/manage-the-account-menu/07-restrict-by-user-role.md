# Restrict Items by User Role

Every endpoint, group and link has a **Visible to roles (empty = everyone)** field. Use it to show an item only to some customers, for example a wholesale page for wholesale customers.

## Set roles on an item

1. Go to **WB Plugins > Woo My Account > Endpoints**.
2. Open the item.
3. In **Visible to roles**, choose one or more roles.
4. Click **Save Changes**.

## How the rule works

- The field is an allowlist. Only users who have one of the chosen roles see the item.
- If you leave the field empty, everyone who is logged in sees the item.
- A user with several roles sees the item when any one role matches.
- The roles come from WordPress, so roles added by plugins such as membership or subscription plugins appear in the list.

## What the rule protects

The rule applies to the page, not only the menu. A logged-in user outside the list who opens the item's URL directly is sent back to My Account. This covers custom endpoints, default WooCommerce items (Orders, Downloads and so on), endpoints added by other plugins, and items inside a restricted group.

**Hide from menu** is different: it only removes the item from the menu, and the URL keeps working.

## Groups

A role limit on a group hides the whole group and blocks every item in it, even items with no role limit of their own. A role limit on an item inside a group hides only that item.

## Default endpoint

If the default endpoint is limited to some roles, users outside those roles are not redirected to it. See [General tab](../settings/02-general-tab.md).

## If an item does not show

See [Role-restricted item is not visible](../troubleshooting/03-role-restricted-item-not-visible.md).
