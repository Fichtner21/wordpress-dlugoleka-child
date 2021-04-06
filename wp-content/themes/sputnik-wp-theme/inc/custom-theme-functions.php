<?php

// Define path to custom template parts
if(!defined('CUSTOM_PARTS')) {
	define('CUSTOM_PARTS', get_template_directory() . '/template-parts/custom');
}

// Define path to custom includes
if(!defined('CUSTOM_INC')) {
	define('CUSTOM_INC', get_template_directory() . '/inc');
}

// Get all Custom Post Types
if(!function_exists('get_all_custom_post_types')) {
    function get_all_custom_post_types() {
        $all_post_types = array();

        $custom_post_types = scandir( CUSTOM_INC . '/custom-post-types/' );

        foreach($custom_post_types as $post_type) {
            if($post_type != '.' && $post_type != '..') {
                $remove_prefix = str_replace('custom-post-type-','', $post_type);
                $remove_suffix = str_replace('.php', '', $remove_prefix);

                $post_type_name = ucfirst($remove_suffix);

                array_push($all_post_types, $post_type_name);
            }
        }

        return $all_post_types;
    }
}

if(!function_exists('create_pages_on_fly')) {
	function create_pages_on_fly($pageName, $parent = 0, $pageTemplate = '') {
		$createPage = array(
			'post_title'    => $pageName,
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_type'     => 'page',
			'post_name'     => $pageName,
			'post_parent' => $parent,
			'page_template' => $pageTemplate
		);
		// Insert the post into the database
		$pageID = wp_insert_post( $createPage );

		if ( $pageID && ! is_wp_error( $pageID ) ){
			$pageSlug = str_replace( ' ', '_', strtolower( trim( $pageName ) ) );

			update_post_meta( $pageID, '_wp_page_template', $pageTemplate );

			add_option($pageSlug . '_page_id', $pageID);

			if($pageName == 'Strona główna') {
                update_option( 'page_on_front', $pageID );
			} elseif($pageName == 'Aktualności' || $pageName == 'Blog') {
				update_option( 'page_for_posts', $pageID );
			}
		}

		return $pageID;
	}
}

// Set options on first activate theme
require CUSTOM_INC . '/set-options.php';

// Allow to upload SVG files
require CUSTOM_INC . '/allow-svg.php';

// Add wp body open
if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

// Add a pingback url auto-discovery header for single posts, pages, or attachments.
function sputnik_wp_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'sputnik_wp_theme_pingback_header' );

// Remove default jquery from frontend. We using jQuery from Webpack Config
if(!function_exists( 'remove_jquery_from_frontend' )) {
	function remove_jquery_from_frontend( $scripts ) {
		if( !is_admin() ) {
			$scripts->remove( 'jquery' );
			$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
		}
	}
	//add_filter( 'wp_default_scripts', 'remove_jquery_from_frontend' );
}

// Svg icon display & dirname(__FILE__, 1) in main functions.php or dirname(__FILE__, 2) when file is in theme subdirectory
if(!function_exists('svg_icon')) {
    function svg_icon($name, $width) {
        $icon = file_get_contents( get_template_directory() . '/dist/public/images/' . $name .'.svg' );

        if($width) echo "<i class='svg-icon siW-". $width ."'>". $icon ."</i>";
    }
}

// Svg icon display in admin
if(!function_exists('svg_icon_admin')) {
	function svg_icon_admin($name, $width) {
		$icon = file_get_contents( get_template_directory() . '/dist/admin/images/' . $name .'.svg' );

		if($width) echo "<i class='svg-icon siW-". $width ."'>". $icon ."</i>";
	}
}

/* Add title attribute for a element
    ! TODO: Change this function. Bad title sometimes.
*/
if(!function_exists('all_menu_items_title')) {
	function all_menu_items_title( $atts, $item, $args ) {
		if ( ! empty( $item->title ) ) {
			$atts['title'] = esc_attr( $item->title );

			return $atts;
		}
	}
	add_filter( 'nav_menu_link_attributes', 'all_menu_items_title', 10, 3 );
}

// Admin assets
if(!function_exists('admin_custom_assets')) {
	function admin_custom_assets() {
		if (is_admin()) {
			wp_enqueue_script( 'admin-scripts', get_template_directory_uri() . '/dist/admin/admin.bundle.js' );
			wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/dist/admin/styles/style.css' );
		}
	}

	add_action( 'admin_enqueue_scripts', 'admin_custom_assets' );
}

// Frontend assets
if(!function_exists('public_custom_assets')) {
	function public_custom_assets() {
		// wp_enqueue_script( 'google-maps-js', 'https://maps.googleapis.com/maps/api/js?key='. get_field('google_map_api_key', 'option') .'&callback=initMap&libraries=&v=weekly' );
		wp_enqueue_script( 'public-scripts', get_template_directory_uri() . '/dist/public/public.bundle.js' );
		wp_enqueue_style( 'public-styles', get_template_directory_uri() . '/dist/public/styles/style.css' );
	}

	add_action( 'wp_enqueue_scripts', 'public_custom_assets' );
}

// Add custom post types
require CUSTOM_INC . '/custom-post-types.php';

// Add custom fields
require CUSTOM_INC . '/custom-fields.php';

// Posts loop templates
require CUSTOM_INC . '/posts-loop-template.php';

// Add theme changer
require CUSTOM_INC . '/skin-changer.php';

// Create cild theme
require CUSTOM_INC . '/create-child-theme.php';

// Use automatic theme updater & checker
// require CUSTOM_INC . '/theme-updater.php';

// Use automatic theme updater & checker
require CUSTOM_INC . '/customize-admin.php';

// Add custom shortcodes
require CUSTOM_INC . '/custom-shortcodes.php';

// Add custom widgets
require CUSTOM_INC . '/custom-widgets.php';


if(!function_exists('custom_swiper_arrows')) {
    function custom_swiper_arrows() { ?>
        <button class="swiper-button-prev" title="<?= __('Poprzedni','sputnik-wp-theme'); ?>">
            <span class="screen-reader-text"><?= __('Poprzedni','sputnik-wp-theme'); ?></span>
        </button>

        <button class="swiper-button-next" title="<?= __('Następny','sputnik-wp-theme'); ?>">
            <span class="screen-reader-text"><?= __('Następny','sputnik-wp-theme'); ?></span>
        </button>
    <?php }
}

if(!function_exists('custom_swiper_pagination')) {
    function custom_swiper_pagination() { ?>
        <div class="swiper-pagination"></div>
    <?php }
}

// Add ACF google map api key
if(!function_exists('my_acf_google_map_api')) {
	function my_acf_google_map_api( $api ){
		$api['key'] = get_field('google_map_api_key', 'option');

		return $api;
	}

	add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
}
