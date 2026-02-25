=== Custom My Account Page for WooCommerce ===
Contributors: wbcomdesigns, vapvarun
Donate link: https://wbcomdesigns.com
Tags: woocommerce my account, custom endpoints, account page customizer, woocommerce tabs, user role menu
Requires at least: 5.0
Tested up to: 6.9.1
Stable tag: 1.6.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Customize the WooCommerce My Account page with custom tabs, groups, and links. Drag-and-drop reordering, user role restrictions, avatar uploads, and full style control.

== Description ==

**Custom My Account Page for WooCommerce** transforms the default WooCommerce My Account area into a fully branded customer portal. Add new pages, organize tabs into collapsible groups, insert external links, restrict visibility by user role, upload custom avatars, and style every color to match your theme.

No coding required. Everything is managed from a clean drag-and-drop admin interface.

= Who Is This For? =

* **Store owners** who want a polished, branded account area instead of the plain WooCommerce default
* **Membership sites** that need to show different tabs to different user roles (subscribers, wholesale customers, VIP members)
* **Agencies** building custom WooCommerce stores where the My Account page needs to match the overall design
* **Marketplace operators** who need to add custom dashboards, external links, or grouped navigation to the account menu

= Key Features =

* **Custom endpoints** - Add new account pages with custom content (HTML, shortcodes, page builder output) that appear as tabs in the My Account navigation
* **Tab groups** - Organize related tabs under collapsible parent items for cleaner, structured navigation
* **External links** - Add links to any URL directly in the account menu, with control over same-tab or new-tab behavior
* **Drag-and-drop reordering** - Rearrange all tabs, groups, and links visually with an intuitive interface
* **User role restrictions** - Show or hide any tab based on the logged-in user's role for a tailored experience per customer type
* **Custom avatar upload** - Let customers upload a profile photo directly from their My Account page
* **Sidebar or tab layout** - Switch between vertical sidebar navigation and horizontal tab navigation
* **Sidebar position** - Place the sidebar on the left or right side of the content area
* **Style customization** - Six color pickers for menu item colors, hover states, active states, logout styling, and backgrounds
* **Font Awesome icons** - Assign icons to any tab, group, or link for a polished, visual navigation menu
* **Rename default tabs** - Change the label of any built-in WooCommerce endpoint (Orders, Downloads, Addresses, Account Details)
* **Disable default tabs** - Hide any default WooCommerce tab you do not need
* **Theme compatible** - Works with Storefront, BuddyBoss Theme, BuddyX, and standard WordPress themes
* **Conflict-free icons** - Scoped icon font prevents conflicts with themes that load their own Font Awesome version
* **Automatic updates** - Receives updates directly from wbcomdesigns.com
* **PHP 8.2+ compatible** - Tested and ready for modern PHP versions

= How It Works =

1. Install and activate the plugin (WooCommerce must be active)
2. Go to **WB Plugins > Custom My Account** in your WordPress admin
3. Open the **Endpoints** tab to see the current account navigation, then drag and drop to reorder
4. Click **Add Endpoint** to create a new custom account page, **Add Group** for a collapsible section, or **Add Link** for an external URL
5. Open the **General** tab to pick sidebar or tab layout, set the sidebar position, and toggle avatar uploads
6. Open **Style Options** to set colors matching your brand
7. Visit the WooCommerce My Account page to see the result

= Developer Friendly =

All frontend templates can be overridden using the standard WooCommerce template override system. Copy any template from `woo-custom-my-account-page/public/templates/` to your theme's `woocommerce/` directory and customize freely.

**Overridable templates:**

* `wcmp-myaccount-menu.php` - Main menu wrapper
* `wcmp-myaccount-menu-item.php` - Individual menu item
* `wcmp-myaccount-menu-group.php` - Group (collapsible) menu
* `wcmp-myaccount-avatar-form.php` - Avatar upload form

The plugin uses the `woocommerce_account_navigation` hook to replace the default navigation. All custom endpoints are registered as proper WooCommerce endpoints with rewrite rules.

= More WooCommerce Plugins by Wbcom Designs =

