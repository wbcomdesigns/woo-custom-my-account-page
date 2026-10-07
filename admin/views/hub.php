<?php
/**
 * WB Plugins hub — landing dashboard at ?page=wbcomplugins.
 *
 * Lists every Wbcom plugin that has registered a submenu under the
 * shared wbcomplugins parent. Legacy wbcom-wrapper plugins register
 * boilerplate helper pages (Our Plugins, Our Themes, Support, License)
 * under this hub; those are filtered out via wbcom_hub_wrapper_helper_slugs.
 *
 * @package Woo_Custom_My_Account_Page
 * @since   1.7.1
 */

defined( 'ABSPATH' ) || exit;

$wcmp_submenu_entries = isset( $GLOBALS['submenu']['wbcomplugins'] ) && is_array( $GLOBALS['submenu']['wbcomplugins'] )
	? $GLOBALS['submenu']['wbcomplugins']
	: array();

// Legacy wbcom-wrapper boilerplate helper pages — not real plugins.
$wcmp_wrapper_helper_slugs = apply_filters(
	'wbcom_hub_wrapper_helper_slugs',
	array(
		'wbcom-plugins-page',
		'wbcom-themes-page',
		'wbcom-support-page',
		'wbcom-license-page',
	)
);

$wcmp_plugins = array();
foreach ( $wcmp_submenu_entries as $wcmp_entry ) {
	$wcmp_slug = isset( $wcmp_entry[2] ) ? (string) $wcmp_entry[2] : '';
	if ( '' === $wcmp_slug || 'wbcomplugins' === $wcmp_slug ) {
		continue;
	}
	if ( in_array( $wcmp_slug, $wcmp_wrapper_helper_slugs, true ) ) {
		continue;
	}
	$wcmp_plugins[] = array(
		'slug'       => $wcmp_slug,
		'menu_title' => isset( $wcmp_entry[0] ) ? wp_strip_all_tags( (string) $wcmp_entry[0] ) : $wcmp_slug,
		'page_title' => isset( $wcmp_entry[3] ) ? wp_strip_all_tags( (string) $wcmp_entry[3] ) : '',
		'url'        => admin_url( 'admin.php?page=' . rawurlencode( $wcmp_slug ) ),
	);
}

$wcmp_plugin_count = count( $wcmp_plugins );
?>
<div class="wrap wcmp-admin">
	<header class="wcmp-page-header">
		<div class="wcmp-page-header__title">
			<span class="dashicons dashicons-lightbulb" aria-hidden="true"></span>
			<div>
				<h1><?php esc_html_e( 'WB Plugins', 'woo-custom-my-account-page' ); ?></h1>
				<p class="wcmp-page-header__subtitle">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %d: active Wbcom plugin count */
							_n(
								'%d Wbcom plugin active on this site.',
								'%d Wbcom plugins active on this site.',
								$wcmp_plugin_count,
								'woo-custom-my-account-page'
							),
							$wcmp_plugin_count
						)
					);
					?>
				</p>
			</div>
		</div>
	</header>

	<?php if ( 0 === $wcmp_plugin_count ) : ?>
		<div class="wcmp-empty-state">
			<span class="wcmp-empty-state__icon" aria-hidden="true">
				<span class="dashicons dashicons-lightbulb"></span>
			</span>
			<p class="wcmp-empty-state__title"><?php esc_html_e( 'No Wbcom plugins attached to this hub yet', 'woo-custom-my-account-page' ); ?></p>
			<p class="wcmp-empty-state__desc">
				<?php esc_html_e( 'Activate one or more Wbcom plugins and they will appear here automatically.', 'woo-custom-my-account-page' ); ?>
			</p>
		</div>
	<?php else : ?>
		<div class="wcmp-hub-grid">
			<?php foreach ( $wcmp_plugins as $wcmp_p ) : ?>
				<a href="<?php echo esc_url( $wcmp_p['url'] ); ?>" class="wcmp-hub-card">
					<span class="wcmp-hub-card__icon" aria-hidden="true">
						<span class="dashicons dashicons-admin-plugins"></span>
					</span>
					<span class="wcmp-hub-card__title"><?php echo esc_html( $wcmp_p['menu_title'] ); ?></span>
					<?php if ( ! empty( $wcmp_p['page_title'] ) && $wcmp_p['page_title'] !== $wcmp_p['menu_title'] ) : ?>
						<span class="wcmp-hub-card__subtitle"><?php echo esc_html( $wcmp_p['page_title'] ); ?></span>
					<?php endif; ?>
					<span class="wcmp-hub-card__cta">
						<?php esc_html_e( 'Open settings', 'woo-custom-my-account-page' ); ?>
						<span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="wcmp-card" style="margin-top: 20px;">
		<div class="wcmp-card__head">
			<p class="wcmp-card__title"><?php esc_html_e( 'About WB Plugins', 'woo-custom-my-account-page' ); ?></p>
		</div>
		<div class="wcmp-card__body">
			<p style="margin: 0 0 8px;">
				<?php esc_html_e( 'This hub is the single entry point for every Wbcom Designs plugin installed on your site. Each plugin lives on its own page under this menu and keeps its own settings and data.', 'woo-custom-my-account-page' ); ?>
			</p>
			<p style="margin: 0;">
				<a href="https://wbcomdesigns.com/" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Visit wbcomdesigns.com for more plugins and themes', 'woo-custom-my-account-page' ); ?>
				</a>
			</p>
		</div>
	</div>
</div>
