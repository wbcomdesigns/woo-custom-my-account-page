<?php
/**
 * This file is used for rendering FAQ content.
 *
 * @since   1.4.1
 * @package Woo_Custom_My_Account_Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
	// Exit if accessed directly.
}
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'Frequently Asked Questions', 'woo-custom-my-account-page' ); ?></h3>
			<p><?php esc_html_e( 'Find answers to common questions about using the WooCommerce Custom My Account Page plugin.', 'woo-custom-my-account-page' ); ?></p>
		</div>

		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">

			<div class="wcmp-faq-section">
				<h3 class="wcmp-faq-title"><?php esc_html_e( 'Getting Started', 'woo-custom-my-account-page' ); ?></h3>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I customize my WooCommerce My Account page?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Navigate to WooCommerce → Custom My Account Page → Endpoints tab. Here you can:', 'woo-custom-my-account-page' ); ?></p>
					<ul>
						<li><?php esc_html_e( '• Drag and drop to reorder menu items', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Show/hide endpoints using the power icon', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Click on an endpoint to edit its settings', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Use the buttons at the top to add groups, endpoints, or links', 'woo-custom-my-account-page' ); ?></li>
					</ul>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: What\'s the difference between Endpoints, Groups, and Links?', 'woo-custom-my-account-page' ); ?></h4>
					<p><strong><?php esc_html_e( 'Endpoints:', 'woo-custom-my-account-page' ); ?></strong> <?php esc_html_e( 'These are pages within your My Account area (e.g., Orders, Downloads, Account Details). They display content on the same site.', 'woo-custom-my-account-page' ); ?></p>
					<p><strong><?php esc_html_e( 'Groups:', 'woo-custom-my-account-page' ); ?></strong> <?php esc_html_e( 'Organize multiple endpoints together under a collapsible menu. Perfect for grouping related items like "My Purchases" (Orders + Downloads).', 'woo-custom-my-account-page' ); ?></p>
					<p><strong><?php esc_html_e( 'Links:', 'woo-custom-my-account-page' ); ?></strong> <?php esc_html_e( 'Add external or internal links to your menu (e.g., Support page, Blog, FAQs). They can open in the same tab or a new tab.', 'woo-custom-my-account-page' ); ?></p>
				</div>
			</div>

			<div class="wcmp-faq-section">
				<h3 class="wcmp-faq-title"><?php esc_html_e( 'Creating & Managing Items', 'woo-custom-my-account-page' ); ?></h3>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I create a new custom endpoint?', 'woo-custom-my-account-page' ); ?></h4>
					<ol>
						<li><?php esc_html_e( 'Go to Endpoints tab', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Click "Add endpoint" button', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Enter a name (e.g., "Wishlist")', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Click "Add" and configure the settings:', 'woo-custom-my-account-page' ); ?></li>
					</ol>
					<ul style="margin-left: 20px;">
						<li><?php esc_html_e( '• Endpoint slug: URL-friendly version (e.g., wishlist)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Label: Display name in the menu', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Icon: FontAwesome class (e.g., fa fa-heart)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Content: Custom HTML/shortcode for the page', 'woo-custom-my-account-page' ); ?></li>
					</ul>
					<ol start="5">
						<li><?php esc_html_e( 'Click "Save Changes"', 'woo-custom-my-account-page' ); ?></li>
					</ol>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I create a group with sub-items?', 'woo-custom-my-account-page' ); ?></h4>
					<ol>
						<li><?php esc_html_e( 'Click "Add group" button', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Enter a name (e.g., "My Purchases")', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Drag and drop existing endpoints INTO the group area', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'The group will now show a dropdown arrow with sub-items', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Save your changes', 'woo-custom-my-account-page' ); ?></li>
					</ol>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I add an external link to the menu?', 'woo-custom-my-account-page' ); ?></h4>
					<ol>
						<li><?php esc_html_e( 'Click "Add link" button', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Enter a name (e.g., "Support")', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Configure the link settings:', 'woo-custom-my-account-page' ); ?></li>
					</ol>
					<ul style="margin-left: 20px;">
						<li><?php esc_html_e( '• Link URL: Full URL (e.g., https://example.com/support)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Link label: Display text', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Open in new tab: Check to open externally', 'woo-custom-my-account-page' ); ?></li>
					</ul>
					<ol start="4">
						<li><?php esc_html_e( 'Save your changes', 'woo-custom-my-account-page' ); ?></li>
					</ol>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I reorder menu items?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Simply drag and drop items to rearrange them. The order you see in the admin panel is the order customers will see on the frontend. Don\'t forget to click "Save Changes" to apply your new order.', 'woo-custom-my-account-page' ); ?></p>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I remove an endpoint?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Click on the endpoint to expand it, then click the "Remove" link. This will delete it from your menu. Note: You can also just hide it using the power icon if you want to keep it for later.', 'woo-custom-my-account-page' ); ?></p>
				</div>
			</div>

			<div class="wcmp-faq-section">
				<h3 class="wcmp-faq-title"><?php esc_html_e( 'Customization Options', 'woo-custom-my-account-page' ); ?></h3>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I add icons to menu items?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: This plugin uses FontAwesome 4.7 icons. To add an icon:', 'woo-custom-my-account-page' ); ?></p>
					<ol>
						<li><?php esc_html_e( 'Visit FontAwesome icon gallery: https://fontawesome.com/v4/icons/', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Find an icon you like (e.g., "shopping-cart")', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Copy the class name (e.g., "fa fa-shopping-cart")', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Paste it into the "Icon" field of your endpoint', 'woo-custom-my-account-page' ); ?></li>
					</ol>
					<p><strong><?php esc_html_e( 'Popular icons:', 'woo-custom-my-account-page' ); ?></strong></p>
					<ul>
						<li><?php esc_html_e( '• fa fa-user (user profile)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• fa fa-shopping-cart (orders)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• fa fa-download (downloads)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• fa fa-map-marker (addresses)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• fa fa-heart (wishlist)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• fa fa-life-ring (support)', 'woo-custom-my-account-page' ); ?></li>
					</ul>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I restrict endpoints to specific user roles?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Each endpoint has a "User roles" dropdown where you can select which roles can see it (e.g., Customer, Subscriber, Administrator). Leave it blank to show to all users. This is useful for:', 'woo-custom-my-account-page' ); ?></p>
					<ul>
						<li><?php esc_html_e( '• Showing wholesale pricing only to wholesale customers', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Displaying admin tools only to administrators', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Creating VIP-only sections for premium members', 'woo-custom-my-account-page' ); ?></li>
					</ul>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: Can I add custom content to an endpoint?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Yes! The "Endpoint content" field accepts:', 'woo-custom-my-account-page' ); ?></p>
					<ul>
						<li><?php esc_html_e( '• HTML markup for custom layouts', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Shortcodes from other plugins', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Text with formatting', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Embedded forms or widgets', 'woo-custom-my-account-page' ); ?></li>
					</ul>
					<p><?php esc_html_e( 'Example: [contact-form-7 id="123"] to embed a contact form.', 'woo-custom-my-account-page' ); ?></p>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: How do I change the styling of my menu?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Go to the "Style Options" tab where you can customize:', 'woo-custom-my-account-page' ); ?></p>
					<ul>
						<li><?php esc_html_e( '• Menu layout (vertical/horizontal)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Colors for menu items, backgrounds, and hover states', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Icon styles and sizes', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Typography options', 'woo-custom-my-account-page' ); ?></li>
					</ul>
				</div>
			</div>

			<div class="wcmp-faq-section">
				<h3 class="wcmp-faq-title"><?php esc_html_e( 'Troubleshooting', 'woo-custom-my-account-page' ); ?></h3>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: My changes aren\'t showing on the frontend. What should I do?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Try these steps:', 'woo-custom-my-account-page' ); ?></p>
					<ol>
						<li><?php esc_html_e( 'Make sure you clicked "Save Changes" in the admin panel', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Clear your browser cache and refresh the page', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Clear any caching plugins (WP Super Cache, W3 Total Cache, etc.)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Check if the endpoint is enabled (power icon should be ON)', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( 'Verify user role restrictions aren\'t hiding the item', 'woo-custom-my-account-page' ); ?></li>
					</ol>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: I\'m getting a 404 error on my custom endpoint. How do I fix it?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Go to WordPress Settings → Permalinks and click "Save Changes" without changing anything. This will flush the rewrite rules and make your endpoint accessible.', 'woo-custom-my-account-page' ); ?></p>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: Can I restore the default WooCommerce menu?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Yes, simply remove all custom endpoints, groups, and links, and leave only the default WooCommerce endpoints (Dashboard, Orders, Downloads, Addresses, Account Details, Logout). You can also deactivate the plugin temporarily to see the default layout.', 'woo-custom-my-account-page' ); ?></p>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: The drag and drop isn\'t working. What\'s wrong?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: This is usually a JavaScript conflict. Try:', 'woo-custom-my-account-page' ); ?></p>
					<ul>
						<li><?php esc_html_e( '• Temporarily deactivating other plugins to find the conflict', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Switching to a default WordPress theme (like Twenty Twenty-Three) temporarily', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Checking your browser console for JavaScript errors (F12)', 'woo-custom-my-account-page' ); ?></li>
					</ul>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: My custom endpoint content isn\'t displaying. Why?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Check these common issues:', 'woo-custom-my-account-page' ); ?></p>
					<ul>
						<li><?php esc_html_e( '• Make sure the "Endpoint content" field has content', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• If using a shortcode, verify the shortcode plugin is active', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Check if your theme overrides the My Account template', 'woo-custom-my-account-page' ); ?></li>
						<li><?php esc_html_e( '• Ensure there are no HTML errors in your custom content', 'woo-custom-my-account-page' ); ?></li>
					</ul>
				</div>
			</div>

			<div class="wcmp-faq-section">
				<h3 class="wcmp-faq-title"><?php esc_html_e( 'Advanced Usage', 'woo-custom-my-account-page' ); ?></h3>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: Can I use custom CSS classes?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Yes! Each endpoint has a "Class" field where you can add custom CSS classes. Use these to apply specific styling to individual menu items. For example, add "highlight-item" and then add CSS in your theme:', 'woo-custom-my-account-page' ); ?></p>
					<pre style="background: #f5f5f5; padding: 10px; border-radius: 4px;">.highlight-item { background: #ffeb3b; font-weight: bold; }</pre>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: Can I add conditional logic to endpoints?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: While the plugin doesn\'t have built-in conditional logic beyond user roles, you can use WordPress hooks and filters to add custom conditions. For developers:', 'woo-custom-my-account-page' ); ?></p>
					<pre style="background: #f5f5f5; padding: 10px; border-radius: 4px; overflow-x: auto;">add_filter( 'woocommerce_account_menu_items', 'custom_menu_logic', 99 );
function custom_menu_logic( $items ) {
	// Your custom logic here
	return $items;
}</pre>
				</div>

				<div class="wcmp-faq-item">
					<h4><?php esc_html_e( 'Q: Is this plugin compatible with other WooCommerce plugins?', 'woo-custom-my-account-page' ); ?></h4>
					<p><?php esc_html_e( 'A: Yes! This plugin works with most WooCommerce extensions. Endpoints created by other plugins (like Subscriptions, Bookings, Memberships) will automatically appear in the Endpoints tab where you can customize them.', 'woo-custom-my-account-page' ); ?></p>
				</div>
			</div>

			<div class="wcmp-faq-section">
				<h3 class="wcmp-faq-title"><?php esc_html_e( 'Need More Help?', 'woo-custom-my-account-page' ); ?></h3>
				<p><?php esc_html_e( 'If your question isn\'t answered here, please check out these resources:', 'woo-custom-my-account-page' ); ?></p>
				<ul>
					<li><a href="https://docs.wbcomdesigns.com/doc_category/woo-custom-my-account-page/" target="_blank"><?php esc_html_e( 'Full Documentation', 'woo-custom-my-account-page' ); ?></a></li>
					<li><a href="https://wbcomdesigns.com/support/" target="_blank"><?php esc_html_e( 'Support Center', 'woo-custom-my-account-page' ); ?></a></li>
					<li><a href="https://wbcomdesigns.com/contact/" target="_blank"><?php esc_html_e( 'Contact Us', 'woo-custom-my-account-page' ); ?></a></li>
				</ul>
			</div>

		</div>
	</div>
</div>

<style>
.wcmp-faq-section {
	margin-bottom: 40px;
}
.wcmp-faq-section:last-child {
	margin-bottom: 0;
}
.wcmp-faq-title {
	font-size: 18px;
	font-weight: 600;
	margin-bottom: 20px;
	padding-bottom: 10px;
	border-bottom: 2px solid #e5e5e5;
	color: #23282d;
}
.wcmp-faq-item {
	background: #fff;
	padding: 20px;
	margin-bottom: 15px;
	border: 1px solid #e5e5e5;
	border-radius: 4px;
}
.wcmp-faq-item h4 {
	margin: 0 0 15px 0;
	font-size: 15px;
	font-weight: 600;
	color: #0073aa;
}
.wcmp-faq-item p {
	margin: 10px 0;
	line-height: 1.6;
}
.wcmp-faq-item ul,
.wcmp-faq-item ol {
	margin: 10px 0 10px 20px;
	line-height: 1.8;
}
.wcmp-faq-item ul li,
.wcmp-faq-item ol li {
	margin-bottom: 8px;
}
.wcmp-faq-item strong {
	color: #23282d;
}
.wcmp-faq-item pre {
	font-size: 13px;
	line-height: 1.5;
	margin: 10px 0;
}
.wcmp-faq-section > p {
	margin-bottom: 15px;
	font-size: 14px;
}
.wcmp-faq-section > ul {
	list-style: disc;
	margin-left: 20px;
	line-height: 2;
}
.wcmp-faq-section > ul li a {
	color: #0073aa;
	text-decoration: none;
	font-weight: 500;
}
.wcmp-faq-section > ul li a:hover {
	text-decoration: underline;
}
</style>
