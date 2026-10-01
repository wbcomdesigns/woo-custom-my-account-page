# Icons and CSS Classes

## Icons

Each endpoint, group and link has an icon field. Type an icon class in it, for example `fa-user`.

Both `fa-user` and `fa fa-user` work. If the class has no `fa-` in it, the plugin adds the prefix for you.

### Bundled icons

The plugin ships its own small icon font, scoped to the account menu so it does not clash with your theme. It includes these icons:

| Icon class | Aliases |
|------------|---------|
| `fa-address-card` | `fa-vcard` |
| `fa-chevron-down` | |
| `fa-chevron-up` | |
| `fa-cog` | `fa-gear` |
| `fa-cubes` | |
| `fa-download` | |
| `fa-edit` | `fa-pencil-square-o` |
| `fa-file-text` | `fa-file-text-o` |
| `fa-life-ring` | |
| `fa-link` | |
| `fa-map-marker` | |
| `fa-newspaper-o` | |
| `fa-power-off` | |
| `fa-question-circle` | |
| `fa-shopping-bag` | |
| `fa-shopping-cart` | |
| `fa-sign-out` | |
| `fa-tachometer` | `fa-dashboard` |
| `fa-tag` | |
| `fa-user` | |

An icon class that is not in this list may show as blank in the menu. Use the table above for icons you can rely on.

### Default icons

| Item | Icon |
|------|------|
| Dashboard | `fa-tachometer` |
| Orders | `fa-file-text` |
| Downloads | `fa-download` |
| Addresses | `fa-address-card` |
| Account details | `fa-edit` |
| Log out | `fa-sign-out` |
| New endpoint, and other default items | `fa-tag` |
| New group | `fa fa-cubes` |
| New link | `fa fa-link` |

### Admin preview

In the admin list, the small icon beside each row is a WordPress Dashicon that approximates your choice. The storefront shows the bundled icon.

## CSS classes

Each item has a class field (Endpoint class, Group class or Link class).

1. Open the item.
2. Type one or more class names separated by spaces, for example `highlight-item`.
3. Click **Save Changes**.
4. Style the class in your theme or in **Appearance > Customize > Additional CSS**.

The plugin cleans each class name when you save. Class names with unsupported characters are changed.
