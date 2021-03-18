<?php
/**
 * MY ACCOUNT TEMPLATE MENU ITEM
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

?>
<li class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<a href="#" class="group-opener">
		<?php
		if ( ! empty( $options['icon'] ) ) :
			// Prevent double fa-.
			$icon = strpos( $options['icon'], 'fa-' ) === false ? 'fa-' . $options['icon'] : $options['icon'];
			?>
			<i class="fa <?php echo esc_attr( $icon ); ?>"></i>
		<?php endif; ?>
		<?php echo esc_html( $options['label'] ); ?>
		<i class="opener fa <?php echo esc_attr( $class_icon ); ?>"></i>
	</a>

	<ul class="myaccount-submenu" <?php echo 'yes' === $options['open'] ? '' : 'style="display:none"'; ?>>
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
