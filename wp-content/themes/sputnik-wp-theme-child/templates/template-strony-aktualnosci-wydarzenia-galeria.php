<?php /* Template Name: Strony, aktualności, wydarzenia i galeria */

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<?php if(in_array('slider-hero', $choosed_elements)) require CUSTOM_PARTS . '/modules/sliders/slider-hero.php'; ?>

		<?php if(in_array('links-under-slider', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-links-under-slider.php'; ?>

		<div class='container'>
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

			<?php require CUSTOM_PARTS . '/loops/loop-page-childs.php'; ?>
		</div>

		<?php require get_stylesheet_directory() . '/template-parts/custom/section-news-4-query.php'; ?>

		<section class='page-section events'>
			<div class='container'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Wydarzenia','sputnik-wp-theme'); ?></h2>
				</header>

				<div class='events__wrapper'>
					<?php require CUSTOM_PARTS . '/modules/module-calendar.php'; ?>

					<?php require CUSTOM_PARTS . '/loops/loop-events.php'; ?>
				</div>
			</div>
		</section>

		<section class='page-section galleries'>
			<div class='container'>
				<header class="entry-header">
					<h2 class='entry-title'><?= __('Galeria','sputnik-wp-theme'); ?></h2>
					<a href="<?= get_the_permalink(get_page_by_path('galerie')); ?>" class="entry-header__anchor" title='<?= __('Zobacz więcej','sputnik-wp-theme'); ?>'><?= __('Zobacz więcej','sputnik-wp-theme'); ?></a>
				</header><!-- .entry-header -->

				<?php

				$galleries_args = array(
					'post_type' => 'galerie',
					'posts_per_page' => 4,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC',
				);

				$galleries_query = new WP_Query($galleries_args);

				if($galleries_query->have_posts()) : ?>
					<div class='posts-loop'>
						<?php while($galleries_query->have_posts()) : $galleries_query->the_post(); ?>
							<article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
								<?php sputnik_wp_theme_post_thumbnail($thumb_size); ?>

								<a href="<?= get_the_permalink(); ?>" class="post__button btn btn--primary" title='<?= __('Zobacz więcej','sputnik-wp-theme'); ?>'><?= __('Zobacz więcej','sputnik-wp-theme'); ?></a>
							</article><!-- #post-<?= get_the_ID(); ?> -->
						<?php endwhile; ?>
					</div>
				<?php endif; wp_reset_query(); wp_reset_postdata(); ?>
			</div>
		</section>
	</main><!-- #main -->

<?php get_footer();