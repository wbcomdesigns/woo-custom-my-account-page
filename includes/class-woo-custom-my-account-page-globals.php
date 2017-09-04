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
class Woo_Custom_My_Account_Page_Globals {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	public $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The various settings used in the plugin, variables defined in the global variable
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $allow_custom_user_avatar
	 */
	public $allow_custom_user_avatar;

	/**
	 * The various settings used in the plugin, variables defined in the global variable
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $default_woo_tab
	 */
	public $default_woo_tab;

	/**
	 * The various settings used in the plugin, variables defined in the global variable
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $font_awesome_icons
	 */
	public $font_awesome_icons;

	/**
	 * The various settings used in the plugin, variables defined in the global variable
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $endpoints
	 */
	public $endpoints;

	/**
	 * The various settings used in the plugin, variables defined in the global variable
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $default_endpoints
	 */
	public $default_endpoints = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name	 = $plugin_name;
		$this->version		 = $version;
		$this->setup_plugin_global();
	}

	public function setup_plugin_global() {
		global $woo_custom_my_account_page;
		$wccma_settings = get_option( 'wccma_settings' );

		//Get Font awesome icons classes
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"\\\\(.+)";\s+}/';
		$subject =  file_get_contents( WCCMA_PLUGIN_PATH.'admin/css/font-awesome.css' );
		preg_match_all( $pattern, $subject, $matches, PREG_SET_ORDER );
		$icons = array();
		foreach( $matches as $match ) {
			$icons[$match[1]] = $match[2];
		}
		ksort($icons);
		$this->font_awesome_icons = $icons;
		
		$this->allow_custom_user_avatar = 'no';
		if( isset( $wccma_settings['allow_custom_user_avatar'] ) ) {
			$this->allow_custom_user_avatar = $wccma_settings['allow_custom_user_avatar'];
		}

		$this->default_woo_tab = 'dashboard';
		if( isset( $wccma_settings['default_woo_tab'] ) ) {
			$this->default_woo_tab = $wccma_settings['default_woo_tab'];
		}

		/**
		 * My Account Page Endpoints
		 */
		$this->endpoints = get_option( 'wccma_endpoints' );
		$this->default_endpoints = array( 'dashboard', 'orders', 'downloads', 'edit-address', 'edit-account', 'customer-logout' );
	}

}
