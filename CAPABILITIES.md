# Custom My Account Page for WooCommerce — Capabilities

**Slug:** `woo-custom-my-account-page` · **Version:** 1.6.5 · **Main file:** `woo-custom-my-account-page.php`
**Requires:** WordPress 6.5+, PHP 8.0+, WooCommerce (active) · **REST:** none · **Custom tables:** none

Turns the default WooCommerce **My Account** page into a branded customer portal. Store owners reorder,
rename, disable, and add account-menu items (endpoints, collapsible groups, external links), restrict any
item to specific user roles, let members upload their own avatar, and override the menu colours — all from a
drag-and-drop admin screen on the shared Wbcom settings shell. The portal renders on the classic My Account
shortcode, on block-based account pages, and anywhere the `[wcmp_my_account]` shortcode or **Custom My
Account** block is placed.

Maturity legend: **Stable** (shipped long-lived, unchanged) · **Rebuilt 1.6.4** (re-architected in the last
cycle) · **Hardened 1.6.5** (fixed/tightened this release).

---

## Capabilities

| Capability | What it does | Maturity |
|---|---|---|
| Endpoint builder | Reorder / rename / disable default WC endpoints and add custom endpoints, collapsible groups, and external links via drag-and-drop (jQuery Nestable). Per-item icon, CSS class, and user-role allowlist. | Stable |
| Custom endpoint content | Each custom endpoint has a content area (HTML, shortcodes, page-builder output). Stored content is `wp_kses_post`-sanitized (raw for `unfiltered_html` users) then shortcode-expanded, so form-plugin controls survive. | Hardened 1.6.4 |
| Custom WC endpoints | Custom items register as real WooCommerce rewrite endpoints (`add_rewrite_endpoint` + injected query vars); rewrite flush deferred through a 60s transient after save. | Stable |
| Role visibility | Any endpoint / group / link carries a role **allowlist** (empty = everyone). Applied to both the menu and the default-endpoint redirect. | Stable (redirect gap fixed 1.6.4) |
| Member avatar upload | Members upload a photo from the account menu header; it replaces their Gravatar site-wide. MIME allowlist (JPEG/PNG/GIF/WebP), 2MB cap, logged-in + nonce gated, PRG redirect. Reset restores Gravatar. | Hardened 1.6.5 |
| Menu layout | Sidebar (left/right) or horizontal Tab layout; collapsible Account menu on phones. | Rebuilt 1.6.4 |
| Style overrides | Six colour pickers. Frontend colours follow the active theme through a CSS-custom-property token bridge; pickers act as overrides only when changed from the default. | Rebuilt 1.6.4 |
| Portal placement | `[wcmp_my_account]` shortcode and `wcmp/my-account` block place the full portal on any page, including block themes (both delegate to `[woocommerce_my_account]`). | Rebuilt 1.6.4 |
| Scoped icon font | Bundled "WCMP Icons" font scoped to `.wcmp-myaccount-template`, so it never clashes with a theme's own Font Awesome. Admin icon picker previews the same set the storefront renders. | Stable |
| Self-hosted updates | Automatic updates via the bundled EDD SL SDK; a free license key is preset on activation — nothing to configure. | Stable |
| Legacy migration | One-time in-place migration of the pre-1.x `wcmp_endpoint` store (with a version-suffixed backup). | Stable |

---

## Admin surfaces

Shared Wbcom **Pattern A** settings shell (`Wbcom_Settings_Page::boot`, prefix `wcmp`, slug
`woo-custom-myaccount-page`, under **WB Plugins**). Capability: `manage_options`.

| Tab | Group | Contents |
|---|---|---|
| **Overview** | main | Read-only portal status: account-page render mode (classic shortcode vs block-based), menu entry counts (total / custom / role-restricted), default endpoint, update state, support links. |
| **Endpoints** | main | Drag-and-drop builder — reorder, rename, disable, add endpoints / groups / links; per-item icon, CSS class, role allowlist. Backed by AJAX `wcmp_add_field` (nonce `ajax_nonce`, cap `manage_woocommerce`). |
| **General** | main | Avatar-upload toggle, menu layout (sidebar / tab), sidebar position (left / right), default endpoint. |
| **Style** | main | Six colour pickers (menu item, menu hover, logout text/hover, logout background/hover). |
| **FAQ** | help | Static help content. |

