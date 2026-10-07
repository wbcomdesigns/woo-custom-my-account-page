<?php
/**
 * MY ACCOUNT LINK FIELDS.
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Template variables passed in by the caller; defaults guard partial overrides.
$link    = isset( $link ) ? $link : ''; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- included inside Admin::wcmp_admin_print_link_field(), so $link is local.
$options = isset( $options ) ? $options : array();
global $wp_roles;
$user_roles = $wp_roles->roles;
?>

<li class="dd-item endpoint link" data-id="<?php echo esc_attr( $link ); ?>" data-type="link">

	<label class="on-off-endpoint" for="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_active' ); ?>">
		<input type="checkbox" class="hide-show-check" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][active]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_active' ); ?>" value="<?php echo esc_attr( $link ); ?>" <?php checked( esc_attr( $options['active'] ), $link ); ?>/>
		<i class="wcmp-eye" data-lucide="eye" aria-hidden="true"></i>
		<span class="screen-reader-text"><?php esc_html_e( 'Show in menu', 'woo-custom-my-account-page' ); ?></span>
	</label>

	<button type="button" class="open-options field-type" aria-expanded="false">
		<span class="wcmp-type-badge wcmp-type-link">
			<?php
			esc_html_e( 'Link', 'woo-custom-my-account-page' );
			?>
		</span>
		<i class="wcmp-chevron" data-lucide="chevron-down" aria-hidden="true"></i>
		<span class="screen-reader-text"><?php echo esc_html( sprintf( /* translators: %s: menu item label. */ __( 'Edit %s', 'woo-custom-my-account-page' ), $options['label'] ) ); ?></span>
	</button>

	<div class="dd-handle endpoint-content">

		<!-- Header -->
		<div class="endpoint-header">
			<?php
			$icon_class = isset( $options['icon'] ) ? (string) $options['icon'] : '';
			if ( '' !== $icon_class ) :
				// Same rule as the front-end menu templates, so the preview matches what customers see.
				$icon_class = false === strpos( $icon_class, 'fa-' ) ? 'fa-' . $icon_class : $icon_class;
				?>
				<i class="wcmp-icon-preview fa <?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
			<?php endif; ?>
			<?php echo esc_html( $options['label'] ); ?>
			<span class="sub-item-label">
				<i>
					<?php
					esc_html_e( 'sub item', 'woo-custom-my-account-page' );
					?>
				</i>
			</span>
		</div>

		<!-- Content -->
		<div class="endpoint-options" style="display: none;">

			<div class="options-row">
				<button type="button" class="wcmp-link-btn hide-show-trigger"><?php echo $options['active'] ? esc_html__( 'Hide from menu', 'woo-custom-my-account-page' ) : esc_html__( 'Show in menu', 'woo-custom-my-account-page' ); ?></button>
				<span class="sep" aria-hidden="true">|</span>
				<button type="button" class="wcmp-link-btn remove-trigger" data-endpoint="<?php echo esc_attr( $link ); ?>"><?php esc_html_e( 'Remove', 'woo-custom-my-account-page' ); ?></button>
			</div>

			<div class="wcmp-endpoint-fields">

				<?php if ( 'dashboard' !== $link ) : ?>
				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_url' ); ?>"><?php esc_html_e( 'Link url', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'The url of the menu item.', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<input type="text" class="wcmp-input" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][url]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_url' ); ?>" value="<?php echo esc_attr( isset( $options['url'] ) ? $options['url'] : '#' ); ?>">
					</div>
				</div>
				<?php endif; ?>

				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_label' ); ?>"><?php esc_html_e( 'Link label', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Menu label for this link in "My Account".', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<input type="text" class="wcmp-input" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][label]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_label' ); ?>" value="<?php echo esc_attr( isset( $options['label'] ) ? $options['label'] : '' ); ?>">
					</div>
				</div>

				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_icon' ); ?>"><?php esc_html_e( 'Link icon', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Link icon for "My Account" menu option.', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<input type="text" class="wcmp-input" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][icon]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_icon' ); ?>" value="<?php echo esc_attr( $options['icon'] ); ?>">
					</div>
				</div>

				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_class' ); ?>"><?php esc_html_e( 'Link class', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Add additional classes to link container.', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<input type="text" class="wcmp-input" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][class]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_class' ); ?>" value="<?php echo esc_attr( $options['class'] ); ?>">
					</div>
				</div>

				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_usr_roles' ); ?>"><?php esc_html_e( 'Visible to roles (empty = everyone)', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Select one or many user roles, you want the endpoint to be displayed. Leaving it blank will show the endpoint to all the user roles.', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<select class="wcmp-select" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][usr_roles][]" multiple="multiple">
							<?php
							if ( $user_roles ) {
								foreach ( $user_roles as $usrrole_slug => $usrrole_arr ) {
									if ( ! empty( $options['usr_roles'] ) ) {
										if ( in_array( $usrrole_slug, $options['usr_roles'], true ) ) {
											?>
												<option value="<?php echo esc_attr( $usrrole_slug ); ?>" selected = "selected">
												<?php echo esc_html( $usrrole_arr['name'] ); ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo esc_attr( $usrrole_slug ); ?>">
													<?php echo esc_html( $usrrole_arr['name'] ); ?>
												</option>
											<?php
											}
									} else {
										?>
										<option value="<?php echo esc_attr( $usrrole_slug ); ?>">
											<?php echo esc_html( $usrrole_arr['name'] ); ?>
										</option>
										<?php
									}
								}
							}
							?>
						</select>
					</div>
				</div>

				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_target_blank' ); ?>"><?php esc_html_e( 'Open link in a new tab?', 'woo-custom-my-account-page' ); ?></label>
					</div>
					<div class="wcmp-field-control">
						<label class="wcmp-switch">
							<input type="checkbox" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][target_blank]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_target_blank' ); ?>" value="yes" <?php checked( $options['target_blank'], 'yes' ); ?>>
							<span class="wcmp-slider"></span>
						</label>
					</div>
				</div>
				<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>">
				<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $link ); ?>][type]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $link . '_type' ); ?>" value="<?php echo esc_attr( $options['type'] ); ?>">
			</div>
		</div>

	</div>
</li>
