<?php
/**
 * Product card in shop loop.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'product-card wc-product-card', $product ); ?>>
	<div class="product-card-inner">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link product-card-link">
			<div class="product-card-image">
				<?php miyaki_product_thumbnail( $product ); ?>
			</div>
			<div class="product-card-body">
				<h2 class="woocommerce-loop-product__title product-card-title"><?php echo esc_html( $product->get_name() ); ?></h2>
				<span class="price product-card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				<?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) ); ?>
			</div>
		</a>
		<div class="product-card-actions">
			<?php woocommerce_template_loop_add_to_cart(); ?>
		</div>
	</div>
</li>
