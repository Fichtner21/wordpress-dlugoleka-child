<?php
// galerie CPT
if(!function_exists('custom_post_type_galerie')) {
    function custom_post_type_galerie() {
        $post_type_name = 'galerie';
        $taxonomy_name = 'kategorie-' . $post_type_name;
        $post_type_rewrite = $post_type_name . '-' . 'lista';

        $labels = array(
            'name'                => _x( 'Galerie', 'Post Type General Name', 'sputnik-wp-theme' ),
            'singular_name'       => _x( 'Galeria', 'Post Type Singular Name', 'sputnik-wp-theme' ),
            'menu_name'           => __( 'Galerie', 'sputnik-wp-theme' ),
            'parent_item_colon'   => __( 'Nadrzędna galeria', 'sputnik-wp-theme' ),
            'all_items'           => __( 'Wszystkie galerie', 'sputnik-wp-theme' ),
            'view_item'           => __( 'Zobacz galerie', 'sputnik-wp-theme' ),
            'add_new_item'        => __( 'Dodaj nową galerie', 'sputnik-wp-theme' ),
            'add_new'             => __( 'Dodaj nową', 'sputnik-wp-theme' ),
            'edit_item'           => __( 'Edytuj galerie', 'sputnik-wp-theme' ),
            'update_item'         => __( 'Zaaktualizuj galerie', 'sputnik-wp-theme' ),
            'search_items'        => __( 'Wyszukaj galerie', 'sputnik-wp-theme' ),
            'not_found'           => __( 'Nie znaleziono', 'sputnik-wp-theme' ),
            'not_found_in_trash'  => __( 'Nie znaleziono w koszu', 'sputnik-wp-theme' ),
        );

        // Set other options for Custom Post Type
        $args = array(
            'label'               => __( 'Galerie', 'sputnik-wp-theme' ),
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
            'rewrite'             => array('slug' => $post_type_rewrite),
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

        // Registering your Custom Post Type
        custom_register_post_type_with_option($post_type_name, $taxonomy_name, $args);
    }

    add_action( 'init', 'custom_post_type_galerie', 0 );
}

if(!function_exists('tax_custom_post_type_galerie_categories')) {
    //create a custom taxonomy name it "type" for your posts
    function tax_custom_post_type_galerie_categories() {
        $post_type_name = 'galerie';
        $taxonomy_name = 'kategorie-' . $post_type_name;

        $labels = array(
            'name' => _x( 'Kategorie galerii', 'taxonomy general name', 'sputnik-wp-theme' ),
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

    add_action( 'init', 'tax_custom_post_type_galerie_categories', 0 );
}