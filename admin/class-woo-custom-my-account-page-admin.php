<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.wbcomdesigns.com
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

		$this->plugin_name	 = $plugin_name;
		$this->version		 = $version;

		if( isset( $_POST['wccma-save-general-settings'] ) && wp_verify_nonce( $_POST['wccma-general-settings-nonce'], 'wccma-general' ) ) {
			$this->wccma_save_general_settings();
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wccma_admin_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Custom_My_Account_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Custom_My_Account_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if( strpos( $_SERVER['REQUEST_URI'], $this->plugin_name ) !== false ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-custom-my-account-page-admin.css' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wccma_admin_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Custom_My_Account_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Custom_My_Account_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if( strpos( $_SERVER['REQUEST_URI'], $this->plugin_name ) !== false ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-custom-my-account-page-admin.js', array( 'jquery' ) );
		}
	}

	/**
	 * Actions performed to add an admin menu page
	 */
	public function wccma_add_admin_submenu_page() {
		add_submenu_page( 'woocommerce', __( 'WooCommerce Custom My Account Page Settings', WCCMA_TEXT_DOMAIN ), __( 'Custom My Account Page', WCCMA_TEXT_DOMAIN ), 'manage_options', $this->plugin_name, array( $this, 'wccma_admin_submenu_page_content' ) );
	}

	/**
	 * Actions performed to create a submenu page content
	 */
	public function wccma_admin_submenu_page_content() {
		$tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $this->plugin_name;
		?>
		<div class="wrap">
			<h2><?php _e( 'Custom My Account Page - WooCommerce', WCCMA_TEXT_DOMAIN ); ?></h2>
			<p><?php _e( 'This plugin will allow the site administrator to setup a custom <strong>WooCommerce My Account Page</strong>.', WCCMA_TEXT_DOMAIN ); ?></p>
			<?php $this->wccma_plugin_settings_tabs(); ?>
			<form action="" method="POST" id="<?php echo $tab; ?>-settings-form" enctype="multipart/form-data">
				<?php do_settings_sections( $tab ); ?>
			</form>
		</div> 
		<?php
	}

	/**
	 * Actions performed to create tabs on the submenu page
	 */
	public function wccma_plugin_settings_tabs() {
		$current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $this->plugin_name;
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_name . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
		echo '</h2>';
	}

	/**
	 * General Tab
	 */
	public function wccma_register_general_settings() {
		$this->plugin_settings_tabs[ 'woo-custom-my-account-page' ] = __( 'General', WCCMA_TEXT_DOMAIN );
		register_setting( 'woo-custom-my-account-page', 'woo-custom-my-account-page' );
		add_settings_section( 'woo-custom-my-account-page-general-section', ' ', array( &$this, 'wccma_general_settings_content' ), 'woo-custom-my-account-page' );
	}

	/**
	 * General Tab Content
	 */
	public function wccma_general_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/includes/wccma-general-settings.php' ) ) {
			require_once( dirname( __FILE__ ) . '/includes/wccma-general-settings.php' );
		}
	}

	/**
	 * Endpoints Tab
	 */
	public function wccma_register_endpoints_settings() {
		$this->plugin_settings_tabs[ 'wccma-endpoints' ] = __( 'Endpoints', WCCMA_TEXT_DOMAIN );
		register_setting( 'wccma-endpoints', 'wccma-endpoints' );
		add_settings_section( 'wccma-endpoints-section', ' ', array( &$this, 'wccma_endpoints_settings_content' ), 'wccma-endpoints' );
	}

	/**
	 * Endpoints Tab Content
	 */
	public function wccma_endpoints_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/includes/wccma-endpoints-settings.php' ) ) {
			require_once( dirname( __FILE__ ) . '/includes/wccma-endpoints-settings.php' );
		}
	}

	/**
	 * Support Tab
	 */
	public function wccma_register_support_settings() {
		$this->plugin_settings_tabs[ 'wccma-support' ] = __( 'Support', WCCMA_TEXT_DOMAIN );
		register_setting( 'wccma-support', 'wccma-support' );
		add_settings_section( 'wccma-support-section', ' ', array( &$this, 'wccma_support_settings_content' ), 'wccma-support' );
	}

	/**
	 * Support Tab Content
	 */
	public function wccma_support_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/includes/wccma-support-settings.php' ) ) {
			require_once( dirname( __FILE__ ) . '/includes/wccma-support-settings.php' );
		}
	}

	/**
	 * Save General Settings
	 */
	public function wccma_save_general_settings() {
		//Allow custom avatar
		$allow_custom_user_avatar = 'no';
		if( isset( $_POST['wccma-custom-avatar'] ) ) {
			$allow_custom_user_avatar = 'yes';
		}

		//Set default active tab
		$default_woo_tab = sanitize_text_field( $_POST['wccma-default-tab'] );

		$wccma_settings = array(
			'allow_custom_user_avatar' => $allow_custom_user_avatar,
			'default_woo_tab' => $default_woo_tab
		);

		update_option( 'wccma_settings', $wccma_settings );

		$success_msg = "<div class='notice updated is-dismissible' id='message'>";
		$success_msg .= "<p>".__( 'Settings Saved.', WCCMA_TEXT_DOMAIN )."</p>";
		$success_msg .= "</div>";
		echo $success_msg;
	}

	/**
	 * Setup Dashboard link in admin bar
	 */
	public function wccma_setup_admin_bar( $wp_admin_nav = array() ) {
		global $wp_admin_bar;
		$menu_title = __( 'My Account', WCCMA_TEXT_DOMAIN );
		$base_url = get_permalink( get_option('woocommerce_myaccount_page_id') );

		if ( is_user_logged_in() ) {
			$user = get_userdata( get_current_user_id() );
			if ( isset( $user->roles ) && is_array( $user->roles ) ) {
				$wp_admin_bar->add_menu( array(
					'parent' => 'my-account-buddypress',
					'id' => 'woo-my-account',
					'title' => __( $menu_title, WCCMA_TEXT_DOMAIN ),
					'href' => trailingslashit( $base_url )
				) );
			}
		}
	}

}
