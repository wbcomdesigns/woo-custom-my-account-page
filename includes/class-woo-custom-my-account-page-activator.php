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

		self::seed_default_settings();

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

	/**
	 * Seed sensible defaults so the first My Account load is intentional.
	 *
	 * Only fills options that do not exist yet - an existing install keeps
	 * every saved setting. The defaults come from the SAME methods the
	 * runtime falls back to, so seeding changes nothing visually; it makes
	 * the stored state explicit for the admin screens and future upgrades.
	 *
	 * @since 1.6.4
	 */
	private static function seed_default_settings() {
		if ( ! class_exists( 'Woo_Custom_My_Account_Page_Functions' ) ) {
			$functions_file = plugin_dir_path( __DIR__ ) . 'includes/class-woo-custom-my-account-page-functions.php';
			if ( file_exists( $functions_file ) ) {
				require_once $functions_file;
			}
		}

		if ( ! class_exists( 'Woo_Custom_My_Account_Page_Functions' ) ) {
			return;
		}

		$functions = new Woo_Custom_My_Account_Page_Functions();

		if ( false === get_option( 'wcmp_general_settings' ) ) {
			add_option( 'wcmp_general_settings', $functions->default_general_settings(), '', false );
		}

		if ( false === get_option( 'wcmp_style_settings' ) ) {
			add_option( 'wcmp_style_settings', $functions->default_style_settings(), '', false );
		}

		// The endpoint snapshot needs WooCommerce's account menu; skip when
		// Woo is not active yet - the runtime falls back to the same defaults.
		if ( false === get_option( 'wcmp_endpoints_settings' ) && function_exists( 'wc_get_account_menu_items' ) ) {
			add_option( 'wcmp_endpoints_settings', array( 'endpoints' => $functions->default_endpoint_settings() ), '', false );
		}
	}
}
