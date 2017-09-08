<?php
/*
 * Exit if accessed directly
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
$default_endpoints = $woo_custom_my_account_page->default_endpoints;
?>
<div class = "wccma-my-account-menu-item wccma-endpoint" id = "menu-<?php echo $menu_slug; ?>" data-menu = "<?php echo $menu_slug; ?>">
	<span id = "<?php echo $menu_slug; ?>-power-icon"><i class = "fa fa-power-off"></i></span>
	<label for = "">
		<?php echo $menu_item; ?>
	</label>
	<span class="wccma-angles" id="span-menu-<?php echo $menu_slug; ?>"><i class="fa fa-angle-down"></i></span>
</div>
<div class="wccma-menu-item-details" id="wccma-menu-item-detail-<?php echo $menu_slug; ?>">
	<?php if ( !in_array( $menu_slug, $default_endpoints ) ): ?>
		<div class="wccma-remove-endpoints-parent"><a href="javascript:void(0)" data-remenu='<?php echo $menu_slug; ?>' onclick="wccma_remove_endpoints( this )" class="wccma-remove-endpoints"><?php _e( 'Remove', WCCMA_TEXT_DOMAIN ) ?></a></div>
	<?php endif; ?>
	<table class="form-table">
		<!-- ENDPOINT LABEL -->
		<tr>
			<th><?php _e( 'Endpoint Label', WCCMA_TEXT_DOMAIN ); ?></th>
			<td>
				<input type="text" class="wccma-text-input" name="<?php echo $menu_slug; ?>-label" placeholder="<?php _e( 'Label', WCCMA_TEXT_DOMAIN ); ?>" value="<?php echo $menu_item; ?>">
				<p class="description"><?php _e( 'This is the label that the user will see on My Account page.', WCCMA_TEXT_DOMAIN ); ?></p>
			</td>
		</tr>
		<!-- ENDPOINT ICON -->
		<tr>
			<th><?php _e( 'Endpoint Icon', WCCMA_TEXT_DOMAIN ); ?></th>
			<td>
				<select class="wccma-font-awesome-icons" name="<?php echo $menu_slug; ?>-icon">
					<option value=""></option>
					<?php if ( !empty( $font_awesome_icons ) ) { ?>
						<?php foreach ( $font_awesome_icons as $fa_icon => $fa_icon_unicode ) { ?>
							<?php $selected_icon = ( $endpoints[ $menu_slug ][ 'icon' ] != '' && $fa_icon_unicode == $endpoints[ $menu_slug ][ 'icon' ] ) ? 'selected' : ''; ?>
							<option value="<?php echo $fa_icon_unicode; ?>" <?php echo $selected_icon; ?>><?php echo str_replace( '-', ' ', str_replace( 'fa-', '', $fa_icon ) ); ?></option>
						<?php } ?>
					<?php } ?>
				</select>
				<p class="description"><?php _e( 'This is the icon that the denote the above mentioned label.', WCCMA_TEXT_DOMAIN ); ?></p>
			</td>
		</tr>
		<!-- USER ROLES -->
		<tr>
			<th><?php _e( 'User Roles', WCCMA_TEXT_DOMAIN ); ?></th>
			<td>
				<select class="wccma-user-roles" multiple name="<?php echo $menu_slug; ?>-user-roles[]">
					<?php foreach ( $wp_user_roles as $role_slug => $role ) { ?>
						<?php $selected_user_roles = (!empty( $endpoints[ $menu_slug ][ 'user_roles' ] ) && in_array( $role_slug, $endpoints[ $menu_slug ][ 'user_roles' ] ) ) ? 'selected' : ''; ?>
						<option value="<?php echo $role_slug; ?>" <?php echo $selected_user_roles; ?>><?php echo $role[ 'name' ]; ?></option>
					<?php } ?>
				</select>
				<p class="description"><?php _e( 'Select the user roles for which you want to hide this menu.', WCCMA_TEXT_DOMAIN ); ?></p>
			</td>
		</tr>
		<!-- ENDPOINT CONTENT -->
		<tr>
			<th><?php _e( 'Endpoint Content', WCCMA_TEXT_DOMAIN ); ?></th>
			<td>
				<?php wp_editor( $endpoints[ $menu_slug ][ 'content' ], $menu_slug . '-tab-content' ); ?>
				<p class="description"><?php _e( 'This will hold the tab content.', WCCMA_TEXT_DOMAIN ); ?></p>
			</td>
		</tr>
	</table>
</div>