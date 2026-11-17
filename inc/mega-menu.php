<?php
/**
 * Mega menu walker and category panels.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Custom nav walker with mega menu support for product categories.
 */
class Miyaki_Mega_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start submenu level.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"sub-menu" . ( 0 === $depth ? ' mega-panel' : '' ) . "\">\n";

		if ( 0 === $depth && class_exists( 'WooCommerce' ) ) {
			$output .= miyaki_mega_menu_categories_html();
		}
	}

	/**
	 * End submenu level.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start menu item.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if ( in_array( 'menu-item-has-children', $classes, true ) && 0 === $depth ) {
			$classes[] = 'has-mega-menu';
		}

		if ( 0 === $depth && class_exists( 'WooCommerce' ) && ! empty( $item->url ) ) {
			$shop_url = wc_get_page_permalink( 'shop' );
			if ( $shop_url && untrailingslashit( $item->url ) === untrailingslashit( $shop_url ) ) {
				$classes[] = 'has-mega-menu';
			}
		}

		$class_names = implode( ' ', array_map( 'esc_attr', array_filter( $classes ) ) );
		$output     .= '<li class="' . $class_names . '">';

		$atts           = array();
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';
		$atts['class']  = 0 === $depth ? 'menu-link' : 'submenu-link';
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$output .= '<a' . $attributes . '>' . esc_html( $title ) . '</a>';

		if ( 0 === $depth && class_exists( 'WooCommerce' ) && ! empty( $item->url ) ) {
			$shop_url = wc_get_page_permalink( 'shop' );
			if ( $shop_url && untrailingslashit( $item->url ) === untrailingslashit( $shop_url ) && ! in_array( 'menu-item-has-children', $classes, true ) ) {
				$output .= '<ul class="sub-menu mega-panel">' . miyaki_mega_menu_categories_html() . '</ul>';
			}
		}
	}

	/**
	 * End menu item.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= "</li>\n";
	}
}

/**
 * Product category grid for mega menu.
 *
 * @return string
 */
function miyaki_mega_menu_categories_html() {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return '';
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'number'     => 6,
			'exclude'    => array( (int) get_option( 'default_product_cat', 0 ) ),
		)
	);

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return '';
	}

	ob_start();
	?>
	<li class="mega-menu-categories">
		<div class="mega-menu-grid">
			<?php foreach ( $terms as $term ) : ?>
				<a class="mega-menu-tile" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
					<span class="mega-menu-tile-label"><?php echo esc_html( $term->name ); ?></span>
					<span class="mega-menu-tile-count">
						<?php
						printf(
							/* translators: %d: product count */
							esc_html( _n( '%d item', '%d items', (int) $term->count, 'miyaki' ) ),
							(int) $term->count
						);
						?>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</li>
	<?php
	return ob_get_clean();
}

/**
 * Use mega menu walker for primary nav.
 */
function miyaki_primary_nav_args( $args ) {
	if ( isset( $args['theme_location'] ) && 'primary' === $args['theme_location'] ) {
		$args['walker'] = new Miyaki_Mega_Menu_Walker();
	}
	return $args;
}
add_filter( 'wp_nav_menu_args', 'miyaki_primary_nav_args' );
