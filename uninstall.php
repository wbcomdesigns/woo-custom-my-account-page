<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete plugin options.
delete_option( 'wcmp_general_settings' );
delete_option( 'wcmp_endpoints_settings' );
delete_option( 'wcmp_style_settings' );
delete_option( 'wcmp_endpoint_order' );
delete_option( 'wcmp_is_my_account' );
delete_option( 'wcmp-users-avatar-ids' );

// Delete license data.
delete_option( 'woo-custom-my-account-page_license_key' );
delete_option( 'woo-custom-my-account-page_license' );
delete_option( 'woo-custom-my-account-page_license_key_allow_tracking' );

// Delete transients.
delete_transient( 'wcmp_flush_rewrite_rules' );

// Flush rewrite rules to remove custom endpoints.
flush_rewrite_rules();
