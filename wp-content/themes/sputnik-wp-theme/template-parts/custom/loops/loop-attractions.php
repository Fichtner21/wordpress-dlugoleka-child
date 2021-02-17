<?php

$attractions_args = array(
    'post_type' => 'atrakcje',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);

$attractions_query = new WP_Query($attractions_args);

if($attractions_query->have_posts()) : ?>
    <div class='posts-loop'>
        <?php while($attractions_query->have_posts()) : $attractions_query->the_post(); ?>
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