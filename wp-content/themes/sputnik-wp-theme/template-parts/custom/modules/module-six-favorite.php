<?php $six_favorite_section = get_field('six_favorite_section'); ?>

<header class="page-section-heading">
    <h2 class="page-section-heading__title"><?= __($six_favorite_section['title'],'sputnik-wp-theme'); ?></h2>
</header>

<?php if(!empty($six_favorite_section['six_favorite'])) : ?>
    <div class='six-favorite'>
        <?php $i = 0; foreach($six_favorite_section['six_favorite'] as $post) : the_row();
            $title = $post['title'];
            $url = $post['url'];
            $image = $post['image'];

            if($i == 0 || $i == 3 || $i == 4) echo "<div class='six-favorite__col'>";
        ?>
            <article class="six-favorite-post">
                <a href='<?= $url; ?>' class='six-favorite-post__thumbnail' title='<?= $title; ?>'>
                    <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                </a>

                <h3 class="six-favorite-post__title"><a href='<?= $url; ?>' title='<?= $title; ?>'><?= $title; ?></a></h3>
            </article>
        <?php

        if($i == 2 || $i == 3 || $i == 5) echo "</div>";

        $i++; endforeach; ?>
    </div>
<?php endif; ?>