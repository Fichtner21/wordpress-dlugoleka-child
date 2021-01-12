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
        <?php while($act_locally_query->have_posts()) : $act_locally_query->the_post();
            if(function_exists('title_on_hover_loop_template')) {
                title_on_hover_loop_template('h3');
            } else {
                // nothing...
                // ! Add some placeholder structure
            }
        endwhile; ?>
    </div>
<?php endif; wp_reset_query(); wp_reset_postdata(); ?>