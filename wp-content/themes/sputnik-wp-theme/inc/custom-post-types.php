<?php

$custom_post_types_files = scandir(CUSTOM_INC . './custom-post-types/');

foreach($custom_post_types_files as $file) {
    if($file != '.' && $file != '..') {
        $custom_post_type_name = trim(str_replace('custom-post-type-', '', $file));

        if(get_option('choose_cpt_' . str_replace('.php', '', $custom_post_type_name))) require CUSTOM_INC . '/custom-post-types/custom-post-type-' . $custom_post_type_name;
    }
}