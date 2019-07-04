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
?>

<li class="dd-item endpoint" data-id="<?php echo esc_attr( $options['slug'] ); ?>" data-type="endpoint">
	<label class="on-off-endpoint" for="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_active' ); ?>">
		<input type="checkbox" class="hide-show-check" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][active]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_active' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>" <?php checked( esc_attr( $options['active'] ), $options['slug'] ); ?>>
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
				<?php if ( ! array_key_exists( $options['slug'], $default_endpoint_settings ) ) { ?>
					<span class="sep">|</span>
					<span class="remove-trigger" data-endpoint="<?php echo esc_attr( $options['slug'] ); ?>">
						<?php esc_html_e( 'Remove', 'woo-custom-my-account-page' ); ?>
					</span>
				<?php } ?>
			</div>

			<table class="options-table form-table">
				<tbody>
					<?php
					if ( 'dashboard' !== $options['slug'] ) {
						?>
					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_slug' ); ?>">
								<?php
								esc_html_e( 'Endpoint slug', 'woo-custom-my-account-page' );
								?>
							</label>
						</th>
						<td>
							<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>" required>
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
						<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>">
						<?php
					}
					?>
					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_label' ); ?>">
								<?php
								esc_html_e( 'Endpoint label', 'woo-custom-my-account-page' );
								?>
							</label>
						</th>
						<td>
							<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][label]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_label' ); ?>" value="<?php echo esc_attr( $options['label'] ); ?>">
							<p class="description">
								<?php
								esc_html_e( 'Menu item for this endpoint in "My Account".', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>

					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_icon' ); ?>"><?php esc_html_e( 'Endpoint icon', 'woo-custom-my-account-page' ); ?></label>
						</th>
						<td>
							<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][icon]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_icon' ); ?>" value="<?php echo esc_attr( $options['icon'] ); ?>">
							<p class="description">
								<?php
								esc_html_e( 'Endpoint icon for "My Account" menu option.', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>

					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_class' ); ?>"><?php esc_html_e( 'Endpoint class', 'woo-custom-my-account-page' ); ?></label>
						</th>
						<td>
							<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][class]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_class' ); ?>" value="<?php echo esc_attr( $options['class'] ); ?>">
							<p class="description">
								<?php
								esc_html_e( 'Add additional classes to endpoint container.', 'woo-custom-my-account-page' );
								?>
							</p>
						</td>
					</tr>

					<tr>
						<th>
							<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_usr_roles' ); ?>"><?php esc_html_e( 'User roles', 'woo-custom-my-account-page' ); ?></label>
						</th>
						<td>
							<select name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][usr_roles][]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_usr_roles' ); ?>" multiple="" tabindex="-1" aria-hidden="true">
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
					<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][type]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $options['slug'] . '_type' ); ?>" value="<?php echo esc_attr( $options['type'] ); ?>">
				</tbody>
			</table>
		</div>
	</div>
</li>
