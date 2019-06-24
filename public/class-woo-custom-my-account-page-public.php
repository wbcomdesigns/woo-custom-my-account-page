<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/public
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Woo_Custom_My_Account_Page_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Custom_My_Account_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Custom_My_Account_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-custom-my-account-page-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Custom_My_Account_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Custom_My_Account_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-custom-my-account-page-public.js', array( 'jquery' ), $this->version, false );

		$paths          = apply_filters( 'wcmp_stylesheet_paths', array( WC()->template_path() . 'yith-customize-myaccount.css', 'yith-customize-myaccount.css' ) );
		$located        = locate_template( $paths, false, false );
		$search         = array( get_stylesheet_directory(), get_template_directory() );
		$replace        = array( get_stylesheet_directory_uri(), get_template_directory_uri() );
		$stylesheet     = ! empty( $located ) ? str_replace( $search, $replace, $located ) : plugin_dir_url( __FILE__ ) . 'assets/css/ywcmap-frontend.css';
        $suffix         = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        $assets_path    = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';

		wp_register_style( 'wcmp-frontend', $stylesheet );
        wp_register_script( 'wcmp-frontend', plugin_dir_url( __FILE__ ) . 'assets/js/ywcmap-frontend'. $suffix . '.js', array( 'jquery' ), false, true );

		// ENQUEUE STYLE
		wp_enqueue_style( 'wcmp-frontend' );
        wp_enqueue_style( 'font-awesome' );

		$inline_css = $this->wcmp_get_custom_css();
		wp_add_inline_style( 'wcmp-frontend', $inline_css );

		// ENQUEUE SCRIPTS
		wp_enqueue_script( 'wcmp-frontend' );
		wp_localize_script( 'wcmp-frontend', 'yith_wcmap', array(
			'ajaxurl'           => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			//'actionPrint'       => $this->action_print
		) );
	}

	public function wcmp_get_custom_css(){
		$myaccount_func = instantiate_woo_custom_myaccount_functions();
		$all_settings   = $myaccount_func->wcmp_settings_data();
		$settings       = $all_settings['style_settings'];
		$inline_css = '
				#my-account-menu .logout a, #my-account-menu-tab .logout a {
					color:' . $settings['logout_color'] . ';
					background-color:' . $settings['logout_background_color'] . ';
				}
				#my-account-menu .logout:hover a, #my-account-menu-tab .logout:hover a {
					color:' . $settings['logout_hover_color'] . ';
					background-color:' . $settings['logout_background_hover_color'] . ';
				}
				.myaccount-menu li a {
					color:' . $settings['menu_item_color']. ';
				}
				.myaccount-menu li a:hover, .myaccount-menu li.active > a, .myaccount-menu li.is-active > a {
					color:' . $settings['menu_item_hover_color']. ';
				}';
		
		return apply_filters( 'wcmp_get_custom_css', $inline_css );
	}

}
