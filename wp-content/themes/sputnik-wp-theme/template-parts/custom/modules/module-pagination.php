<?php the_posts_pagination();

// $paged = get_query_var('paged') ? get_query_var('paged') : 1;

// $big = 999999999; // need an unlikely integer

// if(!function_exists('custom_pagination')) {
//     function custom_pagination() {
//         $big = 999999999; // need an unlikely integer

//         paginate_links( array(
//             'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
//             'format' => '?paged=%#%',
//             'current' => max( 1, get_query_var('paged') ),
//             'total' => $the_query->max_num_pages
//         ) );
//     }
// }