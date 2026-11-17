<?php
/**
 * Template tags and helpers.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site branding output.
 */
function miyaki_site_branding() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	?>
	<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<?php bloginfo( 'name' ); ?>
	</a>
	<?php
}

/**
 * Header account link.
 */
function miyaki_account_link() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$url   = wc_get_page_permalink( 'myaccount' );
	$label = is_user_logged_in()
		? __( 'Account', 'miyaki' )
		: __( 'Login', 'miyaki' );
	?>
	<a class="miyaki-account-link header-action" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $label ); ?>">
		<span class="header-action-icon" aria-hidden="true">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
		</span>
	</a>
	<?php
}

/**
 * Header cart link with count.
 */
function miyaki_cart_link() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	$url   = wc_get_cart_url();
	?>
	<a class="miyaki-cart-link header-action" href="<?php echo esc_url( $url ); ?>" aria-label="<?php esc_attr_e( 'View cart', 'miyaki' ); ?>">
		<span class="header-action-icon" aria-hidden="true">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 6h15l-1.5 9h-12z"/><path d="M6 6L5 3H2"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
		</span>
		<span class="cart-count<?php echo $count ? ' has-items' : ''; ?>"><?php echo esc_html( $count ); ?></span>
	</a>
	<?php
}

/**
 * Primary navigation.
 */
function miyaki_primary_nav() {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_class'     => 'primary-menu',
			'container'      => false,
			'fallback_cb'    => 'miyaki_fallback_menu',
			'depth'          => 2,
		)
	);
}

/**
 * Fallback menu when none assigned.
 */
