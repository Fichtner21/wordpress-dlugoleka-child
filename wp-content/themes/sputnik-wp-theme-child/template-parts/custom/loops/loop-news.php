<?php

$news_args = array(
    'post_type' => 'post',
    'posts_per_page' => 8,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
);

$news_query = new WP_Query($news_args);

if($news_query->have_posts()) : ?>
    <div class='posts-loop'>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda quasi voluptatibus voluptatem pariatur? Vero, impedit fugit. Eligendi sint autem quod! Ut officiis minus quam harum ipsam perspiciatis quos, unde nemo!
        <?php while($news_query->have_posts()) : $news_query->the_post();
            if(function_exists('custom_post_loop_template_dlugoleka')) {
                is_front_page() ? custom_post_loop_template('h3') : custom_post_loop_template_dlugoleka('h2');
            } else {
                // nothing...
                // ! Add some placeholder structure
            }
        endwhile; ?>
    </div>
<?php endif; wp_reset_query(); wp_reset_postdata(); ?>