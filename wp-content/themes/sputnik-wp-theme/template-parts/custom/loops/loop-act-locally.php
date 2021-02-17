<?php

$act_locally_args = array(
    'post_type' => 'dzialaj-lokalnie',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);

$act_locally_query = new WP_Query($act_locally_args);

if($act_locally_query->have_posts()) : ?>
    <div class='posts-loop'>
        <?php while($act_locally_query->have_posts()) : $act_locally_query->the_post(); ?>
            <article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
                <figure class="post-thumbnail-wrapper">
                    <?php sputnik_wp_theme_post_thumbnail(array(250,250)); ?>
                </figure>

                <header class="post-heading">
                    <?php the_title( '<h3 class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
                </header><!-- .entry-header -->
            </article><!-- #post-<?= get_the_ID(); ?> -->
        <?php endwhile; ?>
    </div>
<?php endif; wp_reset_query(); wp_reset_postdata(); ?>