function miyaki_fallback_menu() {
	echo '<ul class="primary-menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'miyaki' ) . '</a></li>';
	if ( class_exists( 'WooCommerce' ) ) {
		echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">' . esc_html__( 'Shop', 'miyaki' ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * SVG mark for products without images.
 *
 * @return string
 */
function miyaki_product_art_svg() {
	return '<svg viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M50 8L88 32v56L50 112 12 88V32L50 8z" stroke="currentColor" stroke-width="1.2"/><path d="M50 28v64M28 44l44 24M72 44L28 68" stroke="currentColor" stroke-width="0.8" opacity="0.6"/></svg>';
}

/**
 * Product image or CSS art fallback — no generated placeholders.
 *
 * @param WC_Product $product Product.
 * @param string       $size    Image size.
 */
function miyaki_product_thumbnail( $product, $size = 'miyaki-card' ) {
	if ( $product->get_image_id() ) {
		echo wp_kses_post( $product->get_image( $size ) );
		return;
	}
	?>
	<div class="product-card-image--art" aria-hidden="true">
		<?php echo miyaki_product_art_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php
}

/**
 * Landing hero.
 *
 * @param string $shop_url Shop URL.
 */
function miyaki_landing_hero( $shop_url ) {
	$title = get_theme_mod( 'miyaki_hero_title', __( 'Wear less, mean more.', 'miyaki' ) );
	$words = preg_split( '/\s+/', trim( $title ), 2 );
	$line1 = $words[0] ?? $title;
	$line2 = $words[1] ?? '';
	?>
	<section class="landing-hero" aria-label="<?php esc_attr_e( 'Introduction', 'miyaki' ); ?>">
		<div class="landing-hero__mesh" aria-hidden="true">
			<div class="landing-hero__blob landing-hero__blob--1"></div>
			<div class="landing-hero__blob landing-hero__blob--2"></div>
			<div class="landing-hero__blob landing-hero__blob--3"></div>
			<div class="landing-hero__line"></div>
		</div>
		<div class="container landing-hero__inner">
			<span class="landing-hero__eyebrow"><?php echo esc_html( get_theme_mod( 'miyaki_hero_eyebrow', __( 'Spring / Summer 2026', 'miyaki' ) ) ); ?></span>
			<h1 class="landing-hero__title">
				<span class="landing-hero__title-line"><span><?php echo esc_html( $line1 ); ?></span></span>
				<?php if ( $line2 ) : ?>
					<span class="landing-hero__title-line"><span><?php echo esc_html( $line2 ); ?></span></span>
				<?php endif; ?>
			</h1>
			<p class="landing-hero__subtitle"><?php echo esc_html( get_theme_mod( 'miyaki_hero_subtitle', __( 'Elevated essentials for a quieter wardrobe — crafted silhouettes, natural fabrics, lasting form.', 'miyaki' ) ) ); ?></p>
			<div class="landing-hero__actions">
				<a class="btn btn-primary" href="<?php echo esc_url( $shop_url ); ?>">
					<?php echo esc_html( get_theme_mod( 'miyaki_hero_cta_label', __( 'Explore the edit', 'miyaki' ) ) ); ?>
				</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( $shop_url ); ?>">
					<?php esc_html_e( 'View lookbook', 'miyaki' ); ?>
				</a>
			</div>
		</div>
		<div class="landing-hero__scroll" aria-hidden="true">
			<span><?php esc_html_e( 'Scroll', 'miyaki' ); ?></span>
			<div class="landing-hero__scroll-line"></div>
		</div>
	</section>
	<?php
}

/**
 * Marquee band.
 */
function miyaki_marquee_band() {
	$items = array(
		__( 'Slow fashion', 'miyaki' ),
		__( 'Natural fibres', 'miyaki' ),
		__( 'Considered design', 'miyaki' ),
		__( 'Small batches', 'miyaki' ),
		__( 'Free returns', 'miyaki' ),
	);
	?>
	<div class="marquee-band" aria-hidden="true">
		<div class="marquee-track">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
				<?php foreach ( $items as $item ) : ?>
					<span><?php echo esc_html( $item ); ?></span>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
	<?php
}

/**
 * Editorial category blocks — gradient only, no images.
 */
function miyaki_category_editorial() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'number'     => 3,
			'exclude'    => array( (int) get_option( 'default_product_cat', 0 ) ),
		)
	);

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return;
	}
	?>
	<section class="section" aria-labelledby="categories-heading">
		<div class="container reveal">
			<span class="section-label"><?php esc_html_e( 'Collections', 'miyaki' ); ?></span>
			<h2 id="categories-heading" class="section-title"><?php esc_html_e( 'Curated edits', 'miyaki' ); ?></h2>
		</div>
		<div class="category-editorial reveal-stagger">
			<?php foreach ( $terms as $index => $term ) : ?>
				<a class="category-editorial__item" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
					<span class="category-editorial__index"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<span class="category-editorial__name"><?php echo esc_html( $term->name ); ?></span>
					<span class="category-editorial__link"><?php esc_html_e( 'Shop now', 'miyaki' ); ?> →</span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * Philosophy section.
 *
 * @param string $about_url About page URL.
 */
function miyaki_philosophy_section( $about_url ) {
	?>
	<section class="section philosophy reveal" aria-labelledby="philosophy-heading">
		<div class="container philosophy__grid">
			<div class="philosophy__copy">
				<span class="section-label philosophy__label"><?php esc_html_e( 'Philosophy', 'miyaki' ); ?></span>
				<h2 id="philosophy-heading" class="philosophy__quote">
					<?php echo esc_html( get_theme_mod( 'miyaki_philosophy_quote', __( 'Clothing should feel inevitable — not loud.', 'miyaki' ) ) ); ?>
				</h2>
				<p class="philosophy__text">
					<?php echo esc_html( get_theme_mod( 'miyaki_philosophy_text', __( 'We design fewer pieces with greater intention. Each garment is cut for ease, finished by hand, and meant to settle into your life — season after season.', 'miyaki' ) ) ); ?>
				</p>
				<a class="philosophy__link" href="<?php echo esc_url( $about_url ); ?>"><?php esc_html_e( 'Read our story', 'miyaki' ); ?> →</a>
			</div>
			<div class="philosophy__visual" aria-hidden="true"></div>
		</div>
	</section>
	<?php
}

