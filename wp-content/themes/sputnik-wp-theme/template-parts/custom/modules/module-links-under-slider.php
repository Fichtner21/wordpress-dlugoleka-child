<?php if(have_rows('links_under_slider')) : ?>
    <div class='links-under-slider'>
        <?php while(have_rows('links_under_slider')) : the_row();
            $title = get_sub_field('title');
            $url = get_sub_field('url');
        ?>
            <a href='<?= $url; ?>' class="links-under-slider__anchor" title='<?= $title; ?>'><?= $title; ?> <i class="fas fa-arrow-circle-right"></i></a>
        <?php endwhile; ?>
    </div>
<?php else : ?>
    <div class='links-under-slider'>
        <div class="links-under-slider__anchor"></div>
        <div class="links-under-slider__anchor"></div>
    </div>
<?php endif; ?>