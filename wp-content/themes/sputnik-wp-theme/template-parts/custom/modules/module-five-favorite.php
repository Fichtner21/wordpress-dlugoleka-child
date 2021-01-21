<?php $five_favorite_section = get_field('five_favorite_section'); ?>

<header class="page-section-heading">
    <h2 class="page-section-heading__title"><?= __($five_favorite_section['title'],'sputnik-wp-theme'); ?></h2>
</header>

<?php if(!empty($five_favorite_section['five_favorite'])) : ?>
    <div class='five-favorite'>
        <?php $i = 0; foreach($five_favorite_section['five_favorite'] as $post) : the_row();
            $title = $post['title'];
            $url = $post['url'];
            $image = $post['image'];

            if($i == 0 || $i == 3) echo "<div class='five-favorite__col'>";
        ?>
            <article class="five-favorite-post">
                <a href='<?= $url; ?>' class='five-favorite-post__thumbnail' title='<?= $title; ?>'>
                    <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                </a>

                <h3 class="five-favorite-post__title"><a href='<?= $url; ?>' title='<?= $title; ?>'><?= $title; ?></a></h3>
            </article>
        <?php

        if($i == 2 || $i == 5) echo "</div>";

        $i++; endforeach; ?>
    </div>
<?php endif; ?>