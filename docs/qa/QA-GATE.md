# Pre-release QA gate — Custom My Account Page for WooCommerce

**Plugin:** `woo-custom-my-account-page` · **Version under test:** 1.6.5 · **Host:** WooCommerce (required)
**Companion:** none (free plugin, no Pro pair) · **REST:** none · **Custom tables:** none

Run this top to bottom before every release. Two layers: **[code]** checks you verify from the terminal
(lint, contract audit, wp-cli, DB), and **[browser]** checks where you must open the page and **read the
rendered result** — admin and frontend — to catch friction a passing test never shows. A box is ticked only
when you have the evidence: a command output or a screenshot you actually looked at. Ship only when every box
is ticked or the gap is a logged, accepted exception (Phase 8).

Surfaces this gate maps to (from `audit/manifest.json` + `CAPABILITIES.md`):
Admin — Overview / Endpoints / General / Style / FAQ tabs on the shared Wbcom shell.
Frontend — My Account custom menu, custom avatar, custom endpoints, dashboard, `[wcmp_my_account]` shortcode, `wcmp/my-account` block.

## How to run

1. Fresh WP 6.5+ + PHP 8.0+ + WooCommerce active. Activate this plugin only (add avatar plugins where a check calls for it).
2. Seed a few custom endpoints, one group, one link, and one role-restricted item so the menu is non-trivial.
3. Use `?autologin=1` for admin; create a `customer`-role user for the shopper checks.
4. Verify at 390 / 768 / 1024 / 1280 on a **generic** theme (Storefront + a default block theme), not only BuddyX / Reign.
5. Record evidence in Phase 8; move to Ready for Testing with before/after proof for anything fixed this cycle.

---

## Phase 01 — Code flow: boot & activation
*Does the plugin come up cleanly, exactly once, and go down without leaving a mess.*

