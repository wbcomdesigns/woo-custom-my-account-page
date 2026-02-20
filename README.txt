=== Custom My Account Page for WooCommerce ===
Contributors: wbcomdesigns,vapvarun
Donate link: https://wbcomdesigns.com
Tags: woocommerce, my account, custom pages, endpoints, account customization
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.5.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Customize My Account page and tabs for WooCommerce with ease. Create, rename, reorder or disable custom pages in the my account section of your users.

== Description ==

Create custom My Account pages and tabs for WooCommerce with ease.

* Create new my account pages
* Reorder, disable or rename account tabs
* Limit tabs to specific user roles

== Installation ==

This section describes how to install the plugin and get it working.
e.g.

1. Upload `woo-custom-my-account-page.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Changelog ==

= 1.5.1 =
* Update: Full WordPress Coding Standards (WPCS) compliance
* Update: Plugin Check compliance fixes

= 1.5.0 =
* New: Integrated Plugin Update Checker for automatic updates outside WordPress.org
* New: Added comprehensive FAQ tab in admin settings for better user guidance
* New: Enhanced admin UI with clean WordPress-style modal dialogs
* New: Added icon display on general tab and endpoints
* New: Cross icon button for modal close instead of text
* New: Asterisk (*) indicators after required field titles
* New: Added build process for distribution zip file generation
* New: Comprehensive user, developer, and QA documentation
* Fix: Fixed avatar upload security vulnerabilities
* Fix: Added proper nonce verification across all forms
* Fix: Fixed capability checks for all admin operations
* Fix: Replaced deprecated extract() function usage
* Fix: Added comprehensive sanitization callbacks
* Fix: Fixed fatal error when creating groups (undefined slug/type)
* Fix: Fixed fatal error in group-item.php when rendering child items
* Fix: Fixed undefined variable warnings in link-item.php
* Fix: Fixed endpoint content not saving issue
* Fix: Fixed settings not saving issues
* Fix: Corrected all settings field names to match form inputs
* Fix: Fixed duplicate endpoints creation on save
* Fix: Fixed avatar display by correcting get_avatar_filter() option lookup
* Fix: Fixed manage icon not showing on endpoints
* Fix: Fixed link endpoints display issues
* Fix: Fixed 'Open in New Tab' option for link endpoints
* Fix: Fixed npm security vulnerabilities
* Update: WordPress coding standards compliance throughout codebase
* Update: PHP 8.2 compatibility improvements
* Update: Optimized FontAwesome loading
* Update: Shortened admin menu and page titles for better UX
* Update: Updated resource versions for cache busting
* Update: Tested up to WordPress 6.8.2
* Update: Removed unwanted files and banner images

= 1.4.1 =
* Fix: Fixed endpoint content not saving issue - missing 'type' field in sanitization callbacks
* Update: Plugin renamed to "Custom My Account Page for WooCommerce" for WordPress.org compliance
* Fix: Fixed missing method error in public class
* Fix: Fixed avatar upload security vulnerability
* Fix: Replaced deprecated extract() function usage
* Fix: Added missing sanitization callbacks for admin settings

= 1.4.0 =
* Fix: Resolved issue where the endpoint was not shown in the default option.
* Update: PHPCS fixes for improved code quality.
* Fix: Addressed compatibility issues with PHP 8.2.
* Update: Implemented display name filter for better user experience.
* Fix: UI improvements for Reign theme integration.
* Fix: Resolved issue with all endpoints being disabled.
* Fix: Corrected plugin redirect issue when multiple plugins are activated simultaneously.

= 1.3.5 =
* Fix: (#60) All endpoints disable issue
* Fix: Plugin redirect issue when multiple plugins activate at the same time

= 1.3.4 =
* Fix: Fixed added support of BuddyBoss theme
* Fix: Compatibility with WooCommerce version 7.1.0

= 1.3.3 =
* Fix: managed admin UI

= 1.3.2 =
* Fix: Compatibility with WooCommerce version 6.6.1  

= 1.3.1 =
* Fix: Managed UI with BuddyX, BuddyX Pro and Buddyboss theme
* Fix: Fixed WPCS issues
* Fix: (#53) Fixed improve admin UI
* Fix: (#55) Fixed update documentation link
* Fix: (#57) Added plugin activation link in admin notice

= 1.3.0 =
* Fix: #48 Managed BuddyX, BuddyX Pro my account spacing
* Fix: Fix text domain issue
* Fix: (#44) Fixed icons issue with default themes

= 1.2.0 =
* Fix: PHPCS Fixes
* Fix: (#31) Fixed default endpoint setting issue
* Fix: (#30) Fixed tabs are not displaying in woo my account page
* Fix: (#29)Fixed font awesome class issue

= 1.1.0 =
* Fix: updated Tabs and Language files

= 1.0.0 =
* Initial Release 
