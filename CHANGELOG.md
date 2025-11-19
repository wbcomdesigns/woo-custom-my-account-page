# Changelog

All notable changes to Custom My Account Page for WooCommerce will be documented in this file.

## [1.5.0] - 2025-01-19

### Major Release - Complete Plugin Relaunch

This is a comprehensive relaunch of the plugin with significant improvements in user experience, security, reliability, and maintainability.

### Added
- **Automatic Updates**: Integrated Plugin Update Checker for seamless updates outside WordPress.org
- **Comprehensive FAQ Tab**: Added detailed FAQ section in admin settings for better user guidance
- **Enhanced Admin UI**:
  - Clean WordPress-style modal dialogs
  - Icon display on general tab and endpoints
  - Cross icon button for modal close instead of text
  - Improved popup UI with better user experience
  - Asterisk (*) indicators after required titles
- **Build Process**: Added distribution zip file generation workflow
- **Documentation**: Comprehensive user, developer, and QA documentation

### Fixed
- **Critical Security Fixes**:
  - Fixed avatar upload security vulnerabilities
  - Added proper nonce verification across all forms
  - Fixed capability checks for all admin operations
  - Replaced deprecated extract() function usage
  - Added comprehensive sanitization callbacks
- **Fatal Errors**:
  - Fixed fatal error when creating groups (undefined slug/type)
  - Fixed fatal error in group-item.php when rendering child items
  - Fixed undefined variable warnings in link-item.php
  - Fixed missing method error in public class
- **Data Persistence**:
  - Fixed endpoint content not saving issue
  - Fixed settings not saving issues
  - Corrected all settings field names to match form inputs
  - Fixed duplicate endpoints creation on save
- **Display Issues**:
  - Fixed avatar display by correcting get_avatar_filter() option lookup
  - Fixed manage icon not showing on endpoints
  - Fixed link endpoints display issues
  - Fixed 'Open in New Tab' option for link endpoints
- **Dependencies**: Fixed npm security vulnerabilities

### Changed
- **Version Bump**: Updated to 1.5.0 to reflect major improvements
- **Plugin Name**: Renamed to "Custom My Account Page for WooCommerce" for WordPress.org compliance
- **Admin Menu**: Shortened admin menu and page titles for better UX
- **Code Quality**:
  - WordPress coding standards compliance
  - PHP 8.2 compatibility improvements
  - PHPCS fixes throughout codebase
- **Resource Optimization**:
  - Optimized FontAwesome loading
  - Updated resource versions for cache busting
- **WordPress Compatibility**: Tested up to WordPress 6.8.2
- **WooCommerce Compatibility**: Updated compatibility checks

### Removed
- Unwanted files and banner images
- Updated wbcom folder structure
- Temporary documentation files
- Deprecated code patterns

---

## [1.4.1] - 2024-11-10

### Fixed
- Fixed endpoint content not saving issue - missing 'type' field in sanitization callbacks
- Fixed missing method error in public class
- Fixed avatar upload security vulnerability
- Replaced deprecated extract() function usage
- Added missing sanitization callbacks for admin settings

### Changed
- Plugin renamed to "Custom My Account Page for WooCommerce" for WordPress.org compliance

---

## [1.4.0] - 2024-10-15

### Fixed
- Resolved issue where the endpoint was not shown in the default option
- Addressed compatibility issues with PHP 8.2
- UI improvements for Reign theme integration
- Resolved issue with all endpoints being disabled
- Corrected plugin redirect issue when multiple plugins are activated simultaneously

### Changed
- PHPCS fixes for improved code quality
- Implemented display name filter for better user experience

---

## [1.3.5] - 2024-08-20

### Fixed
- All endpoints disable issue
- Plugin redirect issue when multiple plugins activate at the same time

---

## [1.3.4] - 2024-07-15

### Fixed
- Added support of BuddyBoss theme
- Compatibility with WooCommerce version 7.1.0

---

## [1.3.3] - 2024-06-10

### Fixed
- Managed admin UI

---

## [1.3.2] - 2024-05-05

### Fixed
- Compatibility with WooCommerce version 6.6.1

---

## [1.3.1] - 2024-04-01

### Fixed
- Managed UI with BuddyX, BuddyX Pro and Buddyboss theme
- Fixed WPCS issues
- Fixed improve admin UI
- Fixed update documentation link
- Added plugin activation link in admin notice

---

## [1.3.0] - 2024-03-01

### Fixed
- Managed BuddyX, BuddyX Pro my account spacing
- Fix text domain issue
- Fixed icons issue with default themes

---

## [1.2.0] - 2024-02-01

### Fixed
- PHPCS Fixes
- Fixed default endpoint setting issue
- Fixed tabs are not displaying in woo my account page
- Fixed font awesome class issue

---

## [1.1.0] - 2024-01-15

### Fixed
- Updated Tabs and Language files

---

## [1.0.0] - 2023-12-01

### Added
- Initial Release
- Create custom My Account pages and tabs for WooCommerce
- Reorder, disable or rename account tabs
- Limit tabs to specific user roles
