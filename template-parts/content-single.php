<?php
/**
 * Single post content.
 *
 * @package Miyaki
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta"><?php echo esc_html( get_the_date() ); ?></div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
	<?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
