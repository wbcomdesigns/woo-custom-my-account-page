# Custom My Account Page for WooCommerce (woo-custom-my-account-page)

> **2026-08-18 status:** the 18-card Bugs program shipped on branch `1.6.4`
> (P0 kses order + block-aware detection + custom default endpoint,
> zero-config activation, Pattern A admin on `lib/wbcom-settings/`, portal
> chrome with token bridge + RTL + a11y + one icon vocabulary, `wcmp/my-account`
> block + `[wcmp_my_account]` shortcode). The checklist below predates that
> work - treat it as historical audit context, not open items.

## Plugin Identity
- **Plugin Name:** Custom My Account Page for WooCommerce
- **Main File:** `woo-custom-my-account-page.php`
- **Text Domain:** `woo-custom-my-account-page`
- **Version:** 1.6.3
- **Author:** Wbcom Designs
- **License:** GPL-2.0+
- **Requires WordPress:** 5.0+
- **Requires PHP:** 7.4+
- **Requires WooCommerce:** yes (hard dependency, self-deactivates)
- **Tested up to:** WordPress 6.9.1
- **Pro Version:** none (single tier)
- **Basecamp:** https://3.basecamp.com/5798509/projects/37614349

## Names & Identity

Every surface this product is known by. When these drift, a site owner reports a bug under one name and support searches for another.

| Surface | Value |
|---|---|
| Plugin Name (what the site owner sees) | `Custom My Account Page for WooCommerce` |
| Install slug (`wp-content/plugins/`) | `woo-custom-my-account-page` |
| Git repo | `woo-custom-my-account-page` |
| Text domain | `woo-custom-my-account-page` |
| README.txt title | `Custom My Account Page for WooCommerce` |
| Basecamp board | `Custom My Account Page for WooCommerce` (37614349) |
| Basecamp URL | https://3.basecamp.com/5798509/projects/37614349 |

The Basecamp board was called `WooCommerce Custom My Account Page` until August 2026; it was renamed to match the plugin, readme, and store listing, which all say `Custom My Account Page for WooCommerce`.

## Where the work is tracked

Two places, deliberately, and they reconcile:

