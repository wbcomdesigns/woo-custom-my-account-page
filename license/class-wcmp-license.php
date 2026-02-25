<?php
/**
 * License Management Class - For Updates Only
 *
 * @package WCMP
 * @since   2.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WCMP License management class for handling plugin updates.
 */
class WCMP_License {

	/**
	 * Single instance of the class.
	 *
	 * @var WCMP_License|null
	 */
	private static $instance = null;

	/**
	 * License key option name.
	 *
	 * @var string
	 */
	private $license_key_option = 'wcmp_license_key';

	/**
	 * License status option name.
	 *
	 * @var string
	 */
	private $license_status_option = 'wcmp_license_status';

	/**
	 * Get instance
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'add_license_page' ) );
		add_action( 'admin_init', array( $this, 'register_license_settings' ) );
		add_action( 'admin_init', array( $this, 'activate_license' ) );
		add_action( 'admin_init', array( $this, 'deactivate_license' ) );
		add_action( 'admin_init', array( $this, 'init_updater' ) );

		// Daily license check.
		add_action( 'wcmp_daily_license_check', array( $this, 'check_license' ) );

		if ( ! wp_next_scheduled( 'wcmp_daily_license_check' ) ) {
			wp_schedule_event( time(), 'daily', 'wcmp_daily_license_check' );
		}
	}

	/**
	 * Add license page
	 */
	public function add_license_page() {
		add_submenu_page(
			'wcmp-endpoints',
			__( 'License', 'woo-custom-my-account-page' ),
			__( 'License', 'woo-custom-my-account-page' ),
			'manage_options',
			'wcmp-license',
			array( $this, 'license_page' )
		);
	}

	/**
	 * Register license settings
	 */
	public function register_license_settings() {
		register_setting(
			'wcmp_license',
			$this->license_key_option,
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
	}

	/**
	 * License page
	 */
	public function license_page() {
		$license = get_option( $this->license_key_option );
		$status  = get_option( $this->license_status_option );

		include WCMP_PLUGIN_PATH . 'license/templates/license-page.php';
	}

	/**
	 * Activate license
	 */
	public function activate_license() {
		if ( ! isset( $_POST['wcmp_license_activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce verified below.
			return;
		}

		if ( ! check_admin_referer( 'wcmp_license_nonce', 'wcmp_license_nonce' ) ) {
			return;
		}

		$license = trim( get_option( $this->license_key_option ) );

		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_id'    => WCMP_ITEM_ID,
			'url'        => home_url(),
		);

		$response = wp_remote_post(
			WCMP_STORE_URL,
			array(
				'timeout' => 15,
				'body'    => $api_params,
			)
		);

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$message = ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : __( 'An error occurred, please try again.', 'woo-custom-my-account-page' );
		} else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( false === $license_data->success ) {
				switch ( $license_data->error ) {
					case 'expired':
						$message = sprintf(
							/* translators: %s: license expiration date. */
							__( 'Your license key expired on %s.', 'woo-custom-my-account-page' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) )
						);
						break;
					case 'disabled':
					case 'revoked':
						$message = __( 'Your license key has been disabled.', 'woo-custom-my-account-page' );
						break;
					case 'missing':
						$message = __( 'Invalid license.', 'woo-custom-my-account-page' );
						break;
					case 'invalid':
					case 'site_inactive':
						$message = __( 'Your license is not active for this URL.', 'woo-custom-my-account-page' );
						break;
					case 'item_name_mismatch':
						/* translators: %s: plugin item name. */
						$message = sprintf( __( 'This appears to be an invalid license key for %s.', 'woo-custom-my-account-page' ), WCMP_ITEM_NAME );
						break;
					case 'no_activations_left':
						$message = __( 'Your license key has reached its activation limit.', 'woo-custom-my-account-page' );
						break;
					default:
						$message = __( 'An error occurred, please try again.', 'woo-custom-my-account-page' );
						break;
				}
			}
		}

		if ( ! empty( $message ) ) {
			$redirect = add_query_arg(
				array(
					'sl_activation' => 'false',
					'message'       => rawurlencode( $message ),
				),
				admin_url( 'admin.php?page=wcmp-license' )
			);
			wp_safe_redirect( $redirect );
			exit();
		}

		update_option( $this->license_status_option, $license_data->license );
		wp_safe_redirect( admin_url( 'admin.php?page=wcmp-license' ) );
		exit();
	}

	/**
	 * Deactivate license
	 */
	public function deactivate_license() {
		if ( ! isset( $_POST['wcmp_license_deactivate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce verified below.
			return;
		}

		if ( ! check_admin_referer( 'wcmp_license_nonce', 'wcmp_license_nonce' ) ) {
			return;
		}

		$license = trim( get_option( $this->license_key_option ) );

		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_id'    => WCMP_ITEM_ID,
			'url'        => home_url(),
		);

		$response = wp_remote_post(
			WCMP_STORE_URL,
			array(
				'timeout' => 15,
				'body'    => $api_params,
			)
		);

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			wp_safe_redirect( admin_url( 'admin.php?page=wcmp-license' ) );
			exit();
		}

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( 'deactivated' === $license_data->license ) {
			delete_option( $this->license_status_option );
		}

		wp_safe_redirect( admin_url( 'admin.php?page=wcmp-license' ) );
		exit();
	}

	/**
	 * Check license
	 */
	public function check_license() {
		$license = trim( get_option( $this->license_key_option ) );

		if ( empty( $license ) ) {
			return;
		}

		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			'item_id'    => WCMP_ITEM_ID,
			'url'        => home_url(),
		);

		$response = wp_remote_post(
			WCMP_STORE_URL,
			array(
				'timeout' => 15,
				'body'    => $api_params,
			)
		);

		if ( is_wp_error( $response ) ) {
			return;
		}

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		update_option( $this->license_status_option, $license_data->license );
	}

	/**
	 * Initialize updater
	 */
	public function init_updater() {
		if ( ! is_admin() ) {
			return;
		}

		$license_key = trim( get_option( $this->license_key_option ) );

		if ( empty( $license_key ) ) {
			return;
		}

		require_once WCMP_PLUGIN_PATH . 'license/class-wcmp-updater.php';

		$edd_updater = new WCMP_Updater(
			WCMP_STORE_URL,
			WCMP_PLUGIN_FILE,
			array(
				'version' => WCMP_VERSION,
				'license' => $license_key,
				'item_id' => WCMP_ITEM_ID,
				'author'  => 'Wbcom Designs',
				'url'     => home_url(),
				'beta'    => false,
			)
		);
	}

	/**
	 * Get license status
	 */
	public function get_license_status() {
		return get_option( $this->license_status_option, false );
	}

	/**
	 * Is license valid
	 */
	public function is_license_valid() {
		$status = $this->get_license_status();
		return 'valid' === $status;
	}
}
