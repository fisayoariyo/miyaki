<?php
/**
 * Post card template.
 *
 * @package Miyaki
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-card-image" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'miyaki-card' ); ?>
		</a>
	<?php endif; ?>
	<div class="post-card-body">
		<h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="post-card-meta"><?php echo esc_html( get_the_date() ); ?></div>
		<div class="post-card-excerpt"><?php the_excerpt(); ?></div>
	</div>
</article>
