# Role-Restricted Item Is Not Visible

**Symptom:** a menu item does not appear for a user, or it does not appear for you while you test.

**Cause:** an item with roles selected is shown only to users who have one of those roles.

## Check these

1. Open the item on the Endpoints tab and read **Visible to roles (empty = everyone)**.
2. Confirm the user has one of the selected roles. Open **Users** and check the Role column.
3. If you are testing as an Administrator, remember the rule still applies. Administrators do not see items limited to other roles. Add the Administrator role or test with a matching user.
4. Check the item's group. A role limit on a group hides every item inside it.
5. Check the **Hide from menu** setting. The eye icon must be on.
6. Clear your page cache. Cached pages show the menu of the user who loaded them first.

## Default endpoint redirect

If your default endpoint is restricted to a role, users outside that role stay on the main My Account page. They are not redirected to a page they cannot see.

## Opening the URL directly sends the user back to My Account

That is the role rule working. Users outside the selected roles cannot open the page, even with a bookmark. See [Restrict items by user role](../manage-the-account-menu/07-restrict-by-user-role.md).
