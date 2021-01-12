<?php if(have_rows('most_searched')) : ?>
    <div class='most-searched'>
        <h3 class="most-searched__title"><?= __('Najczęściej szukane przez użytkowników','sputnik-wp-theme'); ?></h3>

        <ol class="most-searched-list">
            <?php while(have_rows('most_searched')) : the_row();
                $title = get_sub_field('title');
                $url = get_sub_field('url');
            ?>
            <li class="most-searched-list__item">
                <a href="<?= $url; ?>" class="most-searched-list__anchor" title='<?= $title; ?>'><?= $title; ?></a>
            </li>
            <?php endwhile; ?>
        </ol>
    </div>
<?php endif; ?>