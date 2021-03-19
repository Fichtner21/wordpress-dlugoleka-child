<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package sputnik_wp_theme
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found container">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Ups! Nie można znaleźć tej strony.', 'sputnik-wp-theme' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'Wygląda na to, że nic nie znaleziono w tej lokalizacji. Może wypróbuj jeden z poniższych linków lub wyszukaj?', 'sputnik-wp-theme' ); ?></p>

					<?php get_search_form();

					the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Najczęściej używane kategorie', 'sputnik-wp-theme' ); ?></h2>

						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div><!-- .widget -->

					<?php
					/* translators: %1$s: smiley */
					$sputnik_wp_theme_archive_content = '<p>' . sprintf( esc_html__( 'Spróbuj poszukać w miesięcznych archiwach. %1$s', 'sputnik-wp-theme' ), convert_smilies( ':)' ) ) . '</p>';

					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$sputnik_wp_theme_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
					?>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php get_footer();