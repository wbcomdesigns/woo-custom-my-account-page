<?php
/**
 * The Wbcom settings screen - Pattern A: sidebar left, content right.
 *
 * A bundled library, not plugin code. Several plugins on one site each get their own screen from
 * one implementation, and the newest copy on disk is the one that runs (see loader.php).
 *
 * A plugin registers a page and then contributes tabs through two seams named after its own
 * prefix, so free and Pro halves of a product both feed the same screen:
 *
 *     Wbcom_Settings_Page::boot( array(
 *         'prefix'     => 'wcap',
 *         'slug'       => 'woo-audio-preview-settings',
 *         'assets_url' => plugin_dir_url( __FILE__ ),
 *         'version'    => '1.5.3',
 *         'labels'     => array( 'menu_title' => __( 'Audio Preview', 'woo-audio-preview' ), ... ),
 *     ) );
 *
 *     add_filter( 'wcap_settings_nav_groups', ... )   // declare nav entries
 *     add_action( 'wcap_settings_tab_content', ... )  // render one tab's body
 *
 * The screen owns the menu entry, the sidebar, routing, assets, notice suppression and the card
 * structure. It owns no settings, and tab renderers own no chrome - which is what stops a tab
 * added by a Pro plugin from being laid out differently to one added by its free half.
 *
 * @package Wbcom_Settings
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Pattern A settings screen.
 *
 * @since 1.0.0
 */
class Wbcom_Settings_Page {

	/**
	 * Library version. The loader uses this to pick between bundled copies.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	const VERSION = '1.0.0';

	/**
	 * Parent menu slug shared by every Wbcom plugin.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	const PARENT = 'wbcomplugins';

	/**
	 * Registered pages, keyed by menu slug.
	 *
	 * A registry rather than a single set of statics because more than one Wbcom plugin can be
	 * active at once and each needs its own screen. The single-page version of this silently
	 * ignored the second plugin to register.
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	private static $pages = array();

	/**
	 * Register a settings screen.
	 *
	 * @since 1.0.0
	 * @param array $config {
	 *     @type string $prefix       Hook prefix, e.g. 'wcap'. Required.
	 *     @type string $slug         Menu slug. Required.
	 *     @type string $assets_url   URL of the plugin root supplying the assets. Required.
	 *     @type string $version      Plugin version, for asset cache busting.
	 *     @type array  $legacy_slugs Retired page slugs that should redirect here.
	 *     @type array  $labels       Visible strings, translated by the CALLER in its own domain.
	 * }
	 */
	public static function boot( $config ) {
		if ( empty( $config['prefix'] ) || empty( $config['slug'] ) ) {
			return;
		}

		$slug = $config['slug'];

		if ( isset( self::$pages[ $slug ] ) ) {
			return;
		}

		self::$pages[ $slug ] = array_merge(
			array(
				'assets_url'   => '',
				'version'      => self::VERSION,
				'legacy_slugs' => array(),
				'labels'       => array(),
			),
			$config
		);

		self::$pages[ $slug ]['labels'] = array_merge(
			array(
				'menu_title' => 'Settings',
				'brand'      => 'Settings',
				'subtitle'   => 'Settings',
				'nav_label'  => 'Settings sections',
				'pro_badge'  => 'Pro',
			),
			array_filter( (array) self::$pages[ $slug ]['labels'] )
		);

		if ( 1 === count( self::$pages ) ) {
			add_action( 'admin_menu', array( __CLASS__, 'register_pages' ), 20 );
			add_action( 'admin_menu', array( __CLASS__, 'redirect_legacy_slugs' ), 1 );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
			add_action( 'in_admin_header', array( __CLASS__, 'quieten_foreign_notices' ), 1 );
		}
	}

	/**
	 * Add every registered screen to the shared Wbcom menu.
	 *
	 * @since 1.0.0
	 */
	public static function register_pages() {
		foreach ( self::$pages as $slug => $page ) {
			add_submenu_page(
				self::PARENT,
				esc_html( $page['labels']['menu_title'] ),
				esc_html( $page['labels']['menu_title'] ),
				'manage_options',
				$slug,
				array( __CLASS__, 'render' )
			);
		}
	}

