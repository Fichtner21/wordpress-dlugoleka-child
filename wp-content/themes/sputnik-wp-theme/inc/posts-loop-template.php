<?php

// Post public date
if ( ! function_exists( 'sputnik_wp_theme_posted_on' ) ) :
	function sputnik_wp_theme_posted_on() {
		$post_type = get_post_type();

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Data publikacji: %s', 'post date', 'sputnik-wp-theme' ),
			'<span class="post-date__date">' . $time_string . '</span>'
		);

		if($post_type == 'wydarzenia') {
			echo '<span class="post-date"><i class="fas fa-clock"></i> '. __('Kiedy?', 'sputnik-wp-theme') . ' ' . get_field('date_start') . '</span>';
		} else {
			echo '<span class="post-date"><i class="fas fa-clock"></i> '. $posted_on . '</span>';
		}
	}
endif;

// Post author
if ( ! function_exists( 'sputnik_wp_theme_posted_by' ) ) :
	function sputnik_wp_theme_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Autor: %s', 'post author', 'sputnik-wp-theme' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

/** Get categories or one category
 ! True => (many categories) or false => (one category) attribute
*/
if ( ! function_exists( 'sputnik_wp_theme_categories' ) ) :
	function sputnik_wp_theme_categories($many) {
		if ( 'post' === get_post_type() ) {
			$categories = wp_get_post_categories(get_the_ID());

			if( $many === true && !empty($categories) ) {
				$output = '<div class="post-footer__categories">';
				$output .= '<span>'. __('Kategoria','sputnik-wp-theme') .':</span>';

				foreach($categories as $category) {
					$category_data = get_category($category);

					$category_name = $category_data->name;
					$category_permalink = get_category_link($category_data->term_id);

					$output .= '<a href="'. $category_permalink .'" class="post-footer__category" title="'. $category_name .'">'. $category_name .'</a>';
				}

				$output .= '</div>';

				echo $output;
			} elseif( $many === false && !empty($categories) ) {
				$category_data = get_category($categories[0]);
				$category_name = $category_data->name;
				$category_permalink = get_category_link($category_data->term_id);

				$output = '<div class="post-footer__categories">';
				$output .= '<span>'. __('Kategoria','sputnik-wp-theme') .':</span>';
				$output .= '<a href="'. $category_permalink .'" class="post-footer__category" title="'. $category_name .'">'. $category_name .'</a>';
				$output .= '</div>';

				echo $output;
			}
		}
	}
endif;

// Theme post thumbnail
if(!function_exists('sputnik_wp_theme_post_thumbnail')) {
	function sputnik_wp_theme_post_thumbnail($size = 'thumbnail') {
		$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());

		$post_thumbnail_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_post_thumbnail_alt', TRUE);

		$post_thumbnail_title = get_the_title($post_thumbnail_id);

		$post_thumbnail = get_the_post_thumbnail(get_the_ID(), $size, array(
			'class' => 'post-thumbnail',
			'alt' => !empty($post_thumbnail_alt) && $post_thumbnail_alt != null ? $post_thumbnail_alt : get_the_title(get_the_ID()),
			'title' => !empty($post_thumbnail_title) && $post_thumbnail_title != null ? $post_thumbnail_title : get_the_title(get_the_ID()),
		));

		echo $post_thumbnail;
	}
}

// Custom excerpt length
if(!function_exists('get_custom_excerpt')) {
    function get_custom_excerpt( $count ) {
		global $post;

		$excerpt;

		if(empty(get_the_excerpt($post->ID))) {
			$excerpt = get_the_content($post->ID);
			$excerpt = strip_shortcodes($excerpt);
			$excerpt = strip_tags($excerpt);
			$excerpt = substr($excerpt, 0, $count);
			$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
			if(!empty($excerpt)) $excerpt = '<p class="post-content__excerpt">' . $excerpt . '...</p>';
		} else {
			$excerpt = get_the_excerpt($post->ID);
			$excerpt = strip_shortcodes($excerpt);
			$excerpt = strip_tags($excerpt);
			$excerpt = substr($excerpt, 0, $count);
			$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
			if(!empty($excerpt)) $excerpt = '<p class="post-content__excerpt">' . $excerpt . '...</p>';
		}

        return $excerpt;
    }
}

