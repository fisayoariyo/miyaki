<?php
/**
 * WooCommerce integration.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare WooCommerce support.
 */
function miyaki_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 8,
				'default_columns' => 3,
				'min_columns'     => 2,
				'max_columns'     => 4,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'miyaki_woocommerce_setup' );

/**
 * WooCommerce styles — theme handles styling.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Products per page.
 */
function miyaki_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'miyaki_products_per_page', 20 );

/**
 * Related products count.
 */
function miyaki_related_products_args( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'miyaki_related_products_args' );

/**
 * Remove default WooCommerce wrappers — theme provides its own.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function miyaki_woocommerce_wrapper_before() {
	echo '<main id="primary" class="site-main woocommerce-main">';
	echo '<div class="container">';
}
add_action( 'woocommerce_before_main_content', 'miyaki_woocommerce_wrapper_before', 10 );

function miyaki_woocommerce_wrapper_after() {
	echo '</div></main>';
}
add_action( 'woocommerce_after_main_content', 'miyaki_woocommerce_wrapper_after', 10 );

/**
 * Mini cart fragment for header badge.
 */
function miyaki_cart_fragments( $fragments ) {
	ob_start();
	miyaki_cart_link();
	$fragments['a.miyaki-cart-link'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'miyaki_cart_fragments' );

/**
 * Breadcrumb defaults.
 */
function miyaki_woocommerce_breadcrumb_defaults( $defaults ) {
	$defaults['delimiter']   = '<span class="breadcrumb-sep" aria-hidden="true">/</span>';
	$defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'miyaki' ) . '">';
	$defaults['wrap_after']  = '</nav>';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'miyaki_woocommerce_breadcrumb_defaults' );
