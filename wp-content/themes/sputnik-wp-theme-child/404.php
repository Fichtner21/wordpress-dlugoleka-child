<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package sputnik_wp_theme
 */

get_header(); ?>

	<main id="primary" class="site-main site-error">

		<section class="error-404 not-found container">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Ups! Nie można znaleźć tej strony.', 'sputnik-wp-theme' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo(); ?>">
        Wróć do strony głównej</a> lub <span id="go-search" title="wyszukiwarka">użyj wyszukiwarki</span>
					<script>
          jQuery(document).on('click', '#go-search', function(event){
            event.preventDefault();
            jQuery('.sputnik-search-form__toggle').click();
          })
        </script>			
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php get_footer();