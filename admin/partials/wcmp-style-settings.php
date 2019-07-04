<?php
/**
 * This file is used for rendering and saving plugin style settings.
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
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wcmp_style_settings' );
		do_settings_sections( 'wcmp_style_settings' );
		$myaccount_func = instantiate_woo_custom_myaccount_functions();
		$all_settings   = $myaccount_func->wcmp_settings_data();
		$settings       = $all_settings['style_settings'];
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'Menu item color', 'woo-custom-my-account-page' ); ?></label>
					</th>
					<td>
						<input type="text" name="wcmp_style_settings[menu_item_color]" id="menu_item_color" class="wcmp-admin-color-picker" value="<?php echo esc_attr( $settings['menu_item_color'] ); ?>">
						<p class="description">
							<?php esc_html_e( 'Choose a color for menu items.', 'woo-custom-my-account-page' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'Menu item color on hover', 'woo-custom-my-account-page' ); ?></label>
					</th>
					<td>
						<input type="text" name="wcmp_style_settings[menu_item_hover_color]" id="menu_item_hover_color" class="wcmp-admin-color-picker" value="<?php echo esc_attr( $settings['menu_item_hover_color'] ); ?>">
						<p class="description">
							<?php esc_html_e( 'Choose colour of menu items on mouse hover.', 'woo-custom-my-account-page' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'Logout color', 'woo-custom-my-account-page' ); ?></label>
					</th>
					<td>
						<input type="text" name="wcmp_style_settings[logout_color]" id="logout_color" class="wcmp-admin-color-picker" value="<?php echo esc_attr( $settings['logout_color'] ); ?>">
						<p class="description">
							<?php esc_html_e( 'Choose the color of the Logout text.', 'woo-custom-my-account-page' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'Logout color on hover', 'woo-custom-my-account-page' ); ?></label>
					</th>
					<td>
						<input type="text" name="wcmp_style_settings[logout_hover_color]" id="logout_hover_color" class="wcmp-admin-color-picker" value="<?php echo esc_attr( $settings['logout_hover_color'] ); ?>">
						<p class="description">
							<?php esc_html_e( 'Choose the color of the Logout text on mouse hover.', 'woo-custom-my-account-page' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'Logout background color', 'woo-custom-my-account-page' ); ?></label>
					</th>
					<td>
						<input type="text" name="wcmp_style_settings[logout_background_color]" id="logout_background_color" class="wcmp-admin-color-picker" value="<?php echo esc_attr( $settings['logout_background_color'] ); ?>">
						<p class="description">
							<?php esc_html_e( 'Choose the color of the Logout background.', 'woo-custom-my-account-page' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'Logout background color on hover', 'woo-custom-my-account-page' ); ?></label>
					</th>
					<td>
						<input type="text" name="wcmp_style_settings[logout_background_hover_color]" id="wb_logout_background_hover_color" class="wcmp-admin-color-picker" value="<?php echo esc_attr( $settings['logout_background_hover_color'] ); ?>">
						<p class="description">
							<?php esc_html_e( 'Choose the color of the Logout background on mouse hover.', 'woo-custom-my-account-page' ); ?>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
