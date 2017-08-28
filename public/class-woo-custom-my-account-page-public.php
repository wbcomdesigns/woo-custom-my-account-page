<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/public
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Woo_Custom_My_Account_Page_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name	 = $plugin_name;
		$this->version		 = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wccma_enqueue_styles() {
		if( is_account_page() ) {
			wp_enqueue_style( $this->plugin_name.'-modal-css', plugin_dir_url( __FILE__ ) . 'css/woo-custom-my-account-page-modal.css' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-custom-my-account-page-public.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wccma_enqueue_scripts() {
		if( is_account_page() ) {
			global $woo_custom_my_account_page;
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-custom-my-account-page-public.js', array( 'jquery' ), $this->version, false );
			wp_localize_script(
				$this->plugin_name,
				'wccma_public_js_obj',
				array(
					'ajaxurl'			=>	admin_url( 'admin-ajax.php' ),
					'default_woo_tab'	=>	$woo_custom_my_account_page->default_woo_tab
				)
			);
		}
	}

	/**
	 * Actions performed to show the user avatar on my-account page
	 */
	public function wccma_myaccount_content() {
		global $woo_custom_my_account_page;
		$user_avatar = get_avatar( get_current_user_id() );
		$user = get_userdata( get_current_user_id() );
		if( isset( $_POST['wccma-submit-user-avatar'] ) ) {
			?>
			<div class="wccma-avatar-update-success">
				<p><?php _e( 'Your avatar has been updated successfully !', WCCMA_TEXT_DOMAIN );?></p>
			</div>
			<?php
		}
		?>
		<div class="wccma-user-avatar">
			<?php echo $user_avatar;?>
			<p><?php echo $user->data->display_name;?></p>
			<?php if( $woo_custom_my_account_page->allow_custom_user_avatar == 'yes' ) {?>
				<a href="javascript:void(0);" data-modal-id="wccma-user-avatar-modal">Edit</a>
			<?php }?>
		</div>
		<?php
	}

	/**
	 * Define the modals used in the plugin
	 */
	public function wccma_modals() {
		$file = WCCMA_PLUGIN_PATH.'public/templates/modals/wccma-user-avatar-modal.php';
		if( file_exists( $file ) ) {
			include_once $file;
		}
	}

	/**
	 * Create the uploads directory - to save the uploads - user avatars
	 */
	public function wccma_create_uploads_directory() {
		$wp_upload_dir 			=	wp_upload_dir();
		$wccma_upload_dir 		=	$wp_upload_dir['basedir'] . '/woo-custom-my-account-page-uploads';
		$wccma_upload_dir_url	=	$wp_upload_dir['baseurl'] . '/woo-custom-my-account-page-uploads';
		if ( !file_exists( $wccma_upload_dir ) ) {
			mkdir( $wccma_upload_dir, 0755, true );
		}

		if( !defined( 'WCCMA_UPLOADS_PATH' ) ) {
			define( 'WCCMA_UPLOADS_PATH', $wccma_upload_dir );
		}

		if( !defined( 'WCCMA_UPLOADS_URL' ) ) {
			define( 'WCCMA_UPLOADS_URL', $wccma_upload_dir_url );
		}
	}

	/**
	 * Change user avatar - set the custom uploaded photo
	 */
	public function wccma_user_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
		$user = false;
		if ( is_numeric( $id_or_email ) ) {
			$id = (int) $id_or_email;
			$user = get_user_by( 'id' , $id );
		} elseif ( is_object( $id_or_email ) ) {
			if ( ! empty( $id_or_email->user_id ) ) {
				$id = (int) $id_or_email->user_id;
				$user = get_user_by( 'id' , $id );
			}
		} else {
			$user = get_user_by( 'email', $id_or_email );  
		}

		$user_avatar = get_user_meta( $user->data->ID, 'wccma_user_avatar' );

		if( !empty( $user_avatar ) ) {
			$user_avatar_url = $user_avatar[0];
			$avatar = "<img alt='{$alt}' src='{$user_avatar_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
			return $avatar;
		} else {
			return $avatar;
		}
	}

}
