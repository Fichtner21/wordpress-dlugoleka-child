<?php /* Template Name: Gmina */

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<?php if(in_array('slider-hero', $choosed_elements)) require CUSTOM_PARTS . '/modules/sliders/slider-hero.php'; ?>

		<?php if(in_array('links-under-slider', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-links-under-slider.php'; ?>

		<div class='container'>
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

			<?php require CUSTOM_PARTS . '/loops/loop-page-childs.php'; ?>
		</div>

		<section class="page-section three-favorite-section">
			<div class='container'>
				<?php if(in_array('three-favorite-section', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-three-favorite.php'; ?>

				<?php if(in_array('most-searched', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-most-searched.php'; ?>

				<?php if(in_array('contact-informations', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-contact-informations.php'; ?>
			</div>
		</section>

        <section class='page-section attractions'>
			<div class='container'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Atrakcje','sputnik-wp-theme'); ?></h2>
				</header>

				<?php require CUSTOM_PARTS . '/loops/loop-attractions.php'; ?>
			</div>
		</section>

		<?php require CUSTOM_PARTS . '/modules/module-google-map.php'; ?>
	</main><!-- #main -->

<?php get_footer();