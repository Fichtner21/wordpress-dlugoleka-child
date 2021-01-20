<?php

if(!function_exists('sputnik_wp_theme_child_enqueue_style')) {
    function sputnik_wp_theme_child_enqueue_style() {
        wp_enqueue_style( 'child-style', get_stylesheet_uri(),
            array( 'parenthandle' ),
            wp_get_theme()->get('Version') // this only works if you have Version in the style header
        );
    }
    add_action( 'wp_enqueue_scripts', 'sputnik_wp_theme_child_enqueue_style' );
}

// Frontend assets
if(!function_exists('public_custom_assets_child')) {
	function public_custom_assets_child() {
		wp_enqueue_script( 'public-scripts-child', get_stylesheet_directory_uri() . '/dist/public/public.bundle.js' );
		wp_enqueue_style( 'public-styles-child', get_stylesheet_directory_uri() . '/dist/public/styles/style.css' );
	}

	add_action( 'wp_enqueue_scripts', 'public_custom_assets_child', 20 );
}
function sputnik_wp_theme_posted_on_dlugoleka() {
    $post_type = get_post_type();

    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$sr.</time>';

    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() )
    );

    $posted_on = sprintf(
        /* translators: %s: post date. */
        esc_html_x( 'Data publikacji: %s', 'post date', 'sputnik-wp-theme' ),
        '<span class="post-date__date">' . $time_string . '</span>'
    );

    if($post_type == 'wydarzenia') {
        echo '<span class="post-date"><i class="fas fa-clock"></i> '. __('Kiedy?', 'sputnik-wp-theme') . ' ' . get_field('date_start') . '</span>';
    } else {
        echo '<span class="post-date"><i class="fas fa-clock"></i> '. $posted_on . '</span>';
    }
}

function custom_post_loop_template_dlugoleka($heading_level = 'h2', $thumb_size = 'medium', $excerpt_length = 250, $categories_count = false) {
	$post_type = get_post_type(); ?>
	<article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
        <figure>
            <?php sputnik_wp_theme_post_thumbnail($thumb_size); ?>
        </figure>
        <section class="post-bulk">
            <header class="post-heading">
                <div class="post-heading-meta">
                    <?php sputnik_wp_theme_posted_on_dlugoleka(); ?>
                </div>
                <?php the_title( '<'. $heading_level .' class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></'. $heading_level .'>' ); ?>


            </header><!-- .entry-header -->

            <div class="post-content">
                <?= get_custom_excerpt($excerpt_length); ?>
            </div><!-- .entry-content -->

            <footer class="post-footer">
                <!-- Category -->
                <?php sputnik_wp_theme_categories($categories_count); ?>

                <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme'); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
            </footer><!-- .entry-footer -->
        </section>
	</article><!-- #post-<?= get_the_ID(); ?> -->
	<?php
    }




