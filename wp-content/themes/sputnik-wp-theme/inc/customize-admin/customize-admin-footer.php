<?php
// Custom Admin footer
if(!function_exists('add_copyright_admin_footer')) {
	function add_copyright_admin_footer () {
        echo function_exists('svg_icon_admin') ? svg_icon_admin('sputnik-icon', 2) : false;

		echo '<span id="footer-thankyou">'. __('Copyright 2020 @ Sputnik.pl. Wszelkie prawa zastrzeżone.','sputnik-wp-theme') .'</span>';
	}

	add_filter( 'admin_footer_text', 'add_copyright_admin_footer' );
}
