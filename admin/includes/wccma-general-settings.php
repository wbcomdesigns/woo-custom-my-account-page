<?php
if ( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly
global $woo_custom_my_account_page;
// echo '<pre>'; print_r($woo_custom_my_account_page); die;

$my_account_menu_items = wc_get_account_menu_items();
unset( $my_account_menu_items[ 'customer-logout' ] );
?>
<form action="" method="POST">
	<table class="form-table">
		<tbody>
			<!-- ALLOW USER TO UPLOAD CUSTOM AVATAR -->
			<tr>
				<th scope="row"><label for="wccma-allow-custom-avatar"><?php _e( 'Custom User Avatar', WCCMA_TEXT_DOMAIN ); ?></label></th>
				<td>
					<input type="checkbox" name="wccma-custom-avatar" <?php echo ( $woo_custom_my_account_page->allow_custom_user_avatar == 'yes' ) ? 'checked' : 'unchecked'; ?> id="wccma-custom-avatar">
					<label for="wccma-custom-avatar"><?php _e( 'Allow users to upload their avatars.', WCCMA_TEXT_DOMAIN ); ?></label>
					<p class="description"><?php _e( 'This settings will allow the users to change their avatar from their <strong>my-account</strong> page.', WCCMA_TEXT_DOMAIN ); ?></p>
				</td>
			</tr>
			<!-- Menu Style TAB -->
			<tr>
				<th scope="row"><label for="wccma-menu-style-tab"><?php _e( 'Menu Style', WCCMA_TEXT_DOMAIN ); ?></label></th>
				<td>
					<select class="wccma-menu-style-tab" required name="wccma-menu-style-tab">
						<option value="sidebar" <?php selected( $woo_custom_my_account_page->menu_style, 'sidebar' ); ?>><?php _e( 'Sidebar', WCCMA_TEXT_DOMAIN ); ?></option>
						<option value="tab" <?php selected( $woo_custom_my_account_page->menu_style, 'tab' ); ?>><?php _e( 'Tab', WCCMA_TEXT_DOMAIN ); ?></option>
					</select>
					<p class="description"><?php _e( 'Admin can choose menu style to tab or left sidebar on <strong>my-account</strong> page. (Default: Sidebar)', WCCMA_TEXT_DOMAIN ); ?></p>
				</td>
			</tr>
			<!-- SET DEFAULT ACTIVE TAB -->
			<tr>
				<th scope="row"><label for="wccma-default-active-tab"><?php _e( 'Default Tab', WCCMA_TEXT_DOMAIN ); ?></label></th>
				<td>
					<select class="wccma-default-tab" required name="wccma-default-tab">
						<option value=""><?php _e( '--Select--', WCCMA_TEXT_DOMAIN ); ?></option>
						<?php foreach ( $my_account_menu_items as $slug => $item ) { ?>
							<option value="<?php echo $slug; ?>" <?php echo ($slug == $woo_custom_my_account_page->default_woo_tab) ? 'selected' : ''; ?>><?php echo $item; ?></option>
						<?php } ?>
					</select>
					<p class="description"><?php _e( 'Admin can select the default tab to be active when <strong>my-account</strong> page loads.', WCCMA_TEXT_DOMAIN ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<?php wp_nonce_field( 'wccma-general', 'wccma-general-settings-nonce' ); ?>
		<input type="submit" name="wccma-save-general-settings" class="button button-primary" value="<?php _e( 'Save Changes', WCCMA_TEXT_DOMAIN ); ?>">
	</p>
</form>
