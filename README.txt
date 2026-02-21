=== Custom My Account Page for WooCommerce ===
Contributors: wbcomdesigns, vapvarun
Donate link: https://wbcomdesigns.com
Tags: woocommerce, my account, custom endpoints, account page, user roles
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.5.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Customize the WooCommerce My Account page. Add custom tabs, groups, and links with drag-and-drop reordering, role restrictions, and style controls.

== Description ==

**Custom My Account Page for WooCommerce** lets you transform the standard WooCommerce My Account area into a fully customized customer portal. Add new pages, group related tabs, insert external links, restrict tabs by user role, and style everything to match your brand - all from a clean admin interface.

Whether you need to add a custom loyalty dashboard, restrict certain tabs to wholesale customers, or simply reorganize the default account menu, this plugin gives you complete control.

= Key Features =

* **Add custom endpoints** - Create new account pages with custom content that appear as tabs in the My Account navigation
* **Create tab groups** - Group related tabs under a collapsible parent item for cleaner navigation
* **Add external links** - Insert links to any URL (opens in same tab or new tab) directly in the account menu
* **Drag-and-drop reordering** - Rearrange all tabs, groups, and links with an intuitive drag-and-drop interface powered by Nestable.js
* **User role restrictions** - Show or hide any tab based on the current user's role, so wholesale customers, subscribers, and members each see a tailored account menu
* **Custom avatar upload** - Let customers upload a custom profile avatar from the My Account page
* **Sidebar or tab layout** - Choose between a sidebar navigation layout or a horizontal tab layout for the account menu
* **Sidebar position control** - Place the sidebar on the left or right side of the account content area
* **Style customization** - Six color pickers control menu item color, hover color, active color, logout color, and their backgrounds
* **Font Awesome icons** - Assign Font Awesome icons to any tab, group, or link for a polished, visual menu
* **Rename default tabs** - Change the label of any default WooCommerce endpoint (Orders, Downloads, Addresses, etc.)
* **Disable default tabs** - Hide any default WooCommerce My Account tab you do not need
* **BuddyBoss and BuddyX compatible** - Works correctly alongside BuddyBoss Theme and BuddyX Theme
* **PHP 8.2 compatible** - Tested and compatible with modern PHP versions

= How It Works =

1. Install and activate the plugin (WooCommerce must be active)
2. Go to **WooCommerce > My Account Page** or **WB Plugins > Custom My Account** in your admin
3. Under the **Endpoints** tab, drag default tabs to reorder them, add custom endpoints, create groups, or add external links
4. Under the **General** tab, choose sidebar or tab layout and configure avatar settings
5. Under **Style Options**, pick colors to match your theme
6. Customers immediately see the updated, customized My Account experience

= Developer Friendly =

The plugin overrides the standard WooCommerce account navigation via the `woocommerce_account_navigation` hook. All frontend templates (menu wrapper, menu items, groups, and avatar form) can be overridden using the standard WooCommerce template override system.

= Requirements =

* WordPress 5.0 or higher
* WooCommerce (latest recommended)
* PHP 7.4 or higher

== Installation ==

1. Upload the `woo-custom-my-account-page` folder to the `/wp-content/plugins/` directory, or install via **Plugins > Add New** in your WordPress dashboard
2. Activate **WooCommerce** if it is not already active
3. Activate **Custom My Account Page for WooCommerce** through the **Plugins** menu in WordPress
4. Navigate to **WB Plugins > Custom My Account** in your WordPress admin sidebar
5. Click the **Endpoints** tab to see the current account navigation. Drag and drop items to reorder them
6. Click **Add Endpoint** to create a new custom account page, **Add Group** to create a collapsible section, or **Add Link** to insert an external URL
7. Click the **General** tab to choose between sidebar and tab layout, configure sidebar position, and enable the custom avatar feature
8. Click the **Style Options** tab to set custom colors for the account menu
9. Visit your WooCommerce My Account page to review the changes

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =

Yes. Custom My Account Page for WooCommerce is a WooCommerce extension and requires WooCommerce to be installed and activated. The plugin will display an admin notice and will not function if WooCommerce is inactive.

= Can I restrict certain tabs to specific user roles? =

Yes. When editing any endpoint, group, or link in the Endpoints tab, you can select one or more user roles. Only users with those roles will see that item in the My Account navigation. All other users will see the menu without that tab.

= Can I rename the default WooCommerce tabs like Orders and Downloads? =

Yes. In the **Endpoints** settings tab, every default WooCommerce endpoint (Orders, Downloads, Addresses, Account Details, etc.) appears in the list. Click the edit icon on any item to rename its label.

= What is the difference between an Endpoint, a Group, and a Link? =

An **Endpoint** is a new My Account page that can contain custom content you write directly in the admin. A **Group** is a collapsible parent item that organizes other tabs under it. A **Link** is a menu item that redirects customers to any URL, either in the same tab or a new tab.

= Can customers upload their own profile avatar? =

Yes. Enable the **Custom Avatar** option in the **General** settings tab. A profile avatar upload form will appear on the customer's My Account page, allowing them to upload an image from their device.

= Will this plugin work with BuddyBoss or BuddyX theme? =

Yes. Custom My Account Page for WooCommerce includes compatibility adjustments for BuddyBoss Theme and BuddyX Theme, ensuring the account menu layout and spacing render correctly.

= Can I add Font Awesome icons to my custom tabs? =

Yes. When adding or editing any endpoint, group, or link in the admin, there is an icon picker field where you can select a Font Awesome icon. The icon will display alongside the tab label in the account navigation.

= How do I change the layout from sidebar to tabs? =

Go to **WB Plugins > Custom My Account > General** settings. Under the **Menu Style** option, choose between **Sidebar** and **Tab** layout. If you choose Sidebar, you can also set the sidebar position to left or right.

== Screenshots ==

1. Endpoints admin tab showing the drag-and-drop interface for reordering and managing account tabs
2. Add custom endpoint modal with fields for label, slug, icon, content, and role restrictions
3. General settings tab showing layout options (sidebar vs. tab), sidebar position, and avatar toggle
4. Style Options tab with six color pickers for complete menu style control
5. Frontend My Account page with a customized sidebar navigation and custom tabs
6. Frontend My Account page in tab layout mode with Font Awesome icons on each tab

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
* Fix: Managed admin UI

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
* Fix: (#29) Fixed font awesome class issue

= 1.1.0 =
* Fix: Updated tabs and language files

= 1.0.0 =
* Initial Release
