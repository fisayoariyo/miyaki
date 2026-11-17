<?php
/**
 * Search results template.
 *
 * @package Miyaki
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">
		<header class="page-header">
			<h1 class="page-title">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search results for "%s"', 'miyaki' ),
					esc_html( get_search_query() )
				);
				?>
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;
				?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
