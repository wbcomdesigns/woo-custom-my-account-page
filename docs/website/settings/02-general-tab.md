# General Tab

The General tab sets how the account menu looks and where customers land.

## Change a setting

1. Go to **WB Plugins > Woo My Account > General**.
2. Change the options below.
3. Click **Save Changes**.

## Options

| Option | Default | What it does |
|--------|---------|--------------|
| Member avatar upload | On | Lets customers upload their own photo from the account menu header. |
| Menu layout | Sidebar | **Sidebar** keeps the menu beside the content. **Tab** places the menu above the content. |
| Sidebar position | Left | Puts the sidebar on the **Left** or **Right**. Used only with the Sidebar layout. |
| Default endpoint | Dashboard | The page customers see when they open My Account. |

## Member avatar upload

When this is on, a change-photo button appears on the avatar in the menu header. See [Avatar upload](../faq/03-avatar-and-compatibility.md) for file rules.

When you turn it off, uploaded photos stop replacing the normal avatar. The image files stay in your Media Library, and customers see them again if you turn the option back on.

## Menu layout

- **Sidebar:** groups can be opened and closed. The **Show open** option on a group applies here.
- **Tab:** groups are treated as open.

On small screens the menu collapses behind an **Account menu** button in both layouts.

## Default endpoint

The list shows your endpoints. Groups, links, Log out and endpoints placed inside a group are not listed. Custom endpoints can be the default.

How it works:

- A logged-in customer who opens the main My Account address is redirected to the default endpoint.
- If the default is Dashboard, no redirect happens.
- The Dashboard link in the menu points to the main My Account address, so with another default it also leads to that default.
- If the default endpoint is limited to certain roles, customers outside those roles are not redirected.
- If the default endpoint is hidden from the menu, nobody is redirected to it.
- Pages built with Elementor in preview mode are not redirected.

Developers can turn the redirect off with the [`wcmp_no_redirect_to_default`](../developer-guide/01-filters.md) filter.
