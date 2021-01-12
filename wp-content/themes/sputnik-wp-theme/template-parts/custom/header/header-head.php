<?php

// Contrast COOKIE
$contrast_page = isset($_COOKIE['contrast']) && $_COOKIE['contrast'] == 'contrast-mode' ? "contrast-mode" : "";

// FontSize COOKIE
$font_size = isset($_COOKIE['font']) ? $_COOKIE['font'] : "fontsize-62-5";

// Active theme for theme changer
$active_theme = get_option('custom_theme');

// Add post type to body ID
$post_type = get_post_type();

?>

<!doctype html>
<html class='wcagfocus <?= $contrast_page; ?> <?= $font_size; ?>' <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class([$active_theme]); ?> <?= (isset($post_type) && $post_type != '') ? "id='$post_type'" : false; ?>>

<?php wp_body_open(); ?>