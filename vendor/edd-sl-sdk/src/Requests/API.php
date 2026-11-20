<?php
/**
 * Upgrade shim for the licensing SDK move (vendor/edd-sl-sdk 1.0.2 -> libs/edd-sl-sdk, since 1.7.3).
 *
 * During the update from 1.7.2, the 1.7.2 SDK is still loaded in that request and its Composer
 * autoloader only looks under this old path. When its update check runs after the files are swapped
 * (upgrader_process_complete -> wp_update_plugins) it needs this class, so this file hands it the
 * bundled one. Nothing loads this file on a normal request.
 *
 * @package Woo_Custom_My_Account_Page
 */

defined( 'ABSPATH' ) || exit;

require_once dirname( __DIR__, 4 ) . '/libs/edd-sl-sdk/src/Requests/API.php';
