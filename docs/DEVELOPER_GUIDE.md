# WooCommerce Custom My Account Page - Developer Guide

## Table of Contents
1. [Architecture Overview](#architecture-overview)
2. [File Structure](#file-structure)
3. [Core Classes](#core-classes)
4. [Hooks & Filters](#hooks--filters)
5. [Database Structure](#database-structure)
6. [JavaScript & AJAX](#javascript--ajax)
7. [Creating Custom Extensions](#creating-custom-extensions)
8. [Security Implementation](#security-implementation)
9. [API Reference](#api-reference)
10. [Contributing Guidelines](#contributing-guidelines)

---

## Architecture Overview

The plugin follows WordPress coding standards and uses an object-oriented architecture with the following design patterns:

- **MVC Pattern** - Separation of logic, data, and presentation
- **Singleton Pattern** - Main plugin instance
- **Hook-based Architecture** - WordPress action/filter system
- **Modular Design** - Separate admin and public functionality

### Core Components

```
┌─────────────────────────────────────┐
│      Main Plugin Controller         │
├─────────────────────────────────────┤
│                                     │
│  ┌──────────┐      ┌──────────┐   │
│  │  Admin   │      │  Public  │   │
│  │  Module  │      │  Module  │   │
│  └──────────┘      └──────────┘   │
│                                     │
│  ┌──────────┐      ┌──────────┐   │
│  │Functions │      │  Loader  │   │
│  │  Helper  │      │  Class   │   │
│  └──────────┘      └──────────┘   │
└─────────────────────────────────────┘
```

---

## File Structure

```
woo-custom-my-account-page/
├── admin/
│   ├── assets/
│   │   ├── css/
│   │   │   └── woo-custom-my-account-page-admin.css
│   │   └── js/
│   │       ├── jquery.nestable.js
│   │       └── woo-custom-my-account-page-admin.js
│   ├── partials/
│   │   ├── endpoint-item.php
│   │   ├── group-item.php
│   │   ├── link-item.php
│   │   ├── wcmp-endpoints-settings.php
│   │   ├── wcmp-general-settings.php
│   │   ├── wcmp-style-settings.php
│   │   └── wcmp-welcome.php
│   ├── wbcom/
│   │   └── wbcom-admin-settings.php
│   └── class-woo-custom-my-account-page-admin.php
├── assets/
│   └── vendor/
│       ├── font-awesome/
│       └── select2/
├── includes/
│   ├── class-wcmp-error-handler.php
│   ├── class-woo-custom-my-account-page-activator.php
│   ├── class-woo-custom-my-account-page-deactivator.php
│   ├── class-woo-custom-my-account-page-functions.php
│   ├── class-woo-custom-my-account-page-i18n.php
│   ├── class-woo-custom-my-account-page-loader.php
│   └── class-woo-custom-my-account-page.php
├── languages/
├── public/
│   ├── assets/
│   │   └── css/
│   │       └── woo-custom-my-account-page-public.css
│   ├── templates/
│   │   ├── wcmp-myaccount-avatar-form.php
│   │   ├── wcmp-myaccount-endpoint.php
│   │   ├── wcmp-myaccount-group-open.php
│   │   └── wcmp-myaccount-menu.php
│   └── class-woo-custom-my-account-page-public.php
├── docs/
├── uninstall.php
└── woo-custom-my-account-page.php
```

---

## Core Classes

### Main Plugin Class
**File:** `woo-custom-my-account-page.php`

```php
// Plugin initialization
function run_woo_custom_my_account_page() {
    $plugin = new Woo_Custom_My_Account_Page();
    $plugin->run();
}
```

### Woo_Custom_My_Account_Page
**File:** `includes/class-woo-custom-my-account-page.php`

Main orchestrator class that:
- Loads dependencies
- Sets locale
- Registers admin and public hooks
- Maintains plugin version

```php
class Woo_Custom_My_Account_Page {
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->version = WCMP_PLUGIN_VERSION;
        $this->plugin_name = 'woo-custom-my-account-page';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }
}
```

### Functions Helper Class
**File:** `includes/class-woo-custom-my-account-page-functions.php`

Core functionality provider:

```php
class Woo_Custom_My_Account_Page_Functions {
    // Settings management
    public function wcmp_settings_data() { }

    // Endpoint registration
    public function register_custom_endpoints() { }

    // Menu management
    public function wcmp_add_my_account_menu() { }

    // Content rendering
    public function manage_account_content() { }
}
```

### Admin Class
**File:** `admin/class-woo-custom-my-account-page-admin.php`

Handles admin-side functionality:

```php
class Woo_Custom_My_Account_Page_Admin {
    // Settings registration
    public function wcmp_add_plugin_register_settings() { }

    // Sanitization callbacks
    public function wcmp_general_settings_callback($input) { }
    public function wcmp_style_settings_callback($input) { }
    public function wcmp_endpoints_settings_callback($input) { }

    // AJAX handlers
    public function wcmp_admin_add_new_field() { }
}
```

### Public Class
**File:** `public/class-woo-custom-my-account-page-public.php`

Frontend functionality:

```php
class Woo_Custom_My_Account_Page_Public {
    // Avatar management
    public function wcmp_add_avatar() { }
    public function wcmp_reset_default_avatar() { }

    // Form rendering
    public function wcmp_get_avatar_form($print = false) { }

    // Menu classes
    public function wcmp_account_menu_item_classes($classes, $endpoint) { }
}
```

---

## Hooks & Filters

### Actions

#### Admin Actions
```php
// Settings page
do_action('wcmp_before_admin_settings');
do_action('wcmp_after_admin_settings');

// Endpoint management
do_action('wcmp_before_endpoint_save', $endpoint_data);
do_action('wcmp_after_endpoint_save', $endpoint_data);
```

#### Public Actions
```php
// Menu rendering
do_action('wcmp_before_endpoints_menu');
do_action('wcmp_after_endpoints_menu');

// Content display
do_action('wcmp_before_endpoint_content', $endpoint);
do_action('wcmp_after_endpoint_content', $endpoint);
```

### Filters

#### Settings Filters
```php
// Modify settings data
add_filter('wcmp_settings_data', 'custom_function', 10, 1);

// Customize endpoint options
add_filter('wcmp_endpoint_options', 'custom_function', 10, 2);

// Modify menu items
add_filter('wcmp_menu_items', 'custom_function', 10, 1);
```

#### Display Filters
```php
// Avatar customization
add_filter('wcmp_filter_avatar_size', 'custom_size', 10, 1);
add_filter('wcmp_filter_display_name', 'custom_name', 10, 1);

// Menu customization
add_filter('wcmp_account_menu_item_classes', 'custom_classes', 10, 2);
```

### Custom Hook Examples

```php
// Add custom content to endpoint
add_action('wcmp_after_endpoint_content', function($endpoint) {
    if ($endpoint === 'custom-endpoint') {
        echo '<div class="custom-content">Additional content</div>';
    }
});

// Modify avatar size
add_filter('wcmp_filter_avatar_size', function($size) {
    return 150; // pixels
});

// Add custom menu class
add_filter('wcmp_account_menu_item_classes', function($classes, $endpoint) {
    if ($endpoint === 'downloads') {
        $classes[] = 'premium-endpoint';
    }
    return $classes;
}, 10, 2);
```

---

## Database Structure

### Options Table

The plugin stores settings in WordPress options table:

```sql
-- Main settings
option_name: 'wcmp_general_settings'
option_value: serialized array {
    'show_avatar' => 'on',
    'avatar_size' => 120,
    'show_user_name' => 'on',
    'show_logout_link' => 'on',
    'default_endpoint' => 'dashboard'
}

-- Style settings
option_name: 'wcmp_style_settings'
option_value: serialized array {
    'background-color' => '#ffffff',
    'menu-background-color' => '#f5f5f5',
    'text-color' => '#333333',
    'text-hover' => '#0073aa',
    'menu-text-color' => '#333333',
    'menu-text-hover' => '#0073aa',
    'menu_position' => 'left',
    'menu_style' => 'sidebar'
}

-- Endpoints settings
option_name: 'wcmp_endpoints_settings'
option_value: serialized array {
    'endpoints' => array(...),
    'groups' => array(...),
    'links' => array(...),
    'order' => 'endpoint1,group1,endpoint2,...'
}
```

### User Meta

Avatar information stored in user meta:

```sql
meta_key: 'wb-wcmp-avatar'
meta_value: attachment_id
```

### Transients

Temporary data storage:

```sql
transient_name: 'wcmp_flush_rewrite_rules'
value: true
expiration: 60 seconds
```

---

## JavaScript & AJAX

### Admin JavaScript
**File:** `admin/assets/js/woo-custom-my-account-page-admin.js`

#### Nestable Integration
```javascript
$('#nestable').nestable({
    maxDepth: 2,
    expandBtnHTML: '',
    collapseBtnHTML: ''
});

// Serialize on change
$('#nestable').on('change', function() {
    var serialized = $(this).nestable('serialize');
    $('input[name="wcmp_endpoints_settings[order]"]').val(
        JSON.stringify(serialized)
    );
});
```

#### AJAX Add Field
```javascript
$.ajax({
    url: ajaxurl,
    type: 'POST',
    data: {
        action: 'wcmp_add_field',
        field_name: fieldName,
        target: target,
        nonce: wcmp_admin_js_obj.nonce
    },
    success: function(response) {
        if (response.success) {
            $('#nestable > ol').append(response.html);
        }
    }
});
```

### Public JavaScript Integration

For custom JavaScript in frontend:

```javascript
// Wait for document ready
jQuery(document).ready(function($) {
    // Avatar upload handler
    $('#load-avatar').on('click', function(e) {
        e.preventDefault();
        // Load avatar form via AJAX
    });
});
```

---

## Creating Custom Extensions

### Custom Endpoint Type

```php
// Add custom endpoint type
add_filter('wcmp_endpoint_types', function($types) {
    $types['custom_type'] = __('Custom Type', 'textdomain');
    return $types;
});

// Handle custom endpoint rendering
add_action('woocommerce_account_custom-endpoint_endpoint', function() {
    echo '<h2>Custom Endpoint Content</h2>';
    // Your custom content
});
```

### Custom Field in Settings

```php
// Add field to endpoint settings
add_action('wcmp_endpoint_fields', function($endpoint) {
    ?>
    <label>
        <span><?php _e('Custom Field', 'textdomain'); ?></span>
        <input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr($endpoint); ?>][custom_field]" />
    </label>
    <?php
});

// Save custom field
add_filter('wcmp_endpoints_settings_callback', function($sanitized, $input) {
    // Add custom field sanitization
    return $sanitized;
}, 10, 2);
```

### Custom Menu Style

```php
// Register new menu style
add_filter('wcmp_menu_styles', function($styles) {
    $styles['custom'] = __('Custom Style', 'textdomain');
    return $styles;
});

// Add custom style CSS
add_action('wp_head', function() {
    $settings = get_option('wcmp_style_settings');
    if ($settings['menu_style'] === 'custom') {
        ?>
        <style>
            .woocommerce-MyAccount-navigation.custom { /* styles */ }
        </style>
        <?php
    }
});
```

---

## Security Implementation

### Nonce Verification

All forms include nonce fields:

```php
// Generate nonce
wp_nonce_field('wcmp_settings_nonce', 'wcmp_nonce');

// Verify nonce
if (!wp_verify_nonce($_POST['wcmp_nonce'], 'wcmp_settings_nonce')) {
    wp_die('Security check failed');
}
```

### Capability Checks

Admin functions check capabilities:

```php
if (!current_user_can('manage_woocommerce')) {
    wp_die('Insufficient permissions');
}
```

### Data Sanitization

All inputs are sanitized:

```php
// Text fields
$sanitized = sanitize_text_field($input);

// URLs
$sanitized = esc_url_raw($input);

// HTML content
$sanitized = wp_kses_post($input);

// Colors
$sanitized = sanitize_hex_color($input);
```

### Output Escaping

All outputs are escaped:

```php
// HTML attributes
echo esc_attr($value);

// URLs
echo esc_url($url);

// HTML
echo esc_html($text);

// JavaScript
echo esc_js($script);
```

---

## API Reference

### Global Functions

```php
// Get plugin instance
function instantiate_woo_custom_myaccount_functions() {
    return new Woo_Custom_My_Account_Page_Functions();
}

// Check if endpoint exists
function wcmp_endpoint_exists($endpoint) {
    $settings = get_option('wcmp_endpoints_settings');
    return isset($settings['endpoints'][$endpoint]);
}

// Get endpoint URL
function wcmp_get_endpoint_url($endpoint) {
    return wc_get_account_endpoint_url($endpoint);
}
```

### Template Functions

```php
// Load custom template
wc_get_template(
    'template-name.php',
    $args,
    '',
    WCMP_PLUGIN_PATH . 'public/templates/'
);

// Get avatar HTML
echo wcmp_get_user_avatar($user_id, $size);
```

### AJAX Endpoints

```php
// Available AJAX actions
wp_ajax_wcmp_add_field        // Add new field
wp_ajax_wcmp_upload_avatar    // Upload avatar
wp_ajax_wcmp_reset_avatar     // Reset avatar
wp_ajax_wcmp_save_settings    // Save settings
```

---

## Contributing Guidelines

### Code Standards

- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- Use PHP CodeSniffer with WordPress rules
- Maintain PHP 7.0+ compatibility
- Document all functions with PHPDoc

### Testing

Before submitting:

1. Test with latest WordPress and WooCommerce
2. Check PHP error log
3. Validate with different user roles
4. Test on mobile devices
5. Check for JavaScript errors

### Pull Request Process

1. Fork the repository
2. Create feature branch: `git checkout -b feature-name`
3. Commit changes: `git commit -m "Add feature"`
4. Push branch: `git push origin feature-name`
5. Submit pull request with description

### Security Reporting

Report security issues privately to the maintainers. Do not create public issues for security vulnerabilities.

---

## Debugging

### Enable Debug Mode

```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### Debug Functions

```php
// Log to debug.log
error_log('Debug message: ' . print_r($variable, true));

// Custom debug function
if (!function_exists('wcmp_debug')) {
    function wcmp_debug($data, $label = '') {
        if (WP_DEBUG) {
            error_log('[WCMP Debug] ' . $label . ': ' . print_r($data, true));
        }
    }
}
```

### Common Issues

1. **Endpoints 404**: Flush rewrite rules
2. **Styles not loading**: Check handle conflicts
3. **AJAX failing**: Verify nonces and permissions
4. **Missing menu items**: Check role restrictions

---

## Performance Optimization

### Caching

```php
// Use transients for expensive operations
$data = get_transient('wcmp_expensive_data');
if (false === $data) {
    $data = expensive_operation();
    set_transient('wcmp_expensive_data', $data, HOUR_IN_SECONDS);
}
```

### Asset Loading

```php
// Load only where needed
public function enqueue_scripts() {
    if (!is_account_page()) {
        return;
    }
    wp_enqueue_style('wcmp-frontend');
}
```

### Database Queries

```php
// Cache option lookups
private static $settings_cache = null;

public function get_settings() {
    if (null === self::$settings_cache) {
        self::$settings_cache = get_option('wcmp_settings');
    }
    return self::$settings_cache;
}
```

---

*Last updated: November 2024*