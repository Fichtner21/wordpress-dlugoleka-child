<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Sputnik Wp Theme
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require CUSTOM_INC . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'sputnik_wp_theme_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function sputnik_wp_theme_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// This is an example of how to include a plugin from a GitHub repository in your theme.
		// This presumes that the plugin code is based in the root of the GitHub repository
		// and not in a subdirectory ('/src') of the repository.
		// ! Github Repo is have to be Public or allow to download zip package
		array( // * This is private
			'name'      => 'Sputnik Search',
			'slug'      => 'sputnik-search',
			'source'    => 'https://github.com/Fichtner21/sputnik-search/archive/master.zip',
		),
		array( // * This is private
			'name'      => 'Declaration',
			'slug'      => 'declaration',
			'source'    => 'https://github.com/Fichtner21/declaration/archive/master.zip',
		),
		array(
			'name'   => 'Advanced Custom Fields PRO',
			'slug'   => 'advanced-custom-fields-pro',
			'source' => 'https://github.com/wp-premium/advanced-custom-fields-pro/archive/master.zip',
		),
		array(
			'name'   => 'Advanced Custom Fields: Font Awesome',
			'slug'   => 'advanced-custom-fields-font-awesome',
			'source' => 'https://github.com/jessepearson/advanced-custom-fields-font-awesome/archive/master.zip',
		),
		array(
			'name'   => 'gtranslate',
			'slug'   => 'gtranslate',
			'required' => false,
		),
		array(
			'name'   => 'Smush',
			'slug'   => 'wp-smushit',
			'required' => false,
		),
		array(
			'name'        => 'Yoast SEO',
			'slug'        => 'wordpress-seo',
			'required' => false,
		),
		array(
			'name'        => 'Yop Poll',
			'slug'        => 'yop-poll',
			'required' => false,
		),
		array(
			'name'        => 'LuckyWP ACF Menu Field',
			'slug'        => 'luckywp-acf-menu-field',
			'required' => false,
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'sputnik-wp-theme',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		'strings'      => array(
			'page_title'                      => __( 'Zainstaluj wymagane wtyczki', 'sputnik-wp-theme' ),
			'menu_title'                      => __( 'Wymagane wtyczki', 'sputnik-wp-theme' ),
			/* translators: %s: plugin name. */
			'installing'                      => __( 'Instalowanie wtyczki: %s', 'sputnik-wp-theme' ),
			/* translators: %s: plugin name. */
			'updating'                        => __( 'Aktualizowanie wtyczki: %s', 'sputnik-wp-theme' ),
			'oops'                            => __( 'Coś poszło nietak z pluginem API.', 'sputnik-wp-theme' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). */
				'Ten motyw wymaga następującej wtyczki: %1$s.',
				'Ten motyw wymaga następujących wtyczek: %1$s.',
				'sputnik-wp-theme'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). */
				'Ten motyw zaleca następującą wtyczkę: %1$s.',
				'Ten motyw zaleca następujące wtyczki: %1$s.',
				'sputnik-wp-theme'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). */
				'Następującą wtyczkę należy zaktualizować do najnowszej wersji, aby zapewnić maksymalną zgodność z tym motywem: %1$s.',
				'Następujące wtyczki należy zaktualizować do najnowszej wersji, aby zapewnić maksymalną zgodność z tym motywem: %1$s.',
				'sputnik-wp-theme'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). */
				'Dostępna jest aktualizacja dla: %1$s.',
				'Dostępne są aktualizacje dla następujących wtyczek: %1$s.',
				'sputnik-wp-theme'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). */
				'Następująca wymagana wtyczka jest obecnie nieaktywna: %1$s.',
				'Następujące wymagane wtyczki są obecnie nieaktywne: %1$s.',
				'sputnik-wp-theme'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). */
				'Następująca zalecana wtyczka jest obecnie nieaktywna: %1$s.',
				'Następujące zalecane wtyczki są obecnie nieaktywne: %1$s.',
				'sputnik-wp-theme'
			),
			'install_link'                    => _n_noop(
				'Rozpocznij instalację wtyczki',
				'Rozpocznij instalację wtyczek',
				'sputnik-wp-theme'
			),
			'update_link' 					  => _n_noop(
				'Rozpocznij instalację wtyczek',
				'Rozpocznij aktualizację wtyczek',
				'sputnik-wp-theme'
			),
			'activate_link'                   => _n_noop(
				'Rozpocznij aktywację wtyczki',
				'Rozpocznij aktywację wtyczek',
				'sputnik-wp-theme'
			),
			'return'                          => __( 'Wróć do wymaganego instalatora wtyczek', 'sputnik-wp-theme' ),
			'plugin_activated'                => __( 'Wtyczka została aktywowana pomyślnie.', 'sputnik-wp-theme' ),
			'activated_successfully'          => __( 'Następująca wtyczka została pomyślnie aktywowana:', 'sputnik-wp-theme' ),
			/* translators: 1: plugin name. */
			'plugin_already_active'           => __( 'Nie podjęto żadnego działania. Wtyczka %1$s jest już aktywna.', 'sputnik-wp-theme' ),
			/* translators: 1: plugin name. */
			'plugin_needs_higher_version'     => __( 'Wtyczka nie została aktywowana. Wyższa wersja %s jest potrzebna do tego tematu. Zaktualizuj wtyczkę.', 'sputnik-wp-theme' ),
			/* translators: 1: dashboard link. */
			'complete'                        => __( 'Wszystkie wtyczki zostały pomyślnie zainstalowane i aktywowane. %1$s', 'sputnik-wp-theme' ),
			'dismiss'                         => __( 'Odrzuć to powiadomienie', 'sputnik-wp-theme' ),
			'notice_cannot_install_activate'  => __( 'Istnieje co najmniej jedna wymagana lub zalecana wtyczka do zainstalowania, aktualizacji lub aktywacji.', 'sputnik-wp-theme' ),
			'contact_admin'                   => __( 'Skontaktuj się z administratorem tej witryny, aby uzyskać pomoc.', 'sputnik-wp-theme' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),

	);

	tgmpa( $plugins, $config );
}
