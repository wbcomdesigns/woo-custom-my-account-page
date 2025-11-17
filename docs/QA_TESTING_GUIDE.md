# WooCommerce Custom My Account Page - QA Testing Guide

## Table of Contents
1. [Testing Environment Setup](#testing-environment-setup)
2. [Installation Testing](#installation-testing)
3. [Functional Testing](#functional-testing)
4. [Security Testing](#security-testing)
5. [Performance Testing](#performance-testing)
6. [Compatibility Testing](#compatibility-testing)
7. [User Interface Testing](#user-interface-testing)
8. [Regression Testing](#regression-testing)
9. [Test Cases](#test-cases)
10. [Bug Reporting](#bug-reporting)

---

## Testing Environment Setup

### Recommended Test Environment

```
WordPress: 6.4.x (latest)
WooCommerce: 8.3.x (latest)
PHP: 8.0, 8.1, 8.2
MySQL: 8.0
Web Server: Apache 2.4 / Nginx 1.20+
Browser: Chrome (latest), Firefox (latest), Safari (latest), Edge (latest)
```

### Test Site Configuration

1. **Clean Installation**
   - Fresh WordPress install
   - WooCommerce with sample data
   - No other plugins initially

2. **Debug Settings** (wp-config.php)
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
```

3. **User Accounts**
   - Administrator
   - Shop Manager
   - Customer (multiple)
   - Subscriber
   - Custom role (if testing role restrictions)

---

## Installation Testing

### TEST-001: Plugin Installation

**Objective:** Verify clean plugin installation

**Steps:**
1. Upload plugin ZIP via WordPress admin
2. Click Install Now
3. Click Activate

**Expected Results:**
- ✅ No PHP errors during activation
- ✅ Plugin appears in active plugins list
- ✅ Menu item "WB Plugins" appears in admin
- ✅ Database options created successfully
- ✅ No JavaScript console errors

**Pass Criteria:** All expected results achieved

---

### TEST-002: Dependency Check

**Objective:** Verify WooCommerce dependency

**Precondition:** WooCommerce NOT installed

**Steps:**
1. Activate plugin without WooCommerce
2. Check admin notices

**Expected Results:**
- ✅ Warning notice about WooCommerce requirement
- ✅ Plugin functions gracefully degraded
- ✅ No fatal errors

---

## Functional Testing

### TEST-003: General Settings

**Objective:** Test all general settings options

**Test Data:**
```
Show Avatar: On/Off
Avatar Size: 20, 120, 500, 501 (boundary test)
Show Username: On/Off
Show Logout: On/Off
Default Endpoint: Various options
```

**Steps:**
1. Navigate to WB Plugins → Woo My Account → General
2. Test each setting with values above
3. Save settings
4. Verify on frontend My Account page

**Expected Results:**
- ✅ Settings save without errors
- ✅ Avatar size limited to 20-500px
- ✅ Frontend reflects all changes
- ✅ Invalid values handled gracefully

---

### TEST-004: Style Settings

**Objective:** Test color and layout customization

**Test Data:**
```
Colors: #ffffff, #000000, #ff0000, invalid-color, rgb(255,0,0)
Menu Position: left, right
Menu Style: sidebar, tab
```

**Steps:**
1. Navigate to Style Options tab
2. Test color picker for each field
3. Enter manual color values
4. Change menu position and style
5. Save and verify frontend

**Expected Results:**
- ✅ Color picker works correctly
- ✅ Invalid colors rejected
- ✅ RGB values converted to hex
- ✅ Menu position changes apply
- ✅ Menu style changes layout

---

### TEST-005: Endpoint Management

**Objective:** Complete endpoint CRUD operations

#### 5.1 Create Endpoint

**Steps:**
1. Click "Add New Endpoint"
2. Fill fields:
   - Label: "Test Endpoint"
   - Slug: "test-endpoint"
   - Icon: "fa-star"
   - Content: "<h2>Test Content</h2><script>alert('XSS')</script>"
3. Save settings

**Expected Results:**
- ✅ Endpoint appears in menu
- ✅ URL works (/my-account/test-endpoint/)
- ✅ Content displays (without script execution)
- ✅ Icon shows correctly

#### 5.2 Edit Endpoint

**Steps:**
1. Open existing endpoint
2. Change all fields
3. Save settings

**Expected Results:**
- ✅ Changes persist after save
- ✅ Frontend updates immediately
- ✅ URL slug change works

#### 5.3 Delete Endpoint

**Steps:**
1. Click trash icon on endpoint
2. Save settings
3. Check frontend

**Expected Results:**
- ✅ Endpoint removed from list
- ✅ Menu item disappears
- ✅ URL returns 404

#### 5.4 Reorder Endpoints

**Steps:**
1. Drag endpoint to new position
2. Save settings
3. Check frontend order

**Expected Results:**
- ✅ Order persists after save
- ✅ Frontend menu matches admin order

---

### TEST-006: Groups Functionality

**Objective:** Test endpoint grouping

**Steps:**
1. Add new group "Test Group"
2. Drag endpoints into group
3. Test collapsible functionality
4. Add role restrictions
5. Delete group

**Expected Results:**
- ✅ Groups create successfully
- ✅ Endpoints can be nested
- ✅ Collapse/expand works
- ✅ Empty groups hidden
- ✅ Role restrictions apply
- ✅ Group deletion moves children out

---

### TEST-007: External Links

**Objective:** Test external link functionality

**Test Data:**
```
Valid URLs:
- https://example.com
- http://example.com
- /internal-page
- mailto:test@example.com
- tel:+1234567890
- #anchor

Invalid URLs:
- javascript:alert('XSS')
- data:text/html,<script>alert('XSS')</script>
- //evil.com
```

**Steps:**
1. Add links with test data
2. Save and check frontend
3. Click each link

**Expected Results:**
- ✅ Valid URLs work correctly
- ✅ Invalid URLs sanitized/rejected
- ✅ External links open in new tab (if set)
- ✅ Internal links stay in same tab

---

### TEST-008: Avatar Management

#### 8.1 Avatar Upload

**Test Files:**
```
Valid:
- image.jpg (100KB)
- image.png (1.9MB)
- image.gif (500KB)
- image.webp (200KB)

Invalid:
- large.jpg (3MB)
- script.php (renamed to .jpg)
- document.pdf
- image.svg
```

**Steps:**
1. Login as customer
2. Go to My Account
3. Click camera icon
4. Upload each test file
5. Verify display

**Expected Results:**
- ✅ Valid images upload successfully
- ✅ Files >2MB rejected
- ✅ Non-image files rejected
- ✅ PHP files blocked despite extension
- ✅ Success message shows
- ✅ Avatar displays immediately

#### 8.2 Avatar Reset

**Steps:**
1. Upload avatar
2. Click camera icon
3. Select "Reset to default"
4. Confirm action

**Expected Results:**
- ✅ Avatar removed from display
- ✅ File deleted from server
- ✅ Database cleaned
- ✅ Fallback to Gravatar

---

### TEST-009: Role Restrictions

**Objective:** Test user role-based visibility

**Setup:**
1. Create endpoint restricted to "Shop Manager"
2. Create group restricted to "Customer"
3. Create link visible to all

**Test Matrix:**
| User Role | Endpoint | Group | Link |
|-----------|----------|-------|------|
| Admin | ✅ | ✅ | ✅ |
| Shop Manager | ✅ | ❌ | ✅ |
| Customer | ❌ | ✅ | ✅ |
| Subscriber | ❌ | ❌ | ✅ |

**Expected Results:**
- ✅ Visibility matches matrix
- ✅ Hidden items not accessible via URL
- ✅ No errors for restricted access

---

## Security Testing

### TEST-010: XSS Prevention

**Test Vectors:**
```html
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
javascript:alert('XSS')
<iframe src="javascript:alert('XSS')"></iframe>
```

**Test Locations:**
1. Endpoint content field
2. Label fields
3. URL fields
4. Icon class field

**Expected Results:**
- ✅ Scripts stripped or escaped
- ✅ No alert boxes appear
- ✅ Content safely displayed

---

### TEST-011: SQL Injection

**Test Vectors:**
```sql
' OR '1'='1
"; DROP TABLE wp_options; --
' UNION SELECT * FROM wp_users --
```

**Test Locations:**
1. All text input fields
2. Search parameters
3. Slug fields

**Expected Results:**
- ✅ No database errors
- ✅ Inputs properly escaped
- ✅ Functionality continues normally

---

### TEST-012: CSRF Protection

**Steps:**
1. Inspect all forms for nonce fields
2. Modify nonce value in browser
3. Submit form
4. Check response

**Expected Results:**
- ✅ All forms have nonce fields
- ✅ Modified nonce causes security error
- ✅ Valid nonce allows submission

---

### TEST-013: File Upload Security

**Test Files:**
```
exploit.php.jpg
../../etc/passwd
shell.php
large-file-10mb.jpg
```

**Steps:**
1. Attempt to upload each file as avatar
2. Check server response
3. Verify file storage location

**Expected Results:**
- ✅ PHP files blocked regardless of extension
- ✅ Path traversal attempts failed
- ✅ Large files rejected (>2MB)
- ✅ Files stored in uploads directory only

---

## Performance Testing

### TEST-014: Page Load Time

**Tools:** GTmetrix, PageSpeed Insights

**Metrics to Measure:**
- My Account page load time
- Admin settings page load time
- AJAX response times

**Acceptable Thresholds:**
- Page load: <3 seconds
- AJAX calls: <1 second
- No memory leaks detected

---

### TEST-015: Stress Testing

**Scenario:** Many endpoints/groups

**Setup:**
1. Create 50 endpoints
2. Create 10 groups
3. Add 20 external links

**Expected Results:**
- ✅ Admin interface remains responsive
- ✅ Saving doesn't timeout
- ✅ Frontend menu renders correctly
- ✅ No PHP memory errors

---

## Compatibility Testing

### TEST-016: Theme Compatibility

**Test Themes:**
- Twenty Twenty-Four
- Storefront
- Astra
- OceanWP
- Popular WooCommerce themes

**Steps:**
1. Activate each theme
2. Check My Account page
3. Test all functionality

**Expected Results:**
- ✅ Menu displays correctly
- ✅ Styles don't break layout
- ✅ Responsive design maintained

---

### TEST-017: Plugin Compatibility

**Critical Plugins to Test:**
- WooCommerce Subscriptions
- WooCommerce Memberships
- WPML/Polylang
- Yoast SEO
- Popular page builders

**Expected Results:**
- ✅ No conflicts
- ✅ Endpoints accessible
- ✅ No JavaScript errors

---

### TEST-018: Browser Compatibility

**Browsers:**
- Chrome (Latest, Latest-1)
- Firefox (Latest, Latest-1)
- Safari (Latest)
- Edge (Latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

**Test Points:**
- Drag-drop functionality
- Color pickers
- AJAX operations
- Responsive design

---

## User Interface Testing

### TEST-019: Responsive Design

**Breakpoints:**
- Mobile: 320px, 375px, 414px
- Tablet: 768px, 1024px
- Desktop: 1280px, 1920px

**Test Areas:**
- Admin settings interface
- Frontend My Account page
- Avatar upload modal
- Menu layouts (sidebar/tab)

**Expected Results:**
- ✅ All elements visible and accessible
- ✅ No horizontal scrolling
- ✅ Touch interactions work
- ✅ Text remains readable

---

### TEST-020: Accessibility

**Standards:** WCAG 2.1 Level AA

**Test Points:**
- Keyboard navigation
- Screen reader compatibility
- Color contrast (4.5:1 minimum)
- Focus indicators
- ARIA labels

**Tools:**
- WAVE
- axe DevTools
- NVDA/JAWS

---

## Regression Testing

### TEST-021: Update Testing

**Scenario:** Plugin update from previous version

**Steps:**
1. Install previous version
2. Configure settings and endpoints
3. Update to current version
4. Verify all settings preserved

**Expected Results:**
- ✅ No data loss
- ✅ Settings migrate correctly
- ✅ Custom endpoints preserved
- ✅ No errors during update

---

### TEST-022: Uninstall Testing

**Steps:**
1. Configure plugin completely
2. Deactivate plugin
3. Check data persistence
4. Delete plugin
5. Check database cleanup

**Expected Results:**
- ✅ Deactivation preserves data
- ✅ Deletion removes all options
- ✅ User meta cleaned up
- ✅ No orphaned data

---

## Test Cases Summary

### Critical Path Tests
- [ ] TEST-001: Installation
- [ ] TEST-003: General Settings
- [ ] TEST-005: Endpoint Management
- [ ] TEST-008: Avatar Management
- [ ] TEST-010: XSS Prevention
- [ ] TEST-012: CSRF Protection

### Full Test Suite
- [ ] All Installation Tests (TEST-001 to TEST-002)
- [ ] All Functional Tests (TEST-003 to TEST-009)
- [ ] All Security Tests (TEST-010 to TEST-013)
- [ ] All Performance Tests (TEST-014 to TEST-015)
- [ ] All Compatibility Tests (TEST-016 to TEST-018)
- [ ] All UI Tests (TEST-019 to TEST-020)
- [ ] All Regression Tests (TEST-021 to TEST-022)

---

## Bug Reporting

### Bug Report Template

```markdown
**Test ID:** TEST-XXX
**Environment:**
- WordPress Version:
- WooCommerce Version:
- PHP Version:
- Browser:
- Theme:

**Steps to Reproduce:**
1.
2.
3.

**Expected Result:**

**Actual Result:**

**Screenshots/Videos:**

**Error Logs:**

**Severity:** Critical/High/Medium/Low

**Additional Notes:**
```

### Severity Levels

- **Critical:** Security vulnerabilities, data loss, site crash
- **High:** Major functionality broken, blocking issues
- **Medium:** Minor functionality issues, UI problems
- **Low:** Cosmetic issues, minor improvements

### Testing Checklist

#### Pre-Release Checklist
- [ ] All critical path tests passed
- [ ] No Critical or High severity bugs
- [ ] Security tests passed
- [ ] Performance within thresholds
- [ ] Compatible with latest WP/WC
- [ ] Documentation updated
- [ ] Changelog prepared

#### Post-Release Monitoring
- [ ] Monitor support forums
- [ ] Check error tracking
- [ ] Gather user feedback
- [ ] Plan next iteration

---

## Automated Testing

### PHPUnit Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run specific test suite
vendor/bin/phpunit --testsuite functional

# Generate coverage report
vendor/bin/phpunit --coverage-html coverage
```

### JavaScript Tests

```bash
# Run Jest tests
npm test

# Watch mode
npm test -- --watch

# Coverage
npm test -- --coverage
```

### E2E Tests (Cypress)

```bash
# Run E2E tests
npm run cypress:run

# Open Cypress UI
npm run cypress:open
```

---

## Testing Tools

### Recommended Tools

1. **Functionality**
   - WordPress Debug Bar
   - Query Monitor
   - User Switching

2. **Security**
   - WPScan
   - Sucuri Scanner
   - OWASP ZAP

3. **Performance**
   - GTmetrix
   - New Relic
   - P3 Plugin Profiler

4. **Accessibility**
   - WAVE
   - axe DevTools
   - Lighthouse

---

*Last updated: November 2024*
*Version: 1.4.1*