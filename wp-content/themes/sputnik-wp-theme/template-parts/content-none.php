<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sputnik_wp_theme
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nic nie znaleziono', 'sputnik-wp-theme' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) :
			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Gotowy by opublikować swój pierwszy wpis? <a href="%1$s">Zacznij tutaj</a>.', 'sputnik-wp-theme' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Przepraszamy, ale nic nie pasuje do wyszukiwanych haseł. Spróbuj ponownie, używając innych słów kluczowych.', 'sputnik-wp-theme' ); ?></p>

			<?php get_search_form();

		else : ?>

			<p><?php esc_html_e( 'Wygląda na to, że nie możemy znaleźć tego, czego szukasz. Być może wyszukiwanie pomoże.', 'sputnik-wp-theme' ); ?></p>

			<?php get_search_form();

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
