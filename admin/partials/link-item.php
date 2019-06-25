<?php
/**
 * MY ACCOUNT LINK FIELDS
 */
if ( ! defined( 'YITH_WCMAP' ) ) {
    exit;
} // Exit if accessed directly

?>

<li class="dd-item endpoint link" data-id="<?php echo $endpoint ?>" data-type="link">

    <label class="on-off-endpoint" for="<?php echo $id . '_' . $endpoint ?>_active">
        <input type="checkbox" class="hide-show-check" name="<?php echo $id . '_' . $endpoint ?>[active]" id="<?php echo $id . '_' . $endpoint ?>_active" value="<?php echo $endpoint ?>" <?php checked( $options['active'] ) ?>/>
        <i class="fa fa-power-off"></i>
    </label>

    <div class="open-options field-type">
        <span><?php _e( 'Link', 'yith-woocommerce-customize-myaccount-page' ) ?></span>
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
                <span class="sep">|</span>
                <span class="remove-trigger" data-endpoint="<?php echo $endpoint ?>"><?php _e( 'Remove', 'yith-woocommerce-customize-myaccount-page'); ?></span>
            </div>

            <table class="options-table form-table">
            <tbody>

                <?php if( $endpoint != 'dashboard' ) : ?>
                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_url"><?php echo __( 'Link url', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'The url of the menu item.', 'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                    </th>
                    <td>
                        <input type="text" name="<?php echo $id . '_' . $endpoint ?>[url]" id="<?php echo $id . '_' . $endpoint ?>_url" value="<?php echo $options['url'] ?>">
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_label"><?php echo __( 'Link label', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'Menu label for this link in "My Account".',
                            'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                    </th>
                    <td>
                        <input type="text" name="<?php echo $id . '_' . $endpoint ?>[label]" id="<?php echo $id . '_' . $endpoint ?>_label" value="<?php echo $options['label'] ?>">
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_icon"><?php echo __( 'Link icon', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'Link icon for "My Account" menu option', 'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
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
                        <label for="<?php echo $id . '_' . $endpoint ?>_class"><?php echo __( 'Link class', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                        <img class="help_tip" data-tip="<?php esc_attr_e( 'Add additional classes to link container.', 'yith-woocommerce-customize-myaccount-page' ) ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                    </th>
                    <td>
                        <input type="text" name="<?php echo $id . '_' . $endpoint ?>[class]" id="<?php echo $id . '_' . $endpoint ?>_class" value="<?php echo $options['class'] ?>">
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_usr_roles"><?php echo __( 'User roles', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
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

                <tr>
                    <th>
                        <label for="<?php echo $id . '_' . $endpoint ?>_target_blank"><?php echo __( 'Open link in a new tab?', 'yith-woocommerce-customize-myaccount-page' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo $id . '_' . $endpoint ?>[target_blank]" id="<?php echo $id . '_' . $endpoint ?>_target_blank" value="yes" <?php checked( $options['target_blank'] ) ?>>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>

    </div>
</li>