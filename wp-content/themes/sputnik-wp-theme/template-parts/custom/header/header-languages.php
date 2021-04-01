<?php if(shortcode_exists('gtranslate')) : ?>
    <!-- Choose Language module -->
    <div id="languages-btn" class="languages" title="<?= __('Wybierz język','sputnik-wp-theme'); ?>">
        <p class="languages__title"><?= __('Wybierz język','sputnik-wp-theme'); ?><span class="active-language">PL</span></p>
        <div class="languages-list">
            <?= do_shortcode('[gtranslate]'); ?>
        </div>
    </div>
<?php endif; ?>