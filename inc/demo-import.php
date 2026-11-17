<?php
/**
 * One Click Demo Import configuration and demo data seeding.
 *
 * Requires the free "One Click Demo Import" plugin.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register demo import files.
 */
function miyaki_ocdi_import_files() {
	return array(
		array(
			'import_file_name'             => esc_html__( 'Miyaki Fashion Demo', 'miyaki' ),
			'local_import_file'            => MIYAKI_DIR . '/demo/content.xml',
			'local_import_customizer_file' => MIYAKI_DIR . '/demo/customizer.dat',
			'import_preview_image_url'     => MIYAKI_URI . '/assets/images/demo-preview.svg',
			'import_notice'                => wp_kses_post(
				__( '<strong>Before importing:</strong> Install & activate WooCommerce and One Click Demo Import. Existing content may be overwritten.', 'miyaki' )
			),
		),
	);
}
add_filter( 'ocdi/import_files', 'miyaki_ocdi_import_files' );

/**
 * Plugin install recommendations in OCDI panel.
 */
function miyaki_ocdi_register_plugins( $plugins ) {
	$plugins[] = array(
		'name'     => 'WooCommerce',
		'slug'     => 'woocommerce',
		'required' => true,
	);
	$plugins[] = array(
		'name'     => 'Elementor',
		'slug'     => 'elementor',
		'required' => false,
	);
	return $plugins;
}
add_filter( 'ocdi/register_plugins', 'miyaki_ocdi_register_plugins' );

/**
 * Branding in import panel.
 */
function miyaki_ocdi_intro_text( $text ) {
	$text .= '<div class="miyaki-ocdi-intro">';
	$text .= '<p>' . esc_html__( 'Import the Miyaki fashion demo to get pages, menus, sample products, and theme settings in one click.', 'miyaki' ) . '</p>';
	$text .= '</div>';
	return $text;
}
add_filter( 'ocdi/plugin_intro_text', 'miyaki_ocdi_intro_text' );

/**
 * After demo import: configure site, menus, WooCommerce, and products.
 */
function miyaki_ocdi_after_import( $selected_import ) {
	miyaki_setup_wc_pages();
	miyaki_seed_product_categories();
	miyaki_seed_demo_products();
	miyaki_assign_menus();
	miyaki_set_homepage();
	miyaki_apply_customizer_defaults();
}
add_action( 'ocdi/after_import', 'miyaki_ocdi_after_import' );

/**
 * Create WooCommerce pages if missing.
 */
function miyaki_setup_wc_pages() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	if ( null === wc_get_page_id( 'shop' ) || wc_get_page_id( 'shop' ) < 1 ) {
		wc_create_pages();
	}
}

/**
 * Seed fashion product categories.
 */
function miyaki_seed_product_categories() {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return;
	}

	$categories = array(
		'women'   => 'Women',
		'men'     => 'Men',
		'accessories' => 'Accessories',
	);

	foreach ( $categories as $slug => $name ) {
		if ( ! term_exists( $slug, 'product_cat' ) ) {
			wp_insert_term(
				$name,
				'product_cat',
				array( 'slug' => $slug )
			);
		}
	}
}

/**
 * Create sample fashion products with placeholder images.
 */
