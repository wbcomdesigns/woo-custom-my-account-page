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
	<div class="wbcom-welcome-head">
		<h2 class="wbcom-welcome-title"><?php esc_html_e( 'Manage Endpoints', 'woo-custom-my-account-page' ); ?></h2>
	</div><!-- .wbcom-welcome-head -->
	<div class="wbcom-wrapper-section">	
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
		$endpoints      = $all_settings['endpoints_settings'];
		$endpoint_order = $all_settings['endpoint_order'];
		?>
		<div class="dd endpoints-container">
			<ol class="dd-list endpoints">
				<?php
				foreach ( $endpoints as $key => $endpoint ) {
					// Build args array.
					$args = array(
						'endpoint'  => $key,
						'options'   => $endpoint,
						'usr_roles' => $endpoint['usr_roles'],
						'slug'      => $endpoint['slug'],
					);

					// Get type.
					$admin_obj      = Woo_Custom_My_Account_Page_Admin::instance();
					$print_function = "wcmp_admin_print_{$endpoint['type']}_field";
					call_user_func( array( $admin_obj, $print_function ), $args );
				}
				?>
				<input type="hidden" class="endpoints-order" name="wcmp_endpoints_settings[endpoints-order]" id="<?php echo esc_attr( 'wcmp_endpoint_endpoints-order' ); ?>" value="<?php echo esc_attr( $endpoint_order ); ?>">
				<input type="hidden" class="endpoint-to-remove" name="wcmp_endpoints_settings[to_remove]" value="" />
			</ol>
		</div>
		<div class="new-field-form" style="display: none;">
			<label for="wcmp-new-field"><?php esc_html_x( 'Name', 'Label for new endpoint title', 'woo-custom-my-account-page' ); ?>
				<input type="text" id="wcmp-new-field" name="wcmp-new-field" value="">
			</label>
			<div class="wcmp-loader"><i class="fa fa-spinner fa-spin"></i></div>
			<p class="error-msg"></p>
		</div>
		<?php submit_button(); ?>
	</form>
</div>
