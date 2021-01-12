<?php /* Template Name: Page template 1 */

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<?php if(in_array('slider-hero', $choosed_elements)) require CUSTOM_PARTS . '/modules/sliders/slider-hero.php'; ?>

		<?php if(in_array('links-under-slider', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-links-under-slider.php'; ?>

        <?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

        <?php require CUSTOM_PARTS . '/loops/loop-page-childs.php'; ?>

        <section class='page-section news'>
			<header class="page-section-heading">
				<h2 class="page-section-heading__title"><?= __('Aktualności','sputnik-wp-theme'); ?></h2>

				<?= function_exists('show_terms_with_childrens') ? show_terms_with_childrens('category') : null; ?>
			</header>

			<?php require CUSTOM_PARTS . '/loops/loop-news.php'; ?>
		</section>

		<section class="page-section">
			<header class="page-section-heading">
				<h2 class="page-section-heading__title"><?= __('Na skróty','sputnik-wp-theme'); ?></h2>
			</header>

			<?php if(in_array('three-favorite', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-three-favorite.php'; ?>

			<?php if(in_array('most-searched', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-most-searched.php'; ?>

			<?php if(in_array('contact-informations', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-contact-informations.php'; ?>
		</section>

        <section class='page-section events'>
			<header class="page-section-heading">
				<h2 class="page-section-heading__title"><?= __('Wydarzenia','sputnik-wp-theme'); ?></h2>
			</header>

			<div class='events__wrapper'>
				<?php require CUSTOM_PARTS . '/modules/module-calendar.php'; ?>

				<?php require CUSTOM_PARTS . '/loops/loop-events.php'; ?>
			</div>
		</section>
	</main><!-- #main -->

<?php get_footer();