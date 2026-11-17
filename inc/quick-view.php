<?php
/**
 * AJAX quick view modal for products.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue quick view script on shop pages.
 */
function miyaki_quick_view_assets() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	if ( ! is_shop() && ! is_product_taxonomy() && ! is_front_page() ) {
		return;
	}

	wp_enqueue_script(
		'miyaki-quick-view',
		MIYAKI_URI . '/assets/js/quick-view.js',
		array( 'miyaki-theme' ),
		MIYAKI_VERSION,
		true
	);

	wp_localize_script(
		'miyaki-quick-view',
		'miyakiQuickView',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'miyaki_quick_view' ),
			'i18n'    => array(
				'loading' => esc_html__( 'Loading…', 'miyaki' ),
				'error'   => esc_html__( 'Could not load product.', 'miyaki' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'miyaki_quick_view_assets', 20 );

/**
 * Quick view button on product cards.
 */
function miyaki_quick_view_button() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}
	?>
	<button
		type="button"
		class="quick-view-trigger"
		data-product-id="<?php echo esc_attr( (string) $product->get_id() ); ?>"
		aria-label="<?php esc_attr_e( 'Quick view', 'miyaki' ); ?>"
	>
		<?php esc_html_e( 'Quick view', 'miyaki' ); ?>
	</button>
	<?php
}
add_action( 'woocommerce_after_shop_loop_item', 'miyaki_quick_view_button', 15 );

/**
 * AJAX handler: return product HTML for modal.
 */
function miyaki_ajax_quick_view() {
	check_ajax_referer( 'miyaki_quick_view', 'nonce' );

	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$product    = wc_get_product( $product_id );

	if ( ! $product ) {
		wp_send_json_error( array( 'message' => __( 'Product not found.', 'miyaki' ) ), 404 );
	}

	ob_start();
	?>
	<div class="quick-view-product">
		<div class="quick-view-gallery">
			<?php echo wp_kses_post( $product->get_image( 'miyaki-product' ) ); ?>
		</div>
		<div class="quick-view-details">
			<h2 id="quick-view-title" class="quick-view-title"><?php echo esc_html( $product->get_name() ); ?></h2>
			<div class="quick-view-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
			<div class="quick-view-rating">
				<?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) ); ?>
			</div>
			<div class="quick-view-excerpt"><?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?></div>
			<?php
			woocommerce_template_loop_add_to_cart(
				array(
					'class' => 'btn btn-primary',
				)
			);
			?>
			<a class="quick-view-full-link" href="<?php echo esc_url( $product->get_permalink() ); ?>">
				<?php esc_html_e( 'View full details', 'miyaki' ); ?>
			</a>
		</div>
	</div>
	<?php
	wp_send_json_success( array( 'html' => ob_get_clean() ) );
}
add_action( 'wp_ajax_miyaki_quick_view', 'miyaki_ajax_quick_view' );
add_action( 'wp_ajax_nopriv_miyaki_quick_view', 'miyaki_ajax_quick_view' );
