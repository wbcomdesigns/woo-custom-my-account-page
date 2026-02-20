<?php
/**
 * Error Handler Class for WooCommerce Custom My Account Page
 *
 * Provides centralized error handling to improve plugin stability.
 *
 * @since   1.4.1
 * @package Woo_Custom_My_Account_Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WCMP Error Handler Class
 */
class WCMP_Error_Handler {

	/**
	 * Log an error message.
	 *
	 * @param string $message Error message to log.
	 * @param string $context Context where error occurred.
	 */
	public static function log_error( $message, $context = '' ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$log_message = sprintf(
				'[WC My Account Page] %s%s',
				$context ? "({$context}) " : '',
				$message
			);
			error_log( $log_message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		}
	}

	/**
	 * Safe get option with error handling.
	 *
	 * @param string $option_name Option name.
	 * @param mixed  $default_val Default value if option doesn't exist.
	 * @return mixed Option value or default.
	 */
	public static function safe_get_option( $option_name, $default_val = array() ) {
		try {
			$value = get_option( $option_name, $default_val );

			// Ensure we return array if default is array.
			if ( is_array( $default_val ) && ! is_array( $value ) ) {
				self::log_error( "Option {$option_name} expected to be array but got " . gettype( $value ), 'safe_get_option' );
				return $default_val;
			}

			return $value;
		} catch ( Exception $e ) {
			self::log_error( $e->getMessage(), 'safe_get_option' );
			return $default_val;
		}
	}

	/**
	 * Safe array access with error handling.
	 *
	 * @param array  $arr         Array to access.
	 * @param string $key         Key to retrieve.
	 * @param mixed  $default_val Default value if key doesn't exist.
	 * @return mixed Value or default.
	 */
	public static function safe_array_get( $arr, $key, $default_val = null ) {
		if ( ! is_array( $arr ) ) {
			self::log_error( 'Expected array but got ' . gettype( $arr ), 'safe_array_get' );
			return $default_val;
		}

		return isset( $arr[ $key ] ) ? $arr[ $key ] : $default_val;
	}

	/**
	 * Validate and sanitize endpoint data.
	 *
	 * @param array $endpoint_data Endpoint data to validate.
	 * @return array Sanitized endpoint data.
	 */
	public static function validate_endpoint_data( $endpoint_data ) {
		$defaults = array(
			'active'    => '',
			'label'     => '',
			'slug'      => '',
			'class'     => '',
			'icon'      => '',
			'content'   => '',
			'usr_roles' => array(),
		);

		if ( ! is_array( $endpoint_data ) ) {
			self::log_error( 'Invalid endpoint data type', 'validate_endpoint_data' );
			return $defaults;
		}

		// Merge with defaults to ensure all keys exist.
		$validated = wp_parse_args( $endpoint_data, $defaults );

		// Sanitize each field.
		$validated['label'] = sanitize_text_field( $validated['label'] );
		$validated['slug']  = sanitize_title( $validated['slug'] );
		$validated['class'] = sanitize_html_class( $validated['class'] );
		$validated['icon']  = sanitize_text_field( $validated['icon'] );

		// Ensure usr_roles is array.
		if ( ! is_array( $validated['usr_roles'] ) ) {
			$validated['usr_roles'] = array();
		}

		return $validated;
	}

	/**
	 * Check if WooCommerce is active.
	 *
	 * @return bool True if WooCommerce is active.
	 */
	public static function is_woocommerce_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$is_active = class_exists( 'WooCommerce' ) || is_plugin_active( 'woocommerce/woocommerce.php' );

		if ( ! $is_active ) {
			self::log_error( 'WooCommerce is not active', 'is_woocommerce_active' );
		}

		return $is_active;
	}

	/**
	 * Safe template include with error handling.
	 *
	 * @param string $template_path Path to template file.
	 * @param array  $args          Arguments to pass to template.
	 * @return bool True if template loaded successfully.
	 */
	public static function safe_include_template( $template_path, $args = array() ) {
		if ( ! file_exists( $template_path ) ) {
			self::log_error( "Template file not found: {$template_path}", 'safe_include_template' );
			return false;
		}

		try {
			// Extract args for template use safely.
			if ( is_array( $args ) ) {
				foreach ( $args as $key => $value ) {
					if ( is_string( $key ) ) {
						$$key = $value;
					}
				}
			}

			include $template_path;
			return true;
		} catch ( Exception $e ) {
			self::log_error( 'Error including template: ' . $e->getMessage(), 'safe_include_template' );
			return false;
		}
	}

	/**
	 * Initialize error handling.
	 */
	public static function init() {
		// Set custom error handler for plugin.
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			set_error_handler( array( __CLASS__, 'custom_error_handler' ), E_USER_ERROR | E_USER_WARNING ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_set_error_handler
		}
	}

	/**
	 * Custom error handler.
	 *
	 * @param int    $errno   Error number.
	 * @param string $errstr  Error message.
	 * @param string $errfile Error file.
	 * @param int    $errline Error line.
	 * @return bool
	 */
	public static function custom_error_handler( $errno, $errstr, $errfile, $errline ) {
		// Only handle errors from this plugin.
		if ( false === strpos( $errfile, 'woo-custom-my-account-page' ) ) {
			return false;
		}

		$message = sprintf(
			'Error %d: %s in %s on line %d',
			$errno,
			$errstr,
			basename( $errfile ),
			$errline
		);

		self::log_error( $message, 'custom_error_handler' );

		// Don't execute PHP internal error handler.
		return true;
	}
}

// Initialize error handler.
add_action( 'init', array( 'WCMP_Error_Handler', 'init' ) );