* [WooCommerce Document Preview](https://wbcomdesigns.com/downloads/woo-document-preview/) - Let customers preview PDF, DOC, and other document files before purchasing
* [WooCommerce Audio Preview](https://wbcomdesigns.com/downloads/woo-audio-preview/) - Add audio previews and samples to your WooCommerce products
* [WooCommerce Sell Services](https://wbcomdesigns.com/downloads/woo-sell-services/) - Turn your WooCommerce store into a Fiverr-style service marketplace
* [WooCommerce Price Quote](https://wbcomdesigns.com/downloads/woocommerce-price-quote/) - Replace "Add to Cart" with a "Request a Quote" button for B2B stores
* [WooCommerce Email Customizer](https://wbcomdesigns.com/downloads/woocommerce-email-customizer/) - Customize WooCommerce transactional emails with a visual editor

Visit [wbcomdesigns.com](https://wbcomdesigns.com) for our full collection of WordPress and WooCommerce plugins.

= Requirements =

* WordPress 5.0 or higher
* WooCommerce 6.0 or higher (latest recommended)
* PHP 7.4 or higher

== Installation ==

1. Upload the `woo-custom-my-account-page` folder to the `/wp-content/plugins/` directory, or install directly from your WordPress dashboard
2. Make sure **WooCommerce** is installed and active
3. Activate **Custom My Account Page for WooCommerce** through the **Plugins** menu
4. Go to **WB Plugins > Custom My Account** in your admin sidebar
5. Use the **Endpoints** tab to reorder, add, or remove account tabs
6. Use the **General** tab to choose your layout style and enable avatar uploads
7. Use the **Style Options** tab to set colors for the account menu
8. Check the **FAQ** tab for answers to common setup questions

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =

Yes. This is a WooCommerce extension and requires WooCommerce to be installed and active. The plugin will display an admin notice and deactivate itself if WooCommerce is not found.

= Can I restrict certain tabs to specific user roles? =

Yes. When editing any endpoint, group, or link, you can select one or more user roles. Only users with those roles will see that item. This is useful for showing wholesale tabs only to wholesale customers, or membership content only to subscribers.

= Can I rename the default WooCommerce tabs? =

Yes. Every default WooCommerce endpoint (Orders, Downloads, Addresses, Account Details, Payment Methods) appears in the Endpoints list. Click the edit icon to rename the label to anything you prefer.

= What is the difference between an Endpoint, a Group, and a Link? =

An **Endpoint** is a new My Account page with its own URL and content area. A **Group** is a collapsible parent item that organizes other tabs under it. A **Link** is a menu item that redirects to any URL (internal or external).

= Can I add custom content to my endpoints? =

Yes. Each custom endpoint has a content editor where you can add text, HTML, shortcodes, or any content that works in the WordPress editor. This means you can embed page builder output, forms, or any plugin shortcodes inside your custom account pages.

= Can customers upload their own profile avatar? =

Yes. Enable **Custom Avatar** in the General settings tab. A photo upload form will appear on the My Account page. The uploaded avatar replaces the default Gravatar across WordPress, including in comments and author boxes.

= Will this work with my theme? =

The plugin is tested with Storefront, BuddyBoss Theme, BuddyX, and standard WordPress themes. It uses scoped CSS that avoids conflicts with theme stylesheets. If your theme uses a custom My Account template, the plugin's WooCommerce template overrides will still apply.

= Why are some icons not showing? =

The plugin ships with its own scoped icon font that works independently of your theme's Font Awesome version. If icons are missing after a theme update, deactivate and reactivate the plugin to refresh the CSS cache, or clear any caching plugins.

= How do I change the layout from sidebar to tabs? =

Go to **WB Plugins > Custom My Account > General** settings. Under **Menu Style**, choose between **Sidebar** (vertical) and **Tab** (horizontal) layout. If you choose Sidebar, you can also set the position to left or right.

= Can I use this with WooCommerce Memberships or Subscriptions? =

Yes. Custom endpoints and role-based visibility work alongside WooCommerce Memberships, WooCommerce Subscriptions, and similar plugins that assign user roles. You can create tabs visible only to active members or subscribers.

= Does this plugin support multisite? =

The plugin works on individual sites within a WordPress multisite network. It can be activated per site. Network-wide activation is supported through the standard WordPress multisite plugin management.

= How do I get updates? =

The plugin receives automatic updates directly from wbcomdesigns.com. You will see update notifications in your WordPress dashboard just like any other plugin. No license key is required for updates.

== Screenshots ==

1. Endpoints admin tab - drag-and-drop interface for managing account tabs, groups, and links
2. Add custom endpoint modal - fields for label, slug, icon, content, and user role restrictions
3. General settings - layout mode (sidebar vs. tab), sidebar position, and avatar upload toggle
4. Style Options - six color pickers for complete menu style customization
5. Frontend My Account page - sidebar layout with custom tabs and Font Awesome icons
6. Frontend My Account page - tab layout with grouped navigation and custom colors

== Changelog ==

= 1.6.0 =
* New: Self-hosted automatic updates via EDD Software Licensing SDK
* New: Added missing "Our Themes" admin page template
* New: Added .distignore for clean distribution packaging
* Fix: Dashboard and Log Out icons not showing when theme loads Font Awesome 5 - scoped icon font to plugin container to prevent conflicts
* Fix: Rewrite rules flushed before custom endpoints registered - changed flush priority to run after endpoint registration
* Fix: Custom CSS classes never applied to menu items - fixed wrong settings key in menu item classes filter
* Fix: Output buffer leak in menu rendering - removed orphaned ob_start() that was never flushed
* Fix: Missing "Name" label in Add Endpoint modal (esc_html_x not echoed)
* Fix: Plugin URI corrected to match actual EDD product page URL
* Fix: Avatar form AJAX endpoint now requires user to be logged in
* Fix: Null guard added to get_current_screen() in admin script enqueue
* Fix: isset() guard on children array in group endpoint rendering
* Security: Sanitize all $_REQUEST input in activation redirect
* Security: Add ABSPATH direct access guards to all include files
* Performance: Disable autoload for wcmp_is_my_account option
* Removed: Dead WCMP_License class (315 lines) - replaced by EDD SL SDK
* Removed: 263 lines of unused code from error handler, sanitizers, and deprecated methods
* Removed: Legacy groups/links/order sanitizer blocks that no form submits
* Removed: Deprecated _hide_by_usr_roles() and wcmp_flush_rewrite_rules() methods
* Tested up to WordPress 6.9.1

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
* Fix: Resolved issue where the endpoint was not shown in the default option
* Update: PHPCS fixes for improved code quality
* Fix: Addressed compatibility issues with PHP 8.2
* Update: Implemented display name filter for better user experience
* Fix: UI improvements for Reign theme integration
* Fix: Resolved issue with all endpoints being disabled
* Fix: Corrected plugin redirect issue when multiple plugins are activated simultaneously

= 1.3.5 =
* Fix: All endpoints disable issue
* Fix: Plugin redirect issue when multiple plugins activate at the same time

= 1.3.4 =
* Fix: Added support for BuddyBoss theme
* Fix: Compatibility with WooCommerce 7.1.0

= 1.3.3 =
* Fix: Managed admin UI

= 1.3.2 =
* Fix: Compatibility with WooCommerce 6.6.1

= 1.3.1 =
* Fix: Managed UI with BuddyX, BuddyX Pro, and BuddyBoss theme
* Fix: Fixed WPCS issues
* Fix: Improved admin UI
* Fix: Updated documentation link
* Fix: Added plugin activation link in admin notice

= 1.3.0 =
* Fix: Managed BuddyX, BuddyX Pro my account spacing
* Fix: Fixed text domain issue
* Fix: Fixed icons issue with default themes

= 1.2.0 =
* Fix: PHPCS fixes
* Fix: Fixed default endpoint setting issue
* Fix: Fixed tabs not displaying in WooCommerce My Account page
* Fix: Fixed Font Awesome class issue

= 1.1.0 =
* Fix: Updated tabs and language files

= 1.0.0 =
* Initial release
