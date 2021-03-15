<!-- Social media -->
<div class="social-media">
    <?php
        $rss = get_option('rss_link');
        $facebook = get_option('facebook_link');
        $twitter = get_option('twitter_link');
        $youtube = get_option('youtube_link');
        $instagram = get_option('instagram_link');
        $bip = get_option('bip_link');
    ?>
    <?php //if(isset($bip) && !empty($bip) && $bip != null) : ?>
        <a target='_blank' href='<?= $bip; ?>' class='social-media__anchor' title='<?= __('Biuletyn Informacji Publicznej ' . get_bloginfo(),'sputnik-wp-theme'); ?>'>
            <img src="<?php echo get_template_directory_uri() ?>/app/public/images/bip-icon.svg" class="bip-icon">
            <span class='screen-reader-text'><?= __('Biuletyn informacji publicznej','sputnik-wp-theme'); ?></span>
        </a>
    <?php //endif; ?>

    <?php if(isset($facebook) && !empty($facebook) && $facebook != null) : ?>
        <a target='_blank' href='<?= $facebook; ?>' class='social-media__anchor' title='<?= __('Facebook','sputnik-wp-theme'); ?>'>
            <i class="fab fa-facebook-f"></i>
            <span class='screen-reader-text'><?= __('Facebook','sputnik-wp-theme'); ?></span>
        </a>
    <?php endif; ?>

    <?php if(isset($youtube) && !empty($youtube) && $youtube != null) : ?>
        <a target='_blank' href='<?= $youtube; ?>' class='social-media__anchor' title='<?= __('YouTube','sputnik-wp-theme'); ?>'>
            <i class="fab fa-youtube"></i>
            <span class='screen-reader-text'><?= __('YouTube','sputnik-wp-theme'); ?></span>
        </a>
    <?php endif; ?>

    <?php if(isset($instagram) && !empty($instagram) && $instagram != null) : ?>
        <a target='_blank' href='<?= $instagram; ?>' class='social-media__anchor' title='<?= __('Instagram','sputnik-wp-theme'); ?>'>
            <i class="fab fa-instagram"></i>
            <span class='screen-reader-text'><?= __('Instagram','sputnik-wp-theme'); ?></span>
        </a>
    <?php endif; ?>

    <?php if(isset($twitter) && !empty($twitter) && $twitter != null) : ?>
        <a target='_blank' href='<?= $twitter; ?>' class='social-media__anchor' title='<?= __('Twitter','sputnik-wp-theme'); ?>'>
            <i class="fab fa-twitter"></i>
            <span class='screen-reader-text'><?= __('Twitter','sputnik-wp-theme'); ?></span>
        </a>
    <?php endif; ?>

    <?php if(isset($rss) && !empty($rss) && $rss != null) : ?>
        <a target='_blank' href='<?= $rss; ?>' class='social-media__anchor' title='<?= __('RSS','sputnik-wp-theme'); ?>'>
            <i class="fas fa-rss"></i>
            <span class='screen-reader-text'><?= __('RSS','sputnik-wp-theme'); ?></span>
        </a>
    <?php endif; ?>
</div>