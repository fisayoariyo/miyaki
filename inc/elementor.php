<?php
/**
 * Elementor compatibility.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Elementor locations and supports when plugin is active.
 */
function miyaki_elementor_setup() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	add_theme_support( 'elementor' );

	// Allow Elementor on all public post types including products.
	add_post_type_support( 'product', 'elementor' );
}
add_action( 'after_setup_theme', 'miyaki_elementor_setup' );

/**
 * Register Elementor kit-compatible color tokens.
 */
function miyaki_elementor_kit_settings( $config ) {
	return $config;
}
add_filter( 'elementor/editor/localize_settings', 'miyaki_elementor_kit_settings' );

/**
 * Use full-width canvas when Elementor built the page.
 */
function miyaki_elementor_page_template( $template ) {
	if ( is_singular() && get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) ) {
		$canvas = locate_template( 'elementor-canvas.php' );
		if ( $canvas ) {
			return $canvas;
		}
	}
	return $template;
}
add_filter( 'template_include', 'miyaki_elementor_page_template', 99 );

/**
 * Disable default colors/fonts in Elementor to respect theme tokens.
 */
function miyaki_elementor_disable_defaults() {
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
}
add_action( 'after_switch_theme', 'miyaki_elementor_disable_defaults' );

/**
 * Add Miyaki category in Elementor template library (for imported demos).
 */
function miyaki_register_elementor_categories( $elements_manager ) {
	$elements_manager->add_category(
		'miyaki',
		array(
			'title' => esc_html__( 'Miyaki', 'miyaki' ),
			'icon'  => 'fa fa-shopping-bag',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'miyaki_register_elementor_categories' );
