<?php
/**
 * MY ACCOUNT TEMPLATE MENU.
 *
 * Override by copying to {your-theme}/woo-custom-my-account-page/.
 *
 * @since 1.0.0
 * @package    Woo_Custom_My_Account_Page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce, $wp, $post;
$current_user_obj = wp_get_current_user();
?>
<div class="user-profile">

	<div class="user-image">
		<?php echo wp_kses_post( get_avatar( $current_user_obj->ID, apply_filters( 'wcmp_filter_avatar_size', 120 ) ) ); ?>
		<?php if ( $avatar ) : ?>
			<button type="button" id="load-avatar" class="wcmp-avatar-edit">
				<i class="fa fa-camera" aria-hidden="true"></i>
				<span class="screen-reader-text"><?php esc_html_e( 'Change profile photo', 'woo-custom-my-account-page' ); ?></span>
			</button>
		<?php endif; ?>
	</div>
	<div class="user-info">
		<p class="username"><?php echo esc_html( apply_filters( 'wcmp_filter_display_name', $current_user_obj->display_name ) ); ?></p>
	</div>

</div>

<button type="button" class="wcmp-nav-toggle" aria-expanded="false" aria-controls="wcmp-account-menu">
	<i class="fa fa-bars" aria-hidden="true"></i>
	<span><?php esc_html_e( 'Account menu', 'woo-custom-my-account-page' ); ?></span>
</button>

<?php do_action( 'wcmp_before_endpoints_menu' ); ?>
<ul class="myaccount-menu" id="wcmp-account-menu">

	<?php do_action( 'wcmp_before_endpoints_items' ); ?>

	<?php
	foreach ( $endpoints as $endpoint => $options ) {

		if ( isset( $options['children'] ) ) {
			/**
			 * Print endpoints group
			 */
			do_action( 'wcmp_print_endpoints_group', $endpoint, $options );
		} else {
			/**
			 * Print single endpoint
			 */
			do_action( 'wcmp_print_single_endpoint', $endpoint, $options );
		}
	}
	?>

	<?php do_action( 'wcmp_after_endpoints_items' ); ?>

</ul>

<?php do_action( 'wcmp_after_endpoints_menu' ); ?>