function miyaki_seed_demo_products() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$existing = wc_get_products( array( 'limit' => 1 ) );
	if ( ! empty( $existing ) ) {
		return;
	}

	$catalog = array(
		array( 'name' => 'Linen Overshirt', 'price' => '89', 'cat' => 'men', 'color' => '8B7355' ),
		array( 'name' => 'Merino Crew Sweater', 'price' => '120', 'cat' => 'men', 'color' => '2C2C2C' ),
		array( 'name' => 'Tailored Wool Trousers', 'price' => '145', 'cat' => 'men', 'color' => '4A4A4A' ),
		array( 'name' => 'Silk Slip Dress', 'price' => '198', 'cat' => 'women', 'color' => 'C4A484' ),
		array( 'name' => 'Cashmere Wrap Coat', 'price' => '320', 'cat' => 'women', 'color' => 'D4C5B0' ),
		array( 'name' => 'High-Rise Straight Jeans', 'price' => '110', 'cat' => 'women', 'color' => '3D5A80' ),
		array( 'name' => 'Structured Leather Tote', 'price' => '245', 'cat' => 'accessories', 'color' => '6B4C3B' ),
		array( 'name' => 'Minimalist Sneakers', 'price' => '165', 'cat' => 'accessories', 'color' => 'F5F5F0' ),
		array( 'name' => 'Organic Cotton Tee', 'price' => '45', 'cat' => 'women', 'color' => 'E8E4DF' ),
		array( 'name' => 'Relaxed Fit Blazer', 'price' => '210', 'cat' => 'women', 'color' => '1A1A1A' ),
		array( 'name' => 'Ribbed Tank Top', 'price' => '38', 'cat' => 'women', 'color' => 'B8A99A' ),
		array( 'name' => 'Canvas Cap', 'price' => '42', 'cat' => 'accessories', 'color' => '5C6B73' ),
	);

	foreach ( $catalog as $index => $item ) {
		$product = new WC_Product_Simple();
		$product->set_name( $item['name'] );
		$product->set_regular_price( $item['price'] );
		$product->set_description(
			sprintf(
				/* translators: %s: product name */
				__( 'Crafted with premium materials. The %s is designed for everyday elegance with a clean, minimal silhouette.', 'miyaki' ),
				$item['name']
			)
		);
		$product->set_short_description( __( 'Free worldwide shipping on orders over $150.', 'miyaki' ) );
		$product->set_catalog_visibility( 'visible' );
		$product->set_status( 'publish' );
		$product->set_sku( 'miyaki-' . ( $index + 1 ) );
		$product->set_manage_stock( false );
		$product->set_stock_status( 'instock' );

		$product_id = $product->save();

		$term = get_term_by( 'slug', $item['cat'], 'product_cat' );
		if ( $term ) {
			wp_set_object_terms( $product_id, (int) $term->term_id, 'product_cat' );
		}
	}
}

/**
 * Generate and attach a simple placeholder product image.
 */
function miyaki_attach_placeholder_image( $post_id, $label, $hex_color ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	if ( ! function_exists( 'imagecreatetruecolor' ) ) {
		return;
	}

	$width  = 800;
	$height = 1000;
	$image  = imagecreatetruecolor( $width, $height );

	$hex = ltrim( $hex_color, '#' );
	$r   = hexdec( substr( $hex, 0, 2 ) );
	$g   = hexdec( substr( $hex, 2, 2 ) );
	$b   = hexdec( substr( $hex, 4, 2 ) );

	$bg = imagecolorallocate( $image, $r, $g, $b );
	imagefilledrectangle( $image, 0, 0, $width, $height, $bg );

	$text_color = imagecolorallocate( $image, 255, 255, 255 );
	if ( ( $r + $g + $b ) / 3 > 180 ) {
		$text_color = imagecolorallocate( $image, 30, 30, 30 );
	}

	$font = 5;
	$text = substr( $label, 0, 20 );
	$x    = ( $width - ( imagefontwidth( $font ) * strlen( $text ) ) ) / 2;
	$y    = $height / 2;
	imagestring( $image, $font, (int) $x, (int) $y, $text, $text_color );

	$tmp = wp_tempnam( 'miyaki-product' );
	if ( ! $tmp ) {
		imagedestroy( $image );
		return;
	}

	imagejpeg( $image, $tmp, 90 );
	imagedestroy( $image );

	$file_array = array(
		'name'     => sanitize_file_name( strtolower( str_replace( ' ', '-', $label ) ) ) . '.jpg',
		'tmp_name' => $tmp,
	);

	$attachment_id = media_handle_sideload( $file_array, $post_id );
	if ( ! is_wp_error( $attachment_id ) ) {
		set_post_thumbnail( $post_id, $attachment_id );
	}

	@unlink( $tmp );
}

/**
 * Assign imported pages to navigation menus.
 */
