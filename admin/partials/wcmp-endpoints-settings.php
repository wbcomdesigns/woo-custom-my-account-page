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
	<form method="post" action="options.php" id="wbwcmp_endpoints_settings">
		<?php
		settings_fields( 'wcmp_endpoints_settings' );
		do_settings_sections( 'wcmp_endpoints_settings' );
		?>
		<div class="section-title-container">
            <h2 class="title">
            	<?php esc_html_e( 'Manage Endpoints', 'woo-custom-my-account-page' ); ?>
            </h2>
            <div class="button-container">
                <button type="button" class="button add_new_field" data-target="group">
                	<?php esc_html_e( 'Add group', 'woo-custom-my-account-page' ); ?>
                </button>
                <button type="button" class="button add_new_field" data-target="endpoint">
                	<?php esc_html_e( 'Add endpoint', 'woo-custom-my-account-page' ); ?>
                </button>
                <button type="button" class="button add_new_field" data-target="link">
                	<?php esc_html_e( 'Add link', 'woo-custom-my-account-page' ); ?>
                </button>
            </div>
        </div>
		<?php
		global $wp_roles;
		$user_roles     = $wp_roles->roles;
		$myaccount_func = instantiate_woo_custom_myaccount_functions();
		$all_settings   = $myaccount_func->wcmp_settings_data();
		$endpoints      = $all_settings['endpoints_settings'];
		$endpoints_settings = get_option( 'wcmp_endpoints_settings' );
		echo '<pre>endpoints_settings: '; print_r( $endpoints ); echo '</pre>';
		?>
        <div class="dd endpoints-container">
            <ol class="dd-list endpoints">
		        <?php	
		        foreach ( $endpoints as $key => $endpoint ) {
		        ?>
		        <li class="dd-item endpoint" data-id="<?php echo esc_attr( $key ); ?>" data-type="endpoint">
		        	<label class="on-off-endpoint" for="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_active' ); ?>">
				        <input type="checkbox" class="hide-show-check" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $key ); ?>][active]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_active' ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $endpoint['active'], esc_attr( $key ) ); ?>>
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
				            <?php echo esc_html( $endpoint['label'] ); ?>
				            <span class="sub-item-label">
				            	<i>
				            		<?php
				            		esc_html_e( 'sub item', 'woo-custom-my-account-page' );
				            		?>
				             	</i>
				            </span>
				        </div>

				        <!-- Content -->
				        <div class="endpoint-options" style="display: none;">

				            <div class="options-row">
				                <span class="hide-show-trigger">
				                	<?php
				                	esc_html_e( 'Hide', 'woo-custom-my-account-page' );
				                	?> 
				                </span>
				            </div>

				            <table class="options-table form-table">
				            	<tbody>
				            		<?php
				            		if ( 'dashboard' !== $key ) { 
				            		?>
					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_slug' ); ?>">
					                        	<?php
					                        	esc_html_e( 'Endpoint slug', 'woo-custom-my-account-page' );
					                        	?>
					                        </label>					                        
					                    </th>
					                    <td>
					                        <input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $key ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_slug' ); ?>" value="<?php echo esc_attr( $endpoint['slug'] ); ?>">
						                    <p class="description">
					                        	<?php
					                        	esc_html_e( 'Text appended to your page URLs to manage new contents in account pages. It must be unique for every page.', 'woo-custom-my-account-page' );
					                        	?>
					                        </p>
					                    </td>
					                </tr>
					                <?php
					            	}
					            	?>
					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_label' ); ?>">
					                        	<?php
					                        	esc_html_e( 'Endpoint label', 'woo-custom-my-account-page' );
					                        	?>
					                        </label>				                        
					                    </th>
					                    <td>
					                        <input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $key ); ?>][label]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_label' ); ?>" value="<?php echo esc_attr( $endpoint['label'] ); ?>">					                      
						                    <p class="description">
					                        	<?php
					                        	esc_html_e( 'Menu item for this endpoint in "My Account".', 'woo-custom-my-account-page' );
					                        	?>
					                        </p>
					                    </td>
					                </tr>

					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_icon' ); ?>"><?php esc_html_e( 'Endpoint icon', 'woo-custom-my-account-page' ); ?></label>
					                    </th>
					                    <td>
					                    	<input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $key ); ?>][icon]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_icon' ); ?>" value="<?php echo esc_attr( $endpoint['icon'] ); ?>">
						                    <p class="description">
					                        	<?php
					                        	esc_html_e( 'Endpoint icon for "My Account" menu option.', 'woo-custom-my-account-page' );
					                        	?>
					                        </p>
					                    </td>
					                </tr>

					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_class' ); ?>"><?php esc_html_e( 'Endpoint class', 'woo-custom-my-account-page' ); ?></label>
					                    </th>
					                    <td>
					                        <input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $key ); ?>][class]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_class' ); ?>" value="<?php echo esc_attr( $endpoint['class'] ); ?>">
					                        <p class="description">
					                        	<?php
					                        	esc_html_e( 'Add additional classes to endpoint container.', 'woo-custom-my-account-page' );
					                        	?>
					                        </p>
					                    </td>
					                </tr>

					                <tr>
					                    <th>
					                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_usr_roles' ); ?>"><?php esc_html_e( 'User roles', 'woo-custom-my-account-page' ); ?></label>
					                    </th>
					                    <td>
					                        <select name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $key ); ?>][usr_roles][]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key . '_usr_roles' ); ?>" multiple="" tabindex="-1" aria-hidden="true">
                                               <?php
                                               	if ( $user_roles ) {
	                                                foreach ( $user_roles as $usrrole_slug => $usrrole_arr ) { 
	                                                	if ( ! empty( $endpoint['usr_roles'] ) ) {
															if ( in_array( $usrrole_slug, $endpoint['usr_roles'] ) ) {
															?>	
																<option value="<?php echo esc_attr( $usrrole_slug ); ?>" selected = "selected">
																	<?php echo esc_html( $usrrole_arr['name'] ); ?>				
																</option>
															<?php } else { ?>
																<option value="<?php echo esc_attr( $usrrole_slug ); ?>">
																	<?php echo esc_html( $usrrole_arr['name'] ); ?>
																</option>
	                                                	<?php } } else { ?>
	                                                	<option value="<?php echo esc_attr( $usrrole_slug ); ?>"><?php echo esc_html( $usrrole_arr['name'] ); ?></option>
	                                                <?php }
	                                            	}
	                                            }    
                                               ?>
	                                        </select>
	                                        <p class="description">
					                        	<?php
					                        	esc_html_e( 'Restrict endpoint visibility to the following user role(s).', 'woo-custom-my-account-page' );
					                        	?>
					                        </p>
					                    </td>
					                </tr>
					                <input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $key ); ?>][type]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $key  . '_type' ); ?>" value="<?php echo esc_attr( $endpoint['type'] ); ?>">
					            </tbody>
					        </table>
				        </div>
				    </div>
		        </li>	
		        <?php
		    		}
		        ?>
		         <input type="hidden" class="endpoints-order" name="wcmp_endpoints_settings[endpoints-order]" id="<?php echo esc_attr( 'wcmp_endpoint_endpoints-order' ); ?>" value="">
		    </ol>    
        </div>
        <div class="new-field-form" style="display: none;">
            <label for="yith-wcmap-new-field"><?php esc_html_x( 'Name', 'Label for new endpoint title',
                    'yith-woocommerce-customize-myaccount-page' ); ?>
                <input type="text" id="yith-wcmap-new-field" name="yith-wcmap-new-field" value="">
            </label>
            <div class="loader"></div>
            <p class="error-msg"></p>
        </div>
		<?php submit_button(); ?>
	</form>
</div>