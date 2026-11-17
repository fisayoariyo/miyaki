<?php
/**
 * Main template fallback.
 *
 * @package Miyaki
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<?php if ( is_home() && ! is_front_page() ) : ?>
					<h1 class="page-title"><?php single_post_title(); ?></h1>
				<?php elseif ( is_archive() ) : ?>
					<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
					<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
				<?php endif; ?>
			</header>

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
