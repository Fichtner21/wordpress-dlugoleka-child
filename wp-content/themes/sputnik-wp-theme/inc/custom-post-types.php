<?php

if(!get_option('our_post_types')) add_option('our_post_types');

if(!function_exists('custom_register_post_type_with_option')) {
    function custom_register_post_type_with_option($post_type_name, $taxonomy_name = '', $args) {
        // Registering your Custom Post Type
        register_post_type( $post_type_name, $args );

        if(!get_option($post_type_name)) add_option($post_type_name, $taxonomy_name);

        $our_post_types = get_option('our_post_types');

        $our_post_types_arr = explode(',', $our_post_types);

        // $post_type_array = array(
        //     'post-type' => $post_type_name,
        //     'taxonomy' => $taxonomy_name,
        // );

        if(is_array($our_post_types_arr) && !array_search($post_type_name, $our_post_types_arr )) {
            update_option('our_post_types', $our_post_types . ',' . $post_type_name);
        } elseif(empty($our_post_types_arr)) {
            update_option('our_post_types', $post_type_name);
        }
    }
}

$custom_post_types_files = scandir(CUSTOM_INC . '/custom-post-types');

foreach($custom_post_types_files as $file) {
    if($file != '.' && $file != '..') {
        $custom_post_type_name = trim(str_replace('custom-post-type-', '', $file));

        if(get_option('choose_cpt_' . str_replace('.php', '', $custom_post_type_name))) require CUSTOM_INC . '/custom-post-types/custom-post-type-' . $custom_post_type_name;
    }
}

if(!function_exists('custom_post_types_admin_template')) {
    function custom_post_types_admin_template() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'Nie posiadasz odpowiednich uprawnień by przeglądać tą stronę.', 'sputnik-wp-theme' ) );
        }
        echo '<div class="wrap">';
        echo '<p>'. __('Wybierz odpowiedni dział z menu.','sputnik-wp-theme') .'</p>';
        echo '</div>';
    }
}

/* * Adding a menu to contain the custom post types */
if(!function_exists('custom_post_types_admin_menu')) {
    function custom_post_types_admin_menu() {
        add_menu_page(
            'Działy',
            'Działy',
            'read',
            'dzialy',
            'custom_post_types_admin_template',
            'dashicons-format-aside',
            3
        );

        $post_types = explode(',', get_option('our_post_types'));

        foreach($post_types as $post_type) {
            if(!empty($post_type)) {
                add_submenu_page( 'dzialy', ucfirst( $post_type ), ucfirst( $post_type ), 'manage_options', 'edit.php?post_type=' . $post_type, null, null );
            }
        }
     }

     add_action( 'admin_menu', 'custom_post_types_admin_menu' );
}


if(!function_exists('add_extra_button')) {
    function add_extra_button($where) {
        global $post_type_object;

        $post_types = explode(',',get_option('our_post_types'));

        foreach($post_types as $post_type) {
            if ($post_type_object->name === $post_type) {
                $taxonomy_of_post_type = get_option($post_type);
                $taxonomy_archive = "edit-tags.php?taxonomy=$taxonomy_of_post_type&post_type=$post_type";
                ?>
                <a href='<?= $taxonomy_archive; ?>' class='button post-type-add-taxonomies' title='<?= __('Kategorie','sputnik-wp-theme'); ?>'><?= __('Kategorie','sputnik-wp-theme'); ?></a>
            <?php }
        }
    }
    add_action('manage_posts_extra_tablenav', 'add_extra_button');
}