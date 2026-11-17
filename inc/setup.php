<?php
/**
 * Theme setup and supports.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme features.
 */
function miyaki_setup() {
	load_theme_textdomain( 'miyaki', MIYAKI_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 48,
			'width'       => 180,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'miyaki-hero', 1920, 1080, true );
	add_image_size( 'miyaki-product', 800, 1000, true );
	add_image_size( 'miyaki-card', 600, 750, true );

	register_nav_menus(
		array(
			'primary'   => esc_html__( 'Primary Menu', 'miyaki' ),
			'footer'    => esc_html__( 'Footer Menu', 'miyaki' ),
			'mobile'    => esc_html__( 'Mobile Menu', 'miyaki' ),
		)
	);
}
add_action( 'after_setup_theme', 'miyaki_setup' );

/**
 * Content width for embeds and media.
 */
function miyaki_content_width() {
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'miyaki_content_width', 0 );

/**
 * Register widget areas.
 */
function miyaki_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'miyaki' ),
			'id'            => 'shop-sidebar',
			'description'   => esc_html__( 'Appears on shop and product archive pages.', 'miyaki' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'miyaki' ),
			'id'            => 'footer-1',
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'miyaki_widgets_init' );
