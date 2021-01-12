<!-- Custom links with icons / images -->
<?php if(has_nav_menu('menu-2')) {
    wp_nav_menu(
        array(
            'theme_location' => 'menu-2',
            'menu_id'        => 'top-bar-links',
            'container'      => false,
        )
    );
}