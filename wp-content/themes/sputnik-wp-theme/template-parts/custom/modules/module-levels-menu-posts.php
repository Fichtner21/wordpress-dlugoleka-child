<aside class="levels-menu">
    <h3 class="levels-menu__title"><?= __('Wszystkie wpisy', 'sputnik-wp-theme') . ' - ' . get_the_title(); ?></h3>

    <?php
        global $news_query_cpt;

        $post_types = get_post_types();

        $list_args = array(
            'post_type'   => $news_query_cpt->query['post_type'],
            'echo'        => 0,
            'title_li'    => null,
            'link_before' => '<span>',
            'link_after'  => '</span>',
        );

        $children = wp_list_pages($list_args);

        echo '<ul class="levels-menu-list">'. $children .'</ul>';
    ?>
</aside>