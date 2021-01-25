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

    add_action('wp_ajax_myfilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE}
    add_action('wp_ajax_nopriv_myfilter', 'misha_filter_function');

    function misha_filter_function(){
        $args = array(
            'orderby' => 'date', // we will sort posts by date
            'order'	=> $_POST['date'], // ASC or DESC
            'posts_per_page' => 4
        );

        // for taxonomies / categories
        if( isset( $_POST['categoryfilter'] ) )
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $_POST['categoryfilter']
                )
            );

            // if post thumbnail is set
        // if( isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
        // $args['meta_query'][] = array(
        //     'key' => '_thumbnail_id',
        //     'compare' => 'EXISTS'
        // );

        $query = new WP_Query( $args );

        if( $query->have_posts() ) :
            while( $query->have_posts() ): $query->the_post();
                //echo '<h2>' . $query->post->post_title . '</h2>';
                ?>
                <article id="post-<?= get_the_ID(); ?>" <?php post_class() . ' post'; ?>>
                    <div class="post-others-left">
                    <?php
                        if (has_post_thumbnail( get_the_ID() ) ){ ?>
                            <figure>
                            <?php
                                sputnik_wp_theme_post_thumbnail('medium');
                            ?>
                            </figure>
                            <?php
                        } else { ?>
                            <figure>
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/app/public/images/dlugoleka-logo.png" title="<?php get_bloginfo('name'); ?>" alt="<?php get_bloginfo('name'); ?>"/>
                            </figure>
                        <?php
                        }
                    ?>

                    </div>
                    <section class="post-bulk">
                        <header class="post-heading">
                                <div class="post-heading-meta">
                                        <?php echo '<i class="fas fa-clock"></i> Data publikacji: ' . get_the_date('d.m.Y') . 'r.'; ?>
                                </div>
                                <?php the_title( '<div class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></div>' ); ?>

                        </header><!-- .entry-header -->

                        <div class="post-content">
                                <?= get_custom_excerpt(200); ?>

                        </div><!-- .entry-content -->

                        <footer class="post-footer">
                                <!-- Category -->

                            <?php
                            $categories = get_the_category();
                            $separator = ', ';
                            $output = '';
                            if ( ! empty( $categories ) ) {
                                foreach( $categories as $category ) {
                                        $output .= '<div class="category-list">Kategoria: <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a></div>';

                                }
                                echo trim( $output, $separator );
                            } ?>


                        <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme'); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
                        </footer><!-- .entry-footer -->
                    </section>
                </article><!-- #post-<?= get_the_ID(); ?> -->
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo 'No posts found';
        endif;

        die();
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