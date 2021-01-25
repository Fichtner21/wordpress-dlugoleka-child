<?php

$events_args = array(
    'post_type' => 'wydarzenia',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);

$events_query = new WP_Query($events_args);

if($events_query->have_posts()) : ?>
    <div class='posts-loop'>
        <?php while($events_query->have_posts()) : $events_query->the_post();
            if(function_exists('custom_post_loop_template_dlugoleka')) {
                custom_post_loop_template_dlugoleka('h3', 'medium', 140);
            } else {
                // nothing...
                // ! Add some placeholder structure
            }
        endwhile; ?>
    </div>
<?php endif; wp_reset_query(); wp_reset_postdata(); ?>