<?php
// wydarzenia CPT
if(!function_exists('custom_post_type_wydarzenia')) {
    function custom_post_type_wydarzenia() {
        $post_type_name = 'wydarzenia';
        $taxonomy_name = 'kategorie-' . $post_type_name;

        $labels = array(
            'name'                => _x( 'Wydarzenia', 'Post Type General Name', 'sputnik-wp-theme' ),
            'singular_name'       => _x( 'Wydarzenie', 'Post Type Singular Name', 'sputnik-wp-theme' ),
            'menu_name'           => __( 'Wydarzenia', 'sputnik-wp-theme' ),
            'parent_item_colon'   => __( 'Nadrzędne wydarzenie', 'sputnik-wp-theme' ),
            'all_items'           => __( 'Wszystkie wydarzenia', 'sputnik-wp-theme' ),
            'view_item'           => __( 'Zobacz wydarzenie', 'sputnik-wp-theme' ),
            'add_new_item'        => __( 'Dodaj nowe wydarzenie', 'sputnik-wp-theme' ),
            'add_new'             => __( 'Dodaj nowe', 'sputnik-wp-theme' ),
            'edit_item'           => __( 'Edytuj wydarzenie', 'sputnik-wp-theme' ),
            'update_item'         => __( 'Zaaktualizuj wydarzenie', 'sputnik-wp-theme' ),
            'search_items'        => __( 'Wyszukaj wydarzenie', 'sputnik-wp-theme' ),
            'not_found'           => __( 'Nie znaleziono', 'sputnik-wp-theme' ),
            'not_found_in_trash'  => __( 'Nie znaleziono w koszu', 'sputnik-wp-theme' ),
        );

        // Set other options for Custom Post Type
        $args = array(
            'label'               => __( 'wydarzenia', 'sputnik-wp-theme' ),
            'description'         => '',
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            // You can associate this CPT with a taxonomy or custom taxonomy.
            'taxonomies'          => array( $taxonomy_name ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 200,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
            // Set cpt icon
            'menu_icon'           => 'dashicons-arrow-right-alt',
        );

        custom_register_post_type_with_option($post_type_name, $taxonomy_name, $args);
    }

    add_action( 'init', 'custom_post_type_wydarzenia', 0 );
}

if(!function_exists('tax_custom_post_type_wydarzenia_categories')) {
    //create a custom taxonomy name it "type" for your posts
    function tax_custom_post_type_wydarzenia_categories() {
        $post_type_name = 'wydarzenia';
        $taxonomy_name = 'kategorie-' . $post_type_name;

        $labels = array(
            'name' => _x( 'Kategorie wydarzenia', 'taxonomy general name', 'sputnik-wp-theme' ),
            'singular_name' => _x( 'Kategoria', 'taxonomy singular name', 'sputnik-wp-theme' ),
            'search_items' =>  __( 'Wyszukaj kategorie', 'sputnik-wp-theme' ),
            'all_items' => __( 'Wszystkie kategorie', 'sputnik-wp-theme' ),
            'parent_item' => __( 'Nadrzędna kategoria', 'sputnik-wp-theme' ),
            'parent_item_colon' => __( 'Nadrzędna kategoria:', 'sputnik-wp-theme' ),
            'edit_item' => __( 'Edytuj kategorie', 'sputnik-wp-theme' ),
            'update_item' => __( 'Zaaktualizuj kategorie', 'sputnik-wp-theme' ),
            'add_new_item' => __( 'Dodaj nową kategorie', 'sputnik-wp-theme' ),
            'new_item_name' => __( 'Nowa nazwa kategorii', 'sputnik-wp-theme' ),
            'menu_name' => __( 'Kategorie', 'sputnik-wp-theme' ),
        );

        register_taxonomy(
            $taxonomy_name,
            array($post_type_name),

            array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => true,
                'show_in_rest' => true,
            ));
    }

    add_action( 'init', 'tax_custom_post_type_wydarzenia_categories', 0 );
}

// Pass data all events
if(!function_exists('all_events_js_data')) {
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

            $event_type = get_field('event_type');

            $event_data->event_type = $event_type;

            $event_data->event_permalink = get_the_permalink($event_data->ID);

            $event_data->event_thumbnail = get_the_post_thumbnail_url($event_data->ID);

            if($event_type['value'] == 'oneday') {
                $event_data->event_type_data = get_field('oneday_event');
            } elseif($event_type['value'] == 'endless') {
                $event_data->event_type_data = get_field('endless_event');
            } elseif($event_type['value'] == 'multiple') {
                $event_data->event_type_data = get_field('multiple_event');
            }

            array_push($allEvents, $event_data);
        endwhile;
    endif;

    update_option('allEvents', $allEvents);

    function all_events_js_data() {
        $variables = array(
            'allEvents' => get_option('allEvents')
        );

        wp_localize_script('public-scripts', 'allEvents', $variables);
    }

    add_action('wp_enqueue_scripts', 'all_events_js_data');
}