<?php
/**
 * Scripts and styles.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue front-end assets.
 */
function miyaki_enqueue_assets() {
	wp_enqueue_style(
		'miyaki-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Outfit:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'miyaki-main',
		MIYAKI_URI . '/assets/css/main.css',
		array( 'miyaki-fonts' ),
		MIYAKI_VERSION
	);

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'miyaki-woocommerce',
			MIYAKI_URI . '/assets/css/woocommerce.css',
			array( 'miyaki-main' ),
			MIYAKI_VERSION
		);
	}

	wp_enqueue_script(
		'miyaki-theme',
		MIYAKI_URI . '/assets/js/theme.js',
		array(),
		MIYAKI_VERSION,
		true
	);

	wp_enqueue_script(
		'miyaki-dark-mode',
		MIYAKI_URI . '/assets/js/dark-mode.js',
		array(),
		MIYAKI_VERSION,
		true
	);

	wp_enqueue_script(
		'miyaki-animations',
		MIYAKI_URI . '/assets/js/animations.js',
		array(),
		MIYAKI_VERSION,
		true
	);

	wp_localize_script(
		'miyaki-theme',
		'miyakiTheme',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'i18n'    => array(
				'menuOpen'  => esc_html__( 'Open menu', 'miyaki' ),
				'menuClose' => esc_html__( 'Close menu', 'miyaki' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'miyaki_enqueue_assets' );

/**
 * Preconnect to Google Fonts.
 */
function miyaki_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'miyaki_resource_hints', 10, 2 );
