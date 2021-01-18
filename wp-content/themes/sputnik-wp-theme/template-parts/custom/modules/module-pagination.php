<?php the_posts_pagination(
  array(
    'mid_size'  => 2,
    'prev_text' => __( '« Poprzednia', 'textdomain' ),
    'next_text' => __( 'Następna »', 'textdomain' ),
)   
);

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$news_args = array(
  'post_type' => 'post',
  'posts_per_page' => 10,
  'post_status' => 'publish',
  'orderby' => 'date',
  'order' => 'DESC',
  'paged' => $paged
);

$big = 999999999; // need an unlikely integer

if(!function_exists('custom_pagination')) {
    function custom_pagination() {
        $big = 999999999; // need an unlikely integer

        paginate_links( array(
            'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format' => '?paged=%#%',            
            'current' => max( 1, get_query_var('paged') ),
            'total' => $news_args->max_num_pages,
            'prev_text'          => __('« jdsjj'),
            'next_text'          => __('jhdsh »'),
            'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
        ) );
    }
}

