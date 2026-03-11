<?php
/**
 * Template for Wbcom themes page.
 *
 * @package Woo_Custom_My_Account_Page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">
	<h1><?php esc_html_e( 'Our Themes', 'woo-custom-my-account-page' ); ?></h1>
	<p>
		<?php
		printf(
			/* translators: %s: Wbcom Designs website URL */
			esc_html__( 'Check out our themes at %s', 'woo-custom-my-account-page' ),
			'<a href="https://wbcomdesigns.com/themes/" target="_blank" rel="noopener noreferrer">wbcomdesigns.com</a>'
		);
		?>
	</p>
</div>
