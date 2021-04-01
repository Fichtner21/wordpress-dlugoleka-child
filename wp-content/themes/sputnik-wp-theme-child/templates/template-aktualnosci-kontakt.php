<?php /* Template Name: Aktualności i kontakt */

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<?php if(in_array('slider-hero', $choosed_elements)) require CUSTOM_PARTS . '/modules/sliders/slider-hero.php'; ?>

		<?php if(in_array('links-under-slider', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-links-under-slider.php'; ?>

		<div class='container'>
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

			<div class='news-contact-wrapper'>
				<?php require get_stylesheet_directory() . '/template-parts/custom/section-news-3-query.php'; ?>

				<div class='contact-informations-wrapper'>
					<header class="page-section-heading">
						<h1 class="page-section-heading__title"><?= __('Kontakt','sputnik-wp-theme'); ?></h1>
					</header>
					<?php if(in_array('contact-informations', $choosed_elements)) require CUSTOM_PARTS . '/modules/module-contact-informations.php'; ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->

<?php get_footer();