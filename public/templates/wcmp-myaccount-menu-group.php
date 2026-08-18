<?php
/**
 * MY ACCOUNT TEMPLATE MENU GROUP
 *
 * Override by copying to {your-theme}/woo-custom-my-account-page/.
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wcmp_group_open = ( 'yes' === $options['open'] );
$wcmp_submenu_id = 'wcmp-group-' . sanitize_html_class( $endpoint );
?>
<li class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<button type="button" class="group-opener" aria-expanded="<?php echo $wcmp_group_open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $wcmp_submenu_id ); ?>">
		<?php
		if ( ! empty( $options['icon'] ) ) :
			// Prevent double fa-.
			$icon = strpos( $options['icon'], 'fa-' ) === false ? 'fa-' . $options['icon'] : $options['icon'];
			?>
			<i class="fa <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
		<?php endif; ?>
		<span><?php echo esc_html( $options['label'] ); ?></span>
		<i class="opener fa <?php echo esc_attr( $class_icon ); ?>" aria-hidden="true"></i>
	</button>

	<ul class="myaccount-submenu" id="<?php echo esc_attr( $wcmp_submenu_id ); ?>" <?php echo $wcmp_group_open ? '' : 'style="display:none"'; ?>>
		<?php
		foreach ( $options['children'] as $child => $child_options ) {
			/**
			 * Print single endpoint
			 */
			do_action( 'wcmp_print_single_endpoint', $child, $child_options );
		}
		?>
	</ul>
</li>
