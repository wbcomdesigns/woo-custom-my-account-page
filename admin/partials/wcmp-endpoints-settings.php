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
            	<?php esc_html_e( 'Manage Endpoints', 'woo-custom-my-account-page' ); ?>
            </h2>
            <div class="button-container">
                <button type="button" class="button add_new_field" data-target="group"><?php esc_html_e( 'Add group', 'woo-custom-my-account-page' ); ?></button>
                <button type="button" class="button add_new_field" data-target="endpoint"><?php esc_html_e( 'Add endpoint', 'woo-custom-my-account-page' ); ?></button>
                <button type="button" class="button add_new_field" data-target="link"><?php esc_html_e( 'Add link', 'woo-custom-my-account-page' ); ?></button>
            </div>
        </div>
		<?php
		global $wp_roles;
		$user_roles = $wp_roles->roles;
		$endpoints  = wc_get_account_menu_items();
		$endpoints_settings = get_option( 'wcmp_endpoints_settings' );
		?>
        <div class="dd endpoints-container">
            <ol class="dd-list endpoints">
		        <?php	
		        foreach ( $endpoints as $key => $endpoint ) {
		        ?>
		        <li class="dd-item endpoint" data-id="<?php echo esc_attr( $key ); ?>" data-type="endpoint">
		        	<label class="on-off-endpoint" for="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_active' ); ?>">
				        <input type="checkbox" class="hide-show-check" name="wcmp_endpoints_settings[<?php echo esc_attr( $key ); ?>][active]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_active' ); ?>" value="<?php echo esc_attr( $key ); ?>" checked="checked">
				        <i class="fa fa-power-off"></i>
				    </label>
				    <div class="open-options field-type">
				        <span>
				        	<?php 
				        	esc_html_e( 'Endpoint', 'woo-custom-my-account-page' );
				        	?>
				        </span>
				        <i class="fa fa-chevron-down"></i>
				    </div>
				    <div class="dd-handle endpoint-content">

				        <!-- Header -->
				        <div class="endpoint-header">
				            <?php echo esc_html( $endpoint ); ?>
				            <span class="sub-item-label"><i><?php esc_html_e( 'sub item', 'woo-custom-my-account-page' ); ?></i></span>
				        </div>

				        <!-- Content -->
				        <div class="endpoint-options" style="display: none;">

				            <div class="options-row">
				                <span class="hide-show-trigger">
				                	<?php esc_html_e( 'Hide', 'woo-custom-my-account-page' ); ?>			 
				                </span>
				            </div>

				            <table class="options-table form-table">
				            	<tbody>
					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_slug' ); ?>">
					                        	<?php esc_html_e( 'Endpoint slug', 'woo-custom-my-account-page' ); ?></label>
					                        <img class="help_tip" src="http://localhost/buddy2/wp-content/plugins/woocommerce/assets/images/help.png" width="16" height="16">
					                    </th>
					                    <td>
					                        <input type="text" name="wcmp_endpoints_settings[<?php echo esc_attr( $key ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_slug' ); ?>" value="orders">
					                    </td>
					                </tr>
					                
					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_label' ); ?>"><?php esc_html_e( 'Endpoint label', 'woo-custom-my-account-page' ); ?></label>
					                        <img class="help_tip" src="http://localhost/buddy2/wp-content/plugins/woocommerce/assets/images/help.png" width="16" height="16">
					                    </th>
					                    <td>
					                        <input type="text" name="wcmp_endpoints_settings[<?php echo esc_attr( $key ); ?>][label]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_label' ); ?>" value="My Orders">
					                    </td>
					                </tr>

					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_icon' ); ?>"><?php esc_html_e( 'Endpoint icon', 'woo-custom-my-account-page' ); ?></label>
					                        <img class="help_tip" src="http://localhost/buddy2/wp-content/plugins/woocommerce/assets/images/help.png" width="16" height="16">
					                    </th>
					                    <td>
					                        <select name="wcmp_endpoints_settings[<?php echo esc_attr( $key ); ?>][icon]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_icon' ); ?>" tabindex="-1" aria-hidden="true" class="wcmp_select_field">
					                            <option value="">No icon</option>
					                            <option value="glass">glass</option>
					                            <option value="music">music</option>
					                            <option value="search">search</option>
					                            <option value="envelope-o">envelope-o</option>
					                            <option value="heart">heart</option>        
					                        </select>
					                    </td>
					                </tr>

					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_class' ); ?>"><?php esc_html_e( 'Endpoint class', 'woo-custom-my-account-page' ); ?></label>
					                        <img class="help_tip" src="http://localhost/buddy2/wp-content/plugins/woocommerce/assets/images/help.png" width="16" height="16">
					                    </th>
					                    <td>
					                        <input type="text" name="wcmp_endpoints_settings[<?php echo esc_attr( $key ); ?>][class]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_class' ); ?>" value="">
					                    </td>
					                </tr>

					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_usr_roles' ); ?>"><?php esc_html_e( 'User roles', 'woo-custom-my-account-page' ); ?></label>
					                        <img class="help_tip" src="http://localhost/buddy2/wp-content/plugins/woocommerce/assets/images/help.png" width="16" height="16">
					                    </th>
					                    <td>
					                        <select name="wcmp_endpoints_settings[<?php echo esc_attr( $key ); ?>][usr_roles][]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_usr_roles' ); ?>" multiple="" tabindex="-1" aria-hidden="true">
                                               <?php
                                               	if ( $user_roles ) {
	                                                foreach ( $user_roles as $usrrole_slug => $usrrole_arr ) { ?>
	                                                	<option value="<?php echo esc_attr( $usrrole_slug ); ?>"><?php echo esc_html( $usrrole_arr['name'] ); ?></option>
	                                                <?php }
	                                            }    
                                               ?>
	                                        </select>
					                    </td>
					                </tr>
					            </tbody>
					        </table>
				        </div>

				    </div>
		        </li>	
		        <?php
		    		}
		        ?>
		    </ol>    
        </div>	
		<?php submit_button(); ?>
	</form>
</div>