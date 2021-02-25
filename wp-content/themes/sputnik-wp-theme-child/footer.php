<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sputnik_wp_theme
 */

?>

	<?php if(!is_front_page()) : ?>
		<section class='page-section emergency-numbers'>
			<div class='container'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Numery alarmowe','sputnik-wp-theme'); ?></h2>
				</header>

				<?php require CUSTOM_PARTS . '/modules/sliders/slider-emergency-numbers.php'; ?>

				<?php function_exists('custom_swiper_arrows') ? custom_swiper_arrows() : null; ?>
			</div>
		</section>
	<?php endif; ?>

	<footer class="footer">
		<div class="container">
			<?php require CUSTOM_PARTS . '/footer/footer-columns.php'; ?>

			<?php require CUSTOM_PARTS . '/footer/footer-bottom.php'; ?>
		</div>
	</footer>

	<?php if(get_field('eu_image', 'option')) : $eu_image = get_field('eu_image', 'option'); ?>
		<div class='container' style='text-align: center;'>
			<img src='<?= $eu_image["url"]; ?>' alt='<?= $eu_image["alt"]; ?>' class="eu-image">
		</div>
	<?php endif; ?>
</div><!-- #page-wrapper -->

<?php wp_footer(); ?>


<?php if(is_page('kontakt')) : ?>
	<script>
		grecaptcha.ready(function() {
			grecaptcha.execute('6LecWjsaAAAAAEOse8zcdG1kotODFs05U2DY3Jl1', {action: 'homepage'}).then(function(token) {
				document.getElementById('token').value = token;
			});
		});
	</script>
<?php endif; ?>

</body>
</html>
