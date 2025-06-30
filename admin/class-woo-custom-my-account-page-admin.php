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
	private $plugin_name = '';

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version = '';
	
	/**
	 * Plugin_settings_tabs
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var mixed      $plugin_settings_tabs      The settings tab.
	 */
	public $plugin_settings_tabs = array();

	/**
	 * Admin Instance.
	 */
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
	 */
	public function __construct() {
		$this->plugin_name = 'woo-custom-my-account-page';
        $this->version = WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$screen = get_current_screen();
		if ( ! $screen || 'wb-plugins_page_woo-custom-myaccount-page' !== $screen->base ) {
			return;
		}
		
		if ( ! wp_style_is( 'wp-color-picker', 'enqueued' ) ) {
			wp_enqueue_style( 'wp-color-picker' );
		}
		if ( ! wp_style_is( 'woo-custom-my-account-page-admin-css', 'enqueued' ) ) {
			wp_enqueue_style( 'woo-custom-my-account-page-admin-css', plugin_dir_url( __FILE__ ) . 'assets/css/woo-custom-my-account-page-admin.css', array(), time(), 'all' );
		}

	}

	/**
	 * Hide all notices from the setting page.
	 *
	 * @return void
	 */
	public function wbcom_hide_all_admin_notices_from_setting_page() {
		$wbcom_pages_array  = array( 'wbcomplugins', 'wbcom-plugins-page', 'wbcom-support-page', 'woo-custom-myaccount-page' );
		$wbcom_setting_page = filter_input( INPUT_GET, 'page' ) ? filter_input( INPUT_GET, 'page' ) : '';

		if ( in_array( $wbcom_setting_page, $wbcom_pages_array, true ) ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
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
						'nonce'        => wp_create_nonce( 'ajax_nonce' ),
						'show_lbl'     => esc_html__( 'Show', 'woo-custom-my-account-page' ),
						'hide_lbl'     => esc_html__( 'Hide', 'woo-custom-my-account-page' ),
						'checked'      => '<i class="fa fa-check"></i>',
						'error_icon'   => '<i class="fa fa-times"></i>',
						'empty_field'  => esc_html__( 'This field is required.', 'woo-custom-my-account-page' ),
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
		add_submenu_page( 'wbcomplugins', esc_html__( 'Custom My Account Page', 'woo-custom-my-account-page' ), esc_html__( 'Woo My Account', 'woo-custom-my-account-page' ), 'manage_options', 'woo-custom-myaccount-page', array( $this, 'wcmp_admin_settings_page' ) );
	}

	/**
	 * Actions performed to display submenu page.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_admin_settings_page() {
		$current = ( filter_input( INPUT_GET, 'tab' ) !== null ) ? filter_input( INPUT_GET, 'tab' ) : 'wcmp-welcome';
		?>
		<div class="wrap">
			<div class="wbcom-bb-plugins-offer-wrapper">
				<div id="wb_admin_logo">
					<a href="https://wbcomdesigns.com/downloads/buddypress-community-bundle/" target="_blank">
						<img src="<?php echo esc_url( WCMP_PLUGIN_URL ) . 'admin/wbcom/assets/imgs/wbcom-offer-notice.png'; ?>">
					</a>
				</div>
			</div>
			<div class="wbcom-wrap">
				<div class="bupr-header">
					<div class="wbcom_admin_header-wrapper">
						<div id="wb_admin_plugin_name">
							<?php esc_html_e( 'WooCommerce Custom My Account Page', 'woo-custom-my-account-page' ); ?>
							  <?php /* translators: %s: */ ?>
							<span><?php printf( esc_html__( 'Version %s', 'woo-custom-my-account-page' ), WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION ); //phpcs:ignore ?></span>
						</div>
						<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
					</div>
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

		$current = ( filter_input( INPUT_GET, 'tab' ) !== null ) ? filter_input( INPUT_GET, 'tab' ) : 'wcmp-welcome';

		$tab_html = '<div class="wbcom-tabs-section"><div class="nav-tab-wrapper"><div class="wb-responsive-menu"><span>' . esc_html( 'Menu' ) . '</span><input class="wb-toggle-btn" type="checkbox" id="wb-toggle-btn"><label class="wb-toggle-icon" for="wb-toggle-btn"><span class="wb-icon-bars"></span></label></div><ul>';
		foreach ( $this->plugin_settings_tabs as $wss_tab => $wss_name ) {
			$class = ( $wss_tab === $current ) ? 'nav-tab-active' : '';
			$page  = 'woo-custom-myaccount-page';
			if ( 'email' === $wss_tab ) {
				$page = 'wc-settings';
			}
			$tab_html .= '<li><a id="' . $wss_tab . '" class="nav-tab ' . $class . '" href="admin.php?page=' . $page . '&tab=' . $wss_tab . '">' . $wss_name . '</a></li>';
		}
		$tab_html .= '</div></ul></div>';
		echo wp_kses_post( $tab_html ); // WPCS: XSS ok.
	}

	/**
	 * Register all settings.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_add_plugin_register_settings() {
		$this->plugin_settings_tabs['wcmp-welcome'] = esc_html__( 'Welcome', 'woo-custom-my-account-page' );
		add_settings_section( 'wcmp-welcome', ' ', array( $this, 'wcmp_welcome_content' ), 'wcmp-welcome' );

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
	 * Welcome Tab Content.
	 *
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @access public
	 */
	public function wcmp_welcome_content() {
		require_once 'partials/wcmp-welcome-page.php';
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

		// Add to beginning of admin AJAX methods
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'Insufficient permissions', 'woo-custom-my-account-page' ) );
		}
		 // Proper nonce verification
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax_nonce' ) ) {		
			wp_die( esc_html__( 'Security check failed', 'woo-custom-my-account-page' ) );			
		}

		// Validate request
		if ( ! isset( $_REQUEST['action'] ) || 'wcmp_add_field' !== $_REQUEST['action'] || ! isset( $_REQUEST['field_name'] ) || ! isset( $_REQUEST['target'] ) ) {
			wp_die( esc_html__( 'Invalid request', 'woo-custom-my-account-page' ) );
		}

		// Sanitize and validate target
		$allowed_targets = array( 'endpoint', 'group', 'link' );
		$request = sanitize_text_field( wp_unslash( $_REQUEST['target'] ) );
		
		if ( ! in_array( $request, $allowed_targets, true ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Invalid target type', 'woo-custom-my-account-page' ) ) );
		}

		$myaccount_func = instantiate_woo_custom_myaccount_functions();

		// Check if is endpoint.
		$request = trim( sanitize_text_field( wp_unslash( $_REQUEST['target'] ) ) );
		// Build field key.
		$field            = $myaccount_func->create_field_key( sanitize_text_field( wp_unslash( $_REQUEST['field_name'] ) ) );
		$options_function = "wcmp_get_default_{$request}_options";
		$print_function   = "wcmp_admin_print_{$request}_field";

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
						update_option( 'woocommerce_myaccount_' . str_replace( '-', '_', $endpoint ) . '_endpoint', $endpoint_details['slug'] );
					}
				}
			}
		}
	}


	/**
	 * Schedule rewrite rules flush
	 */
	public function wcmp_schedule_flush_rewrite_on_endpoint_save() {
		set_transient( 'wcmp_flush_rewrite_rules', true, 60 );
	}

	/**
	 * Maybe flush rewrite rules
	 */
	public function wcmp_maybe_flush_rewrite_rules() {
		if ( get_transient( 'wcmp_flush_rewrite_rules' ) ) {
			flush_rewrite_rules();
			delete_transient( 'wcmp_flush_rewrite_rules' );
		}
	}

}
