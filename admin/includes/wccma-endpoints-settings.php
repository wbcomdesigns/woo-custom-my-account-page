<?php
global $woo_custom_my_account_page;
$endpoints					 = $woo_custom_my_account_page->endpoints;
$my_account_menu_items		 = wc_get_account_menu_items();
// echo '<pre>'; print_r( $woo_custom_my_account_page->endpoints ); die;
unset( $my_account_menu_items[ 'customer-logout' ] );
$my_account_menu_items_slugs = array();
foreach ( $my_account_menu_items as $slug => $item ) {
	$my_account_menu_items_slugs[] = $slug;
}

$font_awesome_icons	 = $woo_custom_my_account_page->font_awesome_icons;
$wp_user_roles		 = get_editable_roles();
unset( $wp_user_roles[ 'administrator' ] );
?>
<form method="POST" action="">
	<div class="wccma-endpoints-settings-panel">
		<h3><?php _e( 'Endpoints Options', WCCMA_TEXT_DOMAIN ); ?></h3>
		<div class="wccma-endpoints-management">
			<span><?php _e( 'Manage Endpoints', WCCMA_TEXT_DOMAIN ); ?></span>
			<input type="hidden" id="wccma-last-endpoint" value="">
			<input type="button" class="button button-secondary" data-modal-id="wccma-add-endpoint-modal" id="wccma-add-endpoint" value="<?php _e( 'Add Endpoint', WCCMA_TEXT_DOMAIN ); ?>">
			<!-- <input disabled type="button" class="button button-secondary" data-modal-id="wccma-add-group-modal" id="wccma-add-group" value="<?php _e( 'Add Group', WCCMA_TEXT_DOMAIN ); ?>"> -->
		</div>
		<div class="wccma-all-endpoints">
			<?php if ( !empty( $my_account_menu_items ) ) { ?>
				<?php
				foreach ( $my_account_menu_items as $menu_slug => $menu_item ) {
					include WCCMA_PLUGIN_PATH . 'admin/includes/wccma-endpoint-settings-data.php';
				}
				?>
			<?php } ?>
		</div>
	</div>
	<p class="submit">
		<?php wp_nonce_field( 'wccma-endpoints', 'wccma-manage-endpoints-nonce' ); ?>
		<input type="hidden" id="wccma-woo-endpoints" name="wccma-woo-endpoints" value='<?php echo serialize( $my_account_menu_items_slugs ); ?>'>
		<input type="submit" class="wccma-save-endpoints button button-primary" name="wccma-save-endpoints" value="<?php _e( 'Save Changes', WCCMA_TEXT_DOMAIN ); ?>">
	</p>
</form>