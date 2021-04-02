<?php if((get_option('google_play_link') || get_option('app_store_link'))) : ?>
    <div class="apps">
        <img class="apps__phones" src='<?= get_template_directory_uri(); ?>/dist/public/images/app-phones.png' alt='Dwa telefony komórkowe'>

        <h2 class="apps__title"><?= __('Pobierz Aplikację mobilna','sputnik-wp-theme'); ?></h2>
        <p class="apps__text"><?= !empty(get_option('apps_text')) ? get_option('apps_text') : null; ?></p>

        <div class="apps__buttons">
            <a href="<?= get_option('google_play_link'); ?>" class="apps__button" title="<?= __('Pobierz z Google Play','sputnik-wp-theme'); ?>">
                <?= function_exists('svg_icon') ? svg_icon('android', 2) : false; ?>
                <span><?= __('Pobierz z Google Play','sputnik-wp-theme'); ?></span>
            </a>

            <a href="<?= get_option('app_store_link'); ?>" class="apps__button" title="<?= __('Pobierz z App Store','sputnik-wp-theme'); ?>">
                <?= function_exists('svg_icon') ? svg_icon('apple', 2) : false; ?>
                <span><?= __('Pobierz z App Store','sputnik-wp-theme'); ?></span>
            </a>
        </div>
    </div>
<?php endif; ?>