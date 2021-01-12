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

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<?php if(in_array('slider-hero', $choosed_elements)) require CUSTOM_PARTS . '/modules/sliders/slider-hero.php'; ?>

		<?php require CUSTOM_PARTS . '/modules/sliders/slider-icon-links.php'; ?>

		<section class='page-section news'>
			<header class="page-section-heading">
				<h2 class="page-section-heading__title"><?= __('Aktualności','sputnik-wp-theme'); ?></h2>

				<div class='page-section-heading__meta'>
					<a href='<?= get_the_permalink(get_page_by_path(__('aktualnosci', 'sputnik-wp-theme'))); ?>' class='page-section-heading__anchor' title='<?= __('Zobacz wszystkie','sputnik-wp-theme'); ?>'><?= __('Zobacz wszystkie','sputnik-wp-theme'); ?></a>

					<div class="page-section-heading__terms">
						<span><?= __('Filtry','sputnik-wp-theme'); ?>:</span>
						<?= function_exists('show_terms_with_childrens') ? show_terms_with_childrens('category') : null; ?>
					</div>
				</div>
			</header>

			<?php require CUSTOM_PARTS . '/loops/loop-news.php'; ?>
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

		<div class='page-sections-wrapper'>
			<section class='page-section attractions'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Atrakcje','sputnik-wp-theme'); ?></h2>
				</header>

				<?php require CUSTOM_PARTS . '/loops/loop-attractions.php'; ?>
			</section>

			<section class='page-section act-locally'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Działaj lokalnie','sputnik-wp-theme'); ?></h2>
				</header>

				<?php require CUSTOM_PARTS . '/loops/loop-act-locally.php'; ?>
			</section>
		</div>

		<section class='page-section emergency-numbers'>
			<header class="page-section-heading">
				<h2 class="page-section-heading__title"><?= __('Numery alarmowe','sputnik-wp-theme'); ?></h2>
			</header>

			<?php require CUSTOM_PARTS . '/modules/sliders/slider-emergency-numbers.php'; ?>
		</section>

		<section class="page-section poll-map-apps">
			<?php if(get_option('choose_poll_shortcode')) :
				$choose_poll_shortcode = get_option('choose_poll_shortcode');
				?>
				<div class='col-4 poll'>
					<header class="page-section-heading">
						<h2 class="page-section-heading__title"><?= __('Ankieta','sputnik-wp-theme'); ?></h2>
					</header>

					<?= do_shortcode( get_option('choose_poll_shortcode') ); ?>
				</div>
			<?php endif; ?>

			<?php if(get_option('google_maps_key') || (get_option('google_play_link') || get_option('app_store_link'))) : ?>
				<div class='col-8 map-apps'>
					<?php require CUSTOM_PARTS . '/modules/module-google-map.php'; ?>

					<?php require CUSTOM_PARTS . '/modules/module-mobile-apps.php'; ?>
				</div>
			<?php endif; ?>
		</section>
	</main><!-- #main -->

<?php get_footer();