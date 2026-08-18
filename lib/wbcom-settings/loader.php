<?php
/**
 * Bundled-library loader for the Wbcom settings screen.
 *
 * Every plugin that uses the shared settings screen ships its own copy of this directory. That is
 * deliberate: a shared toolkit PLUGIN would have to be installed, updated and version-matched by
 * the site owner, and a plugin that silently stops working because a dependency was deactivated is
 * worse than a little duplication on disk.
 *
 * What this file prevents is the duplication mattering. Every copy registers its version, the
 * HIGHEST one is the only one loaded, and the rest stand down - so a fix shipped in any one
 * plugin's release becomes the implementation every other plugin on that site uses. This is the
 * pattern Action Scheduler and the EDD licensing SDK use, for the same reason.
 *
 * Usage, at include time in the plugin bootstrap:
 *
 *     require_once __DIR__ . '/lib/wbcom-settings/loader.php';
 *     wbcom_settings_register( '1.0.0', __DIR__ . '/lib/wbcom-settings/class-wbcom-settings-page.php' );
 *
 * @package Wbcom_Settings
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wbcom_settings_register' ) ) {

	/**
	 * Offer this plugin's copy of the settings screen.
	 *
	 * @since 1.0.0
	 * @param string $version Version of the copy being offered.
	 * @param string $file    Absolute path to that copy's class file.
	 */
	function wbcom_settings_register( $version, $file ) {
		global $wbcom_settings_copies;

		if ( ! is_array( $wbcom_settings_copies ) ) {
			$wbcom_settings_copies = array();
		}

		$wbcom_settings_copies[ $file ] = $version;

		/*
		 * Loaded before any plugin boots. Plugins call boot() during their own startup, which is
		 * plugins_loaded at 4 or later, so the class is always defined by the time it is used.
		 */
		if ( ! has_action( 'plugins_loaded', 'wbcom_settings_load' ) ) {
			add_action( 'plugins_loaded', 'wbcom_settings_load', -999 );
		}
	}

	/**
	 * Load the newest registered copy, and only that one.
	 *
	 * @since 1.0.0
	 */
	function wbcom_settings_load() {
		global $wbcom_settings_copies;

		if ( empty( $wbcom_settings_copies ) || class_exists( 'Wbcom_Settings_Page' ) ) {
			return;
		}

		uasort( $wbcom_settings_copies, 'version_compare' );
		$newest = array_key_last( $wbcom_settings_copies );

		if ( is_readable( $newest ) ) {
			require_once $newest;
		}
	}
}
