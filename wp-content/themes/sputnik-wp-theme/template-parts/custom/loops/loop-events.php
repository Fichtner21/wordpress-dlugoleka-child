<?php

$today = current_time('mysql');
$cut_today = substr($today, 0,10);

$allEvents = array();

$events_args = array(
    'post_type' => 'wydarzenia',
    'posts_per_page' => '-1',
    'orderby' => 'DATE',
    'order' => 'DESC',
    'post_status' => 'publish',
);

$events_query = new WP_Query($events_args);

if($events_query->have_posts()) :
    while($events_query->have_posts()) : $events_query->the_post();
        $event_data = get_post();

        if($event_type['value'] == 'oneday') {
            $event_data->event_type_data = get_field('oneday_event');
            if(get_field('oneday_event', get_the_ID())) $event_data->date_start = get_field('oneday_event', get_the_ID())[0]['date_start'];
            if(get_field('oneday_event')) $event_data->localization = get_field('oneday_event')[0]['localization'];
        } elseif($event_type['value'] == 'endless') {
            $event_data->event_type_data = get_field('endless_event');
            if(get_field('endless_event', get_the_ID())) $event_data->date_start = get_field('endless_event', get_the_ID())[0]['date_start'];
            if(get_field('endless_event')) $event_data->localization = get_field('endless_event')[0]['localization'];
        } elseif($event_type['value'] == 'multiple') {
            $event_data->event_type_data = get_field('multiple_event');
            if(get_field('multiple_event', get_the_ID())) $event_data->date_start = get_field('multiple_event', get_the_ID())[0]['date_start'];
            if(get_field('multiple_event')) $event_data->localization = get_field('multiple_event')[0]['localization'];
        }

        array_push($allEvents, $event_data);
    endwhile;
endif;

$allEventsLast = array();

foreach($allEvents as $event) {
    if($event->date_start >= $cut_today) {
        array_push($allEventsLast, $event);
    }
}

if(!empty($allEvents)) : ?>
    <div class='posts-loop'>
        <?php foreach (array_slice(array_reverse($allEventsLast),0,4) as $event) : ?>
            <?php
                $ID = $event->ID;
                $event_title = $event->post_title;
                $permalink = get_the_permalink($ID);
                $event_thumbnail = get_the_post_thumbnail($ID, 'medium');
                $event_date_start = $event->date_start;
                $event_localization = $event->localization;
            ?>

            <article id="post-<?= $ID; ?>" <?php post_class(); ?>>
                <figure>
                    <?= $event_thumbnail; ?>
                </figure>

                <div class="post-bulk">
                    <header class="post-heading">
                        <div class="post-heading-meta">
                            <span class="post-date"><i class="fas fa-clock"></i> <?=  __('Kiedy?', 'sputnik-wp-theme') . ' <b>' . $event_date_start . '</b>'; ?></span>

                            <p class="post-localization"><i class="fas fa-map-marker-alt"></i> <?= __('Gdzie?', 'sputnik-wp-theme'); ?> <b><?= $event_localization; ?></b></p>
                        </div>

                        <h3 class='post-heading__title'><a href="<?= esc_url( $permalink ); ?>" rel="bookmark" title="<?= $event_title; ?>"><?= $event_title; ?></a></h3>
                    </header><!-- .entry-header -->

                    <div class="post-content">
                        <?= get_the_excerpt($ID); ?>
                    </div><!-- .entry-content -->

                    <footer class="post-footer">
                        <a href="<?= $permalink; ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . $event_title; ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
                    </footer><!-- .entry-footer -->
                </div>
            </article><!-- #post-<?= $ID; ?> -->
        <?php endforeach; ?>
    </div>
<?php endif; ?>