function miyaki_assign_menus() {
	$primary = wp_get_nav_menu_object( 'Primary Menu' );
	if ( ! $primary ) {
		$primary_id = wp_create_nav_menu( 'Primary Menu' );
	} else {
		$primary_id = $primary->term_id;
	}

	$footer = wp_get_nav_menu_object( 'Footer Menu' );
	if ( ! $footer ) {
		$footer_id = wp_create_nav_menu( 'Footer Menu' );
	} else {
		$footer_id = $footer->term_id;
	}

	$page_map = array(
		'home'    => 'Home',
		'shop'    => 'Shop',
		'about'   => 'About',
		'faq'     => 'FAQ',
		'contact' => 'Contact',
	);

	$shop_id = class_exists( 'WooCommerce' ) ? wc_get_page_id( 'shop' ) : 0;

	wp_delete_nav_menu_items( $primary_id );

	foreach ( $page_map as $slug => $title ) {
		if ( 'shop' === $slug && $shop_id ) {
			wp_update_nav_menu_item(
				$primary_id,
				0,
				array(
					'menu-item-title'  => $title,
					'menu-item-object' => 'page',
					'menu-item-object-id' => $shop_id,
					'menu-item-type'   => 'post_type',
					'menu-item-status' => 'publish',
				)
			);
			continue;
		}

		$page = get_page_by_path( $slug );
		if ( $page ) {
			wp_update_nav_menu_item(
				$primary_id,
				0,
				array(
					'menu-item-title'     => $title,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $page->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
			);
		}
	}

	$locations           = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $primary_id;
	$locations['footer']  = $footer_id;
	$locations['mobile']  = $primary_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Set static front page.
 */
function miyaki_set_homepage() {
	$home = get_page_by_path( 'home' );
	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
	}

	$blog = get_page_by_path( 'blog' );
	if ( $blog ) {
		update_option( 'page_for_posts', $blog->ID );
	}
}

/**
 * Apply customizer defaults after import.
 */
function miyaki_apply_customizer_defaults() {
	set_theme_mod( 'miyaki_hero_eyebrow', __( 'Spring / Summer 2026', 'miyaki' ) );
	set_theme_mod( 'miyaki_hero_title', __( 'Wear less, mean more.', 'miyaki' ) );
	set_theme_mod( 'miyaki_hero_subtitle', __( 'Elevated essentials for a quieter wardrobe — crafted silhouettes, natural fabrics, lasting form.', 'miyaki' ) );
	set_theme_mod( 'miyaki_hero_cta_label', __( 'Explore the edit', 'miyaki' ) );
	set_theme_mod( 'miyaki_footer_tagline', __( 'Considered clothing for everyday life.', 'miyaki' ) );

	if ( ! get_theme_mod( 'custom_logo' ) ) {
		update_option( 'blogname', 'Miyaki' );
	}
}

/**
 * WooCommerce global settings for demo.
 */
function miyaki_configure_woocommerce() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	update_option( 'woocommerce_currency', 'USD' );
	update_option( 'woocommerce_price_thousand_sep', ',' );
	update_option( 'woocommerce_price_decimal_sep', '.' );
	update_option( 'woocommerce_price_num_decimals', '2' );
	update_option( 'woocommerce_enable_guest_checkout', 'yes' );
	update_option( 'woocommerce_calc_taxes', 'no' );
}
add_action( 'ocdi/after_import', 'miyaki_configure_woocommerce', 20 );

/**
 * Disable OCDI branding (optional clean admin).
 */
add_filter( 'ocdi/disable_pt_branding', '__return_true' );

/**
 * Admin notice when OCDI is not installed.
 */
function miyaki_demo_import_notice() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	if ( class_exists( 'OCDI\OneClickDemoImport' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'appearance_page_one-click-demo-import' !== $screen->id ) {
		if ( 'themes' === $screen->id ) {
			echo '<div class="notice notice-info"><p>';
			printf(
				/* translators: %s: plugin install link */
				esc_html__( 'Install %s to import the Miyaki fashion demo in one click.', 'miyaki' ),
				'<a href="' . esc_url( admin_url( 'plugin-install.php?s=one+click+demo+import&tab=search&type=term' ) ) . '">One Click Demo Import</a>'
			);
			echo '</p></div>';
		}
	}
}
add_action( 'admin_notices', 'miyaki_demo_import_notice' );

/**
 * Admin onboarding notice after theme activation.
 */
function miyaki_activation_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( get_option( 'miyaki_dismissed_notice' ) ) {
		return;
	}

	echo '<div class="notice notice-info is-dismissible" data-miyaki-notice><p><strong>Miyaki</strong> — ';
	echo esc_html__( 'Install WooCommerce and Elementor, then go to Appearance → Import Demo Data to load the fashion demo. Add WooCommerce filter blocks to the Shop Sidebar widget area.', 'miyaki' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'miyaki_activation_notice' );

/**
 * Persist notice dismissal.
 */
function miyaki_dismiss_notice() {
	update_option( 'miyaki_dismissed_notice', 1 );
	wp_die();
}
add_action( 'wp_ajax_miyaki_dismiss_notice', 'miyaki_dismiss_notice' );

/**
 * Delete all items from a nav menu.
 *
 * @param int $menu_id Menu term ID.
 */
function wp_delete_nav_menu_items( $menu_id ) {
	$items = wp_get_nav_menu_items( $menu_id );
	if ( empty( $items ) ) {
		return;
	}
	foreach ( $items as $item ) {
		wp_delete_post( $item->ID, true );
	}
}
