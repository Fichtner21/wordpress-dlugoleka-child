<?php

if(!function_exists('choose_cpt')) {
    function choose_cpt() {
        add_submenu_page(
            'options-general.php', 'Wybierz "Custom post types"', 'Wybierz "Custom post types"', 'manage_options', 'choose-cpt-options', 'choose_cpt_template'
        );

        //call register settings function
        add_action( 'admin_init', 'register_choose_cpt_settings' );
    };

    if(!function_exists('register_choose_cpt_settings')) {
        function register_choose_cpt_settings() {
            // Register all options
            $all_post_types = get_all_custom_post_types();

            foreach($all_post_types as $post_type) {
                $post_name = strtolower($post_type);

                register_setting('choose_cpt_group',"choose_cpt_$post_name");
            }
        }
    }

    if(!function_exists('choose_cpt_template')) {
        function choose_cpt_template() { $all_post_types = get_all_custom_post_types(); ?>
            <div class="wrap">
                <h1><?= __('Wybierz, które "Custom Post Types" mają być aktywne','sputnik-wp-theme'); ?></h1>

                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'choose_cpt_group' );
                    do_settings_sections( 'choose_cpt_group' );
                    ?>

                    <table class="form-table">
                        <?php foreach($all_post_types as $post_type) :

                            $cpt_option = 'choose_cpt_' . strtolower($post_type);

                            $isExists = !empty(esc_attr( get_option( $cpt_option ) )) ? get_option( $cpt_option ) : $cpt_option;
                            $isChecked = !empty(esc_attr( get_option( $cpt_option ) )) ? 'Checked' : null;
                            ?>
                            <tr valign="top">
                                <td>
                                    <label for="<?= $cpt_option; ?>"><?= $post_type; ?></label>
                                    <input type="checkbox" id="<?= $cpt_option; ?>" name="<?= $cpt_option; ?>" value="<?= $isExists; ?>" <?= $isChecked; ?> />
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <?php submit_button(); ?>
                </form>
            </div>
        <?php }
    }

    add_action('admin_menu', 'choose_cpt');
}