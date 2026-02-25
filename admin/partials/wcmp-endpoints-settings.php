<?php
/**
 * This file is used for rendering and saving plugin endpoint settings.
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'Manage Endpoints', 'woo-custom-my-account-page' ); ?></h3>
		</div><!-- .wbcom-welcome-head -->
		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
			<form method="post" action="options.php" id="wbwcmp_endpoints_settings">
				<?php
				settings_fields( 'wcmp_endpoints_settings' );
				do_settings_sections( 'wcmp_endpoints_settings' );
				?>
				<div class="section-title-container">
					<div class="button-container">
						<button type="button" class="button add_new_field" data-target="group">
							<?php esc_html_e( 'Add group', 'woo-custom-my-account-page' ); ?>
						</button>
						<button type="button" class="button add_new_field" data-target="endpoint">
							<?php esc_html_e( 'Add endpoint', 'woo-custom-my-account-page' ); ?>
						</button>
						<button type="button" class="button add_new_field" data-target="link">
							<?php esc_html_e( 'Add link', 'woo-custom-my-account-page' ); ?>
						</button>
					</div>
				</div>
				<?php
				$myaccount_func = instantiate_woo_custom_myaccount_functions();
				$all_settings   = $myaccount_func->wcmp_settings_data();
				$endpoints      = isset( $all_settings['endpoints_settings'] ) ? $all_settings['endpoints_settings'] : array();
				$endpoint_order = $all_settings['endpoint_order'];
				?>
				<div class="dd endpoints-container">
					<ol class="dd-list endpoints">
						<?php
						foreach ( $endpoints as $key => $endpoint ) {
							// Skip if endpoint doesn't have required keys.
							if ( ! isset( $endpoint['type'] ) || ! isset( $endpoint['slug'] ) ) {
								continue;
							}

							// Get endpoint type.
							$endpoint_type = $endpoint['type'];

							// Build args array with correct key based on type.
							$args = array(
								'options'   => $endpoint,
								'usr_roles' => isset( $endpoint['usr_roles'] ) ? $endpoint['usr_roles'] : array(),
								'slug'      => $endpoint['slug'],
							);

							// Add type-specific key.
							switch ( $endpoint_type ) {
								case 'endpoint':
									$args['endpoint'] = $key;
									break;
								case 'group':
									$args['group'] = $key;
									break;
								case 'link':
									$args['link'] = $key;
									break;
								default:
									// Skip invalid types.
									continue 2;
							}

							// Get admin instance and print field.
							$admin_obj      = Woo_Custom_My_Account_Page_Admin::instance();
							$print_function = "wcmp_admin_print_{$endpoint_type}_field";

							// Verify method exists before calling.
							if ( method_exists( $admin_obj, $print_function ) ) {
								call_user_func( array( $admin_obj, $print_function ), $args );
							}
						}
						?>
						<input type="hidden" class="endpoints-order" name="wcmp_endpoints_settings[endpoints-order]" id="<?php echo esc_attr( 'wcmp_endpoint_endpoints-order' ); ?>" value="<?php echo esc_attr( $endpoint_order ); ?>">
						<input type="hidden" class="endpoint-to-remove" name="wcmp_endpoints_settings[to_remove]" value="" />
					</ol>
				</div>
				<div class="new-field-form" style="display: none;">
					<div class="wcmp-modal-body">
						<label for="wcmp-new-field" class="wcmp-field-label">
							<?php echo esc_html_x( 'Name', 'Label for new endpoint title', 'woo-custom-my-account-page' ); ?>
						</label>
						<p class="wcmp-field-desc"><?php esc_html_e( 'Enter a name for your new item. This will appear in the My Account menu.', 'woo-custom-my-account-page' ); ?></p>
						<input type="text" id="wcmp-new-field" name="wcmp-new-field" value="" class="wcmp-field-input" placeholder="<?php esc_attr_e( 'e.g., My Orders', 'woo-custom-my-account-page' ); ?>">
						<span class="wcmp-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
						<p class="error-msg"></p>
					</div>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>
</div>
