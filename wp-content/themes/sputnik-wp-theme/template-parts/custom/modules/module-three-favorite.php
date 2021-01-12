<?php if(have_rows('three_favorite')) : ?>
    <div class='three-favorite'>
        <?php while(have_rows('three_favorite')) : the_row();
            $title = get_sub_field('title');
            $url = get_sub_field('url');
            $image = get_sub_field('image');
        ?>
            <article class="three-favorite-post">
                <a href='<?= $url; ?>' class='three-favorite-post__thumbnail' title='<?= $title; ?>'>
                    <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                </a>

                <h3 class="three-favorite-post__title"><a href='<?= $url; ?>' title='<?= $title; ?>'><?= $title; ?></a></h3>
            </article>
        <?php endwhile; ?>
    </div>
<?php endif; ?>