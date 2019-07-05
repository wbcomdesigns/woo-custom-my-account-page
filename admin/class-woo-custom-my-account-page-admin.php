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
	 * The single instance of the class.
	 *
	 * @var   Woo_Custom_My_Account_Page_Admin
	 * @since 1.0.0
	 */
	protected static $instance = null;

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

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  1.0.0
	 * @param  string $plugin_name The name of this plugin.
	 * @param  string $version     The version of this plugin.
	 */
	public function __construct() {
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
			if ( ! wp_script_is( 'jquery-ui', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui' );
			}
			if ( ! wp_script_is( 'jquery-ui-accordion', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-accordion' );
			}
			if ( ! wp_script_is( 'jquery-ui-sortable', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
			}
			wp_register_script( 'nestable', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.nestable.js', array( 'jquery' ), time(), true );
			if ( ! wp_style_is( 'select2-css', 'enqueued' ) ) {
				wp_enqueue_style( 'select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.css' );
			}
			if ( ! wp_script_is( 'select2-js', 'enqueued' ) ) {
				wp_enqueue_script( 'select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.js' );
			}
			if ( ! wp_script_is( 'woo-custom-my-account-page-admin-js', 'enqueued' ) ) {
				wp_enqueue_script( 'woo-custom-my-account-page-admin-js', plugin_dir_url( __FILE__ ) . 'assets/js/woo-custom-my-account-page-admin.js', array( 'jquery', 'wp-color-picker', 'nestable', 'jquery-ui-dialog' ), time(), false );
				wp_localize_script(
					'woo-custom-my-account-page-admin-js',
					'wcmp',
					array(
						'ajaxurl'      => admin_url( 'admin-ajax.php' ),
						'action_add'   => 'wcmp_add_field',
						'show_lbl'     => esc_html__( 'Show', 'woo-custom-my-account-page' ),
						'hide_lbl'     => esc_html__( 'Hide', 'woo-custom-my-account-page' ),
						// 'loading'	    => '<img src="' . yith_wcmap_ASSETS_URL . '/images/wpspin_light.gif' . '">',
						'checked'      => '<i class="fa fa-check"></i>',
						'error_icon'   => '<i class="fa fa-times"></i>',
						'remove_alert' => esc_html__( 'Are you sure that you want to delete this endpoint?', 'woo-custom-my-account-page' ),
					)
				);
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

	/**
	 * Add a new field using ajax.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_add_field_ajax() {

		if ( ! ( isset( $_REQUEST['action'] ) && 'wcmp_add_field' == $_REQUEST['action'] ) || ! isset( $_REQUEST['field_name'] ) || ! isset( $_REQUEST['target'] ) ) {
			die();
		}

		$myaccount_func = instantiate_woo_custom_myaccount_functions();

		// Check if is endpoint.
		$request = trim( $_REQUEST['target'] );
		// Build field key.
		$field            = $myaccount_func->create_field_key( $_REQUEST['field_name'] );
		$options_function = "wcmp_get_default_{$request}_options";
		$print_function   = "wcmp_admin_print_{$request}_field";

		// echo '<pre>options_function: '; print_r( $options_function ); echo '</pre>';
		// echo '<pre>print_function: '; print_r( $print_function ); echo '</pre>';

		// if ( ! $field || ! function_exists( $options_function ) || ! function_exists( $print_function ) ) {
		// wp_send_json( array(
		// 'error' => esc_html__( 'An error has occurred or this endpoint field already exists. Please try again.', 'woo-custom-my-account-page' ),
		// 'field' => false
		// ) );
		// }

		// Build args array.
		$args = array(
			'endpoint'  => $field,
			'options'   => $myaccount_func->$options_function( $field ),
			'id'        => 'wcmp_endpoint',
			'usr_roles' => array(),
		);

		ob_start();
		$this->$print_function( $args );
		$html = ob_get_clean();

		wp_send_json(
			array(
				'html'  => $html,
				'field' => $field,
			)
		);
	}

	/**
	 * Print endpoint field options.
	 *
	 * @since  1.0.0
	 * @param  array $args Template args array.
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_admin_print_endpoint_field( $args ) {
		// Let third part filter template args.
		$args = apply_filters( 'wcmp_admin_print_endpoint_field', $args );
		extract( $args );
		include WCMP_PLUGIN_PATH . 'admin/partials/endpoint-item.php';
	}

	/**
	 * Print endpoints group field options.
	 *
	 * @since  1.0.0
	 * @param  array $args Template args array.
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_admin_print_group_field( $args ) {
		// let third part filter template args.
		$args = apply_filters( 'wcmp_admin_print_endpoints_group', $args );
		extract( $args );
		include WCMP_PLUGIN_PATH . 'admin/partials/group-item.php';
	}

	/**
	 * Print endpoints link field options.
	 *
	 * @since  1.0.0
	 * @param  array $args Template args array.
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_admin_print_link_field( $args ) {
		// let third part filter template args.
		$args = apply_filters( 'wcmp_admin_print_link_field', $args );
		extract( $args );

		include WCMP_PLUGIN_PATH . 'admin/partials/link-item.php';
	}

	/**
	 * Update WooCommerce tab slugs after save endpoint settings.
	 *
	 * @since  1.0.0
	 * @param  array  $old_value   Template args array.
	 * @param  array  $new_value   Template args array.
	 * @param  string $option_name The option name.
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_update_woo_endpoints_slug( $old_value, $new_value, $option_name ) {
		$wcmp_obj          = instantiate_woo_custom_myaccount_functions();
		$default_endpoints = $wcmp_obj->default_endpoint_settings();
		if ( array_key_exists( 'endpoints', $new_value ) ) {
			if ( ! empty( $new_value['endpoints'] ) ) {
				foreach ( $new_value['endpoints'] as $endpoint => $endpoint_details ) {
					if ( ( 'dashboard' !== $endpoint ) && array_key_exists( $endpoint, $default_endpoints ) ) {
						update_option( 'woocommerce_myaccount_'. str_replace( '-', '_', $endpoint ) .'_endpoint', $endpoint_details['slug'] );
					}
				}
			}
		}
	}

}
