<?php
global $woo_custom_my_account_page;
$endpoints = $woo_custom_my_account_page->endpoints;
$my_account_menu_items = wc_get_account_menu_items();
// echo '<pre>'; print_r( $woo_custom_my_account_page->endpoints ); die;
unset( $my_account_menu_items['customer-logout'] );
$my_account_menu_items_slugs = array();
foreach( $my_account_menu_items as $slug => $item ) {
	$my_account_menu_items_slugs[] = $slug;
}

$font_awesome_icons = $woo_custom_my_account_page->font_awesome_icons;
$wp_user_roles = get_editable_roles();
unset( $wp_user_roles['administrator'] );
?>
<form method="POST" action="">
	<div class="wccma-endpoints-settings-panel">
		<h3><?php _e( 'Endpoints Options', WCCMA_TEXT_DOMAIN );?></h3>
		<div class="wccma-endpoints-management">
			<span><?php _e( 'Manage Endpoints', WCCMA_TEXT_DOMAIN );?></span>
			<input type="hidden" id="wccma-last-endpoint" value="">
			<input type="button" class="button button-secondary" data-modal-id="wccma-add-endpoint-modal" id="wccma-add-endpoint" value="<?php _e( 'Add Endpoint', WCCMA_TEXT_DOMAIN );?>">
			<!-- <input disabled type="button" class="button button-secondary" data-modal-id="wccma-add-group-modal" id="wccma-add-group" value="<?php _e( 'Add Group', WCCMA_TEXT_DOMAIN );?>"> -->
		</div>
		<div class="wccma-all-endpoints">
			<?php if( !empty( $my_account_menu_items ) ) {?>
				<?php foreach( $my_account_menu_items as $menu_slug => $menu_item ) {?>
					<?php 

					?>
					<div class="wccma-my-account-menu-item wccma-endpoint" id="menu-<?php echo $menu_slug;?>" data-menu="<?php echo $menu_slug;?>">
						<span id="<?php echo $menu_slug;?>-power-icon"><i class="fa fa-power-off"></i></span>
						<label for=""><?php echo $menu_item;?></label>
						<span class="wccma-angles" id="span-menu-<?php echo $menu_slug;?>"><i class="fa fa-angle-down"></i></span>
					</div>
					<div class="wccma-menu-item-details" id="wccma-menu-item-detail-<?php echo $menu_slug;?>">
						<table class="form-table">
							<!-- ENDPOINT LABEL -->
							<tr>
								<th><?php _e( 'Endpoint Label', WCCMA_TEXT_DOMAIN );?></th>
								<td>
									<input type="text" class="wccma-text-input" name="<?php echo $menu_slug;?>-label" placeholder="<?php _e( 'Label', WCCMA_TEXT_DOMAIN );?>" value="<?php echo $menu_item;?>">
									<p class="description"><?php _e( 'This is the label that the user will see on My Account page.', WCCMA_TEXT_DOMAIN );?></p>
								</td>
							</tr>
							<!-- ENDPOINT ICON -->
							<tr>
								<th><?php _e( 'Endpoint Icon', WCCMA_TEXT_DOMAIN );?></th>
								<td>
									<select class="wccma-font-awesome-icons" name="<?php echo $menu_slug;?>-icon">
										<option value=""></option>
										<?php if( !empty( $font_awesome_icons ) ) {?>
											<?php foreach( $font_awesome_icons as $fa_icon => $fa_icon_unicode ) {?>
												<?php $selected_icon = ( $endpoints[ $menu_slug ]['icon'] != '' && $fa_icon_unicode == $endpoints[ $menu_slug ]['icon'] ) ? 'selected' : '';?>
												<option value="<?php echo $fa_icon_unicode;?>" <?php echo $selected_icon;?>><?php echo str_replace( '-', ' ', str_replace( 'fa-', '', $fa_icon ) );?></option>
											<?php }?>
										<?php }?>
									</select>
									<p class="description"><?php _e( 'This is the icon that the denote the above mentioned label.', WCCMA_TEXT_DOMAIN );?></p>
								</td>
							</tr>
							<!-- USER ROLES -->
							<tr>
								<th><?php _e( 'User Roles', WCCMA_TEXT_DOMAIN );?></th>
								<td>
									<select class="wccma-user-roles" multiple name="<?php echo $menu_slug;?>-user-roles[]">
										<?php foreach( $wp_user_roles as $role_slug => $role ) {?>
											<?php $selected_user_roles = ( !empty( $endpoints[ $menu_slug ]['user_roles'] ) && in_array( $role_slug, $endpoints[ $menu_slug ]['user_roles'] ) ) ? 'selected' : '';?>
											<option value="<?php echo $role_slug;?>" <?php echo $selected_user_roles;?>><?php echo $role['name'];?></option>
										<?php }?>
									</select>
									<p class="description"><?php _e( 'Select the user roles for which you want to hide this menu.', WCCMA_TEXT_DOMAIN );?></p>
								</td>
							</tr>
							<!-- ENDPOINT CONTENT -->
							<tr>
								<th><?php _e( 'Endpoint Content', WCCMA_TEXT_DOMAIN );?></th>
								<td>
									<?php wp_editor( $endpoints[ $menu_slug ]['content'], $menu_slug.'-tab-content' );?>
									<p class="description"><?php _e( 'This will hold the tab content.', WCCMA_TEXT_DOMAIN );?></p>
								</td>
							</tr>
						</table>
					</div>
				<?php }?>
			<?php }?>
		</div>
	</div>
	<p class="submit">
		<?php wp_nonce_field( 'wccma-endpoints', 'wccma-manage-endpoints-nonce' );?>
		<input type="hidden" id="wccma-woo-endpoints" name="wccma-woo-endpoints" value='<?php echo serialize( $my_account_menu_items_slugs );?>'>
		<input type="submit" class="wccma-save-endpoints button button-primary" name="wccma-save-endpoints" value="<?php _e( 'Save Changes', WCCMA_TEXT_DOMAIN );?>">
	</p>
</form>