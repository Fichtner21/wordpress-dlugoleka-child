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
        <?php while($attractions_query->have_posts()) : $attractions_query->the_post();
            if(function_exists('title_on_hover_loop_template')) {
                title_on_hover_loop_template('h3');
            } else {
                // nothing...
                // ! Add some placeholder structure
            }
        endwhile; ?>
    </div>
<?php endif; wp_reset_query(); wp_reset_postdata(); ?>