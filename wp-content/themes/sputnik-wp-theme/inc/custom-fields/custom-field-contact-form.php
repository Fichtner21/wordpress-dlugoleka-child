<?php

if(!function_exists('contact_formpage')) {
    function contact_formpage() {
        add_submenu_page(
            'options-general.php', 'Contact form', 'Wstaw Formularz', 'manage_options', 'contact-form-options', 'contact_formtemplate'
        );

        //call register settings function
        add_action( 'admin_init', 'register_contact_formsettings' );
    };

    if(!function_exists('register_contact_formsettings')) {
        function register_contact_formsettings() {
            // Register all options
            register_setting('contact_formgroup','contact_formshortcode');
        }
    }

    if(!function_exists('contact_formtemplate')) {
        function contact_formtemplate() { ?>
            <div class="wrap">
                <h1><?= __('Wstaw formularz','sputnik-wp-theme'); ?></h1>

                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'contact_formgroup' );
                    do_settings_sections( 'contact_formgroup' );
                    ?>

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?= __('Shortcode','sputnik-wp-theme'); ?></th>
                            <td><input type="text" name="contact_formshortcode" value="<?= esc_attr( get_option('contact_formshortcode') ); ?>" /></td>
                        </tr>
                    </table>

                    <?php submit_button(); ?>
                </form>
            </div>
        <?php }
    }

    add_action('admin_menu', 'contact_formpage');
}