	/**
	 * Whether this request is the shared menu's landing page.
	 *
	 * @since  1.0.0
	 * @return bool
	 */
	private static function is_landing_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Routing only.
		$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

		return self::PARENT === $page;
	}

	/**
	 * Render the hub at the shared "WB Plugins" menu.
	 *
	 * Built from the WordPress submenu table, NOT from this library's own registry. That matters
	 * on a real site: a shop can run Woo addons alongside BuddyPress addons, and only some of them
	 * use this library. Reading the menu means every Wbcom plugin appears whether or not it does -
	 * and it means this hub behaves identically to the one the BuddyPress plugins render, so
	 * whichever plugin happens to own the parent menu, the owner sees the same page.
	 *
	 * Each of the Wbcom plugins used to point this menu at their OWN settings renderer, so the
	 * entry labelled "Welcome" opened one product's settings - picked by plugin load order, and
	 * drawn without that screen's assets, so it arrived unstyled.
	 *
	 * @since 1.0.0
	 */
	public static function render_welcome() {
		$entries = isset( $GLOBALS['submenu'][ self::PARENT ] ) && is_array( $GLOBALS['submenu'][ self::PARENT ] )
			? $GLOBALS['submenu'][ self::PARENT ]
			: array();

		/**
		 * Slugs under the hub that are not products.
		 *
		 * Un-migrated Wbcom plugins register shared boilerplate pages here. They are not plugins,
		 * so listing them as cards would read as duplicate tiles. Same filter name the BuddyPress
		 * plugins use, so a site running both filters one list.
		 *
		 * @since 1.0.0
		 * @param array $slugs Menu slugs to leave out of the hub.
		 */
		$helpers = apply_filters(
			'wbcom_hub_wrapper_helper_slugs',
			array( 'wbcom-plugins-page', 'wbcom-themes-page', 'wbcom-support-page', 'wbcom-license-page' )
		);

		$plugins = array();

		foreach ( $entries as $entry ) {
			$slug = isset( $entry[2] ) ? (string) $entry[2] : '';

			if ( '' === $slug || self::PARENT === $slug || in_array( $slug, $helpers, true ) ) {
				continue;
			}

			$plugins[] = array(
				'slug'     => $slug,
				'title'    => isset( $entry[0] ) ? wp_strip_all_tags( (string) $entry[0] ) : $slug,
				'subtitle' => isset( $entry[3] ) ? wp_strip_all_tags( (string) $entry[3] ) : '',
				'url'      => admin_url( 'admin.php?page=' . rawurlencode( $slug ) ),
				'icon'     => isset( self::$pages[ $slug ]['icon'] ) ? self::$pages[ $slug ]['icon'] : 'plug',
			);
		}

		$count = count( $plugins );
		?>
		<div class="wrap wbcom-admin">
			<header class="wbcom-page-header">
				<span class="wbcom-page-header__icon"><i data-lucide="lightbulb"></i></span>
				<div>
					<h1><?php esc_html_e( 'WB Plugins', 'default' ); ?></h1>
					<p class="wbcom-page-header__subtitle">
						<?php
						echo esc_html(
							sprintf(
								/* translators: %d: number of active Wbcom plugins. */
								_n( '%d Wbcom plugin active on this site.', '%d Wbcom plugins active on this site.', $count, 'default' ),
								$count
							)
						);
						?>
					</p>
				</div>
			</header>

			<?php if ( 0 === $count ) : ?>
				<div class="wbcom-empty-state">
					<i data-lucide="lightbulb"></i>
					<p class="wbcom-empty-state__title"><?php esc_html_e( 'No Wbcom plugins attached to this hub yet', 'default' ); ?></p>
					<p class="wbcom-empty-state__desc"><?php esc_html_e( 'Activate one and it will appear here automatically.', 'default' ); ?></p>
				</div>
			<?php else : ?>
				<div class="wbcom-hub-grid">
					<?php foreach ( $plugins as $plugin ) : ?>
						<a class="wbcom-hub-card" href="<?php echo esc_url( $plugin['url'] ); ?>">
							<span class="wbcom-hub-card__icon"><i data-lucide="<?php echo esc_attr( $plugin['icon'] ); ?>"></i></span>
							<span class="wbcom-hub-card__title"><?php echo esc_html( $plugin['title'] ); ?></span>
							<?php if ( '' !== $plugin['subtitle'] && $plugin['subtitle'] !== $plugin['title'] ) : ?>
								<span class="wbcom-hub-card__subtitle"><?php echo esc_html( $plugin['subtitle'] ); ?></span>
							<?php endif; ?>
							<span class="wbcom-hub-card__cta">
								<?php esc_html_e( 'Open settings', 'default' ); ?>
								<i data-lucide="arrow-right"></i>
							</span>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php
			self::card_open( __( 'About WB Plugins', 'default' ) );
			?>
			<p>
				<?php esc_html_e( 'This hub is the single entry point for every Wbcom Designs plugin installed on your site. Each plugin lives on its own page under this menu and keeps its own settings, licence, and data.', 'default' ); ?>
			</p>
			<p>
				<a href="https://wbcomdesigns.com/" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Visit wbcomdesigns.com for more plugins and themes', 'default' ); ?>
					<i data-lucide="arrow-right"></i>
				</a>
			</p>
			<?php
			self::card_close();
			?>
		</div>
		<?php
	}

	/**
	 * Send retired settings URLs to the screen that replaced them.
	 *
	 * Hooked to admin_menu, not admin_init, and that is not interchangeable. WordPress builds the
	 * menu in wp-admin/menu.php, then checks whether the current user can reach the requested page
	 * and calls wp_die() with a 403 if the slug is not registered - all before admin_init fires. A
	 * redirect on admin_init is therefore unreachable for exactly the case it exists to handle.
	 *
	 * @since 1.0.0
	 */
	public static function redirect_legacy_slugs() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Routing only.
		$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

		if ( '' === $page ) {
			return;
		}

		foreach ( self::$pages as $slug => $config ) {
			if ( in_array( $page, (array) $config['legacy_slugs'], true ) ) {
				wp_safe_redirect( admin_url( 'admin.php?page=' . $slug ) );
				exit;
			}
		}
	}

	/**
	 * Which screen the current request is for.
	 *
	 * @since  1.0.0
	 * @return array|null Page config, or null when this is not one of our screens.
	 */
	private static function current_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Routing only.
		$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

		return isset( self::$pages[ $page ] ) ? self::$pages[ $page ] : null;
	}

	/**
	 * The nav for one screen, as declared by whichever plugins are active.
	 *
	 * @since  1.0.0
	 * @param  string $prefix Hook prefix of the screen.
	 * @return array
	 */
	public static function nav_groups( $prefix ) {
		/**
		 * Filter the settings nav for this product.
		 *
		 * Both halves of a free/Pro pair go through it, which is what makes their tabs
		 * indistinguishable to the owner.
		 *
		 * @since 1.0.0
		 * @param array $groups Nav groups.
		 */
		$groups = apply_filters( $prefix . '_settings_nav_groups', array() );

		return is_array( $groups ) ? $groups : array();
	}

	/**
	 * Every tab id of one screen, in nav order.
	 *
	 * @since  1.0.0
	 * @param  string $prefix Hook prefix.
	 * @return array
	 */
	private static function tab_ids( $prefix ) {
		$ids = array();

		foreach ( self::nav_groups( $prefix ) as $group ) {
			if ( ! empty( $group['items'] ) && is_array( $group['items'] ) ) {
				$ids = array_merge( $ids, array_keys( $group['items'] ) );
			}
		}

		return $ids;
	}

	/**
	 * Load assets, and only on one of our screens.
	 *
	 * @since 1.0.0
	 */
	public static function enqueue() {
		$page = self::current_page();

		/*
		 * The shared landing page is not a registered settings screen, but it is drawn by this
		 * class and needs the same stylesheet. Without this it rendered as unstyled HTML - a list
		 * of plugin names and bare links - which is exactly what it looked like before anyone
		 * noticed it was rendering a plugin's settings by accident.
		 */
		if ( ! $page && self::is_landing_page() ) {
			$page = reset( self::$pages );
		}

		if ( ! $page ) {
			return;
		}

		$base = trailingslashit( $page['assets_url'] );

		wp_enqueue_script( 'wbcom-lucide', $base . 'assets/vendor/lucide.min.js', array(), '0.460.0', true );
		wp_enqueue_style( 'wbcom-settings', $base . 'lib/wbcom-settings/settings.css', array(), self::VERSION );
		wp_style_add_data( 'wbcom-settings', 'rtl', 'replace' );
		wp_enqueue_script( 'wbcom-settings', $base . 'lib/wbcom-settings/settings.js', array( 'wbcom-lucide' ), self::VERSION, true );
	}

	/**
	 * Keep other plugins' notices off this screen.
	 *
	 * Stripped rather than hidden with CSS: display:none leaves every "rate us" banner in the
	 * document, where a screen reader announces all of them before reaching the settings. Ours
	 * stay, and so does anything core registers as a closure - that is where update and error
	 * notices come from.
	 *
	 * @since 1.0.0
	 */
	public static function quieten_foreign_notices() {
		global $wp_filter;

		$page = self::current_page();

		if ( ! $page ) {
			return;
		}

		$keep = array( $page['prefix'], str_replace( '-', '_', $page['slug'] ) );

		foreach ( array( 'admin_notices', 'all_admin_notices', 'user_admin_notices', 'network_admin_notices' ) as $hook ) {
			if ( empty( $wp_filter[ $hook ] ) ) {
				continue;
			}

			foreach ( $wp_filter[ $hook ]->callbacks as $priority => $callbacks ) {
				foreach ( $callbacks as $id => $callback ) {
					if ( self::is_ours_or_core( $callback['function'], $keep ) ) {
						continue;
					}

					unset( $wp_filter[ $hook ]->callbacks[ $priority ][ $id ] );
				}
			}
		}
	}

	/**
	 * Whether a notice callback belongs to this product or to WordPress itself.
	 *
	 * @since  1.0.0
	 * @param  mixed $callback Registered callback.
	 * @param  array $keep     Name fragments that mark a callback as ours.
	 * @return bool
	 */
	private static function is_ours_or_core( $callback, $keep ) {
		if ( $callback instanceof Closure ) {
			return true;
		}

		$name = '';

		if ( is_string( $callback ) ) {
			$name = $callback;
		} elseif ( is_array( $callback ) && isset( $callback[0], $callback[1] ) ) {
			$name = ( is_object( $callback[0] ) ? get_class( $callback[0] ) : (string) $callback[0] ) . '::' . $callback[1];
		}

		foreach ( $keep as $fragment ) {
			if ( '' !== $fragment && false !== stripos( $name, $fragment ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Render the current screen.
	 *
	 * @since 1.0.0
	 */
	public static function render() {
		$page = self::current_page();

		if ( ! $page ) {
			return;
		}

		$prefix = $page['prefix'];
		$groups = self::nav_groups( $prefix );
		$ids    = self::tab_ids( $prefix );

		if ( empty( $ids ) ) {
			return;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Tab routing only.
		$requested = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : '';
		$current   = in_array( $requested, $ids, true ) ? $requested : $ids[0];
		?>
		<div class="wrap wbcom-admin">
			<?php settings_errors(); ?>

			<div class="wbcom-settings-wrap">
				<nav class="wbcom-settings-sidebar" aria-label="<?php echo esc_attr( $page['labels']['nav_label'] ); ?>">
					<div class="wbcom-settings-sidebar__brand">
						<span class="wbcom-settings-sidebar__logo"><i data-lucide="<?php echo esc_attr( isset( $page['icon'] ) ? $page['icon'] : 'settings' ); ?>"></i></span>
						<div>
							<strong><?php echo esc_html( $page['labels']['brand'] ); ?></strong>
							<span><?php echo esc_html( $page['labels']['subtitle'] ); ?></span>
						</div>
					</div>

					<?php foreach ( $groups as $group ) : ?>
						<?php
						if ( empty( $group['items'] ) ) {
							continue;
						}
						?>
						<div class="wbcom-settings-nav-group">
							<?php if ( ! empty( $group['label'] ) ) : ?>
								<span class="wbcom-settings-nav-group__label"><?php echo esc_html( $group['label'] ); ?></span>
							<?php endif; ?>

							<?php foreach ( $group['items'] as $tab_id => $item ) : ?>
								<a class="wbcom-settings-nav-item<?php echo $tab_id === $current ? ' is-active' : ''; ?>"
									href="<?php echo esc_url( self::tab_url( $page['slug'], $tab_id ) ); ?>"
									data-section="<?php echo esc_attr( $tab_id ); ?>"
									<?php echo $tab_id === $current ? 'aria-current="page"' : ''; ?>>
									<i data-lucide="<?php echo esc_attr( isset( $item['icon'] ) ? $item['icon'] : 'circle' ); ?>"></i>
									<span><?php echo esc_html( isset( $item['title'] ) ? $item['title'] : $tab_id ); ?></span>
									<?php if ( ! empty( $item['pro'] ) ) : ?>
										<span class="wbcom-pro-badge"><?php echo esc_html( $page['labels']['pro_badge'] ); ?></span>
									<?php endif; ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</nav>

				<div class="wbcom-settings-content">
					<?php foreach ( $ids as $tab_id ) : ?>
						<div class="wbcom-settings-section<?php echo $tab_id === $current ? ' is-active' : ''; ?>" id="section-<?php echo esc_attr( $tab_id ); ?>">
							<div class="wbcom-settings-body">
								<?php
								/**
								 * Render one settings tab.
								 *
								 * Renderers output bare sections - the screen supplies padding, card chrome
								 * and heading structure, so a tab from a Pro plugin cannot end up spaced
								 * differently from a tab from its free half.
								 *
								 * @since 1.0.0
								 * @param string $tab_id Tab being rendered.
								 */
								do_action( $prefix . '_settings_tab_content', $tab_id );
								?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * URL of one tab.
	 *
	 * A real URL rather than a bare fragment, so a tab survives a save, a refresh and a
	 * middle-click, and the screen still works with JavaScript unavailable.
	 *
	 * @since  1.0.0
	 * @param  string $slug   Page slug.
	 * @param  string $tab_id Tab id.
	 * @return string
	 */
	public static function tab_url( $slug, $tab_id ) {
		return admin_url( 'admin.php?page=' . rawurlencode( $slug ) . '&tab=' . rawurlencode( $tab_id ) );
	}

	/**
	 * Open a settings card.
	 *
	 * Tab renderers call this instead of writing their own markup, which is what stops one
	 * product's cards drifting away from another's.
	 *
	 * @since 1.0.0
	 * @param string $title Card title.
	 * @param string $desc  Optional description.
	 */
	public static function card_open( $title, $desc = '' ) {
		?>
		<section class="wbcom-card">
			<div class="wbcom-card__head">
				<p class="wbcom-card__title"><?php echo esc_html( $title ); ?></p>
				<?php if ( '' !== $desc ) : ?>
					<p class="wbcom-card__desc"><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>
			</div>
			<div class="wbcom-card__body">
		<?php
	}

	/**
	 * Close a settings card.
	 *
	 * @since 1.0.0
	 */
	public static function card_close() {
		echo '</div></section>';
	}
}
