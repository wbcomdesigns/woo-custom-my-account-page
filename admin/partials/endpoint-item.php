<?php
/**
 * MY ACCOUNT ENDPOINT FIELDS.
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Template variables passed in by the caller; defaults guard partial overrides.
$endpoint = isset( $endpoint ) ? $endpoint : '';
$options  = isset( $options ) ? $options : array();

global $wp_roles;
$user_roles                = $wp_roles->roles;
$myaccount_func            = instantiate_woo_custom_myaccount_functions();
$default_endpoint_settings = $myaccount_func->default_endpoint_settings();
$editor_options            = array(
	'textarea_name' => 'wcmp_endpoints_settings[endpoints][' . esc_attr( $endpoint ) . '][content]',
	'wpautop'       => true, // Use wpautop.
	'media_buttons' => true, // Show insert/upload button(s).
	'textarea_rows' => 15, // rows.
	'tabindex'      => '',
	'editor_css'    => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
	'editor_class'  => '', // add extra class(es) to the editor textarea.
	'teeny'         => false, // output the minimal editor config used in Press This.
	'dfw'           => false, // replace the default fullscreen with DFW (needs specific DOM elements and css).
	'tinymce'       => array(
		'theme_advanced_buttons1' => 'formatselect,bold,italic,underline,|,bullist,numlist,|,link,unlink,|,undo,redo',
		'theme_advanced_buttons2' => '',
		'theme_advanced_buttons3' => '',
		'theme_advanced_buttons4' => '',
	),
	'quicktags'     => true, // load Quicktags, can be used to pass settings directly to Quicktags using an array().
);
?>

<li class="dd-item endpoint" data-id="<?php echo esc_attr( $endpoint ); ?>" data-type="endpoint">
	<label class="on-off-endpoint" for="<?php echo esc_attr( 'wcmp_endpoint_' . esc_attr( $endpoint ) . '_active' ); ?>">
		<input type="checkbox" class="hide-show-check" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][active]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_active' ); ?>" value="<?php echo esc_attr( $endpoint ); ?>" <?php checked( esc_attr( $options['active'] ), $endpoint ); ?>>
		<i class="wcmp-eye" data-lucide="eye" aria-hidden="true"></i>
		<span class="screen-reader-text"><?php esc_html_e( 'Show in menu', 'woo-custom-my-account-page' ); ?></span>
	</label>
	<button type="button" class="open-options field-type" aria-expanded="false">
		<span class="wcmp-type-badge wcmp-type-endpoint">
			<?php
			esc_html_e( 'Endpoint', 'woo-custom-my-account-page' );
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
				<button type="button" class="wcmp-link-btn hide-show-trigger">
					<?php
					esc_html_e( 'Hide from menu', 'woo-custom-my-account-page' );
					?>

				</button>
				<?php if ( ! array_key_exists( $endpoint, $default_endpoint_settings ) ) { ?>
					<span class="sep" aria-hidden="true">|</span>
					<button type="button" class="wcmp-link-btn remove-trigger" data-endpoint="<?php echo esc_attr( $endpoint ); ?>">
						<?php esc_html_e( 'Remove', 'woo-custom-my-account-page' ); ?>
					</button>
				<?php } ?>
			</div>

			<div class="wcmp-endpoint-fields">
				<?php
				if ( 'dashboard' !== $endpoint ) {
					?>
				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_slug' ); ?>"><?php esc_html_e( 'Endpoint slug', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Text appended to your page URLs to manage new contents in account pages. It must be unique for every page.', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<input type="text" class="wcmp-input" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>" required>
					</div>
				</div>
					<?php
				} else {
					?>
					<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>">
					<?php
				}
				?>
				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_label' ); ?>"><?php esc_html_e( 'Endpoint label', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Menu item for this endpoint in "My Account".', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<input type="text" class="wcmp-input" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][label]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_label' ); ?>" value="<?php echo esc_attr( $options['label'] ); ?>">
					</div>
				</div>

				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_icon' ); ?>"><?php esc_html_e( 'Endpoint icon', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Endpoint icon for "My Account" menu option.', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<input type="text" class="wcmp-input" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][icon]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_icon' ); ?>" value="<?php echo esc_attr( $options['icon'] ); ?>">
					</div>
				</div>

				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_class' ); ?>"><?php esc_html_e( 'Endpoint class', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Add additional classes to endpoint container.', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<input type="text" class="wcmp-input" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][class]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_class' ); ?>" value="<?php echo esc_attr( $options['class'] ); ?>">
					</div>
				</div>

				<div class="wcmp-field wcmp-field-group">
					<div class="wcmp-field-info">
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_usr_roles' ); ?>"><?php esc_html_e( 'Visible to roles (empty = everyone)', 'woo-custom-my-account-page' ); ?></label>
						<p class="description"><?php esc_html_e( 'Select one or many user roles, you want the endpoint to be displayed. Leaving it blank will show the endpoint to all the user roles.', 'woo-custom-my-account-page' ); ?></p>
					</div>
					<div class="wcmp-field-control">
						<select class="wcmp-select" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][usr_roles][]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_usr_roles' ); ?>" multiple="" tabindex="-1" aria-hidden="true">
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
									<option value="<?php echo esc_attr( $usrrole_slug ); ?>"><?php echo esc_html( $usrrole_arr['name'] ); ?></option>
										<?php
									}
								}
							}
							?>
						</select>
					</div>
				</div>
				<?php if ( ! array_key_exists( $endpoint, $default_endpoint_settings ) ) { ?>
				<div class="wcmp-field">
					<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_content' ); ?>"><?php esc_html_e( 'Endpoint content', 'woo-custom-my-account-page' ); ?></label>
					<p class="description"><?php esc_html_e( 'Custom endpoint content. Leave it blank to use default content.', 'woo-custom-my-account-page' ); ?></p>
					<?php wp_editor( $options['content'], $endpoint . '_content', $editor_options ); ?>
				</div>
				<?php } ?>
				<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][type]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_type' ); ?>" value="<?php echo esc_attr( $options['type'] ); ?>">
			</div>
		</div>
	</div>
</li>
