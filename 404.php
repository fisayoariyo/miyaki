<?php
/**
 * 404 template.
 *
 * @package Miyaki
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container container-narrow not-found">
		<h1 class="page-title"><?php esc_html_e( 'Page not found', 'miyaki' ); ?></h1>
		<p><?php esc_html_e( 'The page you are looking for does not exist or has been moved.', 'miyaki' ); ?></p>
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Back to home', 'miyaki' ); ?>
		</a>
	</div>
</main>

<?php
get_footer();
