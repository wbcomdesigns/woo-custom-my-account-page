<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/includes
 */

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
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Custom_My_Account_Page_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

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
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name	 = 'woo-custom-my-account-page';
		$this->version		 = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_globals();
		$this->define_public_hooks();
		$this->define_endpoints();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Custom_My_Account_Page_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_Custom_My_Account_Page_i18n. Defines internationalization functionality.
	 * - Woo_Custom_My_Account_Page_Admin. Defines all hooks for the admin area.
	 * - Woo_Custom_My_Account_Page_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-custom-my-account-page-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-custom-my-account-page-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-custom-my-account-page-admin.php';

		/**
		 * The class responsible for defining the global variable of the plugin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-custom-my-account-page-globals.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-custom-my-account-page-public.php';

		/**
		 * The class responsible for defining all the custom woocommerce endpoints
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-custom-my-account-page-endpoints.php';

		$this->loader = new Woo_Custom_My_Account_Page_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_Custom_My_Account_Page_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_Custom_My_Account_Page_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_name = $this->get_plugin_name();
		$plugin_admin = new Woo_Custom_My_Account_Page_Admin( $plugin_name, $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'wccma_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'wccma_admin_enqueue_scripts' );
		$this->loader->add_action( 'bp_setup_admin_bar', $plugin_admin, 'wccma_setup_admin_bar' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wccma_add_admin_submenu_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wccma_register_general_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wccma_register_endpoints_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wccma_register_support_settings' );

		if ( stripos( $_SERVER[ 'REQUEST_URI' ], $plugin_name ) !== false ) {
			$this->loader->add_action( 'admin_footer', $plugin_admin, 'wccma_admin_modals' );
		}

		$this->loader->add_action( 'wp_ajax_wccma_add_endpoint', $plugin_admin, 'wccma_add_endpoint' );
		$this->loader->add_action( 'wp_ajax_wccma_add_wp_editor', $plugin_admin, 'wccma_add_wp_editor' );
		$this->loader->add_action( 'wp_ajax_wccma_remove_endpoints', $plugin_admin, 'wccma_remove_endpoints' );
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
		global $woo_custom_my_account_page;
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wccma_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wccma_enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_before_account_navigation', $plugin_public, 'wccma_myaccount_content' );
		$this->loader->add_action( 'init', $plugin_public, 'wccma_create_uploads_directory' );
		if ( $woo_custom_my_account_page->allow_custom_user_avatar == 'yes' ) {
			$this->loader->add_action( 'wp_footer', $plugin_public, 'wccma_modals' );
		}
		$this->loader->add_filter( 'get_avatar', $plugin_public, 'wccma_user_custom_avatar', 1, 5 );
		$this->loader->add_filter( 'woocommerce_account_menu_items', $plugin_public, 'wccma_remove_my_account_menu_items' );
		$this->loader->add_action( 'template_redirect', $plugin_public, 'wccma_redirect_default_my_account_tabs' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'wccma_add_menu_style_footer' );
	}

	/**
	 * Registers a global variable of the plugin - woo-custom-my-account-page
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function define_globals() {
		global $woo_custom_my_account_page;
		$woo_custom_my_account_page = new Woo_Custom_My_Account_Page_Globals( $this->get_plugin_name(), $this->get_version() );
	}

	/**
	 * Registers all the custom woocommerce tabs
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function define_endpoints() {
		new Woo_Custom_My_Account_Page_Endpoints( $this->get_plugin_name(), $this->get_version() );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
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
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Custom_My_Account_Page_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
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
