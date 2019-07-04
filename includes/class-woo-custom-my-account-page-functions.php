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
		protected static $instance = null;

		/**
		 * Page templates
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $is_myaccount = false;

		/**
		 * Boolean to check if account have menu
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $my_account_have_menu = false;

		/**
		 * My account endpoint
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $menu_endpoints = array();

		/**
		 * Main Woo_Custom_My_Account_Page_Functions Instance.
		 *
		 * Ensures only one instance of Woo_Custom_My_Account_Page_Functions is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			add_action( 'init', array( $this, 'init' ), 100 );

			// Check if is shortcode my-account.
			add_action( 'template_redirect', array( $this, 'wcmp_check_myaccount' ), 1 );

			// Redirect to the default endpoint.
			add_action( 'template_redirect', array( $this, 'redirect_to_default' ), 150 );

			// Mem if is my account page.
			add_action( 'shutdown', array( $this, 'save_is_my_account' ) );

			// Add new navigation.
			add_action( 'woocommerce_account_navigation', array( $this, 'wcmp_add_my_account_menu' ), 10 );
			// Manage account content.
			add_action( 'woocommerce_account_content', array( $this, 'manage_account_content' ), 1 );

			add_action( 'wcmp_print_single_endpoint', array( $this, 'wcmp_print_single_endpoint' ), 10, 2 );
			add_action( 'wcmp_print_endpoints_group', array( $this, 'wcmp_print_endpoints_group' ), 10, 2 );

			// Shortcode to print default dashboard.
			add_shortcode( 'default_dashboard_content', array( $this, 'wcmp_print_default_dashboard_content' ) );

			add_action( 'init', array( $this, 'wcmp_update_old_items' ), 0 );
			// Items init.
			add_action( 'init', array( $this, 'wcmp_init_items' ), 20 );
			// Register custom endpoints.
			add_action( 'init', array( $this, 'wcmp_add_custom_endpoints' ), 21 );

			add_action( 'wp_loaded', array( $this, 'wcmp_flush_rewrite_rules' ) );
		}

		/**
		 * Print default dashboard content.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param array $atts The default dashboard content.
		 */
		public function wcmp_print_default_dashboard_content( $atts ) {

			$content       = '';
			$template_name = 'myaccount/dashboard.php';
			$template      = apply_filters( 'wcmp_dashboard_shortcode_template', $template_name );

			ob_start();
			wc_get_template(
				$template,
				array(
					'current_user' => get_user_by( 'id', get_current_user_id() ),
				)
			);
			$content = ob_get_clean();

			return $content;
		}

		/**
		 * Manage endpoint account content based on plugin option
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @return void
		 */
		public function manage_account_content() {

			// Search for active endpoints.
			$active = $this->wcmp_get_current_endpoint();
			// Get active endpoint options by slug.
			$endpoint = $this->wcmp_get_endpoint_by( $active, 'key', $this->menu_endpoints );
			if ( empty( $endpoint ) || ! is_array( $endpoint ) ) {
				return;
			}
			// Get key.
			$key = key( $endpoint );

			// Check in custom content.
			if ( ! empty( $endpoint[ $key ]['content'] ) ) {

				remove_action( 'woocommerce_account_content', 'woocommerce_account_content' );

				echo do_shortcode( $endpoint[ $key ]['content'] );
			}
		}

		/**
		 * Get endpoint by a specified key.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  string $value The endpoint value.
		 * @param  string $key   Can be key or slug.
		 * @param  array  $items Endpoint array.
		 * @return array
		 */
		public function wcmp_get_endpoint_by( $value, $key = 'key', $items = array() ) {

			$accepted = apply_filters( 'wcmp_get_endpoint_by_accepted_key', array( 'key', 'slug' ) );

			if ( ! in_array( $key, $accepted ) ) {
				return array();
			}
			$settings  = $this->wcmp_settings_data();
			$endpoints = '';
			if ( isset( $settings['endpoints'] ) ) {
				$endpoints = $settings['endpoints'];
			}

			empty( $items ) && $items = $endpoints;
			$find                     = array();

			foreach ( $items as $id => $item ) {
				if ( ( 'key' === $key && $id === $value ) || ( isset( $item[ $key ] ) && $item[ $key ] === $value ) ) {
					$find[ $id ] = $item;
					continue;
				} elseif ( isset( $item['children'] ) ) {
					foreach ( $item['children'] as $child_id => $child ) {
						if ( ( 'key' === $key && $child_id === $value ) || ( isset( $child[ $key ] ) && $child[ $key ] === $value ) ) {
							$find[ $child_id ] = $child;
							continue;
						}
					}
					continue;
				}
			}
			return apply_filters( 'wcmp_get_endpoint_by_result', $find );
		}

		/**
		 * Get icon by a specified endpoint key.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  string $key   Can be key or slug.
		 * @return array
		 */
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

		/**
		 * Get default endpoint settings.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @return array
		 */
		public function default_endpoint_settings() {
			$endpoint_arr = array();
			$endpoints    = wc_get_account_menu_items();
			if ( ! empty( $endpoints ) ) {
				foreach ( $endpoints as $key => $endpoint ) {
					$icon                 = $this->wcmp_get_icon( $key );
					$endpoint_arr[ $key ] = array(
						'type'      => 'endpoint',
						'active'    => $key,
						'slug'      => $key,
						'label'     => $endpoint,
						'icon'      => $icon,
						'class'     => '',
						'usr_roles' => array(),
					);
				}
			}

			return apply_filters( 'wcmp_default_endpoints_settings', $endpoint_arr );
		}

		/**
		 * Get default general settings.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @return array
		 */
		public function default_general_settings() {
			$default_arr = array(
				'custom_avatar'    => 'yes',
				'menu_style'       => 'sidebar',
				'sidebar_position' => 'left',
				'default_endpoint' => 'dashboard',
			);

			return apply_filters( 'wcmp_default_general_settings', $default_arr );
		}

		/**
		 * Get default style settings.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @return array
		 */
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
		 * @return   array
		 */
		public function wcmp_settings_data() {
			$general            = array();
			$styles             = array();
			$endpoints          = array();
			$default_endpoints  = $this->default_endpoint_settings();
			$default_general    = $this->default_general_settings();
			$default_styles     = $this->default_style_settings();
			$general_settings   = get_option( 'wcmp_general_settings' );
			$style_settings     = get_option( 'wcmp_style_settings' );
			$endpoints_settings = get_option( 'wcmp_endpoints_settings' );

			/* Endpoints settings */
			if ( isset( $endpoints_settings['endpoints'] ) ) {
				foreach ( $endpoints_settings['endpoints'] as $key => $endpoint ) {
					if ( array_key_exists( $key, $default_endpoints ) ) {
						$default_values = $default_endpoints[ $key ];
					} else {
						$default_function = "wcmp_get_default_{$endpoint['type']}_options";
						$default_values   = $this->$default_function( $key );
					}
					if ( array_key_exists( 'active', $endpoint ) ) {
						$endpoints[ $key ]['active'] = $endpoint['active'];
					} else {
						$endpoints[ $key ]['active'] = $default_values['active'];
					}
					if ( ! empty( $endpoint['type'] ) ) {
						$endpoints[ $key ]['type'] = $endpoint['type'];
					} else {
						$endpoints[ $key ]['type'] = $default_values['type'];
					}
					if ( 'group' === $endpoints[ $key ]['type'] ) {
						if ( isset( $endpoint['open'] ) ) {
							$endpoints[ $key ]['open'] = $endpoint['open'];
						} else {
							$endpoints[ $key ]['open'] = 'no';
						}
					}
					if ( ! empty( $endpoint['slug'] ) ) {
						$endpoints[ $key ]['slug'] = $endpoint['slug'];
					} else {
						$endpoints[ $key ]['slug'] = $default_values['slug'];
					}
					if ( ! empty( $endpoint['label'] ) ) {
						$endpoints[ $key ]['label'] = $endpoint['label'];
					} else {
						$endpoints[ $key ]['label'] = $default_values['label'];
					}
					if ( ! empty( $endpoint['icon'] ) ) {
						$endpoints[ $key ]['icon'] = $endpoint['icon'];
					} else {
						$endpoints[ $key ]['icon'] = $default_values['icon'];
					}
					if ( ! empty( $endpoint['class'] ) ) {
						$endpoints[ $key ]['class'] = $endpoint['class'];
					} else {
						$endpoints[ $key ]['class'] = $default_values['class'];
					}
					if ( ! empty( $endpoint['usr_roles'] ) ) {
						$endpoints[ $key ]['usr_roles'] = $endpoint['usr_roles'];
					} else {
						$endpoints[ $key ]['usr_roles'] = $default_values['usr_roles'];
					}
					if ( 'link' === $endpoints[ $key ]['type'] ) {
						if ( ! empty( $endpoint['url'] ) ) {
							$endpoints[ $key ]['url'] = $endpoint['url'];
						} else {
							$endpoints[ $key ]['url'] = $default_values['url'];
						}
						if ( ! empty( $endpoint['target_blank'] ) ) {
							$endpoints[ $key ]['target_blank'] = $endpoint['target_blank'];
						} else {
							$endpoints[ $key ]['target_blank'] = $default_values['target_blank'];
						}
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
								$child_data_arr = $endpoints[ $child_endpoint['id'] ];
								$group_id       = $endpoint_data['id'];
								$endpoints[ $group_id ]['children'][ $child_endpoint['id'] ] = $child_data_arr;
								unset( $endpoints[ $child_endpoint['id'] ] );
							}
						}
					}
				}
				$endpoint_order = $endpoints_settings['endpoints-order'];
			} else {
				$endpoint_order = '';
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
				'endpoints_settings' => $endpoints,
				'endpoint_order'     => $endpoint_order,
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

			$all_settings         = $this->wcmp_settings_data();
			$endpoints            = $all_settings['endpoints_settings'];
			$this->menu_endpoints = $endpoints;
			$priority             = has_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );

			// get current user and set user role.
			$current_user = wp_get_current_user();
			$user_role    = (array) $current_user->roles;

			// first register string for translations then remove disable.
			foreach ( $this->menu_endpoints as $endpoint => &$options ) {

				// check if master is active.
				if ( isset( $options['active'] ) && ! $options['active'] ) {
					unset( $this->menu_endpoints[ $endpoint ] );
					continue;
				}

				// check master by user role and user membership.
				if ( isset( $options['usr_roles'] ) && $this->_hide_by_usr_roles( $options['usr_roles'], $user_role )
				) {
					unset( $this->menu_endpoints[ $endpoint ] );
					continue;
				} elseif ( isset( $options['usr_roles'] ) && $this->_hide_by_usr_roles( $options['usr_roles'], $user_role ) ) {
					// check master by user roles.
					unset( $this->menu_endpoints[ $endpoint ] );
					continue;
				}

				// check if child is active.
				if ( isset( $options['children'] ) ) {
					foreach ( $options['children'] as $child_endpoint => $child_options ) {
						if ( ! $child_options['active'] ) {
							unset( $options['children'][ $child_endpoint ] );
							continue;
						}
						if ( isset( $child_options['usr_roles'] ) && $this->_hide_by_usr_roles( $child_options['usr_roles'], $user_role ) &&
							isset( $child_options['membership_plans'] ) && $this->_hide_by_membership_plan( $child_options['membership_plans'] )
						) {
							unset( $options['children'][ $child_endpoint ] );
							continue;
						} elseif ( isset( $child_options['usr_roles'] ) && $this->_hide_by_usr_roles( $child_options['usr_roles'], $user_role ) ) {
							// check master by user roles.
							unset( $options['children'][ $child_endpoint ] );
							continue;
						}

						// Get translated label.
						$options['children'][ $child_endpoint ]['label']                                 = $this->get_string_translated( $child_endpoint, $child_options['label'] );
						empty( $child_options['url'] ) || $options['children'][ $child_endpoint ]['url'] = $this->get_string_translated( $child_endpoint . '_url', $child_options['url'] );
						empty( $child_options['content'] ) || $options['children'][ $child_endpoint ]['content'] = $this->get_string_translated( $child_endpoint . '_content', $child_options['content'] );
					}
				}

				// get translated label.
				$options['label']                                   = $this->get_string_translated( $endpoint, $options['label'] );
				empty( $options['url'] ) || $options['url']         = $this->get_string_translated( $endpoint . '_url', $options['url'] );
				empty( $options['content'] ) || $options['content'] = $this->get_string_translated( $endpoint . '_content', $options['content'] );
			}

			// remove standard woocommerce sidebar.
			if ( false !== $priority ) {
				remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation', $priority );
			}
		}

		/**
		 * Init items.
		 *
		 * @since  1.0.0
		 * @author Francesco Licandro
		 */
		public function items_init() {

			// Get saved endpoints order.
			$fields = get_option( 'wcmp_endpoint', '' );
			$fields = json_decode( $fields, true );

			// Set empty array is false or null.
			( ! $fields || is_null( $fields ) ) && $fields = array();

			$this->items = array();

			// Get default endpoints.
			$defaults = $this->maybe_init_default_items();

			if ( empty( $fields ) ) {
					$this->items = $defaults;
			}	else {
				foreach ( $fields as $id => $field_option ) {
					// Build return array.
					$this->_items[ $id ] = array();

					$options = get_option( 'wcmp_endpoint_' . $id, array() );
					empty( $field_option['type'] ) && $field_option['type'] = 'endpoint';
					$options_default = call_user_func( "wcmp_get_default_{$field_option['type']}_options", $id );
					// Is empty check on default endpoint.
					( empty( $options ) && isset( $defaults[ $id ] ) ) && $options = $defaults[ $id ];
					// Always merge with default.
					$myaccount_func = instantiate_woo_custom_myaccount_functions();
					$options = array_merge( $options_default, $options );

					if ( isset( $field_option[ 'children' ] ) ) {

						$children = array();

						foreach ( $field_option[ 'children' ] as $child_id => $child ) {
							$child_options   = get_option( 'wcmp_endpoint_' . $child_id, array() );
							$options_default = call_user_func( "wcmp_get_default_{$child['type']}_options", $child_id );
							// Is empty check on default endpoint.
							( empty( $child_options ) && isset( $defaults[ $id ] ) ) && $child_options = $defaults[ $id ];
							// Always merge with default.
							$children[ $child_id ] = is_array( $child_options ) ? array_merge( $options_default, $child_options ) : $options_default;

							// Check child on default plugin
							unset( $defaults[ $child_id ] );
						}

						$options[ 'children' ] = $children;
					}

					// Unset on defaults.
					unset( $defaults[ $id ] );

					$this->_items[ $id ] = $options;
				}

				// Merge with defaults again.
				$this->_items = array_merge( $this->_items, $defaults );
			}
		}

		/**
		 * Maybe init default items
		 *
		 * @since  1.0.0
		 * @access protected
		 * @author Wbcom Designs
		 */
		protected function maybe_init_default_items() {
			$endpoints_settings = get_option( 'wcmp_endpoints_settings' );
			empty( $endpoints_settings ) && $this->default_endpoint_settings();
		}

		/**
		 * Hide field based on current user role.
		 *
		 * @access protected
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  array $roles WordPress user roles.
		 * @param  array $current_user_role The current user role.
		 * @return boolean
		 */
		protected function _hide_by_usr_roles( $roles, $current_user_role ) {
			// return if $roles is empty.
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
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  string $key
		 * @param  string $value
		 * @return string
		 */
		public function get_string_translated( $key, $value ) {
			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
				$value = apply_filters( 'wpml_translate_single_string', $value, 'yith-woocommerce-customize-myaccount-page', 'plugin_yit_wcmap_' . $key );
			} elseif ( defined( 'POLYLANG_VERSION' ) && function_exists( 'pll__' ) ) {
				$value = pll__( $value );
			}

			return $value;
		}

		/**
		 * Add woocommerce menu on frontend woocommerce myaccount page.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 */
		public function wcmp_add_my_account_menu() {
			if ( apply_filters( 'wcmp_my_account_have_menu', $this->my_account_have_menu ) ) {
				return;
			}

			$all_settings     = $this->wcmp_settings_data();
			$general_settings = $all_settings['general_settings'];
			$position         = $general_settings['sidebar_position'];
			$tab              = 'tab' === $general_settings['menu_style'] ? '-tab' : '';
			$endpoints        = $this->menu_endpoints;
			ob_start();
			?>
				<div id="my-account-menu<?php echo esc_attr( $tab ); ?>" class="wcmp-myaccount-template position-<?php echo $position; ?>">
					<?php
						$args = apply_filters(
							'wcmp_myaccount_menu_template_args',
							array(
								'endpoints'      => $endpoints,
								'my_account_url' => get_permalink( wc_get_page_id( 'myaccount' ) ),
								'avatar'         => 'yes' === $general_settings['custom_avatar'],
							)
						);
					wc_get_template( 'wcmp-myaccount-menu.php', $args, '', WCMP_PLUGIN_PATH . 'public/templates/' );
					?>
				</div>
			<?php

			echo ob_get_clean();

			// set my account menu variable. This prevent double menu.
			$this->my_account_have_menu = true;
		}

		/**
		 * Add woocommerce menu on frontend woocommerce myaccount page.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  string $endpoint The endpoint slug.
		 * @param  array  $options The endpoint details.
		 */
		public function wcmp_print_single_endpoint( $endpoint, $options ) {

			if ( ! isset( $options['url'] ) ) {
				$url                              = get_permalink( wc_get_page_id( 'myaccount' ) );
				'dashboard' !== $endpoint && $url = wc_get_endpoint_url( $endpoint, '', $url );
			} else {
				$url = esc_url( $options['url'] );
			}

			// Check if endpoint is active.
			$current                                   = $this->wcmp_get_current_endpoint();
			$classes                                   = array();
			! empty( $options['class'] ) && $classes[] = $options['class'];
			( $endpoint === $current ) && $classes[]   = 'active';

			if ( 'orders' === $endpoint ) {
				$view_order = get_option( 'woocommerce_myaccount_view_order_endpoint', 'view-order' );
				( $current === $view_order && ! in_array( 'active', $classes ) ) && $classes[] = 'active';
			}

			$classes = apply_filters( 'wcmp_endpoint_menu_class', $classes, $endpoint, $options );

			// build args array.
			$args = apply_filters(
				'wcmp_print_single_endpoint_args',
				array(
					'url'      => $url,
					'endpoint' => $endpoint,
					'options'  => $options,
					'classes'  => $classes,
				)
			);

			wc_get_template( 'wcmp-myaccount-menu-item.php', $args, '', WCMP_PLUGIN_PATH . 'public/templates/' );
		}

		/**
		 * Get current endpoint.
		 *
		 * @access protected
		 * @since  1.0.0
		 * @author Wbcom Designs
		 */
		public function wcmp_get_current_endpoint() {
			global $wp;

			$current = 'dashboard';
			foreach ( WC()->query->get_query_vars() as $key => $value ) {
				if ( isset( $wp->query_vars[ $key ] ) ) {
					$current = $key;
				}
			}

			return apply_filters( 'wcmp_get_current_endpoint', $current );
		}

		/**
		 * Print endpoints group on front menu.
		 *
		 * @param  string $endpoint The group slug.
		 * @param  array  $options  The group endpoint options.
		 * @since  1.0.0
		 * @author Wbcom Designs
		 */
		public function wcmp_print_endpoints_group( $endpoint, $options ) {

			$classes          = array( 'group-' . $endpoint );
			$current          = $this->wcmp_get_current_endpoint();
			$all_settings     = $this->wcmp_settings_data();
			$general_settings = $all_settings['general_settings'];

			! empty( $options['class'] ) && $classes[] = $options['class'];

			// check in child and add class active.
			foreach ( $options['children'] as $child_key => $child ) {
				if ( isset( $child['slug'] ) && $child_key === $current && '' !== WC()->query->get_current_endpoint() ) {
					$options['open'] = 'yes';
					$classes[]       = 'active';
					break;
				}
			}

			$class_icon = 'yes' === $options['open'] ? 'fa-chevron-up' : 'fa-chevron-down';
			$istab      = 'tab' === $general_settings['menu_style'] ? '-tab' : '';
			// options for style tab.
			if ( $istab ) {
				// force option open to true.
				$options['open'] = 'yes';
				$class_icon      = 'fa-chevron-down';
				$classes[]       = 'is-tab';
			}

			$classes = apply_filters( 'wcmp_endpoints_group_class', $classes, $endpoint, $options );

			// Build args array.
			$args = apply_filters(
				'wcmp_print_endpoints_group_group',
				array(
					'options'    => $options,
					'classes'    => $classes,
					'class_icon' => $class_icon,
				)
			);

			wc_get_template( 'wcmp-myaccount-menu-group.php', $args, '', WCMP_PLUGIN_PATH . 'public/templates/' );
		}

		/**
		 * Save an option to check if the page is myaccount.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 */
		public function save_is_my_account() {
			update_option( 'wcmp_is_my_account', $this->is_myaccount );
		}

		/**
		 * Redirect to default endpoint.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 */
		public function redirect_to_default() {

			// Exit if not my account.
			if ( ! $this->is_myaccount || ! is_array( $this->menu_endpoints ) ) {
				return;
			}
			$current_endpoint = $this->wcmp_get_current_endpoint();
			// If a specific endpoint is required return.
			if ( 'dashboard' !== $current_endpoint ) {
				return;
			}
			$all_settings     = $this->wcmp_settings_data();
			$general_settings = $all_settings['general_settings'];
			$default_endpoint = $general_settings['default_endpoint'];
			// Let's third part filter default endpoint.
			$default_endpoint = apply_filters( 'wcmp_default_endpoint', $default_endpoint );
			$url              = wc_get_page_permalink( 'myaccount' );

			// Otherwise, if I'm not in my account yet redirect to default.
			if ( ! get_option( 'wcmp_is_my_account', true ) && ! isset( $_REQUEST['elementor-preview'] ) && $current_endpoint !== $default_endpoint ) {
				'dashboard' !== $default_endpoint && $url = wc_get_endpoint_url( $default_endpoint, '', $url );
				wp_safe_redirect( $url );
				exit;
			}
		}

		/**
		 * Create field key.
		 *
		 * @since  1.0.0
		 * @param  string $key The endpoint slug.
		 * @return string
		 * @author Wbcom Designs
		 * @access public
		 */
		public function create_field_key( $key ) {

			// Build endpoint key.
			$field_key = strtolower( $key );
			$field_key = trim( $field_key );
			// Clear from space and add -.
			$field_key = sanitize_title( $field_key );

			return $field_key;
		}

		/**
		 * Get default options for new endpoints.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  string $endpoint The endpoint slug.
		 * @return array
		 */
		public function wcmp_get_default_endpoint_options( $endpoint ) {

			$endpoint_name = $this->wcmp_build_label( $endpoint );
			$icon          = $this->wcmp_get_icon( $endpoint );
			// Build endpoint options.
			$options = array(
				'type'      => 'endpoint',
				'slug'      => $endpoint,
				'active'    => $endpoint,
				'label'     => $endpoint_name,
				'icon'      => $icon,
				'class'     => '',
				'content'   => '',
				'usr_roles' => array(),
			);

			return apply_filters( 'wcmp_get_default_endpoint_options', $options );
		}

		/**
		 * Get default options for new group.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  string $group The group slug.
		 * @return array
		 */
		public function wcmp_get_default_group_options( $group ) {

			$group_name = $this->wcmp_build_label( $group );

			// Build endpoint options.
			$options = array(
				'type'      => 'group',
				'slug'      => $group,
				'active'    => $group,
				'label'     => $group_name,
				'usr_roles' => array(),
				'icon'      => 'fa fa-cubes',
				'class'     => '',
				'open'      => 'yes',
				'children'  => array(),
			);

			return apply_filters( 'wcmp_get_default_group_options', $options );
		}

		/**
		 * Get default options for new links.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  string $endpoint The endpoint slug.
		 * @return array
		 */
		public function wcmp_get_default_link_options( $endpoint ) {

			$endpoint_name = $this->wcmp_build_label( $endpoint );

			// Build endpoint options.
			$options = array(
				'type'         => 'link',
				'slug'         => $endpoint,
				'url'          => '#',
				'active'       => $endpoint,
				'label'        => $endpoint_name,
				'icon'         => 'fa fa-link',
				'class'        => '',
				'usr_roles'    => '',
				'target_blank' => false,
			);

			return apply_filters( 'wcmp_get_default_link_options', $options );
		}

		/**
		 * Build endpoint label by name.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @param  string $name The endpoint name.
		 * @return string
		 */
		public function wcmp_build_label( $name ) {

			$label = preg_replace( '/[^a-z]/', ' ', $name );
			$label = trim( $label );
			$label = ucfirst( $label );

			return $label;
		}

		/**
		 * Check if is page my-account and set class variable.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 */
		public function wcmp_check_myaccount() {
			global $post;
			if ( ! is_null( $post ) && strpos( $post->post_content, 'woocommerce_my_account' ) !== false && is_user_logged_in() ) {
				$this->is_myaccount = true;
			}

			$this->is_myaccount = apply_filters( 'wcmp_is_my_account_page', $this->is_myaccount );
		}

		/**
		 * Get items slug.
		 *
		 * @since  1.0.0
		 * @access public
		 * @author Wbcom Designs
		 * @return array
		 */
		public function get_items_slug() {
			$slugs    = array();
			$settings = $this->wcmp_settings_data();
			if ( isset( $settings['endpoints_settings'] ) && ! empty( $settings['endpoints_settings'] ) ) {
				foreach ( $settings['endpoints_settings'] as $key => $field ) {
					isset( $field['slug'] ) && $slugs[ $key ] = $field['slug'];
					if ( isset( $field['children'] ) ) {
						foreach ( $field['children'] as $child_key => $child ) {
							isset( $child['slug'] ) && $slugs[ $child_key ] = $child['slug'];
						}
					}
				}
			}
			return $slugs;
		}

		/**
		 * Add custom endpoints to main WC array.
		 *
		 * @since  1.0.0
		 * @access public
		 * @author Wbcom Designs
		 */
		public function wcmp_add_custom_endpoints() {
			$slugs = $this->get_items_slug();
			if ( empty( $slugs ) || ! is_array( $slugs ) ) {
					return;
			}

			$mask = WC()->query->get_endpoints_mask();

			foreach ( $slugs as $key => $slug ) {
				if ( 'dashboard' === $key || isset( WC()->query->query_vars[$key] ) ) {
						continue;
				}

				WC()->query->query_vars[$key] = $slug;
				add_rewrite_endpoint( $slug, $mask );
			}
		}

		/**
		 * Update old items.
		 *
		 * @since  1.0.0
		 * @access public
		 * @author Wbcom Designs
		 * @return void
		 */
		public function wcmp_update_old_items() {

			$fields = get_option( 'wcmp_endpoint', array() );
			if ( empty( $fields ) ) {
					return;
			}

			$backup_option = 'wcmp_endpoint_backup_pre_' . WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION;
			if( ! get_option( $backup_option, false ) ) {
				$fields = json_decode( $fields, true );
				$new_fields = array();
				foreach( $fields as $field ) {

					if( ! isset( $field['id'] ) ) {
							continue;
					}

					$field['id'] == 'view-order'    && $field['id'] = 'orders';
					$field['id'] == 'my-downloads'  && $field['id'] = 'downloads';

					if( isset( $field['children'] ) ) {
						$new_fields[$field['id']] = array( 'type' => 'group', 'children' => array() );
						foreach( $field['children'] as $child ) {
							$child['id'] == 'view-order'    && $child['id'] = 'orders';
							$child['id'] == 'my-downloads'  && $child['id'] = 'downloads';
							$new_fields[$field['id']]['children'][$child['id']] = array( 'type' => 'endpoint' );
						}
					}
					else {
						$new_fields[$field['id']] = array( 'type' => 'endpoint' );
					}
				}

				update_option( 'wcmp_endpoint_backup_pre_' . WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION, json_encode( $fields ) );
				empty( $new_fields ) || update_option( 'wcmp_endpoint', json_encode( $new_fields ) );
			}
		}

		/**
		 * Init plugin items.
		 *
		 * @since  1.0.0
		 * @access public
		 * @author Wbcom Designs
		 */
		public function wcmp_init_items() {
			$this->items_init(); // Init again items.
		}

		/**
		 * Flush rewrite rules.
		 *
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @access public
		 */
		public function wcmp_flush_rewrite_rules() {
			flush_rewrite_rules();
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
