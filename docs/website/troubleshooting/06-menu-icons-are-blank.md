# Menu Icons Are Blank

**Symptom:** a menu item shows no icon, or an empty space where the icon should be.

**Cause:** the plugin ships a small icon font, not the full Font Awesome library. An icon class that is not in that font has no picture.

## Fix

1. Open the item on the Endpoints tab.
2. Set the icon field to a class from the bundled list, for example `fa-user` or `fa-shopping-cart`. The full list is in [Icons and CSS classes](../manage-the-account-menu/08-icons-and-css-classes.md).
3. Click **Save Changes**.

## Notes

- The icon preview in the admin list is a WordPress Dashicon that approximates your choice. A preview does not prove the storefront icon exists.
- Leaving the icon field empty shows no icon. That is allowed.
- The bundled font works on its own and does not depend on your theme's Font Awesome version.
- Clear your page cache and browser cache if an icon changed in the admin but not on the store.
