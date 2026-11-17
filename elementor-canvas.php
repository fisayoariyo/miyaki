<?php
/**
 * Elementor canvas — header/footer with full-width content.
 *
 * @package Miyaki
 */

get_header();
?>

<main id="primary" class="site-main elementor-canvas">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>

<?php
get_footer();
