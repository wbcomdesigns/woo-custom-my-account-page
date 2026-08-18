<?php
/**
 * MY ACCOUNT TEMPLATE MENU ITEM
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

if ( is_array( $classes ) ) {
	$classes = implode( ' ', $classes );
}
$wcmp_new_tab = ( isset( $options['target_blank'] ) && 'yes' === $options['target_blank'] );
?>

<li class="<?php echo esc_attr( $classes ); ?>">
	<a class="<?php echo esc_attr( apply_filters( 'wcmp_endpoint_anchor_tag_class', 'wcmp-' . $endpoint ) ); ?>"
		href="<?php echo esc_url( $url ); ?>"
		<?php if ( $wcmp_new_tab ) : ?>
			target="_blank" rel="noopener noreferrer"
		<?php endif; ?>
	>
		<?php
		if ( ! empty( $options['icon'] ) ) :
			// Prevent double fa-.
			$icon = strpos( $options['icon'], 'fa-' ) === false ? 'fa-' . $options['icon'] : $options['icon'];
			?>
			<i class="fa <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
		<?php endif; ?>
		<span><?php echo esc_html( $options['label'] ); ?></span>
		<?php if ( $wcmp_new_tab ) : ?>
			<span class="wcmp-new-tab" aria-hidden="true">&#8599;</span>
			<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'woo-custom-my-account-page' ); ?></span>
		<?php endif; ?>
	</a>
</li>
