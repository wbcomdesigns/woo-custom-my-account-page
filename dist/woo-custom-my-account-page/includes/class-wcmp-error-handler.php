<?php
/**
 * Error Handler Class for WooCommerce Custom My Account Page
 *
 * Provides centralized error logging to improve plugin stability.
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
}
