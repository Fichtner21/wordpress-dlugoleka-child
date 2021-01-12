<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sputnik_wp_theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<div class="entry-meta">
		<!-- Public data -->

		<!-- Post aurhor -->
		</div>
	</header><!-- .entry-header -->

	<?php sputnik_wp_theme_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->