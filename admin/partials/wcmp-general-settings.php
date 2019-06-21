<?php
/**
 *
 * This file is used for rendering and saving plugin general settings.
 *
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
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Custom Avatar', 'woo-custom-my-account-page' ); ?>
						</label>
					</th>
					<td>
						<label class="wcmp-switch">
							<input name="wcmp_general_settings[custom_avatar]" type="checkbox" <?php //checked( esc_attr( $bupr['multi_reviews'] ), 'yes' ); ?> value="yes">
							<div class="wcmp-slider wcmp-round"></div>
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
								<input type="radio" name="wcmp_general_settings[menu_style]" value="sidebar">
								<span>
									<?php esc_html_e( 'Sidebar', 'woo-custom-my-account-page' ); ?>
								</span>
							</label>
							<br>
							<label>
								<input type="radio" name="wcmp_general_settings[menu_style]" value="tab">
								<span>
									<?php esc_html_e( 'Tab', 'woo-custom-my-account-page' ); ?>
								</span>
							</label>
						</fieldset>
						<p class="description"><?php esc_html_e( 'Choose the style for the "My Account" page.', 'woo-custom-my-account-page' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Sidebar position', 'woo-custom-my-account-page' ); ?>
						</label>
					</th>
					<td>
						<select name="wcmp_general_settings[sidebar_position]">
							<option value="left"><?php esc_html_e( 'Left', 'woo-custom-my-account-page' ); ?></option>
							<option value="right"><?php esc_html_e( 'Right', 'woo-custom-my-account-page' ); ?></option>
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
						<select name="wcmp_general_settings[default_endpoint]">
							<?php
							if ( $woocommerce_menus ) {
								foreach ( $woocommerce_menus as $slug => $menu_name ) {
									?>
									<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $menu_name ); ?></option>
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