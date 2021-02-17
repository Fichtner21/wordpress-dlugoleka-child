<?php if(have_rows('links_under_slider')) : ?>
    <div class='links-under-slider'>
        <?php while(have_rows('links_under_slider')) : the_row();
            $title = get_sub_field('title');
            $url = get_sub_field('url');
            $link_target = $url['target'] ? $url['target'] : '_self';
        ?>
            <a href='<?= $url['url']; ?>' class="links-under-slider__anchor" title='<?= $url['title']; ?>' target="<?= esc_attr( $link_target ); ?>"><?= $title; ?> <i class="fas fa-arrow-circle-right"></i></a>
        <?php endwhile; ?>
    </div>
<?php else : ?>
    <div class='links-under-slider'>
        <div class="links-under-slider__anchor"></div>
        <div class="links-under-slider__anchor"></div>
    </div>
<?php endif; ?>