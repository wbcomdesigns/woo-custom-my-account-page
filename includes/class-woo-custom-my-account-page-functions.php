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
		 * Page templates
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_is_myaccount = false;

		/**
		 * Boolean to check if account have menu
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_my_account_have_menu = false;

		/**
		 * My account endpoint
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_menu_endpoints = array();

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

		public function __construct() {
			add_action( 'init', array( $this, 'init' ), 100 );
			// redirect to the default endpoint
			//add_action( 'template_redirect', array( $this, 'redirect_to_default' ), 150 );
			// Add new navigation.
			add_action( 'woocommerce_account_navigation', array( $this, 'wcmp_add_my_account_menu' ), 10 );
			add_action( 'wcmp_print_single_endpoint', array( $this, 'wcmp_print_single_endpoint' ), 10, 2 );
			add_action( 'wcmp_print_endpoints_group', array( $this, 'wcmp_print_endpoints_group' ), 10, 2 );
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
						'type'      => 'endpoint',
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
			if ( isset( $endpoints_settings['endpoints'] ) ) {
				foreach ( $endpoints_settings['endpoints'] as $key => $endpoint ) {
					if ( array_key_exists( 'active', $endpoint ) ) {
						$endpoints[$key]['active'] = $endpoint['active'];
					} else {
						$endpoints[$key]['active'] = '';
					}
					if ( ! empty( $endpoint['type'] ) ) {
						$endpoints[$key]['type'] = $endpoint['type'];
					} else {
						$endpoints[$key]['type'] = 'endpoint';
					}
					if ( isset( $endpoint['open'] ) ) {
						$endpoints[$key]['open'] = $endpoint['open'];
					} else {
						$endpoints[$key]['open'] = 'no';
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
						$endpoints[$key]['class'] = '';
					}
					if ( ! empty( $endpoint['usr_roles'] ) ) {
						$endpoints[$key]['usr_roles'] = $endpoint['usr_roles'];
					} else {
						$endpoints[$key]['usr_roles'] = array();
					}
				}	
			} else {
				$endpoints = $default_endpoints;
			}
			if ( isset( $endpoints_settings['endpoints-order'] ) && ! empty( $endpoints_settings['endpoints-order'] ) ) {
				$endpoint_orders = json_decode( $endpoints_settings['endpoints-order'], true );
				foreach ( $endpoint_orders as $key => $endpoint_data ) {
					if ( 'group' === $endpoint_data['type'] && isset( $endpoint_data['children'] ) ) {
						if ( ! empty( $endpoint_data['children'] ) ) {
							foreach ( $endpoint_data['children'] as $index => $child_endpoint ) {
								$child_data_arr = $endpoints[$child_endpoint['id']];
								$group_id       = $endpoint_data['id'];
								$endpoints[$group_id]['children'][$child_endpoint['id']] = $child_data_arr;
								unset( $endpoints[$child_endpoint['id']] );
							}
						}	
					}
				}
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

		/**
		 * Init plugins variable.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 */
		public function init() {

			$myaccount_func        = instantiate_woo_custom_myaccount_functions();
			$all_settings          = $myaccount_func->wcmp_settings_data();
			$endpoints             = $all_settings['endpoints_settings'];
			$this->_menu_endpoints = $endpoints;

	        // get current user and set user role.
	        $current_user = wp_get_current_user();
	        $user_role    = (array) $current_user->roles;

			// first register string for translations then remove disable.
			foreach( $this->_menu_endpoints as $endpoint => &$options ) {

	            // check if master is active.
	            if( isset( $options['active'] ) && ! $options['active'] ) {
	                unset( $this->_menu_endpoints[$endpoint] );
	                continue;
	            }

	            // check master by user role and user membership.
	            if( isset( $options['usr_roles'] ) && $this->_hide_by_usr_roles( $options['usr_roles'], $user_role )
	            ){
	                unset( $this->_menu_endpoints[$endpoint] );
	                continue;
	            }  // check master by user roles.
	            elseif( isset( $options['usr_roles'] ) && $this->_hide_by_usr_roles( $options['usr_roles'], $user_role ) ) {
	                unset( $this->_menu_endpoints[$endpoint] );
	                continue;
	            }
	            
			    // check if child is active.
	            if( isset( $options['children'] ) ) {
	                foreach ( $options['children'] as $child_endpoint => $child_options ) {
	                    if ( ! $child_options['active'] ) {
	                        unset( $options['children'][$child_endpoint] );
	                        continue;
	                    }
	                    if ( isset( $child_options['usr_roles'] ) && $this->_hide_by_usr_roles( $child_options['usr_roles'], $user_role ) &&
	                        isset( $child_options['membership_plans'] ) && $this->_hide_by_membership_plan( $child_options['membership_plans'] )
	                    ) {
	                        unset( $options['children'][$child_endpoint] );
	                        continue;
	                    }  // check master by user roles
	                    elseif( isset( $child_options['usr_roles'] ) && $this->_hide_by_usr_roles( $child_options['usr_roles'], $user_role ) ) {
	                        unset( $options['children'][$child_endpoint] );
	                        continue;
	                    }// check master by user membership
	                    elseif( isset( $child_options['membership_plans'] ) && $this->_hide_by_membership_plan( $child_options['membership_plans'] ) ) {
	                        unset( $options['children'][$child_endpoint] );
	                        continue;
	                    }

	                    // Get translated label.
	                    $options['children'][$child_endpoint]['label'] = $this->get_string_translated( $child_endpoint, $child_options['label'] );
	                    empty( $child_options['url'] ) || $options['children'][$child_endpoint]['url'] = $this->get_string_translated( $child_endpoint . '_url', $child_options['url'] );
	                    empty( $child_options['content'] ) || $options['children'][$child_endpoint]['content'] = $this->get_string_translated( $child_endpoint . '_content', $child_options['content'] );
	                }
	            }

	            // get translated label.
	            $options['label'] = $this->get_string_translated( $endpoint, $options['label'] );
	            empty( $options['url'] ) || $options['url'] = $this->get_string_translated( $endpoint . '_url', $options['url'] );
	            empty( $options['content'] ) || $options['content'] = $this->get_string_translated( $endpoint . '_content', $options['content'] );
			}

			// remove theme sidebar.
			if( defined('YIT') && YIT ) {
				remove_action( 'yit_content_loop', 'yit_my_account_template', 5 );
				// also remove the my-account template
				$my_account_id = wc_get_page_id( 'myaccount' );
				if ( 'my-account.php' == get_post_meta( $my_account_id, '_wp_page_template', true ) ) {
					update_post_meta( $my_account_id, '_wp_page_template', 'default' );
				}
			}

	        // remove standard woocommerce sidebar.
	        if( ( $priority = has_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' ) ) !== false ) {
	            remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation', $priority );
	        }
		}

	    /**
	     * Hide field based on current user role.
	     *
	     * @access protected
	     * @since  1.0.0
	     * @author Wbcom Designs
	     * @param  array $roles
	     * @param  array $current_user_role
	     * @return boolean
	     */
	    protected function _hide_by_usr_roles( $roles, $current_user_role ) {
	        // return if $roles is empty
	        if ( empty( $roles ) || current_user_can( 'administrator' ) ) {
	            return false;
	        }

	        // Check if current user can.
	        $intersect = array_intersect( $roles, $current_user_role );
	        if ( ! empty( $intersect ) ) {
	            return false;
	        }

	        return true;
	    }

	    /**
	     * Get a translated string.
	     *
	     * @access protected
	     * @since  1.0.0
	     * @author Wbcom Designs
	     * @param  string $key
	     * @param  string $value
	     * @return string
	     */
	    public function get_string_translated( $key, $value ){
	        if( defined( 'ICL_SITEPRESS_VERSION' ) ) {
	            $value = apply_filters( 'wpml_translate_single_string', $value, 'yith-woocommerce-customize-myaccount-page', 'plugin_yit_wcmap_' . $key );
	        }
	        elseif( defined( 'POLYLANG_VERSION' ) && function_exists( 'pll__' ) ) {
	            $value = pll__( $value );
	        }

	        return $value;
	    }

		public function wcmp_add_my_account_menu() {
		    if( apply_filters( 'wcmp_my_account_have_menu', $this->_my_account_have_menu ) ) {
		        return;
	        }

			$all_settings     = $this->wcmp_settings_data();
			$general_settings = $all_settings['general_settings'];
	        $position         = $general_settings['sidebar_position'];
	        $tab              = $general_settings['menu_style'] == 'tab' ? '-tab' : '';
			$endpoints        = $this->_menu_endpoints;			
	        ob_start();
	        ?>
	            <div id="my-account-menu<?php echo $tab ?>" class="yith-wcmap position-<?php echo $position ?>">
	            	<?php
		                $args = apply_filters( 'wcmp-myaccount-menu-template-args', array(
						'endpoints'      => $endpoints,
						'my_account_url' => get_permalink( wc_get_page_id( 'myaccount' ) ),
						'avatar'	     => $general_settings['custom_avatar'] == 'yes'
					));
					wc_get_template( 'wcmp-myaccount-menu.php', $args, '', WCMP_PLUGIN_PATH . 'public/template/' );
					?>
	            </div>
	        <?php

	        echo ob_get_clean();

	        // set my account menu variable. This prevent double menu
	        $this->_my_account_have_menu = true;
	    }

	    public function wcmp_print_single_endpoint( $endpoint, $options ) {

	        if( ! isset( $options['url'] ) ) {
	            $url = get_permalink( wc_get_page_id( 'myaccount' ) );
	            $endpoint != 'dashboard' && $url = wc_get_endpoint_url( $endpoint, '', $url );
	        } else {
	            $url = esc_url( $options['url'] );
	        }

	        // Check if endpoint is active.
	        $current = $this->wcmp_get_current_endpoint();
	        $classes = array();
	        ! empty( $options['class'] )    && $classes[] = $options['class'];
	        ( $endpoint == $current )       && $classes[] = 'active';

	        if ( $endpoint == 'orders' ) {
	            $view_order = get_option( 'woocommerce_myaccount_view_order_endpoint', 'view-order' );
	            ( $current == $view_order && ! in_array( 'active', $classes ) ) && $classes[] = 'active';
	        }

	        $classes = apply_filters( 'wcmp_endpoint_menu_class', $classes, $endpoint, $options );

	        // build args array.
	        $args = apply_filters( 'wcmp_print_single_endpoint_args', array(
	            'url'       => $url,
	            'endpoint'  => $endpoint,
	            'options'   => $options,
	            'classes'   => $classes
	        ));

	        wc_get_template( 'wcmp-myaccount-menu-item.php', $args, '', WCMP_PLUGIN_PATH . 'public/template/' );
	    }

	    public function wcmp_get_current_endpoint() {
	    	global $wp;

	        $current = 'dashboard';
	        foreach( WC()->query->get_query_vars() as $key => $value ) {
	            if ( isset( $wp->query_vars[ $key ] ) ) {
	                $current = $key;
	            }
	        }

	        return apply_filters( 'wcmp_get_current_endpoint', $current );
	    }

        /**
	     * Print endpoints group on front menu.
	     *
	     * @param  string $endpoint
	     * @param  array $options
 	     * @since  1.0.0
	     * @author Wbcom Designs
	     */
	    public function wcmp_print_endpoints_group( $endpoint, $options ) {

	        $classes = array( 'group-' . $endpoint );
	        $current = $this->wcmp_get_current_endpoint();

	        $all_settings     = $this->wcmp_settings_data();
			$general_settings = $all_settings['general_settings'];

	        ! empty( $options['class'] ) && $classes[] = $options['class'];

	        // check in child and add class active.
	        foreach( $options['children'] as $child_key => $child ) {
	            if( isset( $child['slug'] ) && $child_key == $current && WC()->query->get_current_endpoint() != '' ) {
		            $options['open']    = true;
	                $classes[]          = 'active';
	                break;
	            }
	        }

		    $class_icon = $options['open'] ? 'fa-chevron-up' : 'fa-chevron-down';
	        $istab      = $general_settings['menu_style'] == 'tab' ? '-tab' : '';
	        // options for style tab.
		    if( $istab ) {
			    // force option open to true.
			    $options['open'] = true;
		        $class_icon = 'fa-chevron-down';
			    $classes[] = 'is-tab';
	        }

	        $classes = apply_filters( 'wcmp_endpoints_group_class', $classes, $endpoint, $options );

	        // build args array
	        $args = apply_filters( 'wcmp_print_endpoints_group_group', array(
	            'options'       => $options,
	            'classes'       => $classes,
	            'class_icon'    => $class_icon
	        ));

	        wc_get_template( 'wcmp-myaccount-menu-group.php', $args, '', WCMP_PLUGIN_PATH . 'public/template/' );
	    }

	    /**
		 * Redirect to default endpoint
		 *
		 * @access public
	     * @since  1.0.0
	     * @author Wbcom Designs
		 */
		public function redirect_to_default(){

			// exit if not my account
			// if( ! $this->_is_myaccount || ! is_array( $this->_menu_endpoints ) ) {
			// 	return;
			// }

			$current_endpoint = $this->wcmp_get_current_endpoint();
			// if a specific endpoint is required return.
            if ( $current_endpoint != 'dashboard' || apply_filters( 'wcmp_no_redirect_to_default', false ) ) {
                return;
            }
            $all_settings     = $this->wcmp_settings_data();
			$general_settings = $all_settings['general_settings'];
	        $default_endpoint = $general_settings['default_endpoint'];
			// let's third part filter default endpoint.
			$default_endpoint = apply_filters( 'wcmp_default_endpoint', $default_endpoint );
			$url              = wc_get_page_permalink( 'myaccount' );

            // otherwise if I'm not in my account yet redirect to default.
            if( ! get_option( 'yith_wcmap_is_my_account', true ) && ! isset( $_REQUEST['elementor-preview'] ) && $current_endpoint != $default_endpoint ) {
				$default_endpoint != 'dashboard' && $url = wc_get_endpoint_url( $default_endpoint, '', $url );
				wp_safe_redirect( $url );
				exit;
			}
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

instantiate_woo_custom_myaccount_functions();

