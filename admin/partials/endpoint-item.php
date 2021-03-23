<?php
/**
 * MY ACCOUNT ENDPOINT FIELDS.
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

global $wp_roles;
$user_roles                = $wp_roles->roles;
$myaccount_func            = instantiate_woo_custom_myaccount_functions();
$default_endpoint_settings = $myaccount_func->default_endpoint_settings();
$editor_options            = array(
	'media_buttons' => true,
	'textarea_name' => 'wcmp_endpoints_settings[endpoints][' . esc_attr( $endpoint ) . '][content]',
	'wpautop'       => true, // use wpautop.
	'media_buttons' => true, // show insert/upload button(s).
	'textarea_rows' => 15, // rows.
	'tabindex'      => '',
	'editor_css'    => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
	'editor_class'  => '', // add extra class(es) to the editor textarea.
	'teeny'         => false, // output the minimal editor config used in Press This.
	'dfw'           => false, // replace the default fullscreen with DFW (needs specific DOM elements and css).
	'tinymce'       => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array().
	'quicktags'     => true, // load Quicktags, can be used to pass settings directly to Quicktags using an array().
);
?>

<li class="dd-item endpoint" data-id="<?php echo esc_attr( $endpoint ); ?>" data-type="endpoint">
	<label class="on-off-endpoint" for="<?php echo esc_attr( 'wcmp_endpoint_' . esc_attr( $endpoint ) . '_active' ); ?>">
		<input type="checkbox" class="hide-show-check" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][active]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_active' ); ?>" value="<?php echo esc_attr( $endpoint ); ?>" <?php checked( esc_attr( $options['active'] ), $endpoint ); ?>>
		<i class="fa fa-power-off"></i>
	</label>
	<div class="open-options field-type">
		<span>
			<?php
			esc_html_e( 'Endpoint', 'woo-custom-my-account-page' );
			?>
		</span>
		<i class="fa fa-chevron-down"></i>
	</div>
	<div class="dd-handle endpoint-content">
		<!-- Header -->
		<div class="endpoint-header">
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
				<span class="hide-show-trigger">
					<?php
					esc_html_e( 'Hide', 'woo-custom-my-account-page' );
					?>

				</span>
				<?php if ( ! array_key_exists( $endpoint, $default_endpoint_settings ) ) { ?>
					<span class="sep">|</span>
					<span class="remove-trigger" data-endpoint="<?php echo esc_attr( $endpoint ); ?>">
						<?php esc_html_e( 'Remove', 'woo-custom-my-account-page' ); ?>
					</span>
				<?php } ?>
			</div>

			<table class="options-table form-table gh">
				<tbody>
					<?php
					if ( 'dashboard' != $endpoint ) {
						?>
					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_slug' ); ?>">
								<?php
								esc_html_e( 'Endpoint slug', 'woo-custom-my-account-page' );
								?>
							</label>
						</th>
						<td>
							<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>" required>
							<p class="description">
								<?php
								esc_html_e( 'Text appended to your page URLs to manage new contents in account pages. It must be unique for every page.', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>
						<?php
					} else {
						?>
						<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>">
						<?php
					}
					?>
					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_label' ); ?>">
								<?php
								esc_html_e( 'Endpoint label', 'woo-custom-my-account-page' );
								?>
							</label>
						</th>
						<td>
							<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][label]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_label' ); ?>" value="<?php echo esc_attr( $options['label'] ); ?>">
							<p class="description">
								<?php
								esc_html_e( 'Menu item for this endpoint in "My Account".', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>

					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_icon' ); ?>"><?php esc_html_e( 'Endpoint icon', 'woo-custom-my-account-page' ); ?></label>
						</th>
						<td>
							<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][icon]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_icon' ); ?>" value="<?php echo esc_attr( $options['icon'] ); ?>">
							<p class="description">
								<?php
								esc_html_e( 'Endpoint icon for "My Account" menu option.', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>

					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_class' ); ?>"><?php esc_html_e( 'Endpoint class', 'woo-custom-my-account-page' ); ?></label>
						</th>
						<td>
							<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][class]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_class' ); ?>" value="<?php echo esc_attr( $options['class'] ); ?>">
							<p class="description">
								<?php
								esc_html_e( 'Add additional classes to endpoint container.', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>

					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_usr_roles' ); ?>"><?php esc_html_e( 'User roles', 'woo-custom-my-account-page' ); ?></label>
						</th>
						<td>
							<select name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][usr_roles][]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_usr_roles' ); ?>" multiple="" tabindex="-1" aria-hidden="true">
								<?php
								if ( $user_roles ) {
									foreach ( $user_roles as $usrrole_slug => $usrrole_arr ) {
										if ( ! empty( $options['usr_roles'] ) ) {
											if ( in_array( $usrrole_slug, $options['usr_roles'] ) ) {
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
							<p class="description">
								<?php
								esc_html_e( 'Restrict endpoint visibility to the following user role(s).', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>
					<?php if ( ! array_key_exists( $endpoint, $default_endpoint_settings ) ) { ?>
					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_content' ); ?>"><?php esc_html_e( 'Endpoint content', 'woo-custom-my-account-page' ); ?></label>
						</th>
						<td>
							<?php wp_editor( $options['content'], $endpoint . '_content', $editor_options ); ?>
							<p class="description">
								<?php
								esc_html_e( 'Custom endpoint content. Leave it black to use default content.', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>
					<?php } ?>	
					<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][type]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_type' ); ?>" value="<?php echo esc_attr( $options['type'] ); ?>">
				</tbody>
			</table>
		</div>
	</div>
</li>
