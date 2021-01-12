<?php

if(!function_exists('compareFiles')) {
    function compareFiles($file_a, $file_b) {
        if (filesize($file_a) == filesize($file_b) && md5_file($file_a) == md5_file($file_b)) {
            $fp_a = fopen($file_a, 'rb');
            $fp_b = fopen($file_b, 'rb');

            while ((!feof($fp_a) && ($b = fread($fp_a, 4096)) !== false)) {
                $b_b = fread($fp_b, 4096);
                if ($b !== $b_b)
                {
                    fclose($fp_a);
                    fclose($fp_b);
                    return false;
                }
            }

            fclose($fp_a);
            fclose($fp_b);

            return true;
        }

        return false;
    }
}

if(!function_exists('copy_files_with_folders')) {
    function copy_files_with_folders($src, $dst) {
        $dir = opendir($src);

        if(!file_exists($dst)) @mkdir($dst);

        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    copy_files_with_folders($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}

if(!function_exists('create_sputnik_wp_theme_child')) {
    function create_sputnik_wp_theme_child() {
        $child_source = CUSTOM_INC . '/sputnik-wp-theme-child/';

        $child_destination = WP_CONTENT_DIR . '/' . 'themes/' . basename($child_source);

        // Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
        if(!file_exists($child_destination)) {
            copy_files_with_folders($child_source, $child_destination);

            switch_theme(basename($child_source));

            $result['message'] = __('Poprawnie utworzono i aktywowano motyw .Sprawdź i edytuj folder wp-content/themes/sputnik-wp-theme-child. Strona zostanie przeładowana.','sputnik-wp-theme');

            $result['type'] = 'success';
        } else {
            $result['message'] = __('Niestety coś poszło nie tak... Spróbuj ponownie!','sputnik-wp-theme');

            $result['type'] = 'error';
        }

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result, JSON_UNESCAPED_UNICODE);

            echo $result;
        } else {
            header("Location: ". $_SERVER["HTTP_REFERER"]);
        }

        wp_die();
    }
    add_action('wp_ajax_create_sputnik_wp_theme_child', 'create_sputnik_wp_theme_child');
}