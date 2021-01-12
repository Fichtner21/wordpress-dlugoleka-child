<?php

// Admin assets
if(!function_exists('admin_custom_assets_child')) {
	function admin_custom_assets_child() {
		if ($GLOBALS['pagenow'] == 'wp-login.php' || is_admin()) {
			wp_enqueue_script( 'admin-scripts-child', get_stylesheet_directory_uri() . '/dist/admin/admin.bundle.js' );
			wp_enqueue_style( 'admin-styles-child', get_stylesheet_directory_uri() . '/dist/admin/styles/style.css' );
		}
	}

	add_action( 'admin_enqueue_scripts', 'admin_custom_assets_child' );
}

// Frontend assets
if(!function_exists('public_custom_assets_child')) {
	function public_custom_assets_child() {
		wp_enqueue_script( 'public-scripts-child', get_stylesheet_directory_uri() . '/dist/public/public.bundle.js' );
		wp_enqueue_style( 'public-styles-child', get_stylesheet_directory_uri() . '/dist/public/styles/style.css' );
	}

	add_action( 'wp_enqueue_scripts', 'public_custom_assets_child' );
}