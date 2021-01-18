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

	<?php if(!is_front_page()) require CUSTOM_PARTS . '/modules/sliders/slider-emergency-numbers.php'; ?>

	<footer class="footer">
		<div class="container">
			<?php require CUSTOM_PARTS . '/footer/footer-columns.php'; ?>

			<?php require CUSTOM_PARTS . '/footer/footer-bottom.php'; ?>
		</div>
	</footer>

	<?php if(get_field('eu_image', 'option')) : $eu_image = get_field('eu_image', 'option'); ?>
		<div class='container' style='text-align: center;'>
			<img src='<?= $eu_image["url"]; ?>' alt='<?= $eu_image["alt"]; ?>'>
		</div>
	<?php endif; ?>
</div><!-- #page-wrapper -->

<?php wp_footer(); ?>

</body>
</html>
