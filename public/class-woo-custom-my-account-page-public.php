<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
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
	 * @since  1.0.0
	 * @param  string $plugin_name The name of the plugin.
	 * @param  string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		if ( ! is_account_page() ) {
			return;
		}

		if ( ! wp_style_is( 'font-awesome', 'enqueued' ) ) {
			wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
		}

		wp_register_style( 'wcmp-frontend', plugin_dir_url( __FILE__ ) . 'assets/css/woo-custom-my-account-page-public.css' );
		wp_enqueue_style( 'wcmp-frontend' );

		$inline_css = $this->wcmp_get_custom_css();
		wp_add_inline_style( 'wcmp-frontend', $inline_css );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since   1.0.0
	 */
	public function enqueue_scripts() {

		if ( ! is_account_page() ) {
			return;
		}

		wp_register_script( 'wcmp-frontend', plugin_dir_url( __FILE__ ) . 'assets/js/woo-custom-my-account-page-public.js', array( 'jquery' ), false, true );

		// ENQUEUE SCRIPTS.
		wp_enqueue_script( 'wcmp-frontend' );
		wp_localize_script(
			'wcmp-frontend',
			'wcmp',
			array(
				'ajaxurl'     => WC_AJAX::get_endpoint( '%%endpoint%%' ),
				'actionPrint' => 'wcmp_print_avatar_form',
			)
		);
	}

	/**
	 * Add custom css for styling myaccount page.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 */
	public function wcmp_get_custom_css() {
		$myaccount_func = instantiate_woo_custom_myaccount_functions();
		$all_settings   = $myaccount_func->wcmp_settings_data();
		$settings       = $all_settings['style_settings'];
		$inline_css     = '
				#my-account-menu .logout a, #my-account-menu-tab .logout a {
					color:' . $settings['logout_color'] . ';
					background-color:' . $settings['logout_background_color'] . ';
				}
				#my-account-menu .logout:hover a, #my-account-menu-tab .logout:hover a {
					color:' . $settings['logout_hover_color'] . ';
					background-color:' . $settings['logout_background_hover_color'] . ';
				}
				.myaccount-menu li a {
					color:' . $settings['menu_item_color'] . ';
				}
				.myaccount-menu li a:hover, .myaccount-menu li.active > a, .myaccount-menu li.is-active > a {
					color:' . $settings['menu_item_hover_color'] . ';
				}';

		return apply_filters( 'wcmp_get_custom_css', $inline_css );
	}

	/**
	 * Add user avatar.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 */
	public function wcmp_add_avatar() {
		$avatar_data = wp_unslash( $_POST );
		if ( ! empty( $avatar_data['_nonce'] ) ) {
			$nonce = sanitize_text_field( $avatar_data['_nonce'] );
		}

		if ( ! isset( $_FILES['wcmp_user_avatar'] ) || ! wp_verify_nonce( $nonce, 'wp_handle_upload' ) ) {
			return;
		}

		// Required files.
		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
		}

		$media_id = media_handle_upload( 'wcmp_user_avatar', 0 );

		if ( is_wp_error( $media_id ) ) {
			return;
		}

		// Save media id for filter query in media library.
		$medias   = get_option( 'wcmp-users-avatar-ids', array() );
		$medias[] = $media_id;
		// Then save.
		update_option( 'wcmp-users-avatar-ids', $medias );

		// Save user meta.
		$user = get_current_user_id();
		update_user_meta( $user, 'wb-wcmp-avatar', $media_id );

	}

	/**
	 * Reset standard WordPress avatar for customer.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 */
	public function wcmp_reset_default_avatar() {

		if ( ! isset( $_FILES['reset_image'] ) || ( ! isset( $_POST['action'] ) ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['action'] ) ), 'reset_image' ) ) {

			if ( ! isset( $_POST['action'] ) || 'wcmp_reset_avatar' !== $_POST['action'] ) {
				return;
			}
		}

		// Get user id.
		$user     = get_current_user_id();
		$media_id = get_user_meta( $user, 'wb-wcmp-avatar', true );

		if ( ! $media_id ) {
			return;
		}

		// Remove id from global list.
		$medias = get_option( 'wcmp-users-avatar-ids', array() );
		foreach ( $medias as $key => $media ) {
			if ( $media === $media_id ) {
				unset( $media[ $key ] );
				continue;
			}
		}

		// Then save.
		update_option( 'wcmp-users-avatar-ids', $medias );

		// Then delete user meta.
		delete_user_meta( $user, 'wb-wcmp-avatar' );

		// Then delete media attachment.
		wp_delete_attachment( $media_id );

	}

	/**
	 * Reset standard WordPress avatar for customer.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 */
	public function wcmp_print_avatar_form_ajax() {
		if ( ! is_ajax() ) {
			return;
		}
		echo $this->wcmp_get_avatar_form(); //phpcs:ignore
		die();
	}

	/**
	 * Get avatar upload form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @author Wbcom Designs
	 * @param  boolean $print Print or return avatar form.
	 * @param  array   $args Array of argument for the template.
	 * @return string
	 */
	public function wcmp_get_avatar_form( $print = false, $args = array() ) {
		ob_start();
		wc_get_template( 'wcmp-myaccount-avatar-form.php', $args, '', WCMP_PLUGIN_PATH . 'public/templates/' );
		$form = ob_get_clean();

		if ( $print ) {
			echo $form; //phpcs:ignore
			return;
		}

		return $form;
	}

	/**
	 * Get customer avatar for user.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @param  string $avatar Get user avatar image.
	 * @param  mixed  $id_or_email Get email id of user.
	 * @param  string $size Get user avatar image size.
	 * @param  string $default Default.
	 * @param  string $alt Get user avatar image alt attribute.
	 * @param  array  $args Arguments.
	 */
	public function wcmp_get_avatar( $avatar, $id_or_email, $size, $default, $alt, $args = array() ) {

		if ( $this->get_avatar_filter() ) {
			return $avatar;
		}

		// Prevent filter.
		remove_all_filters( 'get_avatar' );
		// Re-add filter.
		add_filter( 'get_avatar', array( $this, 'wcmp_get_avatar' ), 100, 6 );

		if ( empty( $args ) ) {
			$args['size']       = (int) $size;
			$args['height']     = $args['size'];
			$args['width']      = $args['size'];
			$args['alt']        = $alt;
			$args['extra_attr'] = '';
		}

		$user = false;

		if ( is_string( $id_or_email ) && is_email( $id_or_email ) ) {
			$user = get_user_by( 'email', $id_or_email );
		} elseif ( $id_or_email instanceof WP_User ) {
			// User Object.
			$user = $id_or_email;
		} elseif ( $id_or_email instanceof WP_Post ) {
			// Post Object.
			$user = get_user_by( 'id', (int) $id_or_email->post_author );
		} elseif ( $id_or_email instanceof WP_Comment ) {

			if ( ! empty( $id_or_email->user_id ) ) {
				$user = get_user_by( 'id', (int) $id_or_email->user_id );
			}
			if ( ( ! $user || is_wp_error( $user ) ) && ! empty( $id_or_email->comment_author_email ) ) {
				$email = $id_or_email->comment_author_email;
				$user  = get_user_by( 'email', $email );
			}
		}

		// Get the user ID.
		$user_id = ! $user ? $id_or_email : $user->ID;

		// Get custom avatar.
		$custom_avatar = get_user_meta( $user_id, 'wb-wcmp-avatar', true );

		if ( ! $custom_avatar ) {
			return $avatar;
		}

		// Maybe resize img.
		$resized = $this->wcmp_resize_avatar_url( $custom_avatar, $size );
		// If error occurred return.
		if ( ! $resized ) {
			return $avatar;
		}

		$src   = $this->wcmp_generate_avatar_url( $custom_avatar, $size );
		$class = array( 'avatar', 'avatar-' . (int) $args['size'], 'photo' );

		$avatar = sprintf(
			"<img alt='%s' src='%s' class='%s' height='%d' width='%d' %s/>",
			esc_attr( $args['alt'] ),
			esc_url( $src ),
			esc_attr( join( ' ', $class ) ),
			(int) $args['height'],
			(int) $args['width'],
			$args['extra_attr']
		);

		return $avatar;
	}

	/**
	 * Prevent get avatar filter.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @return boolean
	 */
	public function get_avatar_filter() {
		return apply_filters( 'wcmp_get_avatar_filter', get_option( 'wb-wcmp-custom-avatar', 'yes' ) !== 'yes' );
	}

	/**
	 * Generate avatar path.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @param  int $attachment_id The image attachment id.
	 * @param  int $size          The image size.
	 * @return string
	 */
	public function wcmp_generate_avatar_path( $attachment_id, $size ) {
		// Retrieves attached file path based on attachment ID.
		$filename = get_attached_file( $attachment_id );

		$pathinfo  = pathinfo( $filename );
		$dirname   = $pathinfo['dirname'];
		$extension = $pathinfo['extension'];

		// i18n friendly version of basename().
		$basename = wp_basename( $filename, '.' . $extension );

		$suffix    = $size . 'x' . $size;
		$dest_path = $dirname . '/' . $basename . '-' . $suffix . '.' . $extension;

		return $dest_path;
	}

	/**
	 * Generate avatar url.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @param int $attachment_id The image attachment id.
	 * @param int $size          The image size.
	 * @return mixed
	 */
	public function wcmp_generate_avatar_url( $attachment_id, $size ) {
		// Retrieves path information on the currently configured uploads directory.
		$upload_dir = wp_upload_dir();

		// Generates a file path of an avatar image based on attachment ID and size.
		$path = $this->wcmp_generate_avatar_path( $attachment_id, $size );

		return str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $path );
	}

	/**
	 * Resize avatar.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 * @param  int $attachment_id The image attachment id.
	 * @param  int $size          The image size.
	 * @return boolean
	 */
	public function wcmp_resize_avatar_url( $attachment_id, $size ) {

		$dest_path = $this->wcmp_generate_avatar_path( $attachment_id, $size );

		if ( file_exists( $dest_path ) ) {
			$resize = true;
		} else {
			// Retrieves attached file path based on attachment ID.
			$path = get_attached_file( $attachment_id );

			// Retrieves a WP_Image_Editor instance and loads a file into it.
			$image = wp_get_image_editor( $path );

			if ( ! is_wp_error( $image ) ) {

				// Resizes current image.
				$image->resize( $size, $size, true );

				// Saves current image to file.
				$image->save( $dest_path );

				$resize = true;

			} else {
				$resize = false;
			}
		}

		return $resize;
	}

}
