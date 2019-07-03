<?php
/**
 * MY ACCOUNT TEMPLATE MENU ITEM
 *
 * @since   1.0.0
 * @package Woo_Custom_My_Account_Page
 */

is_array( $classes ) && $classes = implode( ' ', $classes );
$target                          = ( isset( $options['target_blank'] ) && $options['target_blank'] ) ? 'target="_blank"' : '';
?>

<li class="<?php echo esc_attr( $classes ); ?>">
	<a class="<?php echo esc_attr( apply_filters( 'wcmp_endpoint_anchor_tag_class', 'wcmp-' . $endpoint ) ); ?>" href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $options['label'] ); ?>" <?php echo esc_attr( $target ); ?>>
		<?php
		if ( ! empty( $options['icon'] ) ) :
			// Prevent double fa-.
			$icon = strpos( $options['icon'], 'fa-' ) === false ? 'fa-' . $options['icon'] : $options['icon'];
			?>
			<i class="fa <?php echo esc_attr( $icon ); ?>"></i>
		<?php endif; ?>
		<span><?php echo esc_html( $options['label'] ); ?></span>
	</a>
</li>
