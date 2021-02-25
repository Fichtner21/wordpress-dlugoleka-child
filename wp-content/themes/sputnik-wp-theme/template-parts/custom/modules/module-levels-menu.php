<aside class="levels-menu">
    <h3 class="levels-menu__title"><?= get_the_title(); ?></h3>

    <?php
        $ancestors = get_ancestors($post->ID, 'page');

        $parent = (!empty($ancestors)) ? array_pop($ancestors) : $post->ID;

        if (!empty($parent)) {
            $pages = get_pages(array('child_of' => $parent));

            if (!empty($pages)) {
                $page_ids = array();

                foreach ($pages as $page) $page_ids[] = $page->ID;

                $list_args = array(
                    'include' => $page_ids,
                    'echo' => 0,
                    'title_li' => null,
                );

                $children = wp_list_pages($list_args);

                echo '<ul class="levels-menu-list">'. $children .'</ul>';
            }
        }
    ?>
</aside>
