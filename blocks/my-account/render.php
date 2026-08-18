<?php
/**
 * Custom My Account block - server render.
 *
 * Renders WooCommerce's My Account shortcode; this plugin's navigation
 * takeover applies to it wherever it renders, so block themes get the
 * full portal without the classic shortcode string in post_content.
 *
 * @package Woo_Custom_My_Account_Page
 * @since   1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo do_shortcode( '[woocommerce_my_account]' );
