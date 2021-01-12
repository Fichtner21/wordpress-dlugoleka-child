<div class="footer-bottom">
    <?php if(get_field('copyright', 'option')) : ?>
        <p class='footer-bottom__copy'><?= get_field('copyright', 'option'); ?></p>
    <?php endif; ?>

    <p class="footer-bottom__wcag"><?= __('WCAG 2.1 AA','sputnik-wp-theme'); ?></p>

	<?php require CUSTOM_PARTS . '/modules/module-social-media.php'; ?>
</div>