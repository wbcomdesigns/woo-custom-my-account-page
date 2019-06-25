<?php
/**
 * MY ACCOUNT ENDPOINT FIELDS
 */
?>

<li class="dd-item endpoint" data-id="<?php echo $options['slug'] ?>" data-type="endpoint">

    <label class="on-off-endpoint" for="<?php echo $id . '_' . $endpoint ?>_active">
        <input type="checkbox" class="hide-show-check" name="<?php echo $id . '_' . $endpoint ?>[active]" id="<?php echo $id . '_' . $endpoint ?>_active" value="<?php echo $endpoint ?>" <?php checked( $options['active'] ) ?>/>
        <i class="fa fa-power-off"></i>
    </label>

    <div class="open-options field-type">
        <span><?php _e( 'Endpoint', 'yith-woocommerce-customize-myaccount-page' ) ?></span>
        <i class="fa fa-chevron-down"></i>
    </div>

    <div class="dd-handle endpoint-content">

        <!-- Header -->
        <div class="endpoint-header">
            <?php echo $options['label'] ?>
            <span class="sub-item-label"><i><?php _e( 'sub item', 'yith-woocommerce-customize-myaccount-page' ); ?></i></span>
        </div>

        <!-- Content -->
        <div class="endpoint-options" style="display: none;">

            <div class="options-row">
                <span class="hide-show-trigger"><?php echo $options['active'] ? __( 'Hide', 'yith-woocommerce-customize-myaccount-page') : __( 'Show', 'yith-woocommerce-customize-myaccount-page' ); ?></span>
                <?php if( ! yith_wcmap_is_plugin_item( $endpoint ) && ! yith_wcmap_is_default_item( $endpoint ) ) : ?>
                    <span class="sep">|</span>
                    <span class="remove-trigger" data-endpoint="<?php echo $endpoint ?>"><?php _e( 'Remove', 'yith-woocommerce-customize-myaccount-page'); ?></span>
                <?php endif; ?>
            </div>

            <table class="options-table form-table">
            <tbody>

                <?php if( $endpoint != 'dashboard' ) : ?>
                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_slug"><?php echo __( 'Endpoint slug', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'Text appended to your page URLs to manage new contents in account pages. It must be unique for every page.', 'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                    </th>
                    <td>
                        <input type="text" name="<?php echo $id . '_' . $endpoint ?>[slug]" id="<?php echo $id . '_' . $endpoint ?>_slug" value="<?php echo $options['slug'] ?>">
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_label"><?php echo __( 'Endpoint label', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'Menu item for this endpoint in "My Account".',
                            'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                    </th>
                    <td>
                        <input type="text" name="<?php echo $id . '_' . $endpoint ?>[label]" id="<?php echo $id . '_' . $endpoint ?>_label" value="<?php echo $options['label'] ?>">
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_icon"><?php echo __( 'Endpoint icon', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'Endpoint icon for "My Account" menu option', 'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                    </th>
                    <td>
                        <select name="<?php echo $id . '_' . $endpoint ?>[icon]" id="<?php echo $id . '_' . $endpoint ?>_icon" class="icon-select">
                            <option value=""><?php _e( 'No icon', 'yith-woocommerce-customize-myaccount-page' ) ?></option>
                            <?php foreach( $icon_list as $icon => $label ) : ?>
                                <option value="<?php echo $label ?>" <?php selected( $options['icon'], $label ); ?>><?php echo $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_class"><?php echo __( 'Endpoint class', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'Add additional classes to endpoint container.', 'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                    </th>
                    <td>
                        <input type="text" name="<?php echo $id . '_' . $endpoint ?>[class]" id="<?php echo $id . '_' . $endpoint ?>_class" value="<?php echo $options['class'] ?>">
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_usr_roles"><?php echo __( 'User roles',
                                'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'Restrict endpoint visibility to the following user role(s).',
                            'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                    </th>
                    <td>
                        <select name="<?php echo $id . '_' . $endpoint ?>[usr_roles][]" id="<?php echo $id . '_' . $endpoint ?>_usr_roles" multiple="multiple">
                            <?php foreach( $usr_roles as $role => $role_name ) :
                                ! isset( $options['usr_roles'] ) && $options['usr_roles'] = array();
                                ?>
                                <option value="<?php echo $role ?>" <?php selected( in_array( $role, (array) $options['usr_roles'] ), true ); ?>><?php echo $role_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>

    </div>
</li>


<!--- new data --->

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