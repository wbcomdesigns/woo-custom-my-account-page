<?php
/**
 * @link              https://wbcomdesigns.com
 * @since             1.0.0
 * @package           Woo_Custom_My_Account_Page
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Custom My Account Page
 * Plugin URI:        https://wbcomdesigns.com
 * Description:       This plugin helps you to customize the layout of the "My Account" page, adds new endpoints, groups, links and manage its content easily.
 * Version:           1.0.0
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com
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
 * Currently plugin version.
 */
if ( ! defined( 'WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION' ) ) {
	define( 'WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION', '1.0.0' );
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

if ( ! defined( 'WCMP_PLUGIN_VERSION' ) ) {
	define( 'WCMP_PLUGIN_VERSION', '1.0.0' );
}
if ( ! defined( 'WCMP_PLUGIN_NAME' ) ) {
	define( 'WCMP_PLUGIN_NAME', 'woo-custom-my-account-page' );
}
if ( ! defined( 'WCMP_PLUGIN_FILE' ) ) {
	define( 'WCMP_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'WCMP_PLUGIN_PATH' ) ) {
	define( 'WCMP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'WCMP_PLUGIN_URL' ) ) {
	define( 'WCMP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
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

/**
 * Include needed files if required plugin is active
 * @since   1.0.0
 * @author  Wbcom Designs
 */
add_action( 'plugins_loaded', 'wcmp_plugins_files' );

function wcmp_plugins_files() {
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	}
	if ( ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) && ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		add_action( 'admin_notices', 'wcmp_admin_notice' );
	} else {
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wcmp_admin_page_link' );
		run_woo_custom_my_account_page();
	}
}
	
function wcmp_admin_notice() {
	$woo_plugin  = esc_html__( 'WooCommerce', 'woo-custom-my-account-page' );
	$wcmp_plugin = esc_html__( 'WooCommerce Custom My Account Page', 'woo-custom-my-account-page' );

	/* translators: %1$s: WooCommerce plugin, %2$s: WooCommerce Custom My Account Page plugin */
	echo '<div class="error notice is-dismissible" id="message"><p>' . sprintf( esc_html__( '%1$s requires %2$s to be installed and active.', 'woo-custom-my-account-page' ), '<strong>' . esc_attr( $wcmp_plugin ) . '</strong>', '<strong>' . esc_attr( $woo_plugin ) . '</strong>' ) . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' .
	esc_html__( 'Dismiss this notice.', 'woo-custom-my-account-page' ) . '</span></button></div>';
}

/**
 * Settings link for this plugin.
 * @since   1.0.0
 * @author  Wbcom Designs
 */
function wcmp_admin_page_link( $links ) {
	$page_link = array( '<a href="' . admin_url( 'admin.php?page=woo-custom-myaccount-page' ) . '">' . esc_html__( 'Settings', 'woo-custom-my-account-page' ) . '</a>' );
	return array_merge( $links, $page_link );
}
