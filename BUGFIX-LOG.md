# Bug Fix Log - Custom My Account Page for WooCommerce

**Date:** 2026-02-21
**Plugin Version:** 1.5.1 -> 1.5.2 (pending)
**Fixed By:** Wbcom Designs

---

## Bug 1: flush_rewrite_rules() Called on Every Page Load (CRITICAL - Performance)

### Problem

`flush_rewrite_rules()` was hooked to `wp_loaded` in the `Woo_Custom_My_Account_Page_Functions` constructor (line 106), causing it to execute on **every single page load** -- both frontend and admin. This is a serious performance issue because `flush_rewrite_rules()` writes to the database and regenerates the `.htaccess` file on every request.

**Impact:** Significant database write overhead on every page load. On high-traffic sites, this causes slow page loads, increased database load, and potential write contention.

### Root Cause

The constructor in `class-woo-custom-my-account-page-functions.php` contained:

```php
add_action( 'wp_loaded', array( $this, 'wcmp_flush_rewrite_rules' ) );
```

The `wcmp_flush_rewrite_rules()` method unconditionally called `flush_rewrite_rules()` with no conditional check.

### Fix Applied

**File:** `includes/class-woo-custom-my-account-page-functions.php`
- Removed the `wp_loaded` hook registration from the constructor.
- Marked `wcmp_flush_rewrite_rules()` as deprecated (kept for backward compatibility with any third-party code that may call it directly).

**File:** `includes/class-woo-custom-my-account-page-activator.php`
- Added `set_transient( 'wcmp_flush_rewrite_rules', true, 60 )` to the activation hook, so rewrite rules are flushed once after plugin activation (on the next page load, after endpoints are registered via `init`).

**File:** `includes/class-woo-custom-my-account-page-deactivator.php`
- Added `flush_rewrite_rules()` to the deactivation hook to clean up custom endpoints.

**Existing mechanism preserved:** The admin class already has a proper transient-based flush via `wcmp_schedule_flush_rewrite_on_endpoint_save()` (fires on `update_option_wcmp_endpoints_settings`) and `wcmp_maybe_flush_rewrite_rules()` (fires on `init`). This handles the case when settings are saved. No changes were needed there.

**Flush now only occurs in three scenarios:**
1. Plugin activation (via transient flag)
2. Plugin deactivation (direct call)
3. When endpoint settings are saved in admin (existing transient-based mechanism)

---

## Bug 2: Unauthenticated AJAX Endpoint (CRITICAL - Security)

### Problem

The `wp_ajax_nopriv_wcmp_add_field` hook was registered in `class-woo-custom-my-account-page.php`, exposing the endpoint creation AJAX handler to unauthenticated (logged-out) users. While the handler contained a `current_user_can('manage_woocommerce')` check internally, the `nopriv` registration was unnecessary and violated the principle of defense in depth.

### Root Cause

In `define_admin_hooks()` of `class-woo-custom-my-account-page.php`:

```php
$this->loader->add_action( 'wp_ajax_wcmp_add_field', $plugin_admin, 'wcmp_add_field_ajax' );
$this->loader->add_action( 'wp_ajax_nopriv_wcmp_add_field', $plugin_admin, 'wcmp_add_field_ajax' );
```

The `nopriv` variant should never have been registered since endpoint creation is an admin-only operation.

### Fix Applied

**File:** `includes/class-woo-custom-my-account-page.php`
- Removed the `wp_ajax_nopriv_wcmp_add_field` hook registration entirely.
- Only `wp_ajax_wcmp_add_field` (authenticated users) remains.

---

## Bug 3: Nonce Verification Bypass in AJAX Handler (CRITICAL - Security)

### Problem

The nonce verification in `wcmp_add_field_ajax()` had a logic flaw that allowed the check to be bypassed entirely if the `nonce` POST parameter was not sent.

### Root Cause

In `class-woo-custom-my-account-page-admin.php`:

```php
// BEFORE (flawed):
if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( ... ) ) {
    wp_die( 'Security check failed' );
}
```

This condition only fails (and blocks the request) if `nonce` IS set AND is invalid. If `nonce` is simply not included in the request, `isset()` returns false, the entire condition is false, and execution continues past the security check.

### Fix Applied

**File:** `admin/class-woo-custom-my-account-page-admin.php`
- Changed to require nonce to be present AND valid:

```php
// AFTER (fixed):
if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( ... ) ) {
    wp_die( 'Security check failed' );
}
```

- Also reordered checks: nonce verification now happens before capability check (fail fast on invalid requests before hitting the database for user capability lookup).

---

## Code Quality Scan Results

### Items Reviewed (No Additional Critical Issues Found)

| Area | Status | Notes |
|------|--------|-------|
| Admin partials (endpoint-item, group-item, link-item) | OK | Proper `esc_attr()` and `esc_html()` usage throughout |
| Frontend templates (menu, menu-item, menu-group, avatar-form) | OK | Proper escaping with `esc_attr()`, `esc_html()`, `esc_url()` |
| Avatar upload handler | OK | Has nonce verification, login check, file type validation, size limits |
| Avatar reset handler | OK | Has nonce verification and login check |
| Settings sanitization callbacks | OK | Proper `sanitize_text_field()`, `sanitize_hex_color()`, `esc_url_raw()`, `wp_kses_post()` |
| CSS inline output | Acceptable | Values come from sanitized options (sanitize_hex_color on save) |
| Endpoint content output | Acceptable | Uses `do_shortcode()` which is standard WP pattern for user content |

---

## Files Modified

| File | Change |
|------|--------|
| `includes/class-woo-custom-my-account-page-functions.php` | Removed `wp_loaded` hook for `flush_rewrite_rules()`, deprecated method |
| `includes/class-woo-custom-my-account-page-activator.php` | Added transient flag for flush on activation |
| `includes/class-woo-custom-my-account-page-deactivator.php` | Added `flush_rewrite_rules()` on deactivation |
| `includes/class-woo-custom-my-account-page.php` | Removed `wp_ajax_nopriv_wcmp_add_field` hook |
| `admin/class-woo-custom-my-account-page-admin.php` | Fixed nonce verification logic (require nonce presence) |

---

## Testing Checklist

- [ ] Activate plugin -- verify endpoints work (rewrite rules flushed via transient)
- [ ] Save endpoint settings -- verify new/changed endpoints work (rewrite rules flushed via existing transient mechanism)
- [ ] Visit frontend pages -- verify no performance degradation, no unnecessary DB writes
- [ ] Test AJAX endpoint creation while logged out -- should fail (no `nopriv` handler)
- [ ] Test AJAX endpoint creation without nonce -- should fail ("Security check failed")
- [ ] Test AJAX endpoint creation as admin with valid nonce -- should succeed
- [ ] Deactivate plugin -- verify custom endpoint URLs return 404 (rewrite rules cleaned up)
