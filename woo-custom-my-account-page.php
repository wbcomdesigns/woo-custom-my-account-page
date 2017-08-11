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
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Wbcom Designs
 * Author URI:        http://www.wbcomdesigns.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-custom-my-account-page
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
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

	$plugin = new Woo_Custom_My_Account_Page();
	$plugin->run();

}
run_woo_custom_my_account_page();