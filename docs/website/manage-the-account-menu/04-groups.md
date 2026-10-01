# Groups

A group is a parent menu item that holds other endpoints and links. Use it to keep a long menu tidy, for example a "My Purchases" group with Orders and Downloads.

## Add a group

1. Go to **WB Plugins > Woo My Account > Endpoints**.
2. Click **Add group**.
3. Type the group name and click **Save**.
4. The group appears at the bottom of the list.

## Put items in the group

1. Drag an endpoint or link onto the group row so it sits indented under the group.
2. Click **Save Changes**.

Put endpoints and links inside a group. Do not put a group inside another group. The menu shows one level only.

## Group settings

Open the group to set:

| Setting | What it does |
|---------|--------------|
| Group label | The name shown in the menu. |
| Group icon | The icon beside the name. See [Icons and CSS classes](08-icons-and-css-classes.md). |
| Group class | Extra CSS classes on the group. |
| Visible to roles | Limits the whole group to the roles you pick. Leave empty to show everyone. |
| Show open | Shows the group expanded by default. This works for the Sidebar layout only. |

## How groups behave on your store

- In the Sidebar layout, customers click the group to open or close it. A group also opens by itself when the current page is one of its items.
- In the Tab layout, groups are always treated as open and are marked as tab groups.
- If a group is hidden, none of its items show.
- Each item in the group still follows its own role setting.

## Remove a group

Click **Remove** in the group's settings and confirm. The items inside the group move up to the main list. They are not deleted.
