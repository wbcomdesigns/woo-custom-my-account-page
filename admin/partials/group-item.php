<?php
/**
 * MY ACCOUNT ENDPOINTS GROUP TEMPLATE.
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp_roles;
$user_roles     = $wp_roles->roles;
$myaccount_func = instantiate_woo_custom_myaccount_functions();
?>

<li class="dd-item endpoint group" data-id="<?php echo esc_attr( $endpoint ); ?>" data-type="group">

	<label class="on-off-endpoint" for="<?php echo esc_attr( 'wcmp_endpoint_' . esc_attr( $endpoint ) . '_active' ); ?>">
		<input type="checkbox" class="hide-show-check" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][active]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_active' ); ?>" value="<?php echo esc_attr( $endpoint ); ?>" <?php checked( esc_attr( $options['active'] ), $endpoint ); ?>/>
		<i class="fa fa-power-off"></i>
	</label>

	<div class="open-options field-type">
		<span><?php esc_html_e( 'Group', 'woo-custom-my-account-page' ); ?></span>
		<i class="fa fa-chevron-down"></i>
	</div>

	<div class="dd-handle endpoint-content">

		<!-- Header -->
		<div class="endpoint-header">
			<?php echo esc_html( $options['label'] ); ?>
		</div>

		<div class="endpoint-options" style="display: none;">

			<div class="options-row">
				<span class="hide-show-trigger"><?php echo $options['active'] ? esc_html__( 'Hide', 'woo-custom-my-account-page' ) : esc_html__( 'Show', 'woo-custom-my-account-page' ); ?></span>
				<span class="sep">|</span>
				<span class="remove-trigger" data-endpoint="<?php echo esc_attr( $endpoint ); ?>"><?php esc_html_e( 'Remove', 'woo-custom-my-account-page' ); ?></span>
			</div>

			<table class="options-table form-table">
				<tbody>

				<tr>
					<th>
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_label' ); ?>">
							<?php
							esc_html_e( 'Group label', 'woo-custom-my-account-page' );
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
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_icon' ); ?>">
							<?php
							esc_html_e( 'Group icon', 'woo-custom-my-account-page' );
							?>
						</label>
					</th>
					<td>
						<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][icon]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_icon' ); ?>" value="<?php echo esc_attr( $options['icon'] ); ?>">
						<p class="description">
							<?php
							esc_html_e( 'Group icon for "My Account" menu option.', 'woo-custom-my-account-page' );
							?>
						</p>
					</td>
				</tr>

				<tr>
					<th>
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_class' ); ?>">
							<?php esc_html_e( 'Group class', 'woo-custom-my-account-page' ); ?>
						</label>
					</th>
					<td>
						<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][class]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_class' ); ?>" value="<?php echo esc_attr( $options['class'] ); ?>">
						<p class="description">
							<?php
							esc_html_e( 'Add additional classes to group container.', 'woo-custom-my-account-page' );
							?>
						</p>
					</td>
				</tr>

				<tr>
					<th>
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_usr_roles' ); ?>">
							<?php
							esc_html_e( 'User roles', 'woo-custom-my-account-page' );
							?>
						</label>
					</th>
					<td>
						<select name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][usr_roles][]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_usr_roles' ); ?>" multiple="multiple">
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
							esc_html_e( 'Select one or many user roles, you want the endpoint to be displayed. Leaving it blank will show the endpoint to all the user roles.', 'woo-custom-my-account-page' );
							?>
						</p>
					</td>
				</tr>

				<tr>
					<th>
						<label for="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_open' ); ?>"><?php esc_html_e( 'Show open', 'woo-custom-my-account-page' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][open]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_open' ); ?>" value="yes" <?php checked( $options['open'], 'yes' ); ?>>
						<p class="description">
							<?php
							esc_html_e( 'Show the group open by default. (Please note: this option is valid only for "Sidebar" style).', 'woo-custom-my-account-page' );
							?>
						</p>
					</td>
				</tr>
				<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>">
				<input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $endpoint ); ?>][type]" id="<?php echo esc_attr( 'wcmp_endpoint_' . $endpoint . '_type' ); ?>" value="<?php echo esc_attr( $options['type'] ); ?>">

				</tbody>
			</table>
		</div>

	</div>

	<?php if ( ! empty( $options['children'] ) ) : ?>
		<ol class="dd-list endpoints">
		<?php
		foreach ( (array) $options['children'] as $key => $single_options ) {
			$args = array(
				'endpoint'  => $key,
				'options'   => $single_options,
				'id'        => 'wcmp_endpoint',
				'usr_roles' => $single_options['usr_roles'],
			);

			// Get type.
			$admin_obj      = Woo_Custom_My_Account_Page_Admin::instance();
			$print_function = "wcmp_admin_print_{$single_options['type']}_field";
			call_user_func( array( $admin_obj, $print_function ), $args );
		}
		?>
		</ol>
	<?php endif; ?>
</li>
