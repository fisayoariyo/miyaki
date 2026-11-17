<?php
/**
 * Customizer settings.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register customizer panels and settings.
 */
function miyaki_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'miyaki_hero',
		array(
			'title'    => esc_html__( 'Homepage Hero', 'miyaki' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'miyaki_hero_title',
		array(
			'default'           => esc_html__( 'Wear less, mean more.', 'miyaki' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'miyaki_hero_title',
		array(
			'label'   => esc_html__( 'Hero Title', 'miyaki' ),
			'section' => 'miyaki_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'miyaki_hero_subtitle',
		array(
			'default'           => esc_html__( 'Elevated essentials for a quieter wardrobe — crafted silhouettes, natural fabrics, lasting form.', 'miyaki' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'miyaki_hero_subtitle',
		array(
			'label'   => esc_html__( 'Hero Subtitle', 'miyaki' ),
			'section' => 'miyaki_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'miyaki_hero_cta_label',
		array(
			'default'           => esc_html__( 'Explore the edit', 'miyaki' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'miyaki_hero_cta_label',
		array(
			'label'   => esc_html__( 'Hero Button Label', 'miyaki' ),
			'section' => 'miyaki_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'miyaki_hero_eyebrow',
		array(
			'default'           => esc_html__( 'Spring / Summer 2026', 'miyaki' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'miyaki_hero_eyebrow',
		array(
			'label'   => esc_html__( 'Hero Eyebrow', 'miyaki' ),
			'section' => 'miyaki_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'miyaki_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'miyaki_hero_image',
			array(
				'label'     => esc_html__( 'Hero Background Image', 'miyaki' ),
				'section'   => 'miyaki_hero',
				'mime_type' => 'image',
			)
		)
	);

	$wp_customize->add_section(
		'miyaki_footer',
		array(
			'title'    => esc_html__( 'Footer', 'miyaki' ),
			'priority' => 120,
		)
	);

	$wp_customize->add_setting(
		'miyaki_footer_tagline',
		array(
			'default'           => esc_html__( 'Considered clothing for everyday life.', 'miyaki' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'miyaki_footer_tagline',
		array(
			'label'   => esc_html__( 'Footer Tagline', 'miyaki' ),
			'section' => 'miyaki_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'miyaki_newsletter_shortcode',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'miyaki_newsletter_shortcode',
		array(
			'label'       => esc_html__( 'Newsletter Form Shortcode', 'miyaki' ),
			'description' => esc_html__( 'Paste an Elementor form shortcode, e.g. [elementor-template id="123"]', 'miyaki' ),
			'section'     => 'miyaki_footer',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'miyaki_customize_register' );
