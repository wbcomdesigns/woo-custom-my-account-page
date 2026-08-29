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

// Delete the avatar attachments the plugin created, tracked in the
// wcmp-users-avatar-ids registry, before dropping the registry option itself.
$wcmp_avatar_ids = get_option( 'wcmp-users-avatar-ids', array() );
if ( is_array( $wcmp_avatar_ids ) ) {
	foreach ( $wcmp_avatar_ids as $wcmp_attachment_id ) {
		$wcmp_attachment_id = (int) $wcmp_attachment_id;
		if ( $wcmp_attachment_id > 0 ) {
			wp_delete_attachment( $wcmp_attachment_id, true );
		}
	}
}

// Delete every user's avatar meta set by the plugin.
delete_metadata( 'user', 0, 'wb-wcmp-avatar', '', true );

// Delete plugin options.
delete_option( 'wcmp_general_settings' );
delete_option( 'wcmp_endpoints_settings' );
delete_option( 'wcmp_style_settings' );
delete_option( 'wcmp_endpoint_order' );
delete_option( 'wcmp_is_my_account' );
delete_option( 'wcmp-users-avatar-ids' );

// Delete the legacy endpoint option and its per-version settings backups
// (wcmp_endpoint_backup_pre_<version>) created during endpoint migration.
delete_option( 'wcmp_endpoint' );

global $wpdb;
$wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
	$wpdb->prepare(
		"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
		$wpdb->esc_like( 'wcmp_endpoint_backup_pre_' ) . '%'
	)
);

// Delete license data.
delete_option( 'woo-custom-my-account-page_license_key' );
delete_option( 'woo-custom-my-account-page_license' );
delete_option( 'woo-custom-my-account-page_license_key_allow_tracking' );

// Delete transients.
delete_transient( 'wcmp_flush_rewrite_rules' );

// Flush rewrite rules to remove custom endpoints.
flush_rewrite_rules();
