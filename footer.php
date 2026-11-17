<?php
/**
 * Footer template.
 *
 * @package Miyaki
 */
?>

	<footer id="colophon" class="site-footer">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="footer-widgets">
				<div class="container">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="footer-newsletter">
			<div class="container footer-newsletter-inner">
				<div class="footer-newsletter-copy">
					<h2 class="footer-newsletter-title"><?php esc_html_e( 'Stay in the loop', 'miyaki' ); ?></h2>
					<p class="footer-newsletter-text"><?php esc_html_e( 'New arrivals, restocks, and exclusive offers.', 'miyaki' ); ?></p>
				</div>
				<div class="footer-newsletter-form">
					<?php
					$newsletter = get_theme_mod( 'miyaki_newsletter_shortcode', '' );
					if ( $newsletter ) {
						echo do_shortcode( wp_kses_post( $newsletter ) );
					} elseif ( current_user_can( 'edit_theme_options' ) ) {
						?>
						<p class="footer-newsletter-placeholder">
							<?php esc_html_e( 'Add your Elementor form shortcode in Customizer → Footer.', 'miyaki' ); ?>
						</p>
						<?php
					}
					?>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container footer-bottom-inner">
				<p class="footer-tagline"><?php echo esc_html( get_theme_mod( 'miyaki_footer_tagline', __( 'Considered clothing for everyday life.', 'miyaki' ) ) ); ?></p>

				<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer', 'miyaki' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'footer-menu',
							'container'      => false,
							'fallback_cb'    => false,
							'depth'          => 1,
						)
					);
					?>
				</nav>

				<p class="site-info">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				</p>
			</div>
		</div>
	</footer>

	<div id="miyaki-quick-view" class="quick-view-modal" hidden aria-hidden="true">
		<div class="quick-view-backdrop" data-quick-view-close></div>
		<div class="quick-view-panel" role="dialog" aria-modal="true" aria-labelledby="quick-view-title">
			<button type="button" class="quick-view-close" data-quick-view-close aria-label="<?php esc_attr_e( 'Close', 'miyaki' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
			</button>
			<div class="quick-view-content"></div>
		</div>
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
