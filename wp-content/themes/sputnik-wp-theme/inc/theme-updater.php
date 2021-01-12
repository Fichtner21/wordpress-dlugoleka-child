<?php

// require main updater file
require CUSTOM_INC . '/plugin-update-checker-4.10/plugin-update-checker.php';

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/interakcjo/sputnik-wp-theme/',
	get_template_directory(),
	'sputnik-wp-theme'
);

//Optional: If you're using a private repository, specify the access token like this:
$myUpdateChecker->setAuthentication('0ae3e7b11069ef11bd42af1c902a9ae8ceca1348');

//Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

//Enable realese assets
$myUpdateChecker->getVcsApi()->enableReleaseAssets();