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

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

		// Check if Font Awesome is already loaded.
		global $wp_styles;
		$font_awesome_loaded = false;

		if ( ! is_account_page() ) {
			return;
		}

		foreach ( $wp_styles->registered as $handle => $style ) {
			if ( false !== strpos( $style->src, 'font-awesome' ) || false !== strpos( $style->src, 'fontawesome' ) ) {
				$font_awesome_loaded = true;
				break;
			}
		}

		if ( ! $font_awesome_loaded ) {
			// Use minimal Font Awesome subset (only 19 icons we actually use).
			wp_enqueue_style( 'wcmp-font-awesome', plugin_dir_url( __DIR__ ) . 'assets/vendor/font-awesome/css/wcmp-icons.min.css', array(), '6.7.2' );
		}

		wp_register_style( 'wcmp-frontend', plugin_dir_url( __FILE__ ) . 'assets/css/woo-custom-my-account-page-public.css', array(), $this->version );
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

		if ( ! function_exists( 'is_account_page' ) || ! is_account_page() ) {
			return;
		}

		wp_register_script( 'wcmp-frontend', plugin_dir_url( __FILE__ ) . 'assets/js/woo-custom-my-account-page-public.js', array( 'jquery' ), $this->version, true );

		// Enqueue scripts.
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
		// Fixed: Proper nonce handling and initialization.
		$nonce = isset( $_POST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_nonce'] ) ) : '';

		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'wp_handle_upload' ) ) {
			return;
		}

		// Security: Check user is logged in before any file processing.
		if ( ! is_user_logged_in() ) {
			return;
		}

		// Security: Validate file upload exists and no upload errors.
		if ( ! isset( $_FILES['wcmp_user_avatar'] ) ) {
			return;
		}

		$avatar_file = $_FILES['wcmp_user_avatar']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		if ( ! isset( $avatar_file['error'] ) || UPLOAD_ERR_OK !== $avatar_file['error'] ) {
			return;
		}

		// Security: Enhanced file type validation with MIME check.
		$allowed_types = array( 'image/jpeg', 'image/png', 'image/gif', 'image/webp' );
		$file_tmp_name = isset( $avatar_file['tmp_name'] ) ? $avatar_file['tmp_name'] : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$file_name     = isset( $avatar_file['name'] ) ? sanitize_file_name( $avatar_file['name'] ) : '';
		$file_type     = wp_check_filetype_and_ext( $file_tmp_name, $file_name );

		if ( ! $file_type['type'] || ! in_array( $file_type['type'], $allowed_types, true ) ) {
			wc_add_notice( __( 'Invalid file type. Only JPG, PNG, GIF and WebP images are allowed.', 'woo-custom-my-account-page' ), 'error' );
			return;
		}

		// Check file size (max 2MB).
		$max_size  = 2 * 1024 * 1024;
		$file_size = isset( $avatar_file['size'] ) ? absint( $avatar_file['size'] ) : 0;
		if ( $file_size > $max_size ) {
			wc_add_notice( __( 'Image size must be less than 2MB.', 'woo-custom-my-account-page' ), 'error' );
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
			wc_add_notice( $media_id->get_error_message(), 'error' );
			return;
		}

		// Save media id for filter query in media library.
		$medias = get_option( 'wcmp-users-avatar-ids', array() );
		if ( ! is_array( $medias ) ) {
			$medias = array();
		}
		if ( ! in_array( $media_id, $medias, true ) ) {
			$medias[] = $media_id;
			// Then save.
			update_option( 'wcmp-users-avatar-ids', $medias, false );
		}

		// Save user meta.
		$user = get_current_user_id();
		update_user_meta( $user, 'wb-wcmp-avatar', $media_id );

		// Add success message.
		wc_add_notice( __( 'Avatar updated successfully!', 'woo-custom-my-account-page' ), 'success' );

		// Redirect to prevent resubmission.
		wp_safe_redirect( wc_get_account_endpoint_url( 'dashboard' ) );
		exit;
	}

	/**
	 * Reset standard WordPress avatar for customer.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 */
	public function wcmp_reset_default_avatar() {

		// Improved: Use sanitize_text_field for validation.
		$action = isset( $_POST['action'] ) ? sanitize_text_field( wp_unslash( $_POST['action'] ) ) : '';
		if ( ! $action || 'wcmp_reset_avatar' !== $action ) {
			return;
		}

		$reset_nonce = isset( $_POST['reset_image'] ) ? sanitize_text_field( wp_unslash( $_POST['reset_image'] ) ) : '';
		if ( ! $reset_nonce || ! wp_verify_nonce( $reset_nonce, 'action' ) ) {
			return;
		}

		if ( ! is_user_logged_in() ) {
			return;
		}

		// Get user id.
		$user     = get_current_user_id();
		$media_id = get_user_meta( $user, 'wb-wcmp-avatar', true );

		if ( ! $media_id ) {
			return;
		}

		// Remove id from global list.
		$medias = get_option( 'wcmp-users-avatar-ids', array() );
		if ( is_array( $medias ) ) {
			foreach ( $medias as $key => $media ) {
				if ( (int) $media === (int) $media_id ) {
					unset( $medias[ $key ] );
					break;
				}
			}
			// Re-index array and save.
			$medias = array_values( $medias );
			update_option( 'wcmp-users-avatar-ids', $medias, false );
		}

		// Then delete user meta.
		delete_user_meta( $user, 'wb-wcmp-avatar' );

		// Delete the attachment file from server to free space.
		wp_delete_attachment( $media_id, true );

		wc_add_notice( __( 'Avatar removed successfully!', 'woo-custom-my-account-page' ), 'success' );
		// Redirect.
		wp_safe_redirect( wc_get_account_endpoint_url( 'dashboard' ) );
		exit;
	}

	/**
	 * Reset standard WordPress avatar for customer.
	 *
	 * @access public
	 * @since  1.0.0
	 * @author Wbcom Designs
	 */
	public function wcmp_print_avatar_form_ajax() {
		if ( ! is_ajax() || ! is_user_logged_in() ) {
			return;
		}
		// Get the avatar form HTML.
		$avatar_form = $this->wcmp_get_avatar_form();

		// Get allowed HTML tags for form elements.
		$allowed_html = $this->get_form_allowed_html();

		// Output with proper escaping for form elements.
		echo wp_kses( $avatar_form, $allowed_html );
		die();
	}

	/**
	 * Get avatar upload form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @author Wbcom Designs
	 * @param  boolean $should_print Whether to print or return avatar form.
	 * @param  array   $args         Array of argument for the template.
	 * @return string|void
	 */
	public function wcmp_get_avatar_form( $should_print = false, $args = array() ) {
		ob_start();
		wc_get_template( 'wcmp-myaccount-avatar-form.php', $args, '', WCMP_PLUGIN_PATH . 'public/templates/' );
		$form = ob_get_clean();

		if ( $should_print ) {
			// Use the same allowed HTML tags as in wcmp_print_avatar_form_ajax.
			$allowed_html = $this->get_form_allowed_html();
			echo wp_kses( $form, $allowed_html );
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
	 * @param  string $avatar      Get user avatar image.
	 * @param  mixed  $id_or_email Get email id of user.
	 * @param  string $size        Get user avatar image size.
	 * @param  string $default_val Default value.
	 * @param  string $alt         Get user avatar image alt attribute.
	 * @param  array  $args        Arguments.
	 */
	public function wcmp_get_avatar( $avatar, $id_or_email, $size, $default_val, $alt, $args = array() ) {
		static $is_processing = false;

		if ( $is_processing || $this->get_avatar_filter() ) {
			return $avatar;
		}

		$is_processing = true;

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

		$is_processing = false;

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
		// Get the custom_avatar setting from wcmp_general_settings.
		$general_settings = get_option( 'wcmp_general_settings', array() );
		$custom_avatar    = isset( $general_settings['custom_avatar'] ) ? $general_settings['custom_avatar'] : 'yes';

		// Return true if custom avatar is disabled (filter should prevent custom avatar).
		return apply_filters( 'wcmp_get_avatar_filter', 'yes' !== $custom_avatar );
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

	/**
	 * Add custom classes to menu items.
	 *
	 * @param array  $classes  Current classes.
	 * @param string $endpoint Endpoint.
	 * @return array
	 */
	public function wcmp_account_menu_item_classes( $classes, $endpoint ) {
		$functions = instantiate_woo_custom_myaccount_functions();
		// Fixed: get_menu_items_options() doesn't exist, using wcmp_settings_data() instead.
		$all_settings = $functions->wcmp_settings_data();
		$options      = isset( $all_settings['endpoints_settings'] ) ? $all_settings['endpoints_settings'] : array();

		if ( isset( $options[ $endpoint ] ) && ! empty( $options[ $endpoint ]['class'] ) ) {
			$classes[] = $options[ $endpoint ]['class'];
		}

		return $classes;
	}

	/**
	 * Get allowed HTML tags for form elements.
	 *
	 * @access private
	 * @since  1.0.0
	 * @return array Allowed HTML tags and attributes.
	 */
	private function get_form_allowed_html() {
		return array(
			'form'   => array(
				'action'  => array(),
				'method'  => array(),
				'enctype' => array(),
				'class'   => array(),
				'id'      => array(),
			),
			'input'  => array(
				'type'        => array(),
				'name'        => array(),
				'value'       => array(),
				'class'       => array(),
				'id'          => array(),
				'placeholder' => array(),
				'required'    => array(),
				'checked'     => array(),
				'disabled'    => array(),
				'readonly'    => array(),
				'accept'      => array(),
			),
			'button' => array(
				'type'     => array(),
				'class'    => array(),
				'id'       => array(),
				'name'     => array(),
				'value'    => array(),
				'disabled' => array(),
			),
			'label'  => array(
				'for'   => array(),
				'class' => array(),
			),
			'div'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'span'   => array(
				'class' => array(),
				'id'    => array(),
			),
			'img'    => array(
				'src'    => array(),
				'alt'    => array(),
				'class'  => array(),
				'id'     => array(),
				'width'  => array(),
				'height' => array(),
			),
			'a'      => array(
				'href'   => array(),
				'class'  => array(),
				'id'     => array(),
				'target' => array(),
				'rel'    => array(),
			),
			'p'      => array(
				'class' => array(),
			),
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'i'      => array(
				'class' => array(),
			),
		);
	}
}
