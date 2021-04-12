<?php if(shortcode_exists('gtranslate')) : ?>
    <div class="languages">
        <!-- Choose Language module -->
        <button id="languages-btn" class="languages-wrapper" title="<?= __('Wybierz język','sputnik-wp-theme'); ?>"><?= __('Wybierz język','sputnik-wp-theme'); ?><span class="active-language">PL</span></button>
        <div class="languages-list">
            <?= do_shortcode('[gtranslate]'); ?>
        </div>
    </div>
<?php endif; ?>