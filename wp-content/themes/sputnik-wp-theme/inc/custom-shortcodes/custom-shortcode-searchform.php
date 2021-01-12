<?php

if(!function_exists('custom_get_search_form_shortcode')) {
    function custom_get_search_form_shortcode() {
        return get_search_form(false);
    }

    add_shortcode('display_search_form', 'custom_get_search_form_shortcode');
}