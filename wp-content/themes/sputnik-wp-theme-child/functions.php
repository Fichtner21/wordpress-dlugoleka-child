<?php

if(!function_exists('sputnik_wp_theme_child_enqueue_style')) {
    function sputnik_wp_theme_child_enqueue_style() {
        wp_enqueue_style( 'child-style', get_stylesheet_uri(),
            array( 'parenthandle' ),
            wp_get_theme()->get('Version') // this only works if you have Version in the style header
        );
    }
    add_action( 'wp_enqueue_scripts', 'sputnik_wp_theme_child_enqueue_style' );
}

// Frontend assets
if(!function_exists('public_custom_assets_child')) {
	function public_custom_assets_child() {		
		wp_enqueue_script( 'public-scripts-child', get_stylesheet_directory_uri() . '/dist/public/public.bundle.js' );
		wp_enqueue_style( 'public-styles-child', get_stylesheet_directory_uri() . '/dist/public/styles/style.css' );
	}

	add_action( 'wp_enqueue_scripts', 'public_custom_assets_child' );
}