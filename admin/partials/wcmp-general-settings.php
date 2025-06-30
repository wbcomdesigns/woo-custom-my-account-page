<?php
/**
 * This file is used for rendering and saving plugin general settings.
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
			<h3><?php esc_html_e( 'General Settings', 'woo-custom-my-account-page' ); ?></h3>
		</div><!-- .wbcom-welcome-head -->
		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
			<form method="post" action="options.php">
				<?php
				settings_fields( 'wcmp_general_settings' );
				do_settings_sections( 'wcmp_general_settings' );
				$woocommerce_menus = wc_get_account_menu_items();
				$myaccount_func    = instantiate_woo_custom_myaccount_functions();
				$all_settings      = $myaccount_func->wcmp_settings_data();
				$settings          = $all_settings['general_settings'];
				$endpoints 		   = isset( $all_settings['endpoints_settings'] ) ? $all_settings['endpoints_settings'] : array();
				$hidden_cls        = '';
				if ( 'tab' === $settings['menu_style'] ) {
					$hidden_cls = 'wcmp_option_hide';
				}
				?>
				<div class="form-table wcmp_general_settings">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Custom Avatar', 'woo-custom-my-account-page' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Let users upload a custom avatar as their profile picture.', 'woo-custom-my-account-page' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<label class="wb-switch">
								<input type="checkbox" name="wcmp_general_settings[custom_avatar]" <?php checked( esc_attr( $settings['custom_avatar'] ), 'yes' ); ?> value="yes">
								<div class="wb-slider wb-round"></div>
							</label>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Menu style', 'woo-custom-my-account-page' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Choose the style for the "My Account" page.', 'woo-custom-my-account-page' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<fieldset>
								<label>
									<input class="wcmp_menu_style" type="radio" name="wcmp_general_settings[menu_style]" value="sidebar" <?php checked( esc_attr( $settings['menu_style'] ), 'sidebar' ); ?>>
									<span>
										<?php esc_html_e( 'Sidebar', 'woo-custom-my-account-page' ); ?>
									</span>
								</label>
								<br>
								<label>
									<input class="wcmp_menu_style" type="radio" name="wcmp_general_settings[menu_style]" value="tab" <?php checked( esc_attr( $settings['menu_style'] ), 'tab' ); ?>>
									<span>
										<?php esc_html_e( 'Tab', 'woo-custom-my-account-page' ); ?>
									</span>
								</label>
							</fieldset>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap wcmp_sidebar_position_wrapper <?php echo esc_attr( $hidden_cls ); ?>">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Sidebar position', 'woo-custom-my-account-page' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Choose the position of the menu in "My Account" page (only for sidebar style).', 'woo-custom-my-account-page' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<select name="wcmp_general_settings[sidebar_position]" class="wcmp_select_field">
								<option value="left" <?php selected( esc_attr( $settings['sidebar_position'] ), 'left' ); ?>><?php esc_html_e( 'Left', 'woo-custom-my-account-page' ); ?></option>
								<option value="right" <?php selected( esc_attr( $settings['sidebar_position'] ), 'right' ); ?>><?php esc_html_e( 'Right', 'woo-custom-my-account-page' ); ?></option>
							</select>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Default endpoint', 'woo-custom-my-account-page' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Choose the default endpoint for "My account" page.', 'woo-custom-my-account-page' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<select name="wcmp_general_settings[default_endpoint]" class="wcmp_select_field">
								<?php
								if ( !empty($endpoints) ) {
									foreach ( $endpoints as $slug => $menu_name ) {
										?>
										<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( esc_attr( $settings['default_endpoint'] ), esc_attr( $slug ) ); ?>><?php echo esc_html( $menu_name['label'] ); ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>
</div>