---

## Frontend surfaces (My Account)

- **Custom menu** — replaces WooCommerce's default account navigation (`woocommerce_account_navigation`; core nav removed in `Functions::init`). Renders custom endpoints, collapsible groups, and links in sidebar or tab layout.
- **Custom avatar** — a change-photo control in the menu header opens an upload/reset form (WC-AJAX `wcmp_print_avatar_form`); the uploaded image flows through the `get_avatar` filter everywhere WordPress shows the avatar.
- **Endpoints** — custom endpoints render their stored content in `woocommerce_account_content`; default-endpoint redirect is role-aware and works on block-based account pages (`is_account_page()` detection).
- **Dashboard** — `[default_dashboard_content]` embeds WooCommerce's stock dashboard template inside a custom endpoint.
- **Assets load conditionally** — only on the account page, on the portal shortcode/block, or when `wcmp_load_public_assets` forces it (`wcmp_should_load_assets`).
- **Overridable templates** — `public/templates/{wcmp-myaccount-menu, wcmp-myaccount-menu-item, wcmp-myaccount-menu-group, wcmp-myaccount-avatar-form}.php` via the standard `yourtheme/woocommerce/` override path.

---

## Data stored

No custom tables, no REST. State lives in options, one transient, and one user meta key.

| Store | Kind | Purpose |
|---|---|---|
| `wcmp_general_settings` | option | Avatar toggle, menu layout, sidebar position, default endpoint. |
| `wcmp_style_settings` | option | Six menu colours (menu item + hover bridged to frontend CSS vars; logout colours persisted). |
| `wcmp_endpoints_settings` | option | Endpoint / group / link definitions + drag order. On save, default-endpoint slugs are mirrored to WC core `woocommerce_myaccount_*_endpoint` options. |
| `wcmp-users-avatar-ids` | option | Flat list of uploaded avatar attachment ids (media-library scoping). |
| `wb-wcmp-avatar` | user meta | The member's uploaded avatar attachment id. |
| `wcmp_flush_rewrite_rules` | transient (60s) | Defers a rewrite flush to the next `init` after endpoints change. |
| `wcmp_endpoint`, `wcmp_endpoint_backup_pre_*` | option | Legacy store + one-time migration backup. |
| `woo-custom-my-account-page_license`, `…_license_key` | option | Preset free EDD license for auto-updates. |

Uninstall removes the settings/license/avatar-index options and the transient and flushes rewrites. It does
**not** remove `wb-wcmp-avatar` user meta, uploaded avatar attachments, the legacy `wcmp_endpoint`, or its
backup — noted in `audit/manifest.json` under `data_lifecycle`.

---

## Extension seams

Filters (full list in `audit/manifest.json`). The load-bearing ones:

- **`wcmp_get_avatar_filter`** — return `true` to suppress this plugin's avatar for a request (default mirrors the `custom_avatar` setting). The primary seam for handing avatar rendering to another source.
- **`wcmp_load_public_assets`** — force portal assets onto a surface auto-detection misses.
- **`wcmp_get_custom_css`** — amend the inline style-token overrides.
- **`wcmp_default_endpoint`, `wcmp_no_redirect_to_default`, `wcmp_is_my_account_page`, `wcmp_get_current_endpoint`** — steer detection and the default-endpoint redirect.
- **`wcmp_default_*_settings`, `wcmp_get_default_*_options`** — amend seeded defaults and new-item shapes.
- Template/class hooks: `wcmp_myaccount_menu_template_args`, `wcmp_print_single_endpoint_args`, `wcmp_print_endpoints_group_group`, `wcmp_endpoint_menu_class`, `wcmp_endpoints_group_class`.

---

## Avatar coexistence (must-read)

The custom avatar hooks the shared **`get_avatar`** filter (priority 100). It **must coexist** with other
plugins that also filter avatars — BuddyPress, Simple Local Avatars, and similar.

As of **1.6.5** this is handled by a static re-entrancy guard: `wcmp_get_avatar` returns the incoming
`$avatar` unchanged when the member has no `wb-wcmp-avatar` meta, and **never** calls
`remove_all_filters('get_avatar')`. A previous build stripped every other `get_avatar` callback for the rest
of the request after the first avatar rendered, breaking other avatar plugins. The QA gate verifies both
plugins' avatars keep working with the two active together.
