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
	private static $mce_settings = null;
	private static $qt_settings	 = null;

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

//Save general settings
		if ( isset( $_POST[ 'wccma-save-general-settings' ] ) && wp_verify_nonce( $_POST[ 'wccma-general-settings-nonce' ], 'wccma-general' ) ) {
			$this->wccma_save_general_settings();
		}

//Save managed endpoints
		if ( isset( $_POST[ 'wccma-save-endpoints' ] ) && wp_verify_nonce( $_POST[ 'wccma-manage-endpoints-nonce' ], 'wccma-endpoints' ) ) {
			$this->wccma_save_endpoints();
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wccma_admin_enqueue_styles() {

		if ( strpos( $_SERVER[ 'REQUEST_URI' ], $this->plugin_name ) !== false ) {
			wp_enqueue_style( $this->plugin_name . '-modal-css', WCCMA_PLUGIN_URL . 'public/css/woo-custom-my-account-page-modal.css' );
			wp_enqueue_style( $this->plugin_name . '-font-awesome', WCCMA_PLUGIN_URL . 'admin/css/font-awesome.min.css' );
			wp_enqueue_style( $this->plugin_name . '-selectize', WCCMA_PLUGIN_URL . 'admin/css/selectize.css' );
			wp_enqueue_style( $this->plugin_name, WCCMA_PLUGIN_URL . 'admin/css/woo-custom-my-account-page-admin.css' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wccma_admin_enqueue_scripts() {

		if ( strpos( $_SERVER[ 'REQUEST_URI' ], $this->plugin_name ) !== false ) {


			wp_enqueue_script( 'tiny_mce' );
			wp_enqueue_script( $this->plugin_name . '-selectize-js', WCCMA_PLUGIN_URL . 'admin/js/selectize.min.js', array( 'jquery' ) );
			wp_enqueue_script( $this->plugin_name, WCCMA_PLUGIN_URL . 'admin/js/woo-custom-my-account-page-admin.js', array( 'jquery' ) );

			wp_localize_script(
			$this->plugin_name, 'wccma_admin_js_object', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			)
			);
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
			<div class="wccma-header">
				<h2 class="wccma-plugin-heading"><?php _e( 'WooCommerce Custom My Account Page', WCCMA_TEXT_DOMAIN ); ?></h2>
				<div class="wccma-extra-actions">
					<button type="button" class="button button-secondary" onclick="window.open( 'https://wbcomdesigns.com/contact/', '_blank' );"><i class="fa fa-envelope" aria-hidden="true"></i> <?php _e( 'Email Support', WCCMA_TEXT_DOMAIN ) ?></button>
					<button type="button" class="button button-secondary" onclick="window.open( 'https://wbcomdesigns.com/helpdesk/article-categories/woo-custom-my-account-page/', '_blank' );"><i class="fa fa-file" aria-hidden="true"></i> <?php _e( 'User Manual', WCCMA_TEXT_DOMAIN ) ?></button>
					<button disabled type="button" class="button button-secondary" onclick="window.open( 'https://wordpress.org/support/plugin/woo-custom-my-account-page/reviews/', '_blank' );"><i class="fa fa-star" aria-hidden="true"></i> <?php _e( 'Rate Us on WordPress.org', WCCMA_TEXT_DOMAIN ) ?></button>
				</div>
			</div>
			<?php $this->wccma_plugin_settings_tabs(); ?>
			<?php do_settings_sections( $tab ); ?>
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
		$this->plugin_settings_tabs[ 'endpoints' ] = __( 'Endpoints', WCCMA_TEXT_DOMAIN );
		register_setting( 'endpoints', 'endpoints' );
		add_settings_section( 'wccma-endpoints-section', ' ', array( &$this, 'wccma_endpoints_settings_content' ), 'endpoints' );
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
		$this->plugin_settings_tabs[ 'support' ] = __( 'Support', WCCMA_TEXT_DOMAIN );
		register_setting( 'support', 'support' );
		add_settings_section( 'wccma-support-section', ' ', array( &$this, 'wccma_support_settings_content' ), 'support' );
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
		if ( isset( $_POST[ 'wccma-custom-avatar' ] ) ) {
			$allow_custom_user_avatar = 'yes';
		}
		if ( isset( $_POST[ 'wccma-menu-style-tab' ] ) ) {
			$menu_style = sanitize_text_field( $_POST[ 'wccma-menu-style-tab' ] );
		}
		//Set default active tab
		$default_woo_tab = sanitize_text_field( $_POST[ 'wccma-default-tab' ] );

		$wccma_settings = array(
			'allow_custom_user_avatar'	 => $allow_custom_user_avatar,
			'default_woo_tab'			 => $default_woo_tab,
			'menu_style'				 => $menu_style
		);

		update_option( 'wccma_settings', $wccma_settings );

		$success_msg = "<div class='notice updated' id='message'>";
		$success_msg .= "<p>" . __( 'Settings Saved.', WCCMA_TEXT_DOMAIN ) . "</p>";
		$success_msg .= "</div>";
		echo $success_msg;
	}

	/**
	 * Save Endpoints
	 */
	public function wccma_save_endpoints() {
		$woo_endpoints	 = unserialize( sanitize_text_field( $_POST[ 'wccma-woo-endpoints' ] ) );
		$endpoints_data	 = array();
		foreach ( $woo_endpoints as $menu_slug ) {
			$user_roles = array();
			if ( !empty( $_POST[ $menu_slug . '-user-roles' ] ) ) {
				$user_roles = wp_unslash( $_POST[ $menu_slug . '-user-roles' ] );
			}

			$endpoints_data[ $menu_slug ] = array(
				'label'		 => sanitize_text_field( $_POST[ $menu_slug . '-label' ] ),
				'icon'		 => sanitize_text_field( $_POST[ $menu_slug . '-icon' ] ),
				'user_roles' => $user_roles,
				'content'	 => stripslashes( wp_filter_post_kses( addslashes( $_POST[ $menu_slug . '-tab-content' ] ) ) )
			);
		}

		update_option( 'wccma_endpoints', $endpoints_data );

		$success_msg = "<div class='notice updated is-dismissible' id='message'>";
		$success_msg .= "<p>" . __( 'Endpoints Saved.', WCCMA_TEXT_DOMAIN ) . "</p>";
		$success_msg .= "</div>";
		echo $success_msg;
	}

	/**
	 * Setup Dashboard link in admin bar
	 */
	public function wccma_setup_admin_bar( $wp_admin_nav = array() ) {
		global $wp_admin_bar;
		$menu_title	 = __( 'My Account', WCCMA_TEXT_DOMAIN );
		$base_url	 = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );

		if ( is_user_logged_in() ) {
			$user = get_userdata( get_current_user_id() );
			if ( isset( $user->roles ) && is_array( $user->roles ) ) {
				$wp_admin_bar->add_menu( array(
					'parent' => 'my-account-buddypress',
					'id'	 => 'woo-my-account',
					'title'	 => __( $menu_title, WCCMA_TEXT_DOMAIN ),
					'href'	 => trailingslashit( $base_url )
				) );
			}
		}
	}

	/**
	 * Modals in admin area - all defined in footer
	 */
	public function wccma_admin_modals() {
		//Add endpoint modal
		$endpoint_modal = WCCMA_PLUGIN_PATH . 'admin/templates/modals/wccma-add-endpoint-modal.php';
		if ( file_exists( $endpoint_modal ) ) {
			include_once $endpoint_modal;
		}

		//Add group modal
		$group_modal = WCCMA_PLUGIN_PATH . 'admin/templates/modals/wccma-add-group-modal.php';
		if ( file_exists( $group_modal ) ) {
			include_once $group_modal;
		}
	}

	/**
	 * Ajax served, to remove endpoint
	 */
	public function wccma_remove_endpoints() {
		if ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'wccma_remove_endpoints' ) {
			$del_ins		 = sanitize_text_field( $_POST[ 'del_ins' ] );
			$wccma_endpoints = get_option( 'wccma_endpoints' );
			if ( !empty( $wccma_endpoints ) ) {
				foreach ( $wccma_endpoints as $key => $value ) {
					if ( $key == $del_ins ) {
						unset( $wccma_endpoints[ $key ] );
					}
					if ( $key == $del_ins && $key == $wccma_endpoints[ 'default_woo_tab' ] ) {
						$wccma_endpoints[ 'default_woo_tab' ] = 'dashboard';
					}
				}
			}
			update_option( 'wccma_endpoints', $wccma_endpoints );
		}
		die;
	}

	/**
	 * Ajax served, to add endpoint
	 */
	public function wccma_add_endpoint() {
		if ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'wccma_add_endpoint' ) {
			global $woo_custom_my_account_page;
			$endpoint			 = sanitize_text_field( $_POST[ 'endpoint' ] );
			$endpoint_slug		 = sanitize_text_field( $_POST[ 'endpoint_slug' ] );
			$font_awesome_icons	 = $woo_custom_my_account_page->font_awesome_icons;
			$wp_user_roles		 = get_editable_roles();
			$woo_endpoints		 = unserialize( stripslashes( sanitize_text_field( $_POST[ 'woo_endpoints' ] ) ) );
			$woo_endpoints[]	 = $endpoint_slug;
			$editor_args		 = array(
				'wpautop'		 => true, // use wpautop?
				'media_buttons'	 => true, // show insert/upload button(s)
				'textarea_name'	 => $endpoint_slug . '-tab-content', // set the textarea name to something different, square brackets [] can be used here
				'textarea_rows'	 => 15, // rows="..."
				'tabindex'		 => '',
				'editor_css'	 => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
				'editor_class'	 => '', // add extra class(es) to the editor textarea
				'teeny'			 => false, // output the minimal editor config used in Press This
				'dfw'			 => false, // replace the default fullscreen with DFW (needs specific DOM elements and css)
				'tinymce'		 => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
				'quicktags'		 => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
			);
//Prepare endpoint details html
			$htm				 = '';
			$htm				 .= '<div class="wccma-my-account-menu-item wccma-endpoint" id="menu-' . $endpoint_slug . '" data-menu="' . $endpoint_slug . '">';
			$htm				 .= '<span id="' . $endpoint_slug . '-power-icon"><i class="fa fa-power-off"></i></span>';
			$htm				 .= '<label for="">' . $endpoint . '</label>';
			$htm				 .= '<span class="wccma-angles" id="span-menu-' . $endpoint_slug . '"><i class="fa fa-angle-down"></i></span>';
			$htm				 .= '</div>';
			$htm				 .= '<div class="wccma-menu-item-details" id="wccma-menu-item-detail-' . $endpoint_slug . '">';
			$htm				 .= '<div class="wccma-remove-endpoints-parent"><a href="javascript:void(0)" data-remenu="' . $endpoint_slug . '" onclick="wccma_remove_endpoints( this )" class="wccma-remove-endpoints">' . __( 'Remove', WCCMA_TEXT_DOMAIN ) . '</a></div>';
			$htm				 .= '<table class="form-table">';

//ENDPOINT LABEL
			$htm .= '<tr>';
			$htm .= '<th>' . __( 'Endpoint Label', WCCMA_TEXT_DOMAIN ) . '</th>';
			$htm .= '<td>';
			$htm .= '<input type="text" class="wccma-text-input" name="' . $endpoint_slug . '-label" placeholder="' . __( 'Label', WCCMA_TEXT_DOMAIN ) . '" value="' . $endpoint . '">';
			$htm .= '<p class="description">' . __( 'This is the label that the user will see on My Account page.', WCCMA_TEXT_DOMAIN ) . '</p>';
			$htm .= '</td>';
			$htm .= '</tr>';

//ENDPOINT ICON
			$htm .= '<tr>';
			$htm .= '<th>' . __( 'Endpoint Icon', WCCMA_TEXT_DOMAIN ) . '</th>';
			$htm .= '<td>';
			$htm .= '<select class="wccma-font-awesome-icons" name="' . $endpoint_slug . '-icon">';
			$htm .= '<option value=""></option>';
			if ( !empty( $font_awesome_icons ) ) {
				foreach ( $font_awesome_icons as $fa_icon => $fa_icon_unicode ) {
					$htm .= '<option value="' . $fa_icon_unicode . '">' . str_replace( '-', ' ', str_replace( 'fa-', '', $fa_icon ) ) . '</option>';
				}
			}
			$htm .= '</select>';
			$htm .= '<p class="description">' . __( 'This is the icon that the denote the above mentioned label.', WCCMA_TEXT_DOMAIN ) . '</p>';
			$htm .= '</td>';
			$htm .= '</tr>';

//USER ROLES
			$htm .= '<tr>';
			$htm .= '<th>' . __( 'User Roles', WCCMA_TEXT_DOMAIN ) . '</th>';
			$htm .= '<td>';
			$htm .= '<select class="wccma-user-roles" multiple name="' . $endpoint_slug . '-user-roles[]">';
			foreach ( $wp_user_roles as $role_slug => $role ) {
				$htm .= '<option value="' . $role_slug . '">' . $role[ 'name' ] . '</option>';
			}
			$htm .= '</select>';
			$htm .= '<p class="description">' . __( 'Select the user roles for which you want to hide this menu.', WCCMA_TEXT_DOMAIN ) . '</p>';
			$htm .= '</td>';
			$htm .= '</tr>';

//ENDPOINT CONTENT
			$htm		 .= '<tr>';
			$htm		 .= '<th>' . __( 'Endpoint Content', WCCMA_TEXT_DOMAIN ) . '</th>';
			$htm		 .= '<td>';
			ob_start();
			wp_editor( '', $endpoint_slug . '-tab-content', $editor_args );
			\_WP_Editors::enqueue_scripts();
			\_WP_Editors::editor_js();
			$htm		 .= ob_get_clean();
			$htm		 .= '<p class="description">' . __( 'This will hold the tab content.', WCCMA_TEXT_DOMAIN ) . '</p>';
			$htm		 .= '</td>';
			$htm		 .= '</tr>';
			$htm		 .= '</table>';
			$htm		 .= '</div>';
			$response	 = array(
				'message'		 => __( 'Endpoint added', WCCMA_TEXT_DOMAIN ),
				'html'			 => $htm,
				'editor_html'	 => $html,
				'woo_endpoints'	 => serialize( $woo_endpoints )
			);
			wp_send_json_success( $response );
			die;
		}
	}

}
