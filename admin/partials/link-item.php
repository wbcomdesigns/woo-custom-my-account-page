<?php
/**
 * MY ACCOUNT LINK FIELDS
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $wp_roles;
$user_roles = $wp_roles->roles;
?>

<li class="dd-item endpoint link" data-id="<?php echo esc_attr( $options['slug'] ); ?>" data-type="link">

    <label class="on-off-endpoint" for="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug']  . '_active' ); ?>">
        <input type="checkbox" class="hide-show-check" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][active]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug']  . '_active' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>" <?php checked( esc_attr( $options['active'] ), $options['slug'] ) ?>/>
        <i class="fa fa-power-off"></i>
    </label>

    <div class="open-options field-type">
        <span>
            <?php
            esc_html_e( 'Link', 'woo-custom-my-account-page' );
            ?>
        </span>
        <i class="fa fa-chevron-down"></i>
    </div>

    <div class="dd-handle endpoint-content">

        <!-- Header -->
        <div class="endpoint-header">
            <?php echo esc_html( $options['label'] ); ?>
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
                <span class="hide-show-trigger"><?php echo $options['active'] ? esc_html__( 'Hide', 'woo-custom-my-account-page') : esc_html__( 'Show', 'woo-custom-my-account-page' ); ?></span>
                <span class="sep">|</span>
                <span class="remove-trigger" data-endpoint="<?php echo esc_attr( $options['slug'] ); ?>"><?php esc_html_e( 'Remove', 'woo-custom-my-account-page'); ?></span>
            </div>

            <table class="options-table form-table">
            <tbody>

                <?php if( $options['slug'] != 'dashboard' ) : ?>
                <tr>
                    <th>
                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug']  . '_url' ); ?>">
                            <?php
                            esc_html_e( 'Link url', 'woo-custom-my-account-page' );
                            ?>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][url]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug']  . '_url' ); ?>" value="<?php echo esc_attr( $options['url'] ); ?>">
                        <p class="description">
                            <?php
                            esc_html_e( 'The url of the menu item.', 'woo-custom-my-account-page' );
                            ?>
                        </p>
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <th>
                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_label' ); ?>">
                            <?php
                            esc_html_e( 'Link label', 'woo-custom-my-account-page' ); ?>                                
                        </label>
                    </th>
                    <td>
                        <input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][label]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_label' ); ?>" value="<?php echo esc_attr( $options['label'] ); ?>">
                        <p class="description">
                            <?php
                            esc_html_e( 'Menu label for this link in "My Account".', 'woo-custom-my-account-page' );
                            ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_icon' ); ?>">
                            <?php
                            esc_html_e( 'Link icon', 'woo-custom-my-account-page' );
                            ?>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][icon]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_icon' ); ?>" value="<?php echo esc_attr( $options['icon'] ); ?>">
                        <p class="description">
                            <?php
                            esc_html_e( 'Link icon for "My Account" menu option.', 'woo-custom-my-account-page' );
                            ?>
                        </p>
                    </td>
                </tr>


                <tr>
                    <th>
                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_class' ); ?>">
                            <?php
                            esc_html_e( 'Link class', 'woo-custom-my-account-page' ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][class]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_class' ); ?>" value="<?php echo esc_attr( $options['class'] ); ?>">
                        <p class="description">
                            <?php
                            esc_html_e( 'Add additional classes to link container.', 'woo-custom-my-account-page' );
                            ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_usr_roles' ); ?>">
                            <?php
                            esc_html_e( 'User roles', 'woo-custom-my-account-page' ); ?>
                        </label>
                    </th>
                    <td>
                        <select name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][usr_roles][]" multiple="multiple">
                            <?php
                                if ( $user_roles ) {
                                    foreach ( $user_roles as $usrrole_slug => $usrrole_arr ) {
                                        if ( ! empty( $options['usr_roles'] ) ) {
                                            if ( in_array( $usrrole_slug, $options['usr_roles'] ) ) {
                                            ?>  
                                                <option value="<?php echo esc_attr( $usrrole_slug ); ?>" selected = "selected">
                                                    <?php echo esc_html( $usrrole_arr['name'] ); ?>             
                                                </option>
                                            <?php } else { ?>
                                                <option value="<?php echo esc_attr( $usrrole_slug ); ?>">
                                                    <?php echo esc_html( $usrrole_arr['name'] ); ?>
                                                </option>
                                        <?php } } else { ?>
                                        <option value="<?php echo esc_attr( $usrrole_slug ); ?>">
                                            <?php echo esc_html( $usrrole_arr['name'] ); ?>
                                        </option>
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

                <tr>
                    <th>
                        <label for="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_target_blank' ); ?>">
                            <?php
                            esc_html_e( 'Open link in a new tab?', 'woo-custom-my-account-page' );
                            ?>
                        </label>
                    </th>
                    <td>
                        <input type="checkbox" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][target_blank]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug'] . '_target_blank' ); ?>" value="yes" <?php checked( $options['target_blank'], 'yes' ) ?>>
                    </td>
                </tr>
                <input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][slug]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug']  . '_slug' ); ?>" value="<?php echo esc_attr( $options['slug'] ); ?>">
                <input type="hidden" name="wcmp_endpoints_settings[endpoints][<?php echo esc_attr( $options['slug'] ); ?>][type]" id="<?php echo esc_attr( 'wcmp_endpoint_'. $options['slug']  . '_type' ); ?>" value="<?php echo esc_attr( $options['type'] ); ?>">
            </tbody>
        </table>
        </div>

    </div>
</li>