# Security and Performance

## Security

- **Settings screen:** WordPress requires the `manage_options` capability to open and save the settings.
- **Add item request:** the admin request that adds a menu item checks a nonce and the `manage_woocommerce` capability, and accepts only the types `endpoint`, `group` and `link`.
- **Saved settings:** labels are run through `sanitize_text_field()`, colors through `sanitize_hex_color()`, link URLs through `esc_url_raw()` and CSS classes through `sanitize_html_class()`.
- **Endpoint content:** users with `unfiltered_html` keep their markup on save. Everyone else is filtered with `wp_kses_post()`. On the storefront the stored content is filtered with `wp_kses_post()` before shortcodes run.
- **Role rules:** the menu and the custom endpoint content both check the visitor's roles. See [Restrict items by user role](../manage-the-account-menu/07-restrict-by-user-role.md).
- **Avatar upload:** requires a logged-in user and a valid nonce. Only JPG, PNG, GIF and WebP files up to 2 MB are accepted. Reset also needs its own nonce.
- **Link targets:** links that open a new tab get `rel="noopener noreferrer"`.

## Performance

- The plugin CSS and JavaScript load only on the My Account page, or on a page with the `wcmp/my-account` block, `[wcmp_my_account]` or `[woocommerce_my_account]`. Use the `wcmp_load_public_assets` filter to add other pages.
- Resized avatar images are saved next to the original upload and reused on later requests.
- The icon font is a small bundled subset, loaded only where the portal renders.

## Multisite

Options are stored per site. Activate and configure the plugin on each site that needs it.

## Data stored

| Item | Where |
|------|-------|
| General, Style and Endpoints settings | Options `wcmp_general_settings`, `wcmp_style_settings`, `wcmp_endpoints_settings` |
| Customer avatar | User meta `wb-wcmp-avatar` (a Media Library attachment ID) |
| List of avatar attachments | Option `wcmp-users-avatar-ids` |

The plugin creates no custom database tables. Uninstalling removes this data.