| | |
|---|---|
| **Basecamp board** | [Custom My Account Page for WooCommerce](https://3.basecamp.com/5798509/projects/37614349) |
| **Cards to work** | **10** — 3 in Bugs, 7 in Scope |
| **Checklist below** | **48** items on branch `1.6.4` |

**Why the two numbers differ.** A card is the trackable unit a person picks up; a checklist item is one verifiable step inside it. The portfolio-floor items in particular repeat across all 12 plugins — four suite-wide faults, counted once per plugin here.

**To verify progress:** the card is done when every checklist item it names is ticked in this file, on this branch. Neither source is authoritative alone — the board says what is being worked, this file says what "done" means.

## Current Task List

Ordered by how many store owners are affected, not by how interesting the code is.
Derived from a code audit on 2026-08-08 that verified every open Basecamp card against this branch.
**Work happens on this branch (`1.6.4`).**

### 1. Regression we shipped - fix first
- [ ] **`wp_kses_post()` strips `<form>` and `<input>` from endpoint content**, silently breaking every embedded form (Contact Form 7, Gravity, Formidable, login). `includes/class-woo-custom-my-account-page-functions.php:193`. **This is self-inflicted:** the line was plain `do_shortcode()` until 1.6.3 added kses (`d62ba2f`, the "security fixes" commit). Content is already kses'd on save at `admin/...-admin.php:717`, so render-time kses is redundant - drop it and gate the save on `unfiltered_html`.

### 2. Dead on the majority of new installs
- [ ] **Default endpoint does nothing on block themes.** `wcmp_check_myaccount()` (`functions.php:1010-1013`) detects My Account by string-matching the `woocommerce_my_account` **shortcode** in `post_content`; on a block-based My Account that never matches. Also `redirect_to_default()` (`:862`) gates on `wcmp_is_my_account`, a site-wide option used as per-request state and rewritten every shutdown (`:825`) - non-deterministic under concurrent traffic. Replace with `is_account_page()` + block-aware detection and a stateless redirect.

### 3. Cheap wins
- [ ] **WCFM/Dokan endpoints never appear in the builder** - the registry snapshots `wc_get_account_menu_items()` in whatever context the admin page loads (`functions.php:291`). Add a "rescan endpoints" action. (S)
- [ ] **No WPML support at all** - zero i18n registration exists; endpoint labels and slugs are untranslatable. (S)

### 4. Icon vocabulary is a mess
- [ ] The plugin now uses three: Font Awesome 4.7 (frontend, documented to owners), Dashicons (admin preview), and a 25-glyph FA subset (`admin/wbcom/wbcom-admin-settings.php:175-177`) - so any picker entry outside those 25 renders blank, and the Select2 picker still emits `<i class="fa fa-...">` at `admin/assets/js/...-admin.js:288`. Consolidate on Lucide with a migration map for stored `fa fa-*` values. (M)

### Not urgent
The 8 Dependabot alerts are **build-only** (`scope: development` - grunt/npm toolchain, `node_modules` is not shipped). Batch with the next release; do not let "5 high" drive a hotfix.

### What this plugin should have and does not (7 of 16)

**Store owner expects:**

- [ ] **Gutenberg block** - Block themes often never fire the classic WooCommerce hooks this plugin renders through, so the owner sees nothing and has no way to place it by hand.
- [ ] **Admin screen for stored data** - Anything the plugin stores, the owner must be able to see, moderate and export from wp-admin. Otherwise support means phpMyAdmin.
- [ ] **RTL stylesheet** - Arabic, Hebrew and Farsi stores render broken layouts.

**Developer extending it expects:**

- [ ] **REST API** - No mobile app, headless storefront or external integration can reach this data.
- [ ] **Documented hooks/filters** - Developers extending the plugin have to read the source to find the extension points.
- [ ] **Test suite** - Nothing catches a regression before a customer does.
- [ ] **WPCS config** - Coding-standard drift is invisible until a WordPress.org review rejects it.
### Frontend, UX & code health

- [ ] **This plugin owns the account experience**, so access simplification belongs here: 8 `is_user_logged_in()` checks across 4 files, plus role restriction split between menu rendering and endpoint content. Consolidate into one "can this user see this endpoint?" guard used by both - today hiding a menu item and protecting its content are separate decisions, which is exactly how the visibility bug class appears.
- [ ] **245 raw hex against 19 tokens.**
- [ ] **Three icon vocabularies** - Font Awesome 4.7 (frontend, documented to owners), Dashicons (admin preview), and a 25-glyph FA subset; the Select2 picker still emits `<i class="fa fa-...">`, so any glyph outside those 25 renders blank. Consolidate on Lucide with a migration map.
- [ ] **No RTL stylesheet** - one of three plugins missing it.
- [ ] Dead-code leads: 1. Clean on that axis.

### Frontend token bridge - follow the theme, do not repaint it

The store owner sets their brand colour once at theme level and expects every plugin to follow. **Reign and BuddyX each ship a full
token system, and they are different vocabularies** - Reign defines no `--bx-*`, BuddyX defines no `--reign-*` - so the chain must
try both before falling back. Verified against reign-theme (112 tokens), buddyx (118) and both `theme.json` palettes.

| Role | BuddyX | Reign | Preset fallback |
|---|---|---|---|
| Accent | `--bx-color-accent` | `--reign-accent-color` | `primary` / `accent` |
| Page background | `--bx-color-bg-page` | `--reign-site-body-bg-color` | `base` |
| Raised surface | `--bx-color-bg-elevated` | `--reign-site-sections-bg-color` | - |
| Body text | `--bx-color-text` | `--reign-site-body-text-color` | `contrast` |
| Muted text | `--bx-color-fg-muted` | `--reign-site-alternate-text-color` | - |
| Headings | `--bx-color-heading` | `--reign-site-headings-color` | - |
| Border | `--bx-color-border` | `--reign-site-border-color` | - |
| Link | `--bx-color-link` | `--reign-site-link-color` | - |
| Button bg / fg | `--bx-color-button-bg` / `-fg` | `--reign-site-button-bg-color` / `-text-color` | - |
| Success / error | - | `--reign-color-success` / `--reign-color-error` | - |

**Watch the preset slugs too:** Reign's accent slug is `primary`, BuddyX's is `accent`, so `var(--wp--preset--color--primary)`
alone resolves to nothing on BuddyX.

```css
:root,
.wcmp-app {
    /* BuddyX token, then Reign token, then both preset slugs, then a literal. */
    --wcmp-accent: var(--bx-color-accent,
                  var(--reign-accent-color,
                  var(--wp--preset--color--primary,
                  var(--wp--preset--color--accent, #157dfd))));

    --wcmp-bg:     var(--bx-color-bg-page,
                  var(--reign-site-body-bg-color,
                  var(--wp--preset--color--base, #ffffff)));

    --wcmp-text:   var(--bx-color-text,
                  var(--reign-site-body-text-color,
                  var(--wp--preset--color--contrast, #1a1a1a)));

    --wcmp-border: var(--bx-color-border,
                  var(--reign-site-border-color,
                  color-mix(in srgb, var(--wcmp-text) 12%, transparent)));
}
```

- [ ] **Build the bridge block** above, with `surface` and `muted` alongside the four shown.
- [ ] **Components read only `--wcmp-*` tokens.** No component references a theme token, a preset or a hex directly - that single indirection layer is what makes one theme change land everywhere, and what stops a third-party theme falling through to nothing.
- [ ] **Do not add a plugin-side dark class.** Reign and BuddyX both flip dark mode with the same root attribute, `[data-bx-mode="dark"]`. Because our tokens read from theme tokens, dark mode arrives for free. Forcing our own class produces a dark panel on a light page - a state the product never reaches - and you end up "fixing" bugs that do not exist.
- [ ] **Scope any standalone dark values so the theme always wins:** `@media (prefers-color-scheme: dark) { :root:not([data-bx-mode]) { ... } }`. Dark mode is a root token override, never a per-component rule.
- [ ] **Verify on Reign and BuddyX separately** - they resolve through different tokens, so passing on one proves nothing about the other. Change the theme accent, reload, confirm our output moved.
- [ ] **Toggle dark mode with the theme's own control**, never by hand-adding a class. If the theme chrome stays light while our panel darkens, you are in an artificial state - stop and use the real toggle.
- [ ] **Check a third-party theme** (Storefront or a block theme). Most customers run neither of ours; the preset and literal fallbacks are what they get and must look deliberate.

### Admin side of the token bridge

The frontend bridges to the theme. **wp-admin has no theme tokens** — it has its own colour scheme, chosen by each user in their
profile. Same component vocabulary, different source, so components are written once and work in both contexts.

```css
.wcmp-admin {
    /* WordPress exposes these from the user's admin colour scheme.
       They are defined in block-library CSS, so always supply the fallback. */
    --wcmp-accent:        var(--wp-admin-theme-color, #2271b1);
    --wcmp-accent-strong: var(--wp-admin-theme-color-darker-10, #135e96);

    --wcmp-bg:      #ffffff;
    --wcmp-surface: #f6f7f7;
    --wcmp-text:    #1d2327;
    --wcmp-muted:   #646970;
    --wcmp-border:  #dcdcde;
}
```

- [ ] **One vocabulary, two bridges.** `--wcmp-accent`, `-bg`, `-surface`, `-text`, `-muted`, `-border` mean the same thing in both contexts; only the source differs. A component that reads them works on the front end and in wp-admin without a second implementation.
- [ ] **Admin accent follows the user's colour scheme** via `--wp-admin-theme-color`. Always pass the fallback — the variable is defined in block-library CSS and is not guaranteed present on a plain settings screen.
- [ ] **Do not reuse frontend theme tokens in admin.** `--bx-color-*` and `--reign-*` do not exist in wp-admin; referencing them there silently falls through to the literal, so the screen stops following the admin scheme.
- [ ] **Verify by switching admin colour scheme** (Users → Profile) and confirming the panel follows. The reference implementation does not do this — it hardcodes 33 hex values — so do not copy its palette, only its structure.

### No admin-ajax — REST or server-rendered

**Decision (2026-08-08): no `admin-ajax.php` anywhere.** Every call boots the whole WordPress admin stack before doing any work,
often just to read a row. REST skips that, is cacheable, is introspectable, and is the same surface a mobile or headless client
would use later.

**Where this plugin stands: 34 `admin-ajax` references, zero REST routes.** Suite-wide it is 137 references and 0 REST routes
across 12 plugins. Notable here: the largest admin-ajax surface in the suite.

- [ ] **Server-render first.** If the data is known at page render, emit it in the markup and delete the round trip entirely. Fastest option, and available more often than it looks.
- [ ] **Only genuinely async work becomes a REST route**, with a real `permission_callback` and a schema. Never `__return_true`.
- [ ] **Public routes are registered deliberately** for logged-out visitors, with their own nonce — never the admin one.
- [ ] **Do not port a broken guard.** Handlers in this suite use `if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce(...) )`, which is skipped entirely when the nonce is omitted. A REST `permission_callback` fails closed by default — keep it that way.
- [ ] **Migrate, do not double-register.** Leaving the old `wp_ajax_` action alive "for compatibility" keeps the vulnerable path alive.
- [ ] **Nonce is not authorisation.** Every route needs a capability check, plus an ownership check where it touches a record.
- [ ] **Done when** `grep` for `admin-ajax` and `ajaxurl` returns nothing in this plugin.

### Rebuild the admin panel to the standard shell

The one screen every store owner sees, and the least invested-in across the suite. Build to the pattern in
**Who Viewed My Profile** (`who-viewed-my-profile`, `/wp-admin/admin.php?page=bp-profile-views-settings` on the
release-skill site) - roughly 2,000 lines, already solved, copy it rather than reinvent.

```
includes/admin/class-<prefix>-admin.php   controller + get_tabs() registry + get_overview_stats()
includes/admin/views/shell.php            page header, sidebar nav, body slot
includes/admin/views/overview.php         stat tiles + config snapshot + quick actions
includes/admin/views/settings-*.php       one file per settings group
assets/css/admin.css
```

- [ ] **Land on an Overview, not a settings form.** Opening the plugin answers "what is this doing on my store right now?" before offering a single input.
- [ ] **This plugin's Overview should surface:** endpoints defined, how many are role-restricted, and whether the account page is shortcode or block based.
- [ ] **Stat tiles each carry an explanatory caption.** A bare number is not information - the reference writes "Every row recorded in the profile-views table" under its count.
- [ ] **A "Current configuration" snapshot** written as consequences, not stored values - "Yes, anonymous visits are stored but filtered out of aggregate counts", never `exclude_logout_user_count: 1`.
- [ ] **Quick actions** routing to the tab that changes the thing just described.
- [ ] **Sidebar generated from a tab registry** - one array keyed by slug with `label`, `icon`, `group` (main / settings / account). Adding a screen touches one array, not markup in three places.
- [ ] **Version pill in the header; dependency state shown on screen** rather than rendering an empty dashboard.
- [ ] **Replace the shared `admin/wbcom/` header/nav framework** where present - do not layer the new shell on top of it.
- [ ] **Verify at 1440px and 390px, light and dark, LTR and RTL.** Colours from CSS custom properties, never hardcoded hex.

**Two things that will bite:**
- `<hr class="wp-header-end">` immediately after the header is **required**. Without it core's `common.js` re-parents every `.notice` to the first `<h1>` and the "Settings saved" banner lands between the title and subtitle. The reference documents this in a comment - keep the comment.
- Call `settings_errors()` yourself in the shell, after that marker.

### The standard every plugin in this suite is measured against
We are not auditing against each plugin's own history - we are auditing against what a WooCommerce plugin **should** provide a store owner and a developer extending it. Scored across all 12 plugins on 2026-08-08.

| Expectation | Who needs it | Suite score |
|---|---|---|
| Gutenberg block | owner | **0 / 12** |
| Admin screen for stored data | owner | **0 / 12** |
| REST API | developer | **0 / 12** |
| Test suite | developer | **0 / 12** |
| WPCS config | developer | 2 / 12 |
| Documented hooks/filters | developer | 3 / 12 |
| Theme-overridable templates | owner | 4 / 12 |
| Shortcode fallback | owner | 5 / 12 |
| RTL stylesheet | owner | 9 / 12 |
| CSS custom properties | owner | 9 / 12 |
| Conditional asset loading | owner | 9 / 12 |
| Clean uninstall | owner | 10 / 12 |
| First-run guidance | owner | 10 / 12 |
| Translation file | owner | 11 / 12 |
| CI config | developer | 11 / 12 |
| Settings screen | owner | 12 / 12 |

**The four zeros are the real backlog.** Every plugin has a settings screen; not one has a block, an admin screen for the data it stores, a REST route, or a test. Those four gaps explain more customer complaints than the entire open bug list does.

### Portfolio floor - one mechanical pass per plugin
- [ ] **Focus rings** - `outline: none` with no `:focus-visible` replacement, **98 occurrences suite-wide**. Keyboard users cannot see where they are.
- [ ] **RTL** - raw `margin-left` / `margin-right`, **96 occurrences suite-wide**. Use `margin-inline-start/end`.
- [ ] **Icons** - **62** Dashicons references; migrate to Lucide with a map for stored values.
- [ ] **No native dialogs** - **12** `alert()`/`confirm()` calls put a raw browser dialog in front of a shopper mid-purchase.

### Ground rules
- **Dead-code lists are leads, not delete lists.** `init_form_fields()`, `get_content_html()` and `get_content_plain()` are `WC_Email` overrides invoked through the parent class - they look unreferenced to a static scan and **must not be removed**. The same applies to callbacks reached only by `add_action` string name and CSS classes built in JS.
- **Deduplicate at the seam.** Where free and Pro share an identical function body, the fix is one owner plus an extension point, never the same edit twice.
- **One concern per PR**, so a regression bisects fast.

### Ground rules for this list
- A card is a lead, not a spec. Several open cards were found to be already fixed or factually wrong about this tree - re-verify before building.
- Fix at the seam, not on the screen that reported it. Where a fix has a shared cause, the entry below says so.
- Most customers do not run our themes. Verify on a generic theme (Storefront or a block theme), not only on Reign/BuddyX.

## What It Does
Turns the default WooCommerce My Account area into a configurable customer portal. Site owners add custom endpoints (new account pages), organize tabs into collapsible groups, insert external links, restrict any item by user role, allow custom avatars, and restyle the whole area.

## Architecture

### Pattern
WordPress Plugin Boilerplate (loader pattern). `Woo_Custom_My_Account_Page_Loader` registers hooks; `Woo_Custom_My_Account_Page::run()` executes them.

### Key Files

| File | Purpose |
|------|---------|
| `woo-custom-my-account-page.php` | Bootstrap, WooCommerce guard, constants |
| `includes/class-woo-custom-my-account-page.php` | Core class, dependency loading, hook definitions |
| `includes/class-woo-custom-my-account-page-loader.php` | Hook registration system |
| `includes/class-woo-custom-my-account-page-functions.php` | Shared helpers (endpoint resolution, ordering) |
| `includes/class-wcmp-error-handler.php` | Centralized error handling |
| `includes/class-woo-custom-my-account-page-activator.php` | Activation (endpoint registration, rewrite flush) |
| `includes/class-woo-custom-my-account-page-deactivator.php` | Deactivation routine |
| `admin/class-woo-custom-my-account-page-admin.php` | Endpoint builder, settings, styling |
| `public/class-woo-custom-my-account-page-public.php` | Front-end menu + endpoint content rendering |
| `admin/wbcom/` | Shared Wbcom admin header/nav framework |

### Assets
- `admin/assets/js/jquery.nestable.js` - drag-and-drop ordering of endpoints/groups
- `admin/assets/js/woo-custom-my-account-page-admin.js`
- `public/assets/js/woo-custom-my-account-page-public.js`
- Matching CSS under `admin/assets/css/` and `public/assets/css/`

Codebase: ~6,100 PHP LOC across 29 files.

## Constants

| Constant | Value |
|----------|-------|
| `WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION` | `'1.6.3'` |
| `WCMP_PLUGIN_NAME` | `'woo-custom-my-account-page'` |
| `WCMP_PLUGIN_FILE` | `__FILE__` |
| `WCMP_PLUGIN_PATH` | `plugin_dir_path( __FILE__ )` |
| `WCMP_PLUGIN_URL` | `plugin_dir_url( __FILE__ )` |

## Hooks & Filters (plugin-defined)

Prefix is `wcmp_`.

### Actions - front-end rendering seams
| Hook | Fired |
|------|-------|
| `wcmp_before_endpoints_menu` / `wcmp_after_endpoints_menu` | Around the account nav menu |
| `wcmp_before_endpoints_items` / `wcmp_after_endpoints_items` | Around the menu items |
| `wcmp_print_endpoints_group` | Rendering a group |
| `wcmp_print_single_endpoint` | Rendering one endpoint item |

### Filters
| Hook | Purpose |
|------|---------|
| `wcmp_default_general_settings` | Default general settings |
| `wcmp_default_endpoints_settings` | Default endpoint settings |
| `wcmp_default_endpoint` | Default single-endpoint definition |
| `wcmp_dashboard_shortcode_template` | Dashboard shortcode template |
| `wcmp_admin_print_endpoints_group` | Admin group row markup |
| `wcmp_admin_print_endpoint_field` | Admin endpoint field markup |
| `wcmp_admin_print_link_field` | Admin link field markup |

## Settings & Data

### Options (`wp_options`)
| Option | Purpose |
|--------|---------|
| `wcmp_general_settings` | General settings |
| `wcmp_endpoints_settings` | Endpoint definitions |
| `wcmp_style_settings` | Colors and styling |
| `wcmp_endpoint` | Endpoint registry |
| `wcmp_endpoint_order` | Display order |
| `wcmp_endpoint_backup_pre_` | Prefixed backup written before destructive endpoint edits |
| `wcmp_is_my_account` | My Account page detection flag |
| `wcmp-users-avatar-ids` | Custom avatar attachment IDs |

No custom tables, no CPTs.

### AJAX actions
`wcmp_add_field`, plus `wbcom_addons_cards` from the shared admin framework.

## Dependencies
- **WooCommerce** - hard dependency, enforced by a runtime guard plus an `active_plugins` check.

## Development Notes
- **Endpoints are rewrite rules.** Adding, renaming, or removing an endpoint requires a rewrite flush, or customers get 404s on their account pages. The activator handles install; any runtime change must flush too.
- **Role restriction is a security boundary, not just display.** Hiding a menu item is not enough - the endpoint content callback must re-check the role. Verify both layers when touching visibility.
- **Endpoint slugs are user-visible URLs.** Changing a default slug breaks existing bookmarks and links; migrate rather than rename. Note `wcmp_endpoint_backup_pre_` exists precisely because endpoint edits are destructive.
- **Test on a generic theme.** The account menu is heavily themed; Storefront and a block theme behave differently from Reign/BuddyX. Check hover/focus/visited states on the nav links - themes override `<a>` styling.
- **The readme is `README.txt` (uppercase).** Tooling that globs for lowercase `readme.txt` silently misses it - git is case-sensitive even though macOS is not, so `git show <ref>:readme.txt` reports the file as absent while `open('readme.txt')` succeeds. Version-bump and packaging scripts must match case-insensitively or they will ship a stale `Stable tag`.
