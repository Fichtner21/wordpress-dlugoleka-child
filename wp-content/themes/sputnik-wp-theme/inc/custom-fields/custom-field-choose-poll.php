<?php

if(!function_exists('choose_poll_page')) {
    function choose_poll_page() {
        add_submenu_page(
            'options-general.php', 'Choose poll', 'Wstaw Ankietę', 'manage_options', 'choose-poll-options', 'choose_poll_template'
        );

        //call register settings function
        add_action( 'admin_init', 'register_choose_poll_settings' );
    };

    if(!function_exists('register_choose_poll_settings')) {
        function register_choose_poll_settings() {
            // Register all options
            register_setting('choose_poll_group','choose_poll_shortcode');
        }
    }

    if(!function_exists('choose_poll_template')) {
        function choose_poll_template() { ?>
            <div class="wrap">
                <h1><?= __('Wstaw ankietę','sputnik-wp-theme'); ?></h1>

                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'choose_poll_group' );
                    do_settings_sections( 'choose_poll_group' );
                    ?>

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?= __('Shortcode','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="choose_poll_shortcode" value="<?= esc_attr( get_option('choose_poll_shortcode') ); ?>" /></td>
                        </tr>
                    </table>

                    <?php submit_button(); ?>
                </form>
            </div>
        <?php }
    }

    add_action('admin_menu', 'choose_poll_page');
}