/**
 * Values strip.
 */
function miyaki_values_strip() {
	?>
	<div class="values-strip reveal-stagger" aria-label="<?php esc_attr_e( 'Brand values', 'miyaki' ); ?>">
		<div>
			<div class="values-strip__icon">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
			</div>
			<h3 class="values-strip__title"><?php esc_html_e( 'Ethically made', 'miyaki' ); ?></h3>
			<p class="values-strip__text"><?php esc_html_e( 'Transparent supply chain, fair wages, low-impact production.', 'miyaki' ); ?></p>
		</div>
		<div>
			<div class="values-strip__icon">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
			</div>
			<h3 class="values-strip__title"><?php esc_html_e( 'Quality first', 'miyaki' ); ?></h3>
			<p class="values-strip__text"><?php esc_html_e( 'Natural fibres, reinforced seams, pieces built to last.', 'miyaki' ); ?></p>
		</div>
		<div>
			<div class="values-strip__icon">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
			</div>
			<h3 class="values-strip__title"><?php esc_html_e( 'Easy returns', 'miyaki' ); ?></h3>
			<p class="values-strip__text"><?php esc_html_e( '30-day returns worldwide. No questions, no friction.', 'miyaki' ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * CTA band.
 *
 * @param string $shop_url Shop URL.
 */
function miyaki_cta_band( $shop_url ) {
	?>
	<section class="cta-band reveal" aria-labelledby="cta-heading">
		<div class="container">
			<h2 id="cta-heading" class="cta-band__title"><?php esc_html_e( 'Find your uniform', 'miyaki' ); ?></h2>
			<p class="cta-band__text"><?php esc_html_e( 'A considered wardrobe starts with one perfect piece. Begin with the edit.', 'miyaki' ); ?></p>
			<a class="btn btn-primary" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop all', 'miyaki' ); ?></a>
		</div>
	</section>
	<?php
}

/**
 * Render homepage featured products section.
 */
function miyaki_featured_products( $limit = 8 ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$args = array(
		'limit'   => $limit,
		'status'  => 'publish',
		'orderby' => 'date',
		'order'   => 'DESC',
	);

	$products = wc_get_products( $args );

	if ( empty( $products ) ) {
		return;
	}
	?>
	<section class="section featured-products reveal" aria-labelledby="featured-products-heading">
		<div class="section-header">
			<div>
				<span class="section-label"><?php esc_html_e( 'The edit', 'miyaki' ); ?></span>
				<h2 id="featured-products-heading" class="section-title"><?php esc_html_e( 'Just arrived', 'miyaki' ); ?></h2>
			</div>
			<a class="btn btn-outline" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
				<?php esc_html_e( 'Shop all', 'miyaki' ); ?>
			</a>
		</div>
		<ul class="product-grid reveal-stagger">
			<?php foreach ( $products as $product ) : ?>
				<li class="product-card">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-card-link">
						<div class="product-card-image">
							<?php miyaki_product_thumbnail( $product ); ?>
						</div>
						<div class="product-card-body">
							<h3 class="product-card-title"><?php echo esc_html( $product->get_name() ); ?></h3>
							<span class="product-card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php
}

/**
 * Category tiles — deprecated, use miyaki_category_editorial().
 */
function miyaki_category_tiles() {
	miyaki_category_editorial();
}

/**
 * Dark mode toggle button.
 */
function miyaki_dark_mode_toggle() {
	?>
	<button type="button" class="dark-mode-toggle header-action" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'miyaki' ); ?>" data-theme-toggle>
		<span class="icon-sun" aria-hidden="true">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
		</span>
		<span class="icon-moon" aria-hidden="true">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
		</span>
	</button>
	<?php
}
