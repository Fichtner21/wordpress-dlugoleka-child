<?php /* Template Name: Ścieżki */

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<div class='container'>
			<h1 class="screen-reader-tex"><?= get_the_title(); ?></h1>

			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

            <?php require CUSTOM_PARTS . '/modules/module-paths.php'; ?>
		</div>
	</main><!-- #main -->

<?php get_footer();