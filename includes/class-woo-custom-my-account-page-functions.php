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
		 * @var   Woo_Custom_My_Account_Page_Functions|null
		 * @since 1.0.0
		 */
		protected static $instance = null;

		/**
		 * Page templates.
		 *
		 * @var   bool
		 * @since 1.0.0
		 */
		protected $is_myaccount = false;

		/**
		 * Boolean to check if account have menu.
		 *
		 * @var   bool
		 * @since 1.0.0
		 */
		protected $my_account_have_menu = false;

		/**
		 * My account endpoint.
		 *
		 * @var   array
		 * @since 1.0.0
		 */
		protected $menu_endpoints = array();

		/**
		 * Main Woo_Custom_My_Account_Page_Functions Instance.
		 *
		 * Ensures only one instance of Woo_Custom_My_Account_Page_Functions is loaded or can be loaded.
		 *
		 * @since  1.0.0
		 * @static
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'init' ), 100 );

			// Check if is shortcode my-account.
			add_action( 'template_redirect', array( $this, 'wcmp_check_myaccount' ), 1 );

			// Enforce "Visible to roles" on the URL, not only the menu.
			add_action( 'template_redirect', array( $this, 'wcmp_restrict_endpoint_access' ), 20 );

			// Redirect to the default endpoint.
			add_action( 'template_redirect', array( $this, 'redirect_to_default' ), 150 );

			// Change title.
			add_action( 'template_redirect', array( $this, 'manage_account_title' ), 10 );

			// Add new navigation.
			add_action( 'woocommerce_account_navigation', array( $this, 'wcmp_add_my_account_menu' ), 10 );

			// Manage account content.
			add_action( 'woocommerce_account_content', array( $this, 'manage_account_content' ), 1 );

			add_action( 'wcmp_print_single_endpoint', array( $this, 'wcmp_print_single_endpoint' ), 10, 2 );
			add_action( 'wcmp_print_endpoints_group', array( $this, 'wcmp_print_endpoints_group' ), 10, 2 );

			// Shortcode to print default dashboard.
			add_shortcode( 'default_dashboard_content', array( $this, 'wcmp_print_default_dashboard_content' ) );

			// Placement fallbacks for block themes and arbitrary pages: the
			// portal renders wherever WooCommerce's My Account shortcode
			// renders, so both delegate to it.
			add_shortcode( 'wcmp_my_account', array( $this, 'wcmp_render_my_account_shortcode' ) );
			add_action( 'init', array( $this, 'wcmp_register_block' ), 20 );

			add_action( 'init', array( $this, 'wcmp_update_old_items' ), 0 );

			// Register custom endpoints.
			add_action( 'init', array( $this, 'wcmp_add_custom_endpoints' ), 21 );
		}

		/**
		 * Change my account page title based on endpoint
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 */
		public function manage_account_title() {

			global $wp, $post;

			// Search for active endpoints.
			$active = $this->wcmp_get_current_endpoint();
			// Get active endpoint options by slug.
			$endpoint = $this->wcmp_get_endpoint_by( $active, 'slug', $this->menu_endpoints );

			if ( empty( $endpoint ) ) {
				return;
			}

			// Get key.
			$key = key( $endpoint );

			// Set endpoint title.
			if ( isset( $endpoint['view-quote'] ) && ! empty( $wp->query_vars[ $active ] ) ) {
				$order_id = $wp->query_vars[ $active ];
				/* translators: %s: order ID. */
				$post->post_title = sprintf( __( 'Quote #%s', 'woo-custom-my-account-page' ), $order_id );
			} elseif ( ! empty( $endpoint[ $key ]['label'] ) && 'dashboard' !== $active ) {
				$post->post_title = sanitize_text_field( $endpoint[ $key ]['label'] );
			}
		}

		/**
		 * Print default dashboard content.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @return string
		 */
		public function wcmp_print_default_dashboard_content() {

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
		 * Manage endpoint account content based on plugin option.
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
			if ( empty( $endpoint ) ) {
				return;
			}
			// Get key.
			$key = key( $endpoint );

			// Check in custom content.
			if ( ! empty( $endpoint[ $key ]['content'] ) ) {

				remove_action( 'woocommerce_account_content', 'woocommerce_account_content' );

				// Apply wpautop to preserve line breaks and paragraphs.
				$content = wpautop( $endpoint[ $key ]['content'] );

				/*
				 * Sanitize the STORED content first, then expand shortcodes.
				 * The old order (kses after do_shortcode) stripped the form
				 * controls (<input>, <select>, <option>, <textarea>) that
				 * form-plugin shortcodes such as Formidable output, because
				 * the post kses context does not allow them. Shortcode output
				 * is the registering plugin's responsibility - the same trust
				 * model core uses for post_content.
				 */
				echo do_shortcode( wp_kses_post( $content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Stored content is kses-sanitized before shortcode expansion, matching core post rendering.
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

			if ( ! in_array( $key, $accepted, true ) ) {
				return array();
			}
			$settings  = $this->wcmp_settings_data();
			$endpoints = array();
			if ( isset( $settings['endpoints_settings'] ) ) {
				$endpoints = $settings['endpoints_settings'];
			}

			if ( empty( $items ) ) {
				$items = $endpoints;
			}
			$find = array();
			if ( ! empty( $items ) ) {
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
		 * @return string
		 */
		public function wcmp_get_icon( $key ) {
			switch ( $key ) {
				case 'dashboard':
					$icon = 'fa-tachometer';
					break;
				case 'orders':
					$icon = 'fa-file-text';
					break;
				case 'downloads':
					$icon = 'fa-download';
					break;
				case 'edit-address':
					$icon = 'fa-address-card';
					break;
				case 'edit-account':
					$icon = 'fa-edit';
					break;
				case 'customer-logout':
					$icon = 'fa-sign-out';
					break;
				default:
					$icon = 'fa-tag';
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
						$endpoint_type    = isset( $endpoint['type'] ) ? $endpoint['type'] : 'endpoint';
						$default_function = "wcmp_get_default_{$endpoint_type}_options";
						$default_values   = method_exists( $this, $default_function ) ? $this->$default_function( $key ) : $this->wcmp_get_default_endpoint_options( $key );
					}
					if ( ! array_key_exists( $key, $default_endpoints ) ) {
						if ( array_key_exists( 'content', $endpoint ) ) {
							$endpoints[ $key ]['content'] = $endpoint['content'];
						} else {
							$endpoints[ $key ]['content'] = '';
						}
					}
					if ( array_key_exists( 'active', $endpoint ) ) {
						$endpoints[ $key ]['active'] = $endpoint['active'];
					} else {
						$endpoints[ $key ]['active'] = '';
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
						$endpoints[ $key ]['icon'] = '';
					}
					if ( ! empty( $endpoint['class'] ) ) {
						$endpoints[ $key ]['class'] = $endpoint['class'];
					} else {
						$endpoints[ $key ]['class'] = '';
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
				$intersection = array_diff_key( $default_endpoints, $endpoints_settings['endpoints'] );
				$endpoints    = array_merge( $endpoints, $intersection );
			} else {
				$endpoints = $default_endpoints;
			}

			if ( isset( $endpoints_settings['endpoints-order'] ) && ! empty( $endpoints_settings['endpoints-order'] ) ) {
				$endpoint_orders = json_decode( $endpoints_settings['endpoints-order'], true );
				$endpoint_orders = is_array( $endpoint_orders ) ? $this->wcmp_prune_endpoint_order( $endpoint_orders, $endpoints ) : array();
				foreach ( $endpoint_orders as $endpoint_data ) {
					if ( 'group' === $endpoint_data['type'] && ! empty( $endpoint_data['children'] ) ) {
						foreach ( $endpoint_data['children'] as $child_endpoint ) {
							$endpoints[ $endpoint_data['id'] ]['children'][ $child_endpoint['id'] ] = $endpoints[ $child_endpoint['id'] ];
							unset( $endpoints[ $child_endpoint['id'] ] );
						}
					}
				}
				// The admin form posts this back, so the next save stores the clean order.
				$endpoint_order = wp_json_encode( $endpoint_orders );
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
					if ( array_key_exists( $general_settings['default_endpoint'], $this->wcmp_flatten_endpoints( $endpoints ) ) ) {
						$general['default_endpoint'] = $general_settings['default_endpoint'];
					} else {
						$general['default_endpoint'] = $default_general['default_endpoint'];
					}
				} else {
					$general['default_endpoint'] = $default_general['default_endpoint'];
				}
			} else {
				$general = $default_general;
			}

			/*
			 * Style settings: every key falls back to its default when the saved
			 * value is empty. array_filter() (no callback) drops exactly the falsy
			 * values !empty() would, so the merge is identical to the per-key ladder.
			 */
			if ( ! empty( $style_settings ) && is_array( $style_settings ) ) {
				$styles = array_merge( $default_styles, array_filter( $style_settings ) );
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
			$endpoints            = isset( $all_settings['endpoints_settings'] ) ? $all_settings['endpoints_settings'] : array();
			$this->menu_endpoints = $endpoints;
			$priority             = has_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );

			// Get current user and set user role.
			$current_user = wp_get_current_user();
			$user_role    = (array) $current_user->roles;

			// First register string for translations then remove disable.
			foreach ( $this->menu_endpoints as $endpoint => &$options ) {

				// Check if master is active.
				if ( isset( $options['active'] ) && ! $options['active'] ) {
					unset( $this->menu_endpoints[ $endpoint ] );
					continue;
				}

				// Check master by user role and user membership.
				if ( isset( $options['usr_roles'] ) && ! empty( $options['usr_roles'] ) && ! $this->hide_by_usr_roles( $options['usr_roles'], $user_role ) ) {
					unset( $this->menu_endpoints[ $endpoint ] );
					continue;
				}

				// Check if child is active.
				if ( isset( $options['children'] ) ) {
					foreach ( $options['children'] as $child_endpoint => $child_options ) {
						if ( ! $child_options['active'] ) {
							unset( $options['children'][ $child_endpoint ] );
							continue;
						}
						if ( isset( $child_options['usr_roles'] ) && ! empty( $child_options['usr_roles'] ) && ! $this->hide_by_usr_roles( $child_options['usr_roles'], $user_role ) ) {
							// Check master by user roles.
							unset( $options['children'][ $child_endpoint ] );
							continue;
						}

						// Get translated label.
						$options['children'][ $child_endpoint ]['label'] = $child_options['label'];
						if ( ! empty( $child_options['url'] ) ) {
							$options['children'][ $child_endpoint ]['url'] = $child_options['url'];
						}
						if ( ! empty( $child_options['content'] ) ) {
							$options['children'][ $child_endpoint ]['content'] = $child_options['content'];
						}
					}
				}
			}

			// Remove standard woocommerce sidebar.
			if ( false !== $priority ) {
				remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation', $priority );
			}
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
		/*
		 * Note on semantics: despite the historical name, a non-empty roles
		 * list is a visibility ALLOWLIST - this returns true when the current
		 * user's role IS in the list (i.e. the endpoint is visible to them).
		 * The menu builder keeps endpoints when this returns true.
		 */
		protected function hide_by_usr_roles( $roles, $current_user_role ) {
			// Return if $roles is empty.
			if ( empty( $roles ) ) {
				return false;
			}

			// Check if current user can.
			$intersect = array_intersect( $roles, $current_user_role );
			if ( ! empty( $intersect ) ) {
				return true;
			}

			return false;
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
			?>
				<div id="my-account-menu<?php echo esc_attr( $tab ); ?>" class="wcmp-myaccount-template position-<?php echo esc_html( $position ); ?>">
					<div class="wcmp-myaccount-template-inner">
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
				</div>
			<?php
			// Set my account menu variable. This prevent double menu.
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
				// Core's builder: also nonces Log out, which otherwise stops at "Are you sure?".
				$url = wc_get_account_endpoint_url( $endpoint );
			} else {
				$url = esc_url( $options['url'] );
			}

			// Check if endpoint is active.
			$current = $this->wcmp_get_current_endpoint();
			$classes = array();
			if ( ! empty( $options['class'] ) ) {
				$classes[] = $options['class'];
			}
			if ( $endpoint === $current ) {
				$classes[] = 'active';
			}

			if ( 'orders' === $endpoint ) {
				$view_order = get_option( 'woocommerce_myaccount_view_order_endpoint', 'view-order' );
				if ( $current === $view_order && ! in_array( 'active', $classes, true ) ) {
					$classes[] = 'active';
				}
			}

			$classes = apply_filters( 'wcmp_endpoint_menu_class', $classes, $endpoint, $options );

			// Build args array.
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

			if ( ! empty( $options['class'] ) ) {
				$classes[] = $options['class'];
			}

			// Check in child and add class active.
			foreach ( isset( $options['children'] ) ? $options['children'] : array() as $child_key => $child ) {
				if ( isset( $child['slug'] ) && $child_key === $current && '' !== WC()->query->get_current_endpoint() ) {
					$options['open'] = 'yes';
					$classes[]       = 'active';
					break;
				}
			}

			$class_icon = 'yes' === $options['open'] ? 'fa-chevron-up' : 'fa-chevron-down';
			$istab      = 'tab' === $general_settings['menu_style'] ? '-tab' : '';
			// Options for style tab.
			if ( $istab ) {
				// Force option open to true.
				$options['open'] = 'yes';
				$class_icon      = 'fa-chevron-down';
				$classes[]       = 'is-tab';
			}

			$classes = apply_filters( 'wcmp_endpoints_group_class', $classes, $endpoint, $options );

			// Build args array.
			$args = apply_filters(
				'wcmp_print_endpoints_group_group',
				array(
					'endpoint'   => $endpoint,
					'options'    => $options,
					'classes'    => $classes,
					'class_icon' => $class_icon,
				)
			);

			wc_get_template( 'wcmp-myaccount-menu-group.php', $args, '', WCMP_PLUGIN_PATH . 'public/templates/' );
		}

		/**
		 * Send members back to My Account when they open a role-restricted
		 * endpoint by URL. Hiding the menu item alone left the page reachable.
		 *
		 * @access public
		 * @since  1.7.0
		 */
		public function wcmp_restrict_endpoint_access() {
			if ( ! $this->is_myaccount || ! is_user_logged_in() ) {
				return;
			}
			$current = $this->wcmp_get_current_endpoint();
			if ( 'dashboard' === $current ) {
				return;
			}

			$settings = $this->wcmp_settings_data();
			$flat     = $this->wcmp_flatten_endpoints( $settings['endpoints_settings'] );

			if ( isset( $flat[ $current ] ) && ! $this->wcmp_roles_can_view( $current, $flat, (array) wp_get_current_user()->roles ) ) {
				wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
				exit;
			}
		}

		/**
		 * Drop order entries whose item no longer exists (removed, or dropped by
		 * the save sanitizer), so a stale id cannot render as an empty child.
		 *
		 * @since  1.7.1
		 * @param  array $order     Decoded endpoints-order tree.
		 * @param  array $endpoints Endpoints keyed by id.
		 * @return array
		 */
		private function wcmp_prune_endpoint_order( $order, $endpoints ) {
			$out = array();
			foreach ( $order as $item ) {
				$children = ! empty( $item['children'] ) ? $this->wcmp_prune_endpoint_order( $item['children'], $endpoints ) : array();
				if ( empty( $item['id'] ) || empty( $item['type'] ) || ! isset( $endpoints[ $item['id'] ] ) ) {
					// A vanished group keeps its surviving children, one level up.
					$out = array_merge( $out, $children );
					continue;
				}
				if ( $children ) {
					$item['children'] = $children;
				} else {
					unset( $item['children'] );
				}
				$out[] = $item;
			}
			return $out;
		}

		/**
		 * Every menu item keyed by its key, with group children lifted to the
		 * top level and tagged with their group in 'parent_group'.
		 *
		 * @since  1.7.0
		 * @param  array $endpoints Endpoints settings (groups carry 'children').
		 * @return array
		 */
		public function wcmp_flatten_endpoints( $endpoints ) {
			$flat = array();
			foreach ( (array) $endpoints as $key => $item ) {
				$flat[ $key ] = $item;
				foreach ( isset( $item['children'] ) ? (array) $item['children'] : array() as $child_key => $child ) {
					$child['parent_group'] = $key;
					$flat[ $child_key ]    = $child;
				}
			}
			return $flat;
		}

		/**
		 * Whether these roles pass the item's "Visible to roles" list and, for
		 * an item inside a group, the group's list too.
		 *
		 * @since  1.7.0
		 * @param  string $key   Item key.
		 * @param  array  $flat  Output of wcmp_flatten_endpoints().
		 * @param  array  $roles The user's roles.
		 * @return bool
		 */
		protected function wcmp_roles_can_view( $key, $flat, $roles ) {
			$keys = array( $key );
			if ( ! empty( $flat[ $key ]['parent_group'] ) ) {
				$keys[] = $flat[ $key ]['parent_group'];
			}
			foreach ( $keys as $k ) {
				if ( ! empty( $flat[ $k ]['usr_roles'] ) && ! $this->hide_by_usr_roles( (array) $flat[ $k ]['usr_roles'], $roles ) ) {
					return false;
				}
			}
			return true;
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
			if ( ! $this->is_myaccount ) {
				return;
			}
			$current_endpoint = $this->wcmp_get_current_endpoint();
			// If a specific endpoint is required return.
			if ( 'dashboard' !== $current_endpoint || apply_filters( 'wcmp_no_redirect_to_default', false ) ) {
				return;
			}
			$all_settings     = $this->wcmp_settings_data();
			$general_settings = $all_settings['general_settings'];
			$endpoints        = isset( $all_settings['endpoints_settings'] ) ? $all_settings['endpoints_settings'] : array();
			$default_endpoint = $general_settings['default_endpoint'];
			// Let third party filter default endpoint.
			$default_endpoint = apply_filters( 'wcmp_default_endpoint', $default_endpoint );
			$url              = wc_get_page_permalink( 'myaccount' );

			// Read the RAW settings, not the role-filtered menu: a user outside
			// the allowlist has no menu entry, which used to send them to an
			// endpoint they cannot see. Never land members on an endpoint that
			// is role-restricted for them or hidden from the menu, including
			// one inside a group (whose own roles and visibility apply too).
			$flat            = $this->wcmp_flatten_endpoints( $endpoints );
			$default_visible = true;
			if ( isset( $flat[ $default_endpoint ] ) ) {
				$group           = isset( $flat[ $default_endpoint ]['parent_group'] ) ? $flat[ $default_endpoint ]['parent_group'] : '';
				$default_visible = $this->wcmp_roles_can_view( $default_endpoint, $flat, (array) wp_get_current_user()->roles )
					&& ! empty( $flat[ $default_endpoint ]['active'] )
					&& ( '' === $group || ! empty( $flat[ $group ]['active'] ) );
			}

			if ( ! is_wc_endpoint_url( $default_endpoint ) ) {
				// is_myaccount was already confirmed for THIS request at the
				// top of the method - the legacy wcmp_is_my_account option
				// (written on shutdown by the PREVIOUS request) made this
				// redirect non-deterministic and is no longer consulted.
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended
				if ( ! isset( $_GET['elementor-preview'] ) && $current_endpoint !== $default_endpoint && $default_visible ) {
					$url = wc_get_endpoint_url( $default_endpoint, '', $url );
					wp_safe_redirect( $url );
					exit;
				}
			}
		}

		/**
		 * Create an ASCII field key (URL slug, DOM id and option key) from a typed name.
		 *
		 * Latin names keep core's sanitize_title() result, locale transliteration
		 * included. For other scripts sanitize_title() returns percent-encoded
		 * bytes, which 404 as a My Account endpoint and fatal wp_editor(), so the
		 * name is transliterated with intl when available instead.
		 *
		 * @since  1.0.0
		 * @since  1.7.0 Always returns ASCII; added $fallback.
		 * @param  string $name     The typed name or slug.
		 * @param  string $fallback Returned when no ASCII key can be derived.
		 * @return string
		 * @author Wbcom Designs
		 * @access public
		 */
		public function create_field_key( $name, $fallback = '' ) {
			$key = sanitize_title( $name );

			if ( false !== strpos( $key, '%' ) && function_exists( 'transliterator_transliterate' ) ) {
				$latin = transliterator_transliterate( 'Any-Latin; Latin-ASCII', $name );
				if ( false !== $latin ) {
					$key = sanitize_title( $latin );
				}
			}

			// Drop any percent-encoded bytes left (no intl, emoji).
			$key = trim( preg_replace( array( '/%[a-f0-9]{2}/', '/-+/' ), array( '', '-' ), $key ), '-' );

			return '' !== $key ? $key : $fallback;
		}

		/**
		 * Get default options for new endpoints.
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Wbcom Designs
		 * @since  1.7.0 Added $label.
		 * @param  string $endpoint The endpoint slug.
		 * @param  string $label    The name the store owner typed.
		 * @return array
		 */
		public function wcmp_get_default_endpoint_options( $endpoint, $label = '' ) {

			$endpoint_name = '' !== $label ? $label : $endpoint;
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
		 * @since  1.7.0 Added $label.
		 * @param  string $group The group slug.
		 * @param  string $label The name the store owner typed.
		 * @return array
		 */
		public function wcmp_get_default_group_options( $group, $label = '' ) {

			$group_name = '' !== $label ? $label : $group;

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
		 * @since  1.7.0 Added $label.
		 * @param  string $endpoint The link slug.
		 * @param  string $label    The name the store owner typed.
		 * @return array
		 */
		public function wcmp_get_default_link_options( $endpoint, $label = '' ) {

			$endpoint_name = '' !== $label ? $label : $endpoint;

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
		 * Render the full My Account portal anywhere.
		 *
		 * @access public
		 * @since  1.6.4
		 * @return string
		 */
		public function wcmp_render_my_account_shortcode() {
			return do_shortcode( '[woocommerce_my_account]' );
		}

		/**
		 * Register the wcmp/my-account block.
		 *
		 * @access public
		 * @since  1.6.4
		 */
		public function wcmp_register_block() {
			if ( function_exists( 'register_block_type' ) ) {
				register_block_type( WCMP_PLUGIN_PATH . 'blocks/my-account' );
			}
		}

		/**
		 * Build a label from a slug.
		 *
		 * @since      1.0.0
		 * @deprecated 1.7.0 New items keep the name the store owner typed.
		 * @param      string $name The slug.
		 * @return     string
		 */
		public function wcmp_build_label( $name ) {
			_deprecated_function( __METHOD__, '1.7.0' );
			return ucfirst( trim( str_replace( '-', ' ', $name ) ) );
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

			if ( is_user_logged_in() ) {
				if ( function_exists( 'is_account_page' ) && is_account_page() ) {
					// WooCommerce's own conditional covers the classic
					// shortcode, the classic-shortcode block and block-based
					// My Account pages alike.
					$this->is_myaccount = true;
				} elseif ( ! is_null( $post ) &&
					isset( $post->post_content ) &&
					false !== strpos( $post->post_content, 'woocommerce_my_account' ) ) {
					// Legacy fallback for setups where is_account_page() is
					// unavailable or the page is not registered with Woo.
					$this->is_myaccount = true;
				}
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
					if ( isset( $field['slug'] ) ) {
						$slugs[ $key ] = $field['slug'];
					}
					if ( isset( $field['children'] ) ) {
						foreach ( $field['children'] as $child_key => $child ) {
							if ( isset( $child['slug'] ) ) {
								$slugs[ $child_key ] = $child['slug'];
							}
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
			if ( empty( $slugs ) ) {
					return;
			}

			$mask = WC()->query->get_endpoints_mask();

			foreach ( $slugs as $key => $slug ) {
				if ( 'dashboard' === $key || isset( WC()->query->query_vars[ $key ] ) ) {
						continue;
				}

				WC()->query->query_vars[ $key ] = $slug;
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
			if ( ! get_option( $backup_option, false ) ) {
				$fields     = json_decode( $fields, true );
				$new_fields = array();
				foreach ( $fields as $field ) {

					if ( ! isset( $field['id'] ) ) {
							continue;
					}

					if ( 'view-order' === $field['id'] ) {
						$field['id'] = 'orders';
					}
					if ( 'my-downloads' === $field['id'] ) {
						$field['id'] = 'downloads';
					}

					if ( isset( $field['children'] ) ) {
						$new_fields[ $field['id'] ] = array(
							'type'     => 'group',
							'children' => array(),
						);
						foreach ( $field['children'] as $child ) {
							if ( 'view-order' === $child['id'] ) {
								$child['id'] = 'orders';
							}
							if ( 'my-downloads' === $child['id'] ) {
								$child['id'] = 'downloads';
							}
							$new_fields[ $field['id'] ]['children'][ $child['id'] ] = array( 'type' => 'endpoint' );
						}
					} else {
						$new_fields[ $field['id'] ] = array( 'type' => 'endpoint' );
					}
				}

				update_option( 'wcmp_endpoint_backup_pre_' . WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION, wp_json_encode( $fields ) );
				if ( ! empty( $new_fields ) ) {
					update_option( 'wcmp_endpoint', wp_json_encode( $new_fields ) );
				}
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
function instantiate_woo_custom_myaccount_functions() { // phpcs:ignore Universal.Files.SeparateFunctionsFromOO.Mixed
	return Woo_Custom_My_Account_Page_Functions::instance();
}

instantiate_woo_custom_myaccount_functions();
