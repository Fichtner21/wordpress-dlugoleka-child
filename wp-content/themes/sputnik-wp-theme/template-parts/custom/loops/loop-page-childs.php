<?php

$child_pages_args = array(
    'post_type' => 'page',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'post_parent' => get_the_ID(),
);

$child_pages_query = new WP_Query($child_pages_args);

$choosed_elements = get_field('choose_elements');

$isHasBackground = in_array('page-childs-background', $choosed_elements) ? 'pages-loop--background' : null;

if($child_pages_query->have_posts()) : ?>
    <div class='pages-loop <?= $isHasBackground; ?>'>
        <?php while($child_pages_query->have_posts()) : $child_pages_query->the_post();
            if(function_exists('child_pages_loop_template')) {
                is_front_page() ? child_pages_loop_template('h3') : child_pages_loop_template('h2', 'thumbnail', 70);
            } else {
                // nothing...
                // ! Add some placeholder structure
            }
        endwhile; ?>
    </div>
<?php endif; wp_reset_query(); wp_reset_postdata(); ?>