<?php
/**
 * Front page — Atelier landing.
 *
 * @package Miyaki
 */

get_header();

$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
$about_url = get_permalink( get_page_by_path( 'about' ) ) ?: home_url( '/about/' );
?>

<main id="primary" class="site-main front-page">
	<?php miyaki_landing_hero( $shop_url ); ?>
	<?php miyaki_marquee_band(); ?>
	<?php miyaki_category_editorial(); ?>

	<div class="container">
		<?php miyaki_featured_products( 8 ); ?>
	</div>

	<?php miyaki_philosophy_section( $about_url ); ?>

	<div class="container section">
		<?php miyaki_values_strip(); ?>
	</div>

	<?php miyaki_cta_band( $shop_url ); ?>
</main>

<?php
get_footer();
