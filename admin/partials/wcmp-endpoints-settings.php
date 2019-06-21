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
		settings_fields( 'wcmp_endpoints_settings' );
		do_settings_sections( 'wcmp_endpoints_settings' );
		?>
		<div class="section-title-container">
            <h2 class="title">
            	<?php esc_html_e( 'Manage Endpoints', 'yith-woocommerce-customize-myaccount-page' ); ?>
            </h2>
            <div class="button-container">
                <button type="button" class="button add_new_field" data-target="group"><?php esc_html_e( 'Add group', 'yith-woocommerce-customize-myaccount-page' ); ?></button>
                <button type="button" class="button add_new_field" data-target="endpoint"><?php esc_html_e( 'Add endpoint', 'yith-woocommerce-customize-myaccount-page' ); ?></button>
                <button type="button" class="button add_new_field" data-target="link"><?php esc_html_e( 'Add link', 'yith-woocommerce-customize-myaccount-page' ); ?></button>
            </div>
        </div>
        <div class="dd endpoints-container">
            <ol class="dd-list endpoints">
                <!-- Endpoints -->
                <?php
                $endpoints = wc_get_account_menu_items();
                foreach ( $endpoints as $key => $endpoint ) {

                    // build args array
                    $args = array(
                        'endpoint'      => $key,
                        'options'       => $endpoint,
                        'id'            => $option['id'],
                        'icon_list'     => $icon_list,
                        'usr_roles'     => $usr_roles,
                        'value'         => isset( $value[ $key ] ) ? $value[ $key ] : array()
                    );

                    // get type
                    $type = isset( $value[ $key ] ) ? $value[ $key ]['type'] : 'endpoint';
                    call_user_func( "yith_wcmap_admin_print_{$type}_field", $args );
                } ?>
            </ol>
        </div>
		<?php submit_button(); ?>
	</form>
</div>