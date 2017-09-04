<?php

/**
 * The global variable functionality of the plugin.
 *
 * @link       http://www.wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/includes
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Woo_Custom_My_Account_Page_Endpoints {

	/**
	 * The custom endpoint.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $endpoint
	 */
	public static $endpoint;

	/**
	 * The default endpoint.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $endpoint
	 */
	public static $d_endpoint;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		global $woo_custom_my_account_page;
		$endpoints = $woo_custom_my_account_page->endpoints;
		$default_endpoints = $woo_custom_my_account_page->default_endpoints;
		$curr_user = wp_get_current_user();
		$curr_user_roles = $curr_user->roles;

		foreach( $endpoints as $slug => $endpoint ) {
			$denied_user_roles = array();
			if( !in_array( $slug, $default_endpoints ) ) {
				self::$endpoint = $slug;
				if( !empty( $endpoints[ self::$endpoint ]['user_roles'] ) ) {
					$denied_user_roles = $endpoints[ self::$endpoint ]['user_roles'];
				}
				$matching_user_roles = array_intersect( $curr_user_roles, $denied_user_roles );
				if( empty( $matching_user_roles ) ) {
					add_action( 'init', array( $this, 'wccma_add_endpoints' ) );
					add_filter( 'query_vars', array( $this, 'wccma_add_query_vars' ), 0 );
					add_filter( 'the_title', array( $this, 'wccma_endpoint_title' ) );
					add_filter( 'woocommerce_account_menu_items', array( $this, 'wccma_new_menu_items' ) );
					add_action( 'woocommerce_account_' . self::$endpoint .  '_endpoint', array( $this, 'wccma_endpoint_content' ) );
				} else {
					self::$d_endpoint = $slug;
					if( $endpoints[ self::$d_endpoint ]['content'] != '' ) {
						add_action( 'woocommerce_account_' . self::$d_endpoint .  '_endpoint', array( $this, 'wccma_default_endpoint_content' ) );
					}
				}
			}
		}
	}

	public function wccma_add_endpoints() {
		add_rewrite_endpoint( self::$endpoint, EP_ROOT | EP_PAGES );
	}
	
	public function wccma_add_query_vars( $vars ) {
		$vars[] = self::$endpoint;
		return $vars;
	}
	
	public function wccma_endpoint_title( $title ) {
		global $wp_query, $woo_custom_my_account_page;
		$endpoints = $woo_custom_my_account_page->endpoints;

		$is_endpoint = isset( $wp_query->query_vars[ self::$endpoint ] );
		if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
			$title = __( $endpoints[ self::$endpoint ]['label'], WCCMA_TEXT_DOMAIN );
			remove_filter( 'the_title', array( $this, 'wccma_endpoint_title' ) );
		}

		return $title;
	}
	
	public function wccma_new_menu_items( $items ) {
		global $woo_custom_my_account_page;
		$endpoints = $woo_custom_my_account_page->endpoints;

		$logout = $items['customer-logout'];
		unset( $items['customer-logout'] );
		$items[ self::$endpoint ] = __( $endpoints[ self::$endpoint ]['label'], WCCMA_TEXT_DOMAIN );
		$items['customer-logout'] = $logout;
		return $items;
	}
	
	public function wccma_endpoint_content() {
		global $woo_custom_my_account_page;
		$endpoints = $woo_custom_my_account_page->endpoints;
		echo $endpoints[ self::$endpoint ]['content'];
	}

	public function wccma_default_endpoint_content() {
		global $woo_custom_my_account_page;
		$endpoints = $woo_custom_my_account_page->endpoints;
		echo $endpoints[ self::$d_endpoint ]['content'];
	}
}