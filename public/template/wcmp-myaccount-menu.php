<?php
/**
 * MY ACCOUNT TEMPLATE MENU
 *
 * @since 1.0.0
 */
global $woocommerce, $wp, $post;

$logout_url = ( function_exists( 'wc_logout_url' ) ) ? wc_logout_url() : wc_get_endpoint_url( 'customer-logout', '',  $my_account_url );
?>
<div class="user-profile">

    <div class="user-image">
        <?php
            $current_user = wp_get_current_user();
            $user_id      = $current_user->ID;
            echo get_avatar( $user_id, apply_filters( 'wcmp_filter_avatar_size', 120 ) );
        ?>
        <?php if( $avatar ) : ?>
            <a href="#" id="load-avatar">
                <i class="fa fa-camera"></i>
            </a>
        <?php endif; ?>
    </div>
    <div class="user-info">
        <p class="username"><?php echo $current_user->display_name ?></p>
        <?php if( isset( $current_user ) && $current_user->ID != 0 ) : ?>
            <span class="logout"><a href="<?php echo esc_url( $logout_url ) ?>"><?php esc_html_e( 'Logout', 'wcmp-woocommerce-customize-myaccount-page' ) ?></a></span>
        <?php endif; ?>
    </div>

</div>

<?php do_action( 'wcmp_before_endpoints_menu' ); ?>

<ul class="myaccount-menu">

    <?php do_action( 'wcmp_before_endpoints_items' ); ?>

    <?php foreach( $endpoints as $endpoint => $options ) {

        // if( isset( $options['children'] ) ) {
        //     /**
        //      * Print endpoints group
        //      */
        //     do_action( 'yith_wcmap_print_endpoints_group', $endpoint, $options );
        // }
        // else {
            /**
             * Print single endpoint
             */
            do_action('wcmp_print_single_endpoint', $endpoint, $options );
        //}
    } ?>

    <?php do_action( 'wcmp_after_endpoints_items' ); ?>

</ul>

<?php do_action( 'wcmp_after_endpoints_menu' ); ?>