<?php if(have_rows('hero_slider')) : ?>
    <div class='hero'>
        <div class='swiper-container'>
            <div class='swiper-wrapper'>
                <?php while(have_rows('hero_slider')) : the_row();
                    $url = get_sub_field('url');
                    $image = get_sub_field('image');
                    $text = get_sub_field('text');
                    $title = get_sub_field('title');
                    $searchform = get_sub_field('searchform');
                    $herb = get_sub_field('herb');
                ?>
                    <div class="swiper-slide hero-slide">
                        <?php if(!empty($url)) : ?><a href='<?= $url['url']; ?>' title='<?= $url['title']; ?>'><?php endif; ?>
                            <?php if(!empty($herb)) echo '<img class="hero-slide__herb" src="'. $herb['url'] .'" alt="'. $herb['alt'] .'">'; ?>

                            <?php if(!empty($image)) echo '<img class="hero-slide__image" src="'. $image['url'] .'" alt="'. $image['alt'] .'">'; ?>
                        <?php if(!empty($url)) : ?></a><?php endif; ?>

                        <div class='hero-slide__content'>
                            <?php if(!empty($url)) : ?><a href='<?= $url['url']; ?>' title='<?= $url['title']; ?>'><?php endif; ?><?php if(!empty($text)) echo '<p class="hero-slide__text">'. $text .'</p>'; ?><?php if(!empty($url)) : ?></a><?php endif; ?>

                            <?php if(!empty($url)) : ?><a href='<?= $url['url']; ?>' title='<?= $url['title']; ?>'><?php endif; ?><?php if(!empty($title)) echo '<p class="hero-slide__title">'. $title .'</p>'; ?><?php if(!empty($url)) : ?></a><?php endif; ?>

                            <?php if(!empty($searchform)) echo do_shortcode($searchform); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php function_exists('custom_swiper_arrows') ? custom_swiper_arrows() : null; ?>

            <?php function_exists('custom_swiper_pagination') ? custom_swiper_pagination() : null; ?>
        </div>
    </div>
<?php endif; ?>