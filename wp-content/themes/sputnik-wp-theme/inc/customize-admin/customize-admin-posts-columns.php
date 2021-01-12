<?php

// GET FEATURED IMAGE
if(!function_exists('custom_get_featured_image')) {
	function custom_get_featured_image($post_ID) {
		$post_thumbnail_id = get_post_thumbnail_id($post_ID);
		if ($post_thumbnail_id) {
			$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');

			return $post_thumbnail_img[0];
		}
	}
}

// ADD NEW COLUMN
if(!function_exists('custom_columns_head')) {
	function custom_columns_head($defaults) {
		$defaults['post_id'] = __('ID','donovan_child');
		$defaults['featured_image'] = __('Obrazek wyróżniający','donovan_child');

		return $defaults;
	}

	$all_post_types = get_all_custom_post_types();

	foreach($all_post_types as $post_type) {
		$post_name = strtolower($post_type);

		add_filter('manage_'. $post_name .'_posts_columns', 'custom_columns_head', 10);
	}

	add_filter('manage_post_posts_columns', 'custom_columns_head', 10);
}

// SHOW THE FEATURED IMAGE
if(!function_exists('custom_columns_content')) {
	function custom_columns_content($column_name, $post_ID) {
		if ($column_name == 'post_id') {
			echo '<span class="dashboard-post-id">'. get_the_ID() .'</span>';
		}

		if ($column_name == 'featured_image') {
			$post_featured_image = custom_get_featured_image($post_ID);

			if (!empty($post_featured_image) && $post_featured_image != null) {
				echo '<div class="dashboard-featured-image"><img width="100" src="' . $post_featured_image . '" /></div>';
			} else {
				echo '<span>'. __('Brak obrazka','sputnik-wp-theme') .'</span>';
			}
		}
	}

	$all_post_types = get_all_custom_post_types();

	foreach($all_post_types as $post_type) {
		$post_name = strtolower($post_type);

		add_action('manage_'. $post_name .'_posts_custom_column', 'custom_columns_content', 10, 2);
	}

	add_action('manage_post_posts_custom_column', 'custom_columns_content', 10, 2);
}