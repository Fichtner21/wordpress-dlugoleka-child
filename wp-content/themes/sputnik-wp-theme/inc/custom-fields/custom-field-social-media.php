<?php

if(!function_exists('custom_social_media_page')) {
    function custom_social_media_page() {
        add_submenu_page(
            'options-general.php', 'Social Media', 'Social Media', 'manage_options', 'social-media-options', 'custom_social_media_template'
        );

        //call register settings function
        add_action( 'admin_init', 'register_custom_social_media_settings' );
    };

    if(!function_exists('register_custom_social_media_settings')) {
        function register_custom_social_media_settings() {
            // Register all options
            register_setting('custom_social_media_group','facebook_link');
            register_setting('custom_social_media_group','youtube_link');
            register_setting('custom_social_media_group','instagram_link');
            register_setting('custom_social_media_group','twitter_link');
            register_setting('custom_social_media_group','rss_link');
        }
    }

    if(!function_exists('custom_social_media_template')) {
        function custom_social_media_template() { ?>
            <div class="wrap">
                <h1><?= __('Social Media','sputnik-wp-theme'); ?></h1>

                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'custom_social_media_group' );
                    do_settings_sections( 'custom_social_media_group' );
                    ?>

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?= __('Facebook link','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="facebook_link" value="<?= esc_attr( get_option('facebook_link') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('YouTube link','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="youtube_link" value="<?= esc_attr( get_option('youtube_link') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Instagram link','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="instagram_link" value="<?= esc_attr( get_option('instagram_link') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Twitter link','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="twitter_link" value="<?= esc_attr( get_option('twitter_link') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('RSS link','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="rss_link" value="<?= esc_attr( get_option('rss_link') ); ?>" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?= __('BIP link','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="bip_link" value="<?= esc_attr( get_option('bip_link') ); ?>" /></td>
                        </tr>
                    </table>

                    <?php submit_button(); ?>
                </form>
            </div>
        <?php }
    }

    add_action('admin_menu', 'custom_social_media_page');
}