<?php
/**
 * Class to define all the global variables related to plugin.
 *
 * @since   1.0.0
 * @author  Wbcom Designs
 * @package Woo_Custom_My_Account_Page
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Woo_Custom_My_Account_Page_Functions' ) ) {
	/**
	 * Class to add global variables of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @author   Wbcom Designs
	 */
	class Woo_Custom_My_Account_Page_Functions {
		/**
		 * The single instance of the class.
		 *
		 * @var   Woo_Custom_My_Account_Page_Functions
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Main Woo_Custom_My_Account_Page_Functions Instance.
		 *
		 * Ensures only one instance of Woo_Custom_My_Account_Page_Functions is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function wcmp_get_icon( $key ) {
			switch ( $key ) {
				case 'dashboard':
					$icon = 'fa fa-tachometer';
					break;
				case 'orders':
					$icon = 'fa fa-file-text-o';
					break;
				case 'downloads':
					$icon = 'fa fa-download';
					break;
				case 'edit-address':
					$icon = 'fa fa-address-card';
					break;
				case 'edit-account':
					$icon = 'fa fa-pencil-square-o';
					break;
				case 'customer-logout':
					$icon = 'fa fa-sign-out';
					break;				
				default:
					$icon = 'fa fa-tag';
					break;
			}

			return $icon;
		}

		public function default_endpoint_settings() {
			$endpoint_arr = array();
			$endpoints    = wc_get_account_menu_items();
			if ( ! empty( $endpoints ) ) {
				foreach ( $endpoints as $key => $endpoint ) {
					$icon               = $this->wcmp_get_icon( $key );
					$endpoint_arr[$key] = array(
						'active'    => $key,
						'slug'      => $key,
						'label'     => $endpoint,
						'icon'      => $icon,
						'class'     => '',
						'usr_roles' => array()
					);
				}
			}

			return apply_filters( 'wcmp_default_endpoints_settings', $endpoint_arr );	
		}

		public function default_general_settings() {
			$default_arr = array(
				'custom_avatar'    => 'yes',
				'menu_style'       => 'sidebar',
				'sidebar_position' => 'left',
				'default_endpoint' => 'dashboard'
			);

			return apply_filters( 'wcmp_default_general_settings', $default_arr );
		}

		public function default_style_settings() {
			$default_arr = array(
				'menu_item_color'               => '#777777',
				'menu_item_hover_color'         => '#000000',
				'logout_color'                  => '#ffffff',
				'logout_hover_color'            => '#ffffff',
				'logout_background_color'       => '#c0c0c0',
				'logout_background_hover_color' => '#333333',
			);

			return apply_filters( 'wcmp_default_style_settings', $default_arr );
		}

		/**
		 * Get all admin settings data.
		 *
		 * @since    1.0.0
		 * @access   public
		 * @author   Wbcom Designs
		 */
		public function wcmp_settings_data() {
			$general = $styles = $endpoints = array();
			$default_endpoints  = $this->default_endpoint_settings();
			$default_general    = $this->default_general_settings();
			$default_styles     = $this->default_style_settings();
			$general_settings   = get_option( 'wcmp_general_settings' );
			$style_settings     = get_option( 'wcmp_style_settings' );
			$endpoints_settings = get_option( 'wcmp_endpoints_settings' );

			/* Endpoints settings */
			if ( ! empty( $endpoints_settings ) ) {
				foreach ( $endpoints_settings as $key => $endpoint ) {
					if ( array_key_exists( 'active', $endpoint ) ) {
						$endpoints[$key]['active'] = $endpoint['active'];
					} else {
						$endpoints[$key]['active'] = '';
					}
					if ( ! empty( $endpoint['slug'] ) ) {
						$endpoints[$key]['slug'] = $endpoint['slug'];
					} else {
						$endpoints[$key]['slug'] = $default_endpoints[$key]['slug'];
					}
					if ( ! empty( $endpoint['label'] ) ) {
						$endpoints[$key]['label'] = $endpoint['label'];
					} else {
						$endpoints[$key]['label'] = $default_endpoints[$key]['label'];
					}
					if ( ! empty( $endpoint['icon'] ) ) {
						$endpoints[$key]['icon'] = $endpoint['icon'];
					} else {
						$endpoints[$key]['icon'] = $default_endpoints[$key]['icon'];
					}
					if ( ! empty( $endpoint['class'] ) ) {
						$endpoints[$key]['class'] = $endpoint['class'];
					} else {
						$endpoints[$key]['class'] = $default_endpoints[$key]['class'];
					}
					if ( ! empty( $endpoint['usr_roles'] ) ) {
						$endpoints[$key]['usr_roles'] = $endpoint['usr_roles'];
					} else {
						$endpoints[$key]['usr_roles'] = $default_endpoints[$key]['usr_roles'];
					}
				}	
			} else {
				$endpoints = $default_endpoints;
			}

			/* General settings */
			if ( ! empty( $general_settings ) ) {
				if ( array_key_exists( 'custom_avatar', $general_settings ) ) {
					$general['custom_avatar'] = $general_settings['custom_avatar'];
				} else {
					$general['custom_avatar'] = 'no';
				}

				if ( array_key_exists( 'menu_style', $general_settings ) ) {
					$general['menu_style'] = $general_settings['menu_style'];
				} else {
					$general['menu_style'] = $default_general['menu_style'];
				}

				if ( ! empty( $general_settings['sidebar_position'] ) ) {
					$general['sidebar_position'] = $general_settings['sidebar_position'];
				} else {
					$general['sidebar_position'] = $default_general['sidebar_position'];
				}

				if ( ! empty( $general_settings['default_endpoint'] ) ) {
					$general['default_endpoint'] = $general_settings['default_endpoint'];
				} else {
					$general['default_endpoint'] = $default_general['default_endpoint'];
				}

			} else {
				$general = $default_general;
			}

			/* Style settings */
			if ( ! empty( $style_settings ) ) {
				if ( ! empty( $style_settings['menu_item_color'] ) ) {
					$styles['menu_item_color'] = $style_settings['menu_item_color'];
				} else {
					$styles['menu_item_color'] = $default_styles['menu_item_color'];
				}
				if ( ! empty( $style_settings['menu_item_hover_color'] ) ) {
					$styles['menu_item_hover_color'] = $style_settings['menu_item_hover_color'];
				} else {
					$styles['menu_item_hover_color'] = $default_styles['menu_item_hover_color'];
				}
				if ( ! empty( $style_settings['logout_color'] ) ) {
					$styles['logout_color'] = $style_settings['logout_color'];
				} else {
					$styles['logout_color'] = $default_styles['logout_color'];
				}
				if ( ! empty( $style_settings['logout_hover_color'] ) ) {
					$styles['logout_hover_color'] = $style_settings['logout_hover_color'];
				} else {
					$styles['logout_hover_color'] = $default_styles['logout_hover_color'];
				}
				if ( ! empty( $style_settings['logout_background_color'] ) ) {
					$styles['logout_background_color'] = $style_settings['logout_background_color'];
				} else {
					$styles['logout_background_color'] = $default_styles['logout_background_color'];
				}
				if ( ! empty( $style_settings['logout_background_hover_color'] ) ) {
					$styles['logout_background_hover_color'] = $style_settings['logout_background_hover_color'];
				} else {
					$styles['logout_background_hover_color'] = $default_styles['logout_background_hover_color'];
				}
			} else {
				$styles = $default_styles;
			}	

			$settings = array(
				'general_settings'   => $general,
				'style_settings'     => $styles, 
				'endpoints_settings' => $endpoints
			);

			return $settings;
		}

	}
}

/**
 * Main instance of Woo_Custom_My_Account_Page_Functions.
 *
 * Returns the main instance of Woo_Custom_My_Account_Page_Functions to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return Woo_Custom_My_Account_Page_Functions
 */
function instantiate_woo_custom_myaccount_functions() {
	return Woo_Custom_My_Account_Page_Functions::instance();
}

