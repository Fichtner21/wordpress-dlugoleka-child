<?php /* Template Name: Działy */

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<?php if(in_array('slider-hero', $choosed_elements)) require CUSTOM_PARTS . '/modules/sliders/slider-hero.php'; ?>

		<?php if(in_array('links-under-slider', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-links-under-slider.php'; ?>

		<div class='container'>
			<h1 class="screen-reader-tex"><?= get_the_title(); ?></h1>

			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

			<div class="cpt-wrapper">
				<div class='cpt-content'>
					<?php require CUSTOM_PARTS . '/loops/loop-page-childs.php'; ?>

					<?php require get_stylesheet_directory() . '/template-parts/custom/section-news-cpt.php'; ?>
				</div>

				<aside class="cpt-sidebar">
					<?php require get_template_directory() . '/template-parts/custom/modules/module-levels-menu-posts.php'; ?>

					<?php require CUSTOM_PARTS . '/modules/module-attachments.php'; ?>
				</aside>
			</div>
		</div>
	</main><!-- #main -->

<?php get_footer();