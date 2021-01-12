<?php

// Deactivate and Delete default plugins
if(!function_exists('deactivate_default_plugins')) {
    function deactivate_default_plugins() {
        $plugins = ['hello.php', 'akismet/akismet.php'];

        deactivate_plugins($plugins);
        delete_plugins($plugins);
    }
}

// If options is not set then function not firing
if(!function_exists('set_options_on_activate')) {
    function set_options_on_activate() {
        $sputnik_set_options = get_option('sputnik_wp_theme_set_options');

        $checkIsOptionsSet = $sputnik_set_options == false || !isset($sputnik_set_options) || empty($sputnik_set_options) || $sputnik_set_options != 1;

        // Set options only once with theme activate
        if($checkIsOptionsSet == true) {
            // delete the default comment, post and page
            wp_delete_comment( 1 );
            wp_delete_post( 1, TRUE );
            wp_delete_post( 2, TRUE );

            // Create default pages homepage & news page => set them in options > reading as main
            update_option('show_on_front', 'page');

            if(function_exists('create_pages_on_fly')) {
                create_pages_on_fly('Strona główna');
                create_pages_on_fly('Aktualności');
            }

            // set the options to change
            $option = array(
                // we don't want no description
                'blogdescription'               => '',
                // change category base
                'category_base'                 => '/kategoria',
                // change tag base
                'tag_base'                      => '/tag',
                // change the permalink structure
                'permalink_structure'           => '/%postname%/',
                // don't use those ugly smilies
                'use_smilies'                   => ''
            );

            // change the options!
            foreach ( $option as $key => $value ) {
                update_option( $key, $value );
            }

            // Delete default plugins
            deactivate_default_plugins();

            // flush rewrite rules because we changed the permalink structure
            global $wp_rewrite;

            $wp_rewrite->flush_rules();

            update_option('sputnik_wp_theme_set_options', 1);
        }
    }
    add_action('admin_init', 'set_options_on_activate');
}