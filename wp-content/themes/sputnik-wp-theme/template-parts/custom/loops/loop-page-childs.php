<?php

$child_pages_args = array(
    'post_type' => 'page',
    'posts_per_page' => '-1',
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post_parent' => get_the_ID(),
);

$child_pages_query = new WP_Query($child_pages_args);

$choosed_elements = get_field('choose_elements');

$isHasBackground = in_array('page-childs-background', $choosed_elements) ? 'pages-loop--background' : null;

$isSwiper = $child_pages_query->post_count > 4;

if($child_pages_query->have_posts()) : ?>
    <div class="pages-loop <?= $isHasBackground; ?> <?= $isSwiper ? 'swiper-container' : null; ?>">
        <?php if($isSwiper) : ?><div class="swiper-wrapper"><?php endif; ?>

            <?php while($child_pages_query->have_posts()) : $child_pages_query->the_post();
                if(function_exists('child_pages_loop_template')) {
                    is_front_page() ? child_pages_loop_template('h3') : child_pages_loop_template('h2', array(250,250), 70);
                } else {
                    // nothing...
                    // ! Add some placeholder structure
                }
            endwhile; ?>

        <?php if($isSwiper) : ?>

        </div>

        <?php function_exists('custom_swiper_arrows') ? custom_swiper_arrows() : null; ?>

        <?php endif; ?>
    </div>
<?php endif; wp_reset_query(); wp_reset_postdata(); ?>