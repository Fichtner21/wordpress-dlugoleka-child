<?php if(have_rows('paths')) : ?>
    <div class='paths'>
        <?php while(have_rows('paths')) : the_row();
            $title = get_sub_field('title');
            $paths_list = get_sub_field('paths_list');
        ?>

        <h3 class="paths__title"><?= $title; ?></h3>

            <?php $i = 1; foreach($paths_list as $path) :
                $image = $path['image'];
                $title = $path['title'];
                $distance = $path['distance'];
                $text = $path['text'];
                ?>
                <div class="path">
                    <header class="path-heading">
                        <span class="path-heading__number"><?= $i; ?></span>
                        <h4 class="path-heading__title"><?= $title; ?><?= !empty($distance) ? ' - ' . $distance : null; ?></h4>
                    </header>

                    <div class="path-content">
                        <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" class="path-content__image">
                        <p class="path-content__text"><?= $text; ?></p>
                    </div>
                </div>
            <?php $i++; endforeach; ?>

        <?php endwhile; ?>
    </div>
<?php endif; ?>