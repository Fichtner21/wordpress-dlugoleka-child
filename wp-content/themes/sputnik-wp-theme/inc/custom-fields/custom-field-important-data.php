<?php

if(!function_exists('custom_important_data_page')) {
    function custom_important_data_page() {
        add_submenu_page(
            'options-general.php', 'Ważne dane', 'Ważne dane', 'manage_options', 'important-data-options', 'custom_important_data_template'
        );

        //call register settings function
        add_action( 'admin_init', 'register_custom_important_data_settings' );
    };

    if(!function_exists('register_custom_important_data_settings')) {
        function register_custom_important_data_settings() {
            // Register all options
            register_setting('custom_important_data_group','address');
            register_setting('custom_important_data_group','open_hours');
            register_setting('custom_important_data_group','phone');
            register_setting('custom_important_data_group','fax');
            register_setting('custom_important_data_group','email');
            register_setting('custom_important_data_group','bank_account_1');
            register_setting('custom_important_data_group','bank_account_2');
        }
    }

    if(!function_exists('custom_important_data_template')) {
        function custom_important_data_template() { ?>
            <div class="wrap">
                <h1><?= __('Ważne dane','sputnik-wp-theme'); ?></h1>

                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'custom_important_data_group' );
                    do_settings_sections( 'custom_important_data_group' );
                    ?>

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?= __('Adres urzędu','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="address" value="<?= esc_attr( get_option('address') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Godziny otwarcia','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="open_hours" value="<?= esc_attr( get_option('open_hours') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Telefon kontaktowy','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="phone" value="<?= esc_attr( get_option('phone') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Fax','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="fax" value="<?= esc_attr( get_option('fax') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Email','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="email" value="<?= esc_attr( get_option('email') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Numer konta bankowego 1','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="bank_account_1" value="<?= esc_attr( get_option('bank_account_1') ); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?= __('Numer konta bankowego 2','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="bank_account_2" value="<?= esc_attr( get_option('bank_account_2') ); ?>" /></td>
                        </tr>
                    </table>

                    <?php submit_button(); ?>
                </form>
            </div>
        <?php }
    }

    add_action('admin_menu', 'custom_important_data_page');
}