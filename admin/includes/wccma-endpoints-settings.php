<?php
$my_account_menu_items = wc_get_account_menu_items();
unset( $my_account_menu_items['customer-logout'] );

//Get Font awesome icons classes
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"\\\\(.+)";\s+}/';
$subject =  file_get_contents( WCCMA_PLUGIN_PATH.'admin/css/font-awesome.css' );
preg_match_all( $pattern, $subject, $matches, PREG_SET_ORDER );
$font_awesome_icons = array();
foreach( $matches as $match ) {
	$font_awesome_icons[$match[1]] = $match[2];
}
ksort($font_awesome_icons);

$wp_user_roles = get_editable_roles();
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
								<input type="text" class="regular-text" placeholder="<?php _e( 'Label', WCCMA_TEXT_DOMAIN );?>">
								<p class="description"><?php _e( 'This is the label that the user will see on <strong>My Account</strong> page.', WCCMA_TEXT_DOMAIN );?></p>
							</td>
						</tr>
						<!-- ENDPOINT ICON -->
						<tr>
							<th><?php _e( 'Endpoint Icon', WCCMA_TEXT_DOMAIN );?></th>
							<td>
								<select class="wccma-font-awesome-icons">
									<?php if( !empty( $font_awesome_icons ) ) {?>
										<?php foreach( $font_awesome_icons as $fa_icon => $fa_icon_unicode ) {?>
											<option value="<?php echo $fa_icon;?>"><?php echo str_replace( '-', ' ', str_replace( 'fa-', '', $fa_icon ) );?></option>
										<?php }?>
									<?php }?>
								</select>
								<p class="description"><?php _e( 'This is the label that the denote the above mentioned label.', WCCMA_TEXT_DOMAIN );?></p>
							</td>
						</tr>
						<!-- USER ROLES -->
						<tr>
							<th><?php _e( 'User Roles', WCCMA_TEXT_DOMAIN );?></th>
							<td>
								<select class="wccma-user-roles">
									<?php foreach( $wp_user_roles as $role_slug => $role ) {?>
										<option value="<?php echo $role_slug;?>"><?php echo $role['name'];?></option>
									<?php }?>
								</select>
								<p class="description"><?php _e( 'Select the user roles for which you want to hide this menu.', WCCMA_TEXT_DOMAIN );?></p>
							</td>
						</tr>
						<!-- ENDPOINT CONTENT -->
						<tr>
							<th><?php _e( 'Endpoint Content', WCCMA_TEXT_DOMAIN );?></th>
							<td>
								<?php wp_editor( $content = '', $menu_slug.'-tab-content' );?>
								<p class="description"><?php _e( 'This is the label that the user will see on <strong>My Account</strong> page.', WCCMA_TEXT_DOMAIN );?></p>
							</td>
						</tr>
					</table>
				</div>
			<?php }?>
		<?php }?>
	</div>
</div>