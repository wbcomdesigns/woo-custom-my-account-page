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
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wcmp_general_settings' );
		do_settings_sections( 'wcmp_general_settings' );
		$woocommerce_menus = wc_get_account_menu_items();
		$myaccount_func    = instantiate_woo_custom_myaccount_functions();
		$all_settings      = $myaccount_func->wcmp_settings_data();
		$settings          = $all_settings['general_settings'];
		$hidden_cls        = '';
		if ( 'tab' === $settings['menu_style'] ) {
			$hidden_cls = 'wcmp_option_hide';
		}
		?>
		<table class="form-table wcmp_general_settings">
			<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Custom Avatar', 'woo-custom-my-account-page' ); ?>
						</label>
					</th>
					<td>
						<label class="wcmp-switch">
							<input type="checkbox" name="wcmp_general_settings[custom_avatar]" <?php checked( esc_attr( $settings['custom_avatar'] ), 'yes' ); ?> value="yes">
							<div class="wcmp-slider round"></div>
						</label>
						<p class="description"><?php esc_html_e( 'Let users upload a custom avatar as their profile picture.', 'woo-custom-my-account-page' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Menu style', 'woo-custom-my-account-page' ); ?>
						</label>
					</th>
					<td>
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
						<p class="description"><?php esc_html_e( 'Choose the style for the "My Account" page.', 'woo-custom-my-account-page' ); ?></p>
					</td>
				</tr>
				<tr class="wcmp_sidebar_position_wrapper <?php echo esc_attr( $hidden_cls ); ?>">
					<th scope="row">
						<label>
							<?php esc_html_e( 'Sidebar position', 'woo-custom-my-account-page' ); ?>
						</label>
					</th>
					<td>
						<select name="wcmp_general_settings[sidebar_position]" class="wcmp_select_field">
							<option value="left" <?php selected( esc_attr( $settings['sidebar_position'] ), 'left' ); ?>><?php esc_html_e( 'Left', 'woo-custom-my-account-page' ); ?></option>
							<option value="right" <?php selected( esc_attr( $settings['sidebar_position'] ), 'right' ); ?>><?php esc_html_e( 'Right', 'woo-custom-my-account-page' ); ?></option>
						</select>
						<p class="description"><?php esc_html_e( 'Choose the position of the menu in "My Account" page (only for sidebar style).', 'woo-custom-my-account-page' ); ?></p>
					</td>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Default endpoint', 'woo-custom-my-account-page' ); ?>
						</label>
					</th>
					<td>
						<select name="wcmp_general_settings[default_endpoint]" class="wcmp_select_field">
							<?php
							if ( $woocommerce_menus ) {
								foreach ( $woocommerce_menus as $slug => $menu_name ) {
									?>
									<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( esc_attr( $settings['default_endpoint'] ), esc_attr( $slug ) ); ?>><?php echo esc_html( $menu_name ); ?></option>
									<?php
								}
							}
							?>
						</select>
						<p class="description"><?php esc_html_e( 'Choose the default endpoint for "My account" page.', 'woo-custom-my-account-page' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
