<?php
/**
 * MY ACCOUNT TEMPLATE AVATAR FORM.
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

?>
<div id="wcmp-avatar-form" data-width="400" data-height="280">
	<h3><?php esc_html_e( 'Upload your avatar', 'woo-custom-my-account-page' ); ?></h3>
	<i class="fa fa-times close-form"></i>
	<form enctype="multipart/form-data" method="post">
		<p>
			<input type="file" name="wcmp_user_avatar" id="wcmp_user_avatar" accept="image/*">
		</p>
		<p class="submit">
			<input type="submit" class="button" value="<?php esc_html_e( 'Upload', 'woo-custom-my-account-page' ); ?>">
		</p>
		<input type="hidden" name="action" value="wp_handle_upload">
		<input type="hidden" name="_nonce" value="<?php echo esc_attr( wp_create_nonce( 'wp_handle_upload' ) ); ?>">
	</form>
	<form enctype="multipart/form-data" method="post">
		<p class="submit" style="margin-top: 15px;">
			<input type="submit" class="button" value="<?php esc_html_e( 'Reset to default', 'woo-custom-my-account-page' ); ?>">
			<?php wp_nonce_field( 'action', 'reset_image' ); ?>
		</p>
		<input type="hidden" name="action" value="wcmp_reset_avatar">
	</form>
</div>
