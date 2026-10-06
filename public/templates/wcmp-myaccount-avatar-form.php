<?php
/**
 * MY ACCOUNT TEMPLATE AVATAR FORM.
 *
 * Override by copying to {your-theme}/woocommerce/.
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wcmp_user_id    = get_current_user_id();
$wcmp_has_custom = (bool) get_user_meta( $wcmp_user_id, 'wb-wcmp-avatar', true );
$wcmp_max_bytes  = Woo_Custom_My_Account_Page_Public::AVATAR_MAX_BYTES;
$wcmp_types      = Woo_Custom_My_Account_Page_Public::AVATAR_TYPES;
?>
<div id="wcmp-avatar-form" role="dialog" aria-modal="true" aria-labelledby="wcmp-avatar-title">
	<div class="wcmp-popup-title">
		<h2 id="wcmp-avatar-title"><?php esc_html_e( 'Upload your avatar', 'woo-custom-my-account-page' ); ?></h2>
		<button type="button" class="close-form"><i class="fa fa-times" aria-hidden="true"></i><span class="screen-reader-text"><?php esc_html_e( 'Close', 'woo-custom-my-account-page' ); ?></span></button>
	</div>
	<div class="wcmp-popup-content">
		<form id="wcmp-avatar-upload" class="wcmp-avatar-upload" enctype="multipart/form-data" method="post"
			data-max-bytes="<?php echo esc_attr( (string) $wcmp_max_bytes ); ?>"
			data-types="<?php echo esc_attr( implode( ',', $wcmp_types ) ); ?>"
			data-size-error="<?php esc_attr_e( 'Image size must be less than 2MB.', 'woo-custom-my-account-page' ); ?>"
			data-type-error="<?php esc_attr_e( 'Invalid file type. Only JPG, PNG, GIF and WebP images are allowed.', 'woo-custom-my-account-page' ); ?>">

			<div class="wcmp-avatar-picker">
				<div class="wcmp-avatar-current">
					<?php echo get_avatar( $wcmp_user_id, 96 ); ?>
					<img class="wcmp-avatar-new" alt="" hidden>
				</div>

				<div class="wcmp-file-drop">
					<input type="file" name="wcmp_user_avatar" id="wcmp_user_avatar" class="wcmp-file-input" accept="<?php echo esc_attr( implode( ',', $wcmp_types ) ); ?>" aria-describedby="wcmp-avatar-hint wcmp-avatar-error">
					<i class="fa fa-camera" aria-hidden="true"></i>
					<label for="wcmp_user_avatar" class="wcmp-file-drop__title"><?php esc_html_e( 'Choose an image or drag it here', 'woo-custom-my-account-page' ); ?></label>
					<span class="wcmp-file-drop__hint" id="wcmp-avatar-hint"><?php esc_html_e( 'JPG, PNG, GIF or WebP, up to 2MB.', 'woo-custom-my-account-page' ); ?></span>
					<span class="wcmp-file-drop__name" aria-live="polite"></span>
				</div>
			</div>

			<p class="wcmp-field-error" id="wcmp-avatar-error" role="alert" hidden></p>

			<input type="hidden" name="action" value="wp_handle_upload">
			<input type="hidden" name="_nonce" value="<?php echo esc_attr( wp_create_nonce( 'wp_handle_upload' ) ); ?>">
		</form>

		<?php if ( $wcmp_has_custom ) : ?>
			<form id="wcmp-avatar-reset" method="post">
				<?php wp_nonce_field( 'wcmp_reset_avatar', 'reset_image' ); ?>
				<input type="hidden" name="action" value="wcmp_reset_avatar">
			</form>
		<?php endif; ?>

		<div class="wcmp-popup-actions">
			<?php if ( $wcmp_has_custom ) : ?>
				<button type="submit" form="wcmp-avatar-reset" class="wcmp-btn wcmp-btn--ghost"><?php esc_html_e( 'Reset to default', 'woo-custom-my-account-page' ); ?></button>
			<?php endif; ?>
			<button type="submit" form="wcmp-avatar-upload" class="wcmp-btn wcmp-btn--primary" disabled><?php esc_html_e( 'Upload', 'woo-custom-my-account-page' ); ?></button>
		</div>
	</div>
</div>