- [ ] **[code]** Activates on a clean WP + WooCommerce install with no PHP notice/warning/fatal in `debug.log`.
- [ ] **[code]** Bootstraps **exactly once** — `run_woo_custom_my_account_page()` runs only through the `plugins_loaded` → `wcmp_plugins_files` WooCommerce-active branch; no duplicate hook registration on admin loads.
- [ ] **[code]** `Requires Plugins: woocommerce` header present; the runtime `is_plugin_active_for_network` self-deactivation notice fires only when WooCommerce is genuinely absent (don't double-guard).
- [ ] **[code]** Bundled `lib/wbcom-settings` shell registers via `wbcom_settings_register('1.0.2', …)`; with a second Wbcom plugin shipping a different copy active, the highest version loads and there is no fatal / no double menu.
- [ ] **[code]** Textdomain loads on `plugins_loaded` (i18n), not earlier; no output before headers.
- [ ] **[code]** Deactivate → reactivate is clean. `uninstall.php` removes the plugin's own options + license + `wcmp-users-avatar-ids` + transient and flushes rewrites. **Known gap:** it does not remove `wb-wcmp-avatar` user meta, uploaded avatar attachments, legacy `wcmp_endpoint`, or `wcmp_endpoint_backup_pre_*` — confirm this is still the intended scope or fix.
- [ ] **[code]** PHP lint (8.0–8.4) + PHPStan clean; WPCS clean.

## Phase 02 — Code flow: data, contracts & scale
*Every key that is read is written, every store is reachable, nothing globally destructive.*

- [ ] **[code]** Contract audit reviewed against `.contract-audit-baseline.json`. The eight suppressions all still carry `TODO: justify or fix` — resolve or re-justify before tagging. In particular: `wcmp_settings_nav_groups` / `wcmp_settings_tab_content` are *fired by the bundled Wbcom shell* (not this plugin) so the static "consumed-never-fired" is a false positive; `wcmp_reset_avatar` is a `template_redirect` POST form, not admin-ajax; `wcmp_endpoint_order` + `wcmp_is_my_account` are written-never-read and are deleted on uninstall.
- [ ] **[code]** Every data store is reachable: `wcmp_general_settings` / `wcmp_style_settings` / `wcmp_endpoints_settings` via admin tabs; `wb-wcmp-avatar` via the frontend avatar flow. No REST surface exists by design — do **not** file that as a missing entry point.
- [ ] **[code] AVATAR — does NOT strip other plugins' hooks.** Grep confirms `wcmp_get_avatar` uses a `static $is_processing` re-entrancy guard and contains **no** `remove_all_filters('get_avatar')` / `remove_all_actions`. This was the 1.6.5 fix — a prior build wiped every other `get_avatar` callback (BuddyPress, local-avatar plugins) for the rest of the request after the first avatar. Keep this assertion permanent.
- [ ] **[code]** Nonce + capability on every write: `wcmp_add_field_ajax` (nonce `ajax_nonce` + `manage_woocommerce` + target allowlist); avatar upload (`wp_handle_upload` nonce + logged-in + MIME allowlist + 2MB cap); avatar reset (`wcmp_reset_avatar` nonce + logged-in). No unauthenticated path mutates data.
- [ ] **[code]** Endpoint content trust model correct: `wp_kses_post` for non-`unfiltered_html` users, raw for `unfiltered_html`, sanitize **before** `do_shortcode` (so form-plugin controls survive).
- [ ] **[code] Scale:** the menu builder and `wcmp_settings_data()` handle a large endpoint set (seed 50+ endpoints/groups/links). No per-row query in a loop; menu assembly stays O(endpoints). *(No list table / paginated grid exists — this plugin's scale surface is the endpoint set, not a 2,000-row list.)*
- [ ] **[browser][admin]** Settings persist: save each tab → reload → values retained. Every registered key (`custom_avatar`, `menu_style`, `sidebar_position`, `default_endpoint`, the six colours, endpoint definitions + order) round-trips. Note the four `logout_*` colours persist but are not currently emitted to frontend CSS — confirm that is intended.

## Phase 03 — Browser: admin presentation
*Open every admin tab and read it. Layout painted, states handled, nothing silently blank.*

- [ ] **[browser][admin]** All five tabs render on the shared shell and **paint** (not just present in the DOM): **Overview**, **Endpoints**, **General**, **Style**, **FAQ**. Switch each and look — a `content-visibility` panel can measure full-size and paint blank.
- [ ] **[browser][admin]** **Overview** shows correct live status: account-page mode badge (Classic shortcode vs Block based), the "N entries — X custom, Y role-restricted" count matching what you seeded, default endpoint, and the Active update badge. "Manage endpoints" button lands on the Endpoints tab.
- [ ] **[browser][admin]** **Endpoints builder**: drag-reorder persists after save; Add Endpoint / Add Group / Add Link each insert a row via AJAX with no duplicate field ids; the in-admin delete dialog (not a native `confirm`) removes an item; icon previews render with the bundled WCMP icon set (not broken squares).
- [ ] **[browser][admin]** "Settings saved" notice appears under the page header in the active tab (via the shared shell's `wp-header-end` handling) — not dropped into the wrong section, not suppressed by `wbcom_hide_all_admin_notices_from_setting_page`.
- [ ] **[browser][admin]** No console errors on any tab; `select2`, `nestable`, color-picker, and admin JS/CSS each enqueue once (screen-gated), no 404s on the bundled vendor assets.
- [ ] **[browser][admin]** Docs / support links in Overview resolve to the live `docs.wbcomdesigns.com` / `wbcomdesigns.com` URLs — not localhost, not a stale slug.

## Phase 04 — Browser: frontend presentation
*The shopper's My Account, on a theme we do not own. Renders, reachable, never traps the user.*

- [ ] **[browser][front]** The **custom My Account menu + custom endpoints render on a generic theme** (Storefront **and** a default block theme), not only BuddyX / Reign. Sidebar and Tab layouts both render; sidebar-right is honoured on flex-wrapped account columns.
- [ ] **[browser][front]** Custom endpoints resolve to their own URL and show their stored content; groups collapse/expand (keyboard + `aria-expanded`); external links open per their same-tab / new-tab setting with the new-tab marker visible and screen-reader announced.
- [ ] **[browser][front]** **A custom avatar uploads and displays.** Enable the toggle, open the change-photo form on My Account, upload a JPG/PNG/GIF/WebP → it appears immediately and replaces the Gravatar; Reset restores the Gravatar. Reject an oversized (>2MB) and a non-image file with an honest notice.
- [ ] **[browser][front] AVATAR COEXISTENCE (1.6.5 fix — keep prominent).** With **another avatar plugin active (BuddyPress or Simple Local Avatars)** alongside this one, **both still work**: this plugin's avatar shows for members who uploaded one, and the other plugin's avatar shows for everyone else — on the same page with multiple avatars (e.g. a comment list). This plugin does **not** strip other `get_avatar` filters. Verify by looking at a page that renders several users' avatars at once.
- [ ] **[browser][front]** `[wcmp_my_account]` shortcode and the **Custom My Account** block both place the full portal on an arbitrary page (including a block theme) — same menu takeover as the native account page.
- [ ] **[browser][front]** Button / link **hover, focus, and visited** states are correct on `<a>`-based menu items (themes override these). Default-endpoint redirect never lands a role-restricted member on an endpoint hidden from them.
- [ ] **[browser][front]** No JS errors in the storefront console; no handler bound to a selector the markup never emits. No store internals leaked to shoppers (file paths, admin notices, local-env warnings). Portal assets load only where `wcmp_should_load_assets` allows.

## Phase 05 — Cross-cutting: responsive · RTL · dark · a11y
*Admin and frontend, at each breakpoint. Shipping surfaces, not afterthoughts.*

- [ ] **[browser][admin][front]** 390 / 768 / 1024 / 1280: no horizontal body scroll; **the My Account layout stacks at 390px** (menu collapses to the phone Account toggle, content column full-width); the endpoint builder rows stack in admin.
- [ ] **[browser][front]** Primary actions (open an endpoint, change photo) reachable one-thumb at 390px; tap targets ≥ 40px.
- [ ] **[browser][admin][front]** RTL: admin shell + frontend menu mirror; the registered RTL frontend stylesheet loads (`wp_style_add_data('wcmp-frontend','rtl','replace')`); spacing uses logical properties.
- [ ] **[browser][front]** Dark mode: frontend colours follow the theme token bridge, including dark themes; Style pickers override only the tokens actually changed (untouched Style tab = theme palette). No raw hex bleeding one theme onto the other.
- [ ] **[browser][admin][front]** Keyboard reachable: every control tabbable, visible focus ring, group collapse works via keyboard with `aria-expanded`, icon-only buttons carry `aria-label` / `screen-reader-text`; semantic `<ul>`/`<nav>` in the menu.

## Phase 06 — Packaging & release artifact
*Verify the zip, not the dev tree.*

- [ ] **[code]** Version agrees across the main-file header, `WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION`, `readme.txt`/`README.txt` stable tag, `package.json`, and `blocks/my-account/block.json`.
- [ ] **[code]** Built zip (via `bin/build-release.sh`, reading `.distignore`) contains no `bin/`, `.distignore`, `node_modules/`, `dist/`, `audit/`, `docs/`, `*.md`, tests, or grunt config.
- [ ] **[code]** Bundled runtime libraries **are present** in the zip, asserted by named file: `vendor/edd-sl-sdk/edd-sl-sdk.php`, `lib/wbcom-settings/class-wbcom-settings-page.php`, the scoped icon font under `assets/vendor/font-awesome/`, `assets/vendor/select2/`, `assets/vendor/lucide.min.js`, and `blocks/my-account/render.php`.
- [ ] **[code][browser]** Pristine install from the **built zip** (fresh WP + WooCommerce): activates, lands on the Endpoints builder, My Account returns 200, the EDD SDK + Wbcom shell classes load, no fatal.
- [ ] **[code]** Changelog in WooCommerce action-prefix style (New/Improve/Fix/Security/Dev/Compat), no em-dashes, no emoji.

## Phase 07 — Friction hunt
*Not "does it work" but "where does a real person stall." Judge against 10,000 store owners, not the happy path.*

- [ ] **[browser][admin][front] First run:** on a fresh activation with zero config, is My Account already sensible? Defaults are seeded and activation lands on the Endpoints builder — confirm the account page looks intentional before any configuration, not a blank or broken menu.
- [ ] **[browser][admin] Owner setup:** can a non-developer build the menu without docs? "Add Endpoint / Group / Link" and the role field ("Visible to roles (empty = everyone)") read by what they do; the Endpoint vs Group vs Link distinction is discoverable.
- [ ] **[browser][front] Shopper path:** walk member → My Account → open a custom endpoint → change avatar → follow a group/link, counting clicks. Any dead end, any endpoint with no content, any silent no-op? The role-restricted default endpoint must never trap a member on a page hidden from them.
- [ ] **[browser][code] Error honesty:** force each failure — oversized avatar, non-image upload, empty endpoint label, a custom endpoint slug colliding with a WC core endpoint. Each says what went wrong; nothing is silently swallowed.
- [ ] **[browser][front] Coexistence conflict:** with **another `get_avatar` plugin** and a theme that ships its own Font Awesome, confirm avatars from both plugins coexist and the scoped WCMP icon font does not clash with the theme's FA. (This is the release's headline risk — do not skip.)
- [ ] **[browser][code] Same-class sweep:** every friction found — is the same shape broken on another endpoint type, role, viewport, layout (sidebar vs tab), or on the shortcode/block placement the tester never opened? Fix the class, prove the sweep (grep / matrix), and record what you did not cover.

## Phase 08 — Release sign-off
*The gate closes here. Everything above green, or the gap named and accepted.*

- [ ] **[code][browser]** Phases 01–07 complete, or each unchecked item logged below as an accepted exception with a reason.
- [ ] **[code]** Functionality catalog current: `audit/manifest.json` + `CAPABILITIES.md` regenerated no earlier than the newest `includes/` / `public/` / `admin/` change.
- [ ] **[code]** Smoke-pass evidence recorded, with before/after proof for the avatar `get_avatar` coexistence fix (Phase 02 + Phase 04) and anything else fixed this cycle.

---

### Accepted exceptions (log here)

| Item | Reason accepted | Owner |
|---|---|---|
| | | |
