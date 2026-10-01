# Links

A link is a menu item that opens any URL, on your site or elsewhere. It does not create an account page.

## Add a link

1. Go to **WB Plugins > Woo My Account > Endpoints**.
2. Click **Add link**.
3. Type the link name, for example `Support`, and click **Save**.
4. Open the new link and set **Link url**.
5. Click **Save Changes**.

A new link starts with the URL `#`. Replace it with the real address, for example `https://example.com/support`.

## Link settings

| Setting | What it does |
|---------|--------------|
| Link url | The address the menu item opens. |
| Link label | The text shown in the menu. |
| Link icon | The icon beside the text. See [Icons and CSS classes](08-icons-and-css-classes.md). |
| Link class | Extra CSS classes on the item. |
| Visible to roles | Shows the link only to the roles you pick. Leave empty to show everyone. |
| Open link in a new tab? | Opens the link in a new browser tab. |

## New tab links

When you turn on **Open link in a new tab?**, the link opens with `target="_blank"` and `rel="noopener noreferrer"`. The menu item also shows a small arrow, and screen readers hear "(opens in a new tab)".

## Put a link in a group

Drag the link under a group, then save. See [Groups](04-groups.md).
