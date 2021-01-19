<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sputnik_wp_theme
 */

?>

<?php require CUSTOM_PARTS . '/header/header-head.php'; ?>

<div id="page-wrapper" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Przejdź do treści', 'sputnik-wp-theme' ); ?></a>

	<?php require CUSTOM_PARTS . '/modules/module-messages.php'; ?>

	<header id="masthead" class="site-header">
		<div class="container">
			<div class="site-header__top">
				<nav class='wcag-nav' id='js-wcag-navigation'>
					<button class="wcag-nav-toggle" id='js-wcag-nav-toggle' title='<?= __('Menu górne','sputnik-wp-theme'); ?>'>
						<span class="screen-reader-text"><?= __('Menu górne','sputnik-wp-theme'); ?></span>

						<i class="fas fa-info"></i>
					</button>

					<div class='wcag-nav__content'>
						<?php require CUSTOM_PARTS . '/header/header-custom-links.php'; ?>

						<?php require CUSTOM_PARTS . '/header/header-wcag-fonts.php'; ?>

						<?php require CUSTOM_PARTS . '/header/header-wcag-contrast.php'; ?>
					</div>
				</nav>

				<?php require CUSTOM_PARTS . '/modules/module-social-media.php'; ?>

			</div>

			<div class='site-header__bottom'>
				<?php require CUSTOM_PARTS . '/header/header-logo.php'; ?>

				<?php require CUSTOM_PARTS . '/header/header-navigation.php'; ?>

				<!-- Sputnik Search plugin search form || Get search form default -->
				<?= shortcode_exists( 'sputnik_search_form' ) ? do_shortcode( '[sputnik_search_form]' ) : get_search_form(); ?>
			</div>
		</div>
	</header><!-- #masthead -->
