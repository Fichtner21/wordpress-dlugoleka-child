<?php

if(!function_exists('custom_mobile_apps_page')) {
    function custom_mobile_apps_page() {
        add_submenu_page(
            'options-general.php', 'Mobile Apps', 'Mobile Apps', 'manage_options', 'mobile-apps-options', 'custom_mobile_apps_template'
        );

        //call register settings function
        add_action( 'admin_init', 'register_custom_mobile_apps_settings' );
    };

    if(!function_exists('register_custom_mobile_apps_settings')) {
        function register_custom_mobile_apps_settings() {
            // Register all options
            register_setting('custom_mobile_apps_group','apps_text');
            register_setting('custom_mobile_apps_group','google_play_link');
            register_setting('custom_mobile_apps_group','app_store_link');
        }
    }

    if(!function_exists('custom_mobile_apps_template')) {
        function custom_mobile_apps_template() { ?>
            <div class="wrap">
                <h1><?= __('Mobile Apps','sputnik-wp-theme'); ?></h1>

                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'custom_mobile_apps_group' );
                    do_settings_sections( 'custom_mobile_apps_group' );
                    ?>

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?= __('Podaj tekst','sputnik-wp-theme'); ?></th>
                            <td><textarea name="apps_text" value="<?= esc_attr( get_option('apps_text') ); ?>" rows="10"><?= esc_attr( get_option('apps_text') ); ?></textarea></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Google Play Link','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="google_play_link" value="<?= esc_attr( get_option('google_play_link') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('App Store Link','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="app_store_link" value="<?= esc_attr( get_option('app_store_link') ); ?>" /></td>
                        </tr>
                    </table>

                    <?php submit_button(); ?>
                </form>
            </div>
        <?php }
    }

    add_action('admin_menu', 'custom_mobile_apps_page');
}