<?php if((get_option('google_play_link') || get_option('app_store_link'))) : ?>
    <div class="apps">
        <h2 class="apps__title"><?= __('Pobierz Aplikację mobilna','sputnik-wp-theme'); ?></h2>
        <p class="apps__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Qui</p>

        <div class="apps__buttons">
            <a href="<?= get_option('google_play_link'); ?>" class="apps__button" title="<?= __('Pobierz z','sputnik-wp-theme'); ?>"><?= __('Google play','sputnik-wp-theme'); ?></a>

            <a href="<?= get_option('app_store_link'); ?>" class="apps__button" title="<?= __('Pobierz z','sputnik-wp-theme'); ?>"><?= __('App Store','sputnik-wp-theme'); ?></a>
        </div>
    </div>
<?php endif; ?>