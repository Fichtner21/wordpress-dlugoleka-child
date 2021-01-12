<!-- Messages with animate and interaction [CPT: komunikaty] -->
<?php

$messages_args = array(
    'post_type' => 'komunikaty',
    'posts_per_page' => 6,
    'post_status' => 'published',
    'orderby' => 'date',
    'order' => 'DESC',
);

$messages_query = new WP_Query($messages_args);

if($messages_query->have_posts()) : ?>
    <aside class='module-messages'>
        <div class="container">
            <i class="fas fa-bullhorn"></i>

            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php while($messages_query->have_posts()) : $messages_query->the_post(); ?>
                        <div class="swiper-slide module-messages__content">
                            <p class="module-messages__title"><a href="<?= get_the_permalink(); ?>" title='<?= get_the_title(); ?>'><?= get_the_title(); ?></a></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <a href="<?= get_post_type_archive_link(get_post_type()); ?>" class="btn btn--secondary" title='<?= __('Więcej','sputnik-wp-theme'); ?>'><?= __('Więcej','sputnik-wp-theme'); ?></a>
        </div>
    </aside>
<?php endif; wp_reset_query(); wp_reset_postdata(); ?>