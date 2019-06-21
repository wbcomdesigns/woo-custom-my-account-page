<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/admin
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Woo_Custom_My_Account_Page_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$screen = get_current_screen();
		if ( 'wb-plugins_page_woo-custom-myaccount-page' === $screen->base ) {
			if ( ! wp_style_is( 'wp-color-picker', 'enqueued' ) ) {
				wp_enqueue_style( 'wp-color-picker' );
			}	
			if ( ! wp_style_is( 'woo-custom-my-account-page-admin-css', 'enqueued' ) ) {
				wp_enqueue_style( 'woo-custom-my-account-page-admin-css', plugin_dir_url( __FILE__ ) . 'assets/css/woo-custom-my-account-page-admin.css', array(), time(), 'all' );
			}
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$screen = get_current_screen();
		if ( 'wb-plugins_page_woo-custom-myaccount-page' === $screen->base ) {
			if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery' );
			}
			if ( ! wp_script_is( 'jquery-ui-sortable', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
			}
			if ( ! wp_script_is( 'woo-custom-my-account-page-admin-js', 'enqueued' ) ) {
				wp_enqueue_script( 'woo-custom-my-account-page-admin-js', plugin_dir_url( __FILE__ ) . 'assets/js/woo-custom-my-account-page-admin.js', array( 'wp-color-picker' ), time(), false );
			}	
		}

	}

	/**
	 * Register a submenu in admin area ( In case of other wbcom plugin exists ) or a menu with submenu.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_add_plugin_menu_page() {
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			add_menu_page( esc_html__( 'WB Plugins', 'woo-custom-my-account-page' ), esc_html__( 'WB Plugins', 'woo-custom-my-account-page' ), 'manage_options', 'wbcomplugins', array( $this, 'wcmp_admin_settings_page' ), 'dashicons-lightbulb', 59 );
			add_submenu_page( 'wbcomplugins', esc_html__( 'General', 'woo-custom-my-account-page' ), esc_html__( 'General', 'woo-custom-my-account-page' ), 'manage_options', 'wbcomplugins' );
		}
		add_submenu_page( 'wbcomplugins', esc_html__( 'Custom Myaccount Page', 'woo-custom-my-account-page' ), esc_html__( 'Custom Myaccount Page', 'woo-custom-my-account-page' ), 'manage_options', 'woo-custom-myaccount-page', array( $this, 'wcmp_admin_settings_page' ) );
	}

	/**
	 * Actions performed to display submenu page.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_admin_settings_page() {
		$current = ( filter_input( INPUT_GET, 'tab' ) !== null ) ? filter_input( INPUT_GET, 'tab' ) : 'wcmp-general';
		?>
		<div class="wrap">
			<div class="wcmp-admin-header">
				<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
				<h1 class="wbcom-plugin-heading">
					<?php esc_html_e( 'WooCommerce Custom Myaccount Page Settings', 'woo-custom-myaccount-page' ); ?>
				</h1>
			</div>
			<?php settings_errors(); ?>
			<div class="wbcom-admin-settings-page">
				<?php
				$this->wcmp_plugin_settings_tabs();
				settings_fields( $current );
				do_settings_sections( $current );
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Actions performed to create tabs on the sub menu page.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_plugin_settings_tabs() {

		$current = ( filter_input( INPUT_GET, 'tab' ) !== null ) ? filter_input( INPUT_GET, 'tab' ) : 'wcmp-general';

		$tab_html = '<div class="wbcom-tabs-section"><h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $wss_tab => $wss_name ) {
			$class = ( $wss_tab === $current ) ? 'nav-tab-active' : '';
			$page  = 'woo-custom-myaccount-page';
			if ( 'email' === $wss_tab ) {
				$page = 'wc-settings';
			}
			$tab_html .= '<a id="' . $wss_tab . '" class="nav-tab ' . $class . '" href="admin.php?page=' . $page . '&tab=' . $wss_tab . '">' . $wss_name . '</a>';
		}
		$tab_html .= '</h2></div>';
		echo $tab_html;
	}

	/**
	 * Register all settings.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_add_plugin_register_settings() {
		$this->plugin_settings_tabs['wcmp-general'] = esc_html__( 'General', 'woo-custom-my-account-page' );
		register_setting( 'wcmp_general_settings', 'wcmp_general_settings' );
		add_settings_section( 'wcmp-general', ' ', array( $this, 'wcmp_general_settings_content' ), 'wcmp-general' );
		$this->plugin_settings_tabs['wcmp-style'] = esc_html__( 'Style Options', 'woo-custom-my-account-page' );
		register_setting( 'wcmp_style_settings', 'wcmp_style_settings', array( $this, 'wcmp_style_settings_callback' ) );
		add_settings_section( 'wcmp-style', ' ', array( $this, 'wcmp_style_settings_content' ), 'wcmp-style' );
		$this->plugin_settings_tabs['wcmp-endpoints'] = esc_html__( 'Endpoints', 'woo-custom-my-account-page' );
		register_setting( 'wcmp_endpoints_settings', 'wcmp_endpoints_settings', array( $this, 'wcmp_endpoints_settings_callback' ) );
		add_settings_section( 'wcmp-endpoints', ' ', array( $this, 'wcmp_endpoints_settings_content' ), 'wcmp-endpoints' );
	}

	/**
	 * General Tab Content.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_general_settings_content() {
		require_once 'partials/wcmp-general-settings.php';
	}

	/**
	 * Style Options Tab Content.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_style_settings_content() {
		require_once 'partials/wcmp-style-settings.php';
	}

	/**
	 * Endpoints Tab Content.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_endpoints_settings_content() {
		require_once 'partials/wcmp-endpoints-settings.php';
	}

}
