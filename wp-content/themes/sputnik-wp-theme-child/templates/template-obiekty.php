<?php /* Template Name: Obiekty */

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<div class='container'>
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

            <?php require CUSTOM_PARTS . '/modules/module-objects.php'; ?>
		</div>
	</main><!-- #main -->

<?php get_footer();