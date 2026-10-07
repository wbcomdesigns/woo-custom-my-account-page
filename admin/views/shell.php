<?php
/**
 * Admin page shell: page header, sidebar nav, body slot.
 *
 * Receives from Woo_Custom_My_Account_Page_Admin::render_page():
 *
 * @var Woo_Custom_My_Account_Page_Admin $wcmp_admin Renders the active tab.
 * @var array  $wcmp_tabs Tab registry keyed by slug.
 * @var string $active    Active tab slug.
 * @var string $page_url  Base URL (admin.php?page=woo-custom-myaccount-page).
 *
 * @package Woo_Custom_My_Account_Page
 * @since   1.7.1
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="wrap wcmp-admin">

	<header class="wcmp-page-header">
		<div class="wcmp-page-header__title">
			<span class="dashicons dashicons-id-alt" aria-hidden="true"></span>
			<div>
				<h1><?php echo 'Custom My Account Page for WooCommerce'; ?></h1>
				<p class="wcmp-page-header__subtitle"><?php esc_html_e( 'Turn the WooCommerce My Account area into a branded customer portal: reorder, group and role-restrict its menu, and add your own pages and links.', 'woo-custom-my-account-page' ); ?></p>
			</div>
		</div>
		<div class="wcmp-page-header__actions">
			<span class="wcmp-version-pill">v<?php echo esc_html( WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION ); ?></span>
		</div>
	</header>

	<?php
	/*
	 * Without this marker, core's common.js re-parents every .notice to sit
	 * right after the first <h1> it finds, which slots the "Settings saved"
	 * banner between our title and its subtitle instead of below the header.
	 */
	?>
	<hr class="wp-header-end">

	<div class="wcmp-settings-layout">

		<aside class="wcmp-settings-sidebar">
			<div class="wcmp-settings-sidebar-brand">
				<span class="wcmp-settings-brand-icon" aria-hidden="true">
					<span class="dashicons dashicons-id-alt"></span>
				</span>
				<div class="wcmp-settings-brand-text">
					<p class="wcmp-settings-brand-name"><?php esc_html_e( 'My Account Page', 'woo-custom-my-account-page' ); ?></p>
					<p class="wcmp-settings-brand-sub"><?php esc_html_e( 'Plugin', 'woo-custom-my-account-page' ); ?></p>
				</div>
			</div>
			<nav class="wcmp-settings-sidebar-nav" aria-label="<?php esc_attr_e( 'My Account Page navigation', 'woo-custom-my-account-page' ); ?>">
				<?php
				$wcmp_printed_groups = array();
				$wcmp_group_labels   = array(
					'settings' => esc_html__( 'Settings', 'woo-custom-my-account-page' ),
					'help'     => esc_html__( 'Help', 'woo-custom-my-account-page' ),
				);
				foreach ( $wcmp_tabs as $wcmp_slug => $wcmp_tab ) {
					$wcmp_group = isset( $wcmp_tab['group'] ) ? $wcmp_tab['group'] : 'main';
					if ( 'main' !== $wcmp_group && ! in_array( $wcmp_group, $wcmp_printed_groups, true ) ) {
						echo '<div class="wcmp-snav-divider" role="separator"></div>';
						if ( isset( $wcmp_group_labels[ $wcmp_group ] ) ) {
							echo '<p class="wcmp-snav-section-label">' . esc_html( $wcmp_group_labels[ $wcmp_group ] ) . '</p>';
						}
						$wcmp_printed_groups[] = $wcmp_group;
					}
					$wcmp_is_active = $active === $wcmp_slug;
					echo '<a href="' . esc_url( $page_url . '&tab=' . $wcmp_slug ) . '" class="wcmp-snav-link' . ( $wcmp_is_active ? ' wcmp-snav-link--active' : '' ) . '"' . ( $wcmp_is_active ? ' aria-current="page"' : '' ) . '>';
					echo '<span class="dashicons ' . esc_attr( $wcmp_tab['icon'] ) . '" aria-hidden="true"></span>';
					echo esc_html( $wcmp_tab['label'] );
					echo '</a>';
				}
				?>

				<div class="wcmp-snav-divider" role="separator"></div>
				<p class="wcmp-snav-section-label"><?php esc_html_e( 'Resources', 'woo-custom-my-account-page' ); ?></p>
				<a href="https://github.com/wbcomdesigns/woo-custom-my-account-page/tree/master/docs/website" class="wcmp-snav-link" target="_blank" rel="noopener noreferrer">
					<span class="dashicons dashicons-book" aria-hidden="true"></span>
					<?php esc_html_e( 'Documentation', 'woo-custom-my-account-page' ); ?>
					<span class="dashicons dashicons-external wcmp-snav-link__ext" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'woo-custom-my-account-page' ); ?></span>
				</a>
			</nav>
		</aside>

		<div class="wcmp-settings-main">
			<?php
			// Render settings notices inside the content column so the banner
			// aligns with the panel chrome instead of spanning full width.
			settings_errors();

			$wcmp_admin->render_settings_tab( $active );
			?>
		</div>

	</div>
</div>
