<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/includes
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/includes
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Woo_Custom_My_Account_Page {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies and set the hooks for the admin area and the public-facing
	 * side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION' ) ) {
			$this->version = WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woo-custom-my-account-page';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Custom_My_Account_Page_Admin. Defines all hooks for the admin area.
	 * - Woo_Custom_My_Account_Page_Public. Defines all hooks for the public side of the site.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-woo-custom-my-account-page-functions.php';

		/**
		 * Enqueue wbcom plugin settings file.
		 */

		/**
		 * The error handler class for improved stability.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-wcmp-error-handler.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-woo-custom-my-account-page-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-woo-custom-my-account-page-public.php';
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woo_Custom_My_Account_Page_Admin();

		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );
		add_action( 'init', array( $plugin_admin, 'boot_settings_page' ), 1 );
		add_action( 'admin_menu', array( $plugin_admin, 'wcmp_add_plugin_menu_page' ), 5 );
		add_action( 'admin_init', array( $plugin_admin, 'wcmp_add_plugin_register_settings' ) );

		// Update WooCommerce tab slugs after save endpoint settings.
		add_action( 'update_option_wcmp_endpoints_settings', array( $plugin_admin, 'wcmp_update_woo_endpoints_slug' ), 10, 3 );

		// Add endpoint ajax (admin-only, no nopriv handler needed).
		add_action( 'wp_ajax_wcmp_add_field', array( $plugin_admin, 'wcmp_add_field_ajax' ) );
		add_action( 'in_admin_header', array( $plugin_admin, 'wbcom_hide_all_admin_notices_from_setting_page' ) );

		add_action( 'update_option_wcmp_endpoints_settings', array( $plugin_admin, 'wcmp_schedule_flush_rewrite_on_endpoint_save' ) );
		add_action( 'init', array( $plugin_admin, 'wcmp_maybe_flush_rewrite_rules' ), 30 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woo_Custom_My_Account_Page_Public( $this->get_plugin_name(), $this->get_version() );

		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_scripts' ) );

		// Filter user avatar.
		add_filter( 'get_avatar', array( $plugin_public, 'wcmp_get_avatar' ), 100, 6 );
		// Add avatar.
		add_action( 'template_redirect', array( $plugin_public, 'wcmp_add_avatar' ) );
		// Reset default avatar.
		add_action( 'template_redirect', array( $plugin_public, 'wcmp_reset_default_avatar' ) );
		// Display 'change avatar' form ajax.
		add_action( 'wc_ajax_wcmp_print_avatar_form', array( $plugin_public, 'wcmp_print_avatar_form_ajax' ) );

		add_filter( 'woocommerce_account_menu_item_classes', array( $plugin_public, 'wcmp_account_menu_item_classes' ), 999, 2 );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
