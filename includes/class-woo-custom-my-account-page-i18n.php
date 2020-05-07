<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/includes
 */

if ( ! class_exists( 'Woo_Custom_My_Account_Page_i18n' ) ) :

	/**
	 * Define the internationalization functionality.
	 *
	 * Loads and defines the internationalization files for this plugin
	 * so that it is ready for translation.
	 *
	 * @since      1.0.0
	 * @package    Woo_Custom_My_Account_Page
	 * @subpackage Woo_Custom_My_Account_Page/includes
	 * @author     Wbcom Designs <admin@wbcomdesigns.com>
	 */
	class Woo_Custom_My_Account_Page_i18n {


		/**
		 * Load the plugin text domain for translation.
		 *
		 * @since    1.0.0
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain(
				'woo-custom-my-account-page',
				false,
				dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
			);

		}

	}

endif;
