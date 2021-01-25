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
				<h1 class='entry-title'><?= __('Kalendarz wydarzeń','sputnik-wp-theme'); ?></h1>
				<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
			</header><!-- .entry-header -->

			<?php require CUSTOM_PARTS . '/modules/module-calendar.php'; ?>

			<?php

			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			$events_args = array(
				'post_type' => 'wydarzenia',
				'posts_per_page' => 3,
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'DESC',
				'paged' => $paged,
			);

			$events_query = new WP_Query($events_args);

			if($events_query->have_posts()) : ?>
				<div class='posts-loop'>
					<?php while($events_query->have_posts()) : $events_query->the_post();
						if(function_exists('custom_post_loop_template')) {
							custom_post_loop_template('h2');
						} else {
							// nothing...
							// ! Add some placeholder structure
						}
					endwhile; ?>
				</div>
			<?php endif; wp_reset_query(); wp_reset_postdata(); ?>

			<?php require CUSTOM_PARTS . '/modules/module-pagination.php'; ?>
		</div>
	</main><!-- #main -->

<?php get_footer();
