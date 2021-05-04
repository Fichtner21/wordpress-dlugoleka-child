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
        if(get_field('oneday_event')[0]['localization']) {
            $date_start = get_field('oneday_event')[0]['date_start'];
        } elseif(get_field('multiple_event')[0]['date_start']) {
            $date_start = get_field('multiple_event')[0]['date_start'];
        } elseif(get_field('endless_event')[0]['date_start']) {
            $date_start = get_field('endless_event')[0]['date_start'];
        }

        echo '<span class="post-date"><i class="fas fa-clock"></i> '. __('Kiedy?', 'sputnik-wp-theme') . ' ' . $date_start . '</span>';
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

        <div class="post-bulk">
            <header class="post-heading">
                <div class="post-heading-meta">
                    <?php sputnik_wp_theme_posted_on_dlugoleka(); ?>

                    <?php if(get_field('oneday_event')[0]['localization']) : $localization = get_field('oneday_event')[0]['localization']; ?>
                        <p class="post-localization"><i class="fas fa-map-marker-alt"></i> <?= __('Gdzie?', 'sputnik-wp-theme'); ?> <?= $localization; ?></p>
                    <?php elseif(get_field('multiple_event')[0]['localization']) : $localization = get_field('multiple_event')[0]['localization']; ?>
                        <p class="post-localization"><i class="fas fa-map-marker-alt"></i> <?= __('Gdzie?', 'sputnik-wp-theme'); ?> <?= $localization; ?></p>
                    <?php elseif(get_field('endless_event')[0]['localization']) : $localization = get_field('endless_event')[0]['localization']; ?>
                        <p class="post-localization"><i class="fas fa-map-marker-alt"></i> <?= __('Gdzie?', 'sputnik-wp-theme'); ?> <?= $localization; ?></p>
                    <?php endif; ?>
                </div>
                <?php the_title( '<'. $heading_level .' class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></'. $heading_level .'>' ); ?>
            </header><!-- .entry-header -->

            <div class="post-content">
                <?= get_custom_excerpt($excerpt_length); ?>
            </div><!-- .entry-content -->

            <footer class="post-footer">
                <!-- Category -->
                <?php sputnik_wp_theme_categories($categories_count); ?>

                <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
            </footer><!-- .entry-footer -->
        </div>
	</article><!-- #post-<?= get_the_ID(); ?> -->
	<?php
    }


    // Default custom post template
if(!function_exists('title_on_hover_loop_template')) {
    function title_on_hover_loop_template($heading_level = 'h2', $thumb_size = 'thumbnail') {
		$post_type = get_post_type(); ?>
		<article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
			<?php sputnik_wp_theme_post_thumbnail($thumb_size); ?>

			<header class="post-heading">
				<?php the_title( '<'. $heading_level .' class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></'. $heading_level .'>' ); ?>
			</header><!-- .entry-header -->
		</article><!-- #post-<?= get_the_ID(); ?> -->
    <?php }
}



// Fromat unit sizes in attachments
if(!function_exists('formatSizeUnits')) {
	function formatSizeUnits($bytes) {
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes . ' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes . ' byte';
		} else {
			$bytes = '0 bytes';
		}

		return $bytes;
	}
}

function dl_upload_mime_types($mime_types){
    $mime_types['pdf'] = 'application/pdf';

    return $mime_types;
}
add_filter('upload_mimes', 'dl_upload_mime_types', 1, 1);


// Wyłączenie gutenberga dla Mapy Interaktywnej (dla konkretnego template)
add_filter( 'use_block_editor_for_post', 'my_disable_gutenberg', 10, 2 );

function my_disable_gutenberg( $can_edit, $post ) {
  if(get_page_template_slug(  ) == 'template-parts/content-map.php') {
      return false;
  } elseif(get_page_template_slug(  ) == 'declaration.php') {
      return false;
  }
  return true;
}

// rmeove cf7 auto p and br
add_filter( 'wpcf7_autop_or_not', '__return_false' );

require get_stylesheet_directory() . '/inc/posts-ajax/posts-ajax-my.php';