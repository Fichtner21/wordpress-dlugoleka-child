<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sputnik_wp_theme
 */

get_header(); ?>

	<main id="primary" class="site-main">
		<div class="container">			
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>
			<div class="container-news">
				<div class='archive-posts'>			
					<header class="page-section-heading">
						<h1 class="page-section-heading__title"><?= __('Aktualności','sputnik-wp-theme'); ?></h1>

						<div class='page-section-heading__meta'>
							<div class="page-section-heading__terms">
								<span><?= __('Filtry','sputnik-wp-theme'); ?>:</span>
								<?= function_exists('show_terms_with_childrens') ? show_terms_with_childrens('category') : null; ?>
							</div>
						</div>
					</header>
					<?php
					$news_args = array(
						'post_type' => 'post',
						'posts_per_page' => 8,
						'post_status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC',
					);

					$news_query = new WP_Query($news_args);

					if($news_query->have_posts()) : ?>
							<div class='posts-loop'>							
									<?php while($news_query->have_posts()) : $news_query->the_post();
											custom_post_loop_template_dlugoleka();
									endwhile; ?>
							</div>
					<?php endif; wp_reset_query(); wp_reset_postdata(); ?>			
				</div>

				<div class="archive-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
		<?php require CUSTOM_PARTS . '/modules/module-pagination.php'; ?>
	</main><!-- #main -->

<?php get_footer();