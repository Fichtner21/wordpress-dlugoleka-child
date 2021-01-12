<?php

// This theme uses wp_nav_menu() in one location.
register_nav_menus(
    array(
        'menu-1' => esc_html__( 'Menu główne', 'sputnik-wp-theme' ),
        'menu-2' => esc_html__( 'Pasek górny', 'sputnik-wp-theme' ),
        'menu-3' => esc_html__( 'Pod bannerem głównym', 'sputnik-wp-theme' ),
        'menu-4' => esc_html__( 'Numery alarmowe', 'sputnik-wp-theme' ),
        'menu-5' => esc_html__( 'Stopka 1', 'sputnik-wp-theme' ),
        'menu-6' => esc_html__( 'Stopka 2', 'sputnik-wp-theme' ),
        'menu-7' => esc_html__( 'Stopka 3', 'sputnik-wp-theme' ),
    )
);

// Add swiper slide class to menus with swiper-wrapper class
if(!function_exists('menu_item_swiper_slide_class')) {
    function menu_item_swiper_slide_class ( $classes, $item, $args, $depth ) {
        if($args->menu_class == 'swiper-wrapper' || strpos($args->menu_class, 'swiper-wrapper')) {
			$classes[] = 'swiper-slide';
        }

        return $classes;
    }
    add_filter ( 'nav_menu_css_class', 'menu_item_swiper_slide_class', 10, 4 );
}

// Add icons to page boxes menus
if(!function_exists('menu_item_page_boxes_images')) {
	function getFullPath($url){
		return realpath(str_replace(get_bloginfo('url'), '.', $url));
	}

	function requireToVariable($file){
		ob_start();

		require $file;

		return ob_get_clean();
    }

    // ! BAD TITLES FIX IT
    function menu_item_page_boxes_images ( $items, $args ) {
        // loop
        foreach( $items as $item ) {
            $menu_item_icon = get_field('menu_item_icon', $item);
            $menu_item_image = get_field('menu_item_image', $item);
            $menu_item_awesome = get_field('menu_item_awesome', $item);

            if(!empty($menu_item_icon) && $menu_item_icon != null) {
                $menu_item_icon_URL = $menu_item_icon['url'];

                $menu_item_icon_PATH = getFullPath($menu_item_icon_URL);

                $require_svg_icon = requireToVariable($menu_item_icon_PATH);

                $item->attr_title = $item->title;

                $item->title = $require_svg_icon . '<span class="menu-item__title menu-item__title--icon">'. $item->title .'</span>';
            } elseif(!empty($menu_item_image) && $menu_item_image != null) {
                $menu_item_image_URL = $menu_item_image['url'];

                $menu_item_image_ALT = $menu_item_image['alt'];

                $item->menu_item_image = $menu_item_image_URL;

                $item->attr_title = $item->title;

                $item->title = '<img src="'. $menu_item_image_URL .'" alt="'. $menu_item_image_ALT .'">' . '<span class="menu-item__title menu-item__title--image">'. $item->title .'</span>';
            } elseif(!empty($menu_item_awesome) && $menu_item_awesome != null) {
                $item->menu_icon = $menu_item_awesome;

				$item->attr_title = $item->title;

				$item->title = $menu_item_awesome . '<span class="menu-item__title menu-item__title--awesome">' . $item->title . '</span>';
            } else {
				$item->attr_title = $item->title;

                $item->title = '<span class="menu-item__title">'. $item->title .'</span>';
            }
        }

        return $items;
    }
    add_filter ( 'wp_nav_menu_objects', 'menu_item_page_boxes_images', 10, 2 );
}

// Add icons to page boxes menus
if(!function_exists('menu_item_commons_images')) {
    function menu_item_commons_images ( $items, $args ) {
		if($args->menu_class == 'commons-wrapper') {
			// loop
			foreach( $items as $item ) {
				$menu_item_image = get_field('menu_item_image', $item);

				if($menu_item_image) {
					$menu_item_image_URL = $menu_item_image['url'];
					$menu_item_image_ALT = $menu_item_image['alt'];

					$item->title = $item->title . '<img src="'. $menu_item_image_URL .'" alt="'. $menu_item_image_ALT .'">';
				}
			}
		}

        return $items;
    }
    add_filter ( 'wp_nav_menu_objects', 'menu_item_commons_images', 10, 2 );
}

// Display theme menus Slider || Simple
if(!function_exists('display_custom_theme_menu')) {
    function display_custom_theme_menu($location, $type = 'simple-menu', $slides_visible = null) {
        $theme_location = $location;
        $theme_locations = get_nav_menu_locations();
        $menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );
        $menu_slug = $menu_obj->slug;

        if(has_nav_menu($theme_location)) {
            if($type == 'swiper-container') {
                echo '<div class="'. $type .' menu-'. $menu_slug .'" data-slides-visible="'. $slides_visible .'">';
                    wp_nav_menu(
                        array(
                            'theme_location' => $theme_location,
                            'menu_id'        => uniqid() . '-' . $menu_slug,
                            'menu_class'     => 'menu swiper-wrapper',
                            'container'      => false,
                        )
                    );
                echo '</div>';
            } elseif($type == 'simple-menu') {
                echo '<div class="'. $type .' menu-'. $menu_slug .'">';
                    wp_nav_menu(
                        array(
                            'theme_location' => $theme_location,
                            'menu_id'        => uniqid() . '-' . $menu_slug,
                            'menu_class'     => 'menu ' . $type,
                            'container'      => false,
                        )
                    );
                echo '</div>';
            }
        }
    }
}