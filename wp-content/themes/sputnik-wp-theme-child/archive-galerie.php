<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sputnik_wp_theme
 */

get_header(); ?>

	<main id="primary" class="site-main galleries">
		<div class='container'>
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

			<header class="entry-header">
				<h1 class='entry-title'><?= __('Galeria','sputnik-wp-theme'); ?></h1>
				<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
			</header><!-- .entry-header -->

			<?php require CUSTOM_PARTS . '/loops/loop-galleries.php'; ?>

			<?php require CUSTOM_PARTS . '/modules/module-pagination.php'; ?>
		</div>
	</main><!-- #main -->

<?php get_footer();
