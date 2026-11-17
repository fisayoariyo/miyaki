<?php
/**
 * Shop archive with sidebar filters.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 */
do_action( 'woocommerce_before_main_content' );
?>

<header class="woocommerce-products-header shop-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php do_action( 'woocommerce_archive_description' ); ?>
</header>

<div class="shop-layout">
	<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
		<aside class="shop-filters" aria-label="<?php esc_attr_e( 'Product filters', 'miyaki' ); ?>">
			<?php dynamic_sidebar( 'shop-sidebar' ); ?>
		</aside>
	<?php endif; ?>

	<div class="shop-products">
		<?php
		if ( woocommerce_product_loop() ) {
			do_action( 'woocommerce_before_shop_loop' );
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					do_action( 'woocommerce_shop_loop' );
					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			do_action( 'woocommerce_no_products_found' );
		}
		?>
	</div>
</div>

<?php
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
