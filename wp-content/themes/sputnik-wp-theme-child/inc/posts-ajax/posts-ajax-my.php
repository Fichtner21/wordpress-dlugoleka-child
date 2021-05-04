<?php

if(!function_exists('ajax_posts_filter_function')) {
    function ajax_posts_filter_function() {
        if ( !wp_verify_nonce( $_REQUEST['nonce'], "filter_posts_nonce")) exit("Wystąpił błąd!");

        $choosed_post_type; $taxonomy; $pageID;

        $pageID = $_REQUEST['page_id'];

        $page = get_page($pageID);

        $posts_sections = get_post_meta($pageID, 'posts_sections')[0];

        if(!empty($posts_sections)) {
            $choosed_post_type = $posts_sections;
            $taxonomy = get_option($choosed_post_type);
        } else {
            $choosed_post_type = 'post';
            $taxonomy = 'category';
        }

        $args = array(
            'post_type' => $choosed_post_type,
            'orderby' => 'date', // we will sort posts by date
            'order'	=> $_POST['date'], // ASC or DESC
            'posts_per_page' => 4
        );

        // for taxonomies / categories
        if( isset( $_POST['categoryfilter'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $_POST['categoryfilter']
                )
            );
        }

        $query = new WP_Query( $args );

        if( $query->have_posts() ) :
            while( $query->have_posts() ): $query->the_post(); ?>
                <article id="post-<?= get_the_ID(); ?>" <?php post_class() . ' post'; ?>>
                    <div class="post-others-left">
                    <?php if (has_post_thumbnail( get_the_ID() ) ) { ?>
                            <figure>
                                <?php sputnik_wp_theme_post_thumbnail('medium'); ?>
                            </figure>
                        <?php } else { ?>
                            <figure>
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/app/public/images/dlugoleka-logo.png" title="<?php get_bloginfo('name'); ?>" alt="<?php get_bloginfo('name'); ?>"/>
                            </figure>
                        <?php } ?>
                    </div>

                    <div class="post-bulk">
                        <header class="post-heading">
                            <div class="post-heading-meta">
                                <?php echo '<i class="fas fa-clock"></i> Data publikacji: ' . get_the_date('d.m.Y') . 'r.'; ?>
                            </div>

                            <?php the_title( '<div class="post-heading__title"><h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3></div>' ); ?>
                        </header><!-- .entry-header -->

                        <div class="post-content">
                            <?= get_custom_excerpt(200); ?>
                        </div><!-- .entry-content -->

                        <footer class="post-footer">
                            <?php $categories;

                            if(is_front_page()) {
                                $categories = get_the_category();
                            } else {
                                $categories = get_the_terms(get_the_ID(), $taxonomy);
                            }

                            $separator = ', ';
                            $output = '';
                            if ( ! empty( $categories ) ) {
                                foreach( $categories as $category ) {
                                        $output .= '<div class="category-list">Kategoria: <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'Zobacz wszystkie wpisy w: %s', 'textdomain' ), $category->name ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a></div>';

                                }
                                echo trim( $output, $separator );
                            }
                            ?>
                            <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
                        </footer><!-- .entry-footer -->
                    </div>
                </article><!-- #post-<?= get_the_ID(); ?> -->
        <?php endwhile; wp_reset_postdata();

        else :
            echo 'Nie znaleziono wpisów.';
        endif;

        die();
    }

    add_action('wp_ajax_filter_posts', 'ajax_posts_filter_function'); // wp_ajax_{ACTION HERE}
    add_action('wp_ajax_nopriv_filter_posts', 'ajax_posts_filter_function');
}