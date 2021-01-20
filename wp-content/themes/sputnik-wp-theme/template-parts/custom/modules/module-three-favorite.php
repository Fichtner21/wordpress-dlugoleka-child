<?php $three_favorite_section = get_field('three_favorite_section'); ?>

<header class="page-section-heading">
    <h2 class="page-section-heading__title"><?= __($three_favorite_section['title'],'sputnik-wp-theme'); ?></h2>
</header>

<?php if(!empty($three_favorite_section['three_favorite'])) : ?>
    <div class='three-favorite'>
        <?php foreach($three_favorite_section['three_favorite'] as $post) : the_row();
            $title = $post['title'];
            $url = $post['url'];
            $image = $post['image'];
        ?>
            <article class="three-favorite-post">
                <a href='<?= $url; ?>' class='three-favorite-post__thumbnail' title='<?= $title; ?>'>
                    <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                </a>

                <h3 class="three-favorite-post__title"><a href='<?= $url; ?>' title='<?= $title; ?>'><?= $title; ?></a></h3>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>