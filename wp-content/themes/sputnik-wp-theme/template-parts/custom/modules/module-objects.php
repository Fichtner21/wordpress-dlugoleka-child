<?php if(have_rows('objects')) : ?>
    <div class='objects'>
        <?php while(have_rows('objects')) : the_row();
            $icon = get_sub_field('icon');
            $title = get_sub_field('title');
            $objects_list = get_sub_field('objects_list');
        ?>

        <h3 class="objects__title"><?= $title; ?></h3>

            <?php foreach($objects_list as $object) :
                $title = $object['title'];
                $address = $object['address'];
                $phone = $object['phone'];
                $email = $object['email'];
                $website = $object['website'];
                ?>
                <div class="object">
                    <img src="<?= $icon['url']; ?>" alt="" class="object__icon" width='180'>

                    <h4 class="object__title"><?= $title; ?></h4>

                    <div class="object-data">
                        <div class="object-data-col">
                            <i class="fas fa-map-marker-alt"></i>

                            <p class="object-data-col__title"><?= __('Adres','sputnik-wp-theme'); ?></p>

                            <p class="object-data-col__data"><?= $address; ?></p>
                        </div>

                        <div class="object-data-col">
                            <i class="fas fa-phone-volume"></i>

                            <p class="object-data-col__title"><?= __('Kontakt','sputnik-wp-theme'); ?></p>

                            <p class="object-data-col__data"><?= __('tel.:','sputnik-wp-theme'); ?> <?= $phone; ?></p>
                            <p class="object-data-col__data"><?= __('email:','sputnik-wp-theme'); ?> <?= $email; ?></p>
                        </div>

                        <div class="object-data-col">
                            <i class="fas fa-globe"></i>

                            <p class="object-data-col__title"><?= __('Adres www','sputnik-wp-theme'); ?></p>

                            <p class="object-data-col__data"><?= $website; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endwhile; ?>
    </div>
<?php endif; ?>