<?php 
//Upload the avatar
$curr_uid = get_current_user_id();
if( isset( $_POST['wccma-submit-user-avatar'] ) && wp_verify_nonce( $_POST['wccma-update-avatar-nonce'], 'wccma-update-avatar' ) ) {
	$target_file = WCCMA_UPLOADS_PATH . '/' . basename( $_FILES['wccma-user-avatar']['name'] );
	if ( move_uploaded_file( $_FILES['wccma-user-avatar']['tmp_name'], $target_file ) ) {
		$avatar_url = WCCMA_UPLOADS_URL . '/' . basename( $_FILES['wccma-user-avatar']['name'] );
		update_user_meta( $curr_uid, 'wccma_user_avatar', $avatar_url );
	}
}
?>
<div id="wccma-user-avatar-modal" class="modal-box">
	<header>
		<a href="javascript:void(0);" class="js-modal-close close">×</a>
		<h3><?php _e( 'Update Your Avatar', WCCMA_TEXT_DOMAIN );?></h3>
	</header>
	<div class="modal-body">
		<div class="wccma-update-avatar-box">
			<div class="wccma-update-avatar-error"><p></p></div>
			<form method="POST" action="" enctype="multipart/form-data">
				<input type="file" name="wccma-user-avatar" id="wccma-user-avatar" required>
				<?php wp_nonce_field('wccma-update-avatar','wccma-update-avatar-nonce');?>
				<input type="submit" name="wccma-submit-user-avatar" value="<?php _e( 'Update', WCCMA_TEXT_DOMAIN );?>">
			</form>
		</div>
	</div>
	<footer>
		<a href="javascript:void(0);" class="btn btn-small js-modal-close"><?php _e( 'Close', WCCMA_TEXT_DOMAIN );?></a>
	</footer>
</div>