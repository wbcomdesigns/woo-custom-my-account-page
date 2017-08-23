<?php
$my_account_menu_items = wc_get_account_menu_items();
unset( $my_account_menu_items['customer-logout'] );
?>
<div class="wccma-endpoints-settings-panel">
	<h3><?php _e( 'Endpoints Options', WCCMA_TEXT_DOMAIN );?></h3>
	<div class="wccma-endpoints-management">
		<span><?php _e( 'Manage Endpoints', WCCMA_TEXT_DOMAIN );?></span>
		<input type="button" class="button button-secondary" data-modal-id="wccma-add-endpoint-modal" id="wccma-add-endpoint" value="<?php _e( 'Add Endpoint', WCCMA_TEXT_DOMAIN );?>">
		<!-- <input type="button" class="button button-secondary" data-modal-id="wccma-add-group-modal" id="wccma-add-group" value="<?php _e( 'Add Group', WCCMA_TEXT_DOMAIN );?>"> -->
	</div>
	<div class="wccma-all-endpoints">
		<?php if( !empty( $my_account_menu_items ) ) {?>
			<?php foreach( $my_account_menu_items as $menu_slug => $menu_item ) {?>
				<div class="wccma-my-account-menu-item wccma-endpoint" id="menu-<?php echo $menu_slug;?>" data-menu="<?php echo $menu_slug;?>">
					<span><i class="fa fa-power-off"></i></span>
					<label for=""><?php echo $menu_item;?></label>
					<span class="wccma-angles" id="span-menu-<?php echo $menu_slug;?>"><i class="fa fa-angle-down"></i></span>
				</div>
				<div class="wccma-menu-item-details" id="wccma-menu-item-detail-<?php echo $menu_slug;?>">
					<table>
						<!-- ENDPOINT LABEL -->
						<tr>
							<th><?php _e( 'Endpoint label' );?></th>
							<td>
								<input type="text" class="regular-text" placeholder="<?php _e( 'Label', WCCMA_TEXT_DOMAIN );?>">
							</td>
						</tr>
						<!-- ENDPOINT ICON -->
						<tr>
							<th><?php _e( 'Endpoint icon' );?></th>
							<td>
								<input type="text" class="regular-text" placeholder="<?php _e( 'Label', WCCMA_TEXT_DOMAIN );?>">
							</td>
						</tr>
					</table>
				</div>
			<?php }?>
		<?php }?>
	</div>
</div>