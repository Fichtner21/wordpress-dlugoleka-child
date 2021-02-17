<?php

$galleries_args = array(
    'post_type' => 'galerie',
    'posts_per_page' => 16,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
);

$galleries_query = new WP_Query($galleries_args);

if($galleries_query->have_posts()) : ?>
    <div class='posts-loop'>
        <?php while($galleries_query->have_posts()) : $galleries_query->the_post(); ?>
            <article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
                <figure class="post-thumbnail-wrapper">
                    <?php sputnik_wp_theme_post_thumbnail(array(250,250)); ?>
                </figure>

                <a href="<?= get_the_permalink(); ?>" class="post__button btn btn--primary" title='<?= __('Zobacz więcej','sputnik-wp-theme'); ?>'><?= __('Zobacz więcej','sputnik-wp-theme'); ?></a>

                <header class="post-heading">
                    <?php the_title( '<h2 class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

                    <div class="post-content">
                        <?= get_custom_excerpt(80); ?>
                    </div><!-- .entry-content -->
                </header><!-- .entry-header -->
            </article><!-- #post-<?= get_the_ID(); ?> -->
        <?php endwhile; ?>
    </div>
<?php endif; wp_reset_query(); wp_reset_postdata();