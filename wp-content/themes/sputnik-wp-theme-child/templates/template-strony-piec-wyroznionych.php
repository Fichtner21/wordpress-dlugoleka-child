<?php /* Template Name: Strony i pięć wyróżnionych */

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<?php if(in_array('slider-hero', $choosed_elements)) require CUSTOM_PARTS . '/modules/sliders/slider-hero.php'; ?>

		<?php if(in_array('links-under-slider', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-links-under-slider.php'; ?>

		<div class='container'>
			<h1 class="screen-reader-tex"><?= get_the_title(); ?></h1>

			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

			<?php require CUSTOM_PARTS . '/loops/loop-page-childs.php'; ?>
		</div>

		<div class='container'>
			<?php require CUSTOM_PARTS . '/modules/module-five-favorite.php'; ?>
		</div>
	</main><!-- #main -->

<?php get_footer();