// Default custom post template
if(!function_exists('custom_post_loop_template')) {
    function custom_post_loop_template($heading_level = 'h2', $thumb_size = 'thumbnail', $excerpt_length = 200, $categories_count = false) {
		$post_type = get_post_type(); ?>
		<article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
			<?php sputnik_wp_theme_post_thumbnail($thumb_size); ?>

			<header class="post-heading">
				<?php the_title( '<'. $heading_level .' class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></'. $heading_level .'>' ); ?>

				<div class="post-heading-meta">
					<?php sputnik_wp_theme_posted_on(); ?>

					<?php $post_type != 'wydarzenia' ? sputnik_wp_theme_posted_by() : null; ?>
				</div>
			</header><!-- .entry-header -->

			<div class="post-content">
				<?= get_custom_excerpt($excerpt_length); ?>
			</div><!-- .entry-content -->

			<footer class="post-footer">
				<!-- Category -->
				<?php sputnik_wp_theme_categories($categories_count); ?>

				<a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
			</footer><!-- .entry-footer -->
		</article><!-- #post-<?= get_the_ID(); ?> -->
    <?php }
}

// Default custom post template
if(!function_exists('child_pages_loop_template')) {
    function child_pages_loop_template($heading_level = 'h2', $thumb_size = 'thumbnail', $excerpt_length = 200) {
		$post_type = get_post_type(); ?>
		<article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
			<figure class="post-thumbnail-wrapper">
				<a href="<?= get_the_permalink(); ?>" title="<?= get_the_title(); ?>">
					<?php sputnik_wp_theme_post_thumbnail($thumb_size); ?>
				</a>
			</figure>

			<header class="post-heading">
				<?php the_title( '<'. $heading_level .' class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></'. $heading_level .'>' ); ?>

				<div class="post-content">
					<?= get_custom_excerpt($excerpt_length); ?>
				</div><!-- .entry-content -->
			</header><!-- .entry-header -->
		</article><!-- #post-<?= get_the_ID(); ?> -->
    <?php }
}

// Default custom post template
if(!function_exists('title_on_hover_loop_template')) {
    function title_on_hover_loop_template($heading_level = 'h2', $thumb_size = 'thumbnail') {
		$post_type = get_post_type(); ?>
		<article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
			<figure class="post-thumbnail-wrapper">
				<?php sputnik_wp_theme_post_thumbnail($thumb_size); ?>
			</figure>

			<header class="post-heading">
				<?php the_title( '<'. $heading_level .' class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></'. $heading_level .'>' ); ?>
			</header><!-- .entry-header -->
		</article><!-- #post-<?= get_the_ID(); ?> -->
    <?php }
}

// Show terms with childrens
if(!function_exists('show_terms_with_childrens')) {
    function show_terms_with_childrens($taxonomy) {
        //This gets top layer terms only.  This is done by setting parent to 0.
        $parent_terms = get_terms( $taxonomy, array( 'parent' => 0, 'hide_empty' => false ) );

        if(isset($parent_terms) && !empty($parent_terms) && $parent_terms != null && count($parent_terms) > 0) {
            echo '<ul class="custom-terms">';

            foreach ( $parent_terms as $pterm ) {
                //Get the Child terms
                $terms = get_terms( $taxonomy, array( 'parent' => $pterm->term_id, 'hide_empty' => false ) );

                // Add toggle button when terms is not empty
                if(!empty($terms)) {
                    $toggleButton = '<button class="custom-terms__toggle">'. __('+','sputnik') .'</button>';
                } else {
                    $toggleButton = '';
				}

				$term_permalink = get_term_link($pterm);

                echo '<li data-term-name="'. $pterm->slug .'" class="custom-terms__item"><a class="custom-terms__anchor" href="'. $term_permalink .'">'. $pterm->name .'</a>'.$toggleButton.'</li>';

                foreach ( $terms as $term ) {
                    echo '<li data-parent-name="'. $pterm->slug .'" class="custom-terms__item custom-terms__item--child custom-terms__item--hidden"><a class="custom-terms__anchor" href="">' . $term->name . '</a></li>';
                }
            }
        }
    }
}