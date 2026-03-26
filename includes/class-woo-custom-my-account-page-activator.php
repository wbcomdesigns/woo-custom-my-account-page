<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/includes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/includes
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Woo_Custom_My_Account_Page_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Set a transient flag so rewrite rules are flushed on the next page load
		// (after custom endpoints have been registered via init hook).
		set_transient( 'wcmp_flush_rewrite_rules', true, 60 );

		// Preset free license key so users receive automatic updates without activation.
		$key_option    = 'woo-custom-my-account-page_license_key';
		$status_option = 'woo-custom-my-account-page_license';

		if ( ! get_option( $key_option ) ) {
			update_option( $key_option, 'wbcomfreea4f9c2d8b7e61a3c9d5e0f4b2c8a7e19', false );
			update_option(
				$status_option,
				(object) array(
					'success'          => true,
					'license'          => 'valid',
					'item_id'          => 110615,
					'item_name'        => 'Custom My Account Page for WooCommerce',
					'license_limit'    => 0,
					'site_count'       => 0,
					'expires'          => 'lifetime',
					'activations_left' => 'unlimited',
					'payment_id'       => 0,
					'customer_name'    => '',
					'customer_email'   => '',
				),
				false
			);
		}
	}
}
