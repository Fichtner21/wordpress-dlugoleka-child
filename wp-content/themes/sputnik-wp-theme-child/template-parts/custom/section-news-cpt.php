<?php $posts_sections = get_field('posts_sections') ? get_field('posts_sections') : 'post'; ?>

<section class='page-section news'>
  <div class='posts-front'>
    <header class="page-section-heading">
      <h2 class="page-section-heading__title"><?= __('Aktualności','sputnik-wp-theme'); ?></h2>

      <a href='<?= get_post_type_archive_link($posts_sections) ?>' class='page-section-heading__anchor' title='<?= __('Zobacz wszystkie','sputnik-wp-theme'); ?>'><?= __('Zobacz wszystkie','sputnik-wp-theme'); ?></a>
    </header>

    <?php

    $news_args = array(
        'post_type' => $posts_sections,
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $news_query = new WP_Query($news_args);

    global $news_query_cpt;

    $news_query_cpt = $news_query;

    if($news_query->have_posts()) : ?>
        <div class='posts-loop'>

            <?php while($news_query->have_posts()) : $news_query->the_post(); ?>

            <article id="post-<?= get_the_ID(); ?>" <?php post_class() . ' post'; ?>>
                  <div class="post-others-left">
                    <?php if (has_post_thumbnail( get_the_ID() ) ) { ?>
                            <figure><?php sputnik_wp_theme_post_thumbnail('medium');  ?></figure>
                    <?php } else { ?>
                            <figure>
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/app/public/images/dlugoleka-logo.png" title="<?php get_bloginfo('name'); ?>" alt="<?php get_bloginfo('name'); ?>"/>
                            </figure>
                    <?php } ?>
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
                        <div class="category-list">

                        <?php

                        $taxonomy = 'kategorie-' . $posts_sections;

                        $categories = get_terms( array(
                          'taxonomy' => $taxonomy,
                          'hide_empty' => false,
                        ) );

                        $output = '';

                        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                          echo '<div class="category-list">Kategorie:';
                            foreach( $categories as $category ) {
                              $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'Zobacz wszystkie wpisy w: %s', 'textdomain' ), $category->name ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a>';
                            }
                            echo trim( $output );
                          echo '</div>';
                        } ?>
                        </div>

                        <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
                      </footer><!-- .entry-footer -->
                  </section>
              </article><!-- #post-<?= get_the_ID(); ?> -->

            <?php endwhile; ?>

        </div>
    <?php endif; wp_reset_query(); wp_reset_postdata(); ?>
</section>