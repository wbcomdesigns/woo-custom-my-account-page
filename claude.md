# Claude Code - Project Notes

This file contains important reminders and context for Claude Code when working on this project.

---

## Plugin Overview

**Plugin Name:** Custom My Account Page for WooCommerce
**Slug:** woo-custom-my-account-page
**Version:** 1.5.2
**Prefix:** WCMP / wcmp
**License:** GPL-2.0+
**Author:** Wbcom Designs
**Basecamp Project ID:** 37614349
**WordPress.org:** Not listed (distributed via wbcomdesigns.com, uses Plugin Update Checker)
**PHP Lines (excl. vendor):** ~6,378

### What It Does
Customizes the WooCommerce "My Account" page layout. Users can add custom endpoints, groups, and external links to the account navigation. Supports drag-and-drop reordering, user role restrictions, custom avatars, sidebar/tab layout modes, and style customization.

### Architecture
- **Pattern:** WordPress Plugin Boilerplate (Loader pattern)
- **Admin Class:** `Woo_Custom_My_Account_Page_Admin` - Settings pages, AJAX handlers, endpoint management
- **Public Class:** `Woo_Custom_My_Account_Page_Public` - Frontend rendering, avatar upload/display, styles
- **Functions Class:** `Woo_Custom_My_Account_Page_Functions` (singleton) - Core logic, endpoint registration, menu rendering, WC integration
- **License Class:** `WCMP_License` - EDD-based license system (prepared but not actively used in free version)
- **Error Handler:** `WCMP_Error_Handler` - Stability improvements
- **Update Checker:** Plugin Update Checker (PUC v5p6) pointing to `demos.wbcomdesigns.com`

### Admin Settings Tabs
1. **Welcome** - Help resources, documentation links
2. **General** - Custom avatar toggle, menu style (sidebar/tab), sidebar position (left/right), default endpoint
3. **Style Options** - 6 color pickers (menu item, hover, logout colors + backgrounds)
4. **Endpoints** - Drag-and-drop endpoint/group/link management with nestable.js
5. **FAQ** - Common questions and answers

### Key Options (wp_options)
- `wcmp_general_settings` - General configuration
- `wcmp_style_settings` - Color/style settings
- `wcmp_endpoints_settings` - Endpoints, groups, links, ordering
- `wcmp_is_my_account` - Page detection flag
- `wcmp-users-avatar-ids` - Uploaded avatar media IDs

### WooCommerce Hooks Used
- `woocommerce_account_navigation` - Replaces default nav with custom menu
- `woocommerce_account_content` - Manages custom endpoint content
- `woocommerce_account_menu_item_classes` - Adds custom CSS classes
- `get_avatar` - Custom avatar filter (priority 100)
- `wc_ajax_wcmp_print_avatar_form` - AJAX avatar form

### Frontend Templates (overridable via WC template system)
- `public/templates/wcmp-myaccount-menu.php` - Main menu wrapper
- `public/templates/wcmp-myaccount-menu-item.php` - Individual menu item
- `public/templates/wcmp-myaccount-menu-group.php` - Group (collapsible) menu
- `public/templates/wcmp-myaccount-avatar-form.php` - Avatar upload form

### Vendor Libraries
- jQuery Nestable (drag-and-drop)
- Select2 (multi-select for user roles)
- Font Awesome subset (19 icons, custom minimal build)

---

## Key Files

| File | Purpose |
|------|---------|
| `woo-custom-my-account-page.php` | Main plugin file, bootstrapping, WC dependency check |
| `includes/class-woo-custom-my-account-page.php` | Core class, hook registration |
| `includes/class-woo-custom-my-account-page-functions.php` | Business logic, endpoint management, menu rendering |
| `admin/class-woo-custom-my-account-page-admin.php` | Admin settings, AJAX handlers, sanitization |
| `public/class-woo-custom-my-account-page-public.php` | Frontend scripts/styles, avatar handling |
| `admin/partials/wcmp-endpoints-settings.php` | Endpoints management UI |
| `admin/partials/endpoint-item.php` | Endpoint admin template |
| `admin/partials/group-item.php` | Group admin template |
| `admin/partials/link-item.php` | Link admin template |
| `admin/partials/wcmp-general-settings.php` | General settings form |
| `admin/partials/wcmp-style-settings.php` | Style settings form |
| `admin/partials/wcmp-faq.php` | FAQ tab content |
| `license/class-wcmp-license.php` | EDD license management (prepared for Pro) |

---

## Basecamp Integration Guidelines

### Comment Formatting
**IMPORTANT:** When posting comments or replies to Basecamp cards using the MCP Basecamp integration, always use explicit HTML `<br>` tags for line breaks instead of relying on newline characters (`\n`).

**Correct Format:**
```html
<strong>Status:</strong> Fixed<br><br>
The issue has been resolved.<br><br>
<strong>Testing instructions:</strong><br>
1. Test the feature<br>
2. Verify it works<br>
```

**Why:** Basecamp's comment system requires explicit HTML formatting for proper line break rendering. Using `\n` may not render correctly in the Basecamp UI.

**Additional HTML formatting to use:**
- `<strong>` for bold text
- `<ul><li>` for unordered lists
- `<ol><li>` for ordered lists
- `<code>` for inline code
- `<pre>` for code blocks
- `<br>` for line breaks (single break)
- `<br><br>` for paragraph breaks (double break)

---

## Recent Changes

| Date | Version | Change |
|------|---------|--------|
| 2025-01-19 | 1.5.0 | Major relaunch: security fixes, admin UI overhaul, PUC integration, FAQ tab, comprehensive docs |
| 2025-11-11 | 1.4.1 | Fixed groups fatal error, link-item warnings, duplicate endpoints, added FAQ |
| 2024-11-10 | 1.4.1 | Fixed content saving, security vulnerabilities, deprecated extract() |
| 2024-10-15 | 1.4.0 | PHP 8.2 compat, default endpoint fix, redirect fix |

### Pending Issues
- Avatar upload blank display issue (Basecamp Card: 9266167368)

---

## Development Guidelines

### Code Standards
- Follow WordPress coding standards
- Always use proper escaping: `esc_html()`, `esc_attr()`, `esc_url()`
- Add security checks: nonce verification, capability checks
- Use `isset()` checks before accessing array keys
- Add PHPDoc comments for all methods

### Testing Workflow
1. Make code changes
2. Test locally
3. Commit to git
4. Add detailed comment to Basecamp card explaining the fix
5. Move card to "Testing" column in Basecamp
6. QA team validates the fix

### Basecamp Card Movement
- Use `mcp__basecamp__basecamp_move_card` to move cards between columns
- Testing Column ID: 7421374094
- Ready for Development Column ID: 7421374091

---

*Last Updated: 2026-02-21*
