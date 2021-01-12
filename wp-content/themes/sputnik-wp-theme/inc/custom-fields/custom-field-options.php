<?php

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> __('Opcje motywu', 'sputnik-wp-theme'),
		'menu_title'	=> __('Opcje motywu', 'sputnik-wp-theme'),
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __('Lokalizacja', 'sputnik-wp-theme'),
		'menu_title'	=> __('Lokalizacja', 'sputnik-wp-theme'),
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __('Stopka', 'sputnik-wp-theme'),
		'menu_title'	=> __('Stopka', 'sputnik-wp-theme'),
		'parent_slug'	=> 'theme-general-settings',
	));

}