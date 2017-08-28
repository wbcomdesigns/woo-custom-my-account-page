<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.wbcomdesigns.com
 * @since             1.0.0
 * @package           Woo_Custom_My_Account_Page
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Custom My Account Page
 * Plugin URI:        http://www.wbcomdesigns.com
 * Description:       This plugin helps the site administrator to customize the tabs in <strong>WooCommerce - My Account</strong> page.
 * Version:           1.0.0
 * Author:            Wbcom Designs
 * Author URI:        http://www.wbcomdesigns.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-custom-my-account-page
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

if ( !defined( 'WCCMA_TEXT_DOMAIN' ) ) {
	define( 'WCCMA_TEXT_DOMAIN', 'woo-custom-my-account-page' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-custom-my-account-page-activator.php
 */
function activate_woo_custom_my_account_page() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-custom-my-account-page-activator.php';
	Woo_Custom_My_Account_Page_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-custom-my-account-page-deactivator.php
 */
function deactivate_woo_custom_my_account_page() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-custom-my-account-page-deactivator.php';
	Woo_Custom_My_Account_Page_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_custom_my_account_page' );
register_deactivation_hook( __FILE__, 'deactivate_woo_custom_my_account_page' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-custom-my-account-page.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_custom_my_account_page() {

	//Define constants
	if ( !defined( 'WCCMA_PLUGIN_PATH' ) ) {
		define( 'WCCMA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
	}

	if ( !defined( 'WCCMA_PLUGIN_URL' ) ) {
		define( 'WCCMA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	$plugin = new Woo_Custom_My_Account_Page();
	$plugin->run();
}

/**
 * Check plugin requirement on plugins loaded
 * this plugin requires WooCommerce to be installed and active
 */
add_action( 'plugins_loaded', 'wccma_plugin_init' );

function wccma_plugin_init() {
	$wc_active = in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) );
	if ( current_user_can( 'activate_plugins' ) && $wc_active !== true ) {
		add_action( 'admin_notices', 'wccma_plugin_admin_notice' );
	} else {
		run_woo_custom_my_account_page();
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wccma_admin_plugin_links' );
	}
}

function wccma_plugin_admin_notice() {
	$wccma_plugin	 = __( 'WooCommerce Custom My Account Page', WCCMA_TEXT_DOMAIN );
	$wc_plugin		 = __( 'WooCommerce', WCCMA_TEXT_DOMAIN );

	echo '<div class="error"><p>'
	. sprintf( __( '%1$s is ineffective now as it requires %2$s to be installed and active.', WCCMA_TEXT_DOMAIN ), '<strong>' . esc_html( $wccma_plugin ) . '</strong>', '<strong>' . esc_html( $wc_plugin ) . '</strong>' )
	. '</p></div>';
	if ( isset( $_GET[ 'activate' ] ) )
		unset( $_GET[ 'activate' ] );
}

function wccma_admin_plugin_links( $links ) {
	$wccma_links = array(
		'<a href="' . admin_url( 'admin.php?page=woo-custom-my-account-page' ) . '">' . __( 'Settings', WCCMA_TEXT_DOMAIN ) . '</a>',
		'<a href="https://wbcomdesigns.com/contact/" target="_blank" title="' . __( 'Go for any custom development.', WCCMA_TEXT_DOMAIN ) . '">' . __( 'Support', WCCMA_TEXT_DOMAIN ) . '</a>'
	);
	return array_merge( $links, $wccma_links );
}
