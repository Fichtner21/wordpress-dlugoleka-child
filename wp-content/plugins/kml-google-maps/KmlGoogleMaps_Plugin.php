<?php

include_once('KmlGoogleMaps_LifeCycle.php');
include_once('KmlGoogleMaps_Meta.php');

class KmlGoogleMaps_Plugin extends KmlGoogleMaps_LifeCycle {

    /**
     * See: http://plugin.michael-simpson.com/?page_id=31
     * @return array of option meta data.
     */
    public function getOptionMetaData() {
        //  http://plugin.michael-simpson.com/?page_id=31
        $optionMetaData = array(
            //'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
            'GoogleApiKey' => array(__('Klucz Google API', $this->getPluginSlugName())),
            'GoogleMapDefaultData' => array(__('Domyślne współrzędne środka mapy', $this->getPluginSlugName()), 'lat', 'lng', 'zoom'),
			'ActivatedPageTypes' => array(__('Dodaj pole mapy do wybranych typów postów', $this->getPluginSlugName()))
        );

        foreach(get_post_types(array('public' => true)) as $pt)
        {
            array_push($optionMetaData['ActivatedPageTypes'], $pt);
        }

        return $optionMetaData;
    }

    /**
     * Summary of getOptionMetaDataFieldsTypes
     * @return string[]
     */
    public function getOptionMetaDataFieldsTypes() {
        return array(
            'GoogleApiKey' => 'input',
			'ActivatedPageTypes' => 'checkbox',
            'GoogleMapDefaultData' => 'map'
        );
    }

//    protected function getOptionValueI18nString($optionValue) {
//        $i18nValue = parent::getOptionValueI18nString($optionValue);
//        return $i18nValue;
//    }

    protected function initOptions() {
        $options = $this->getOptionMetaData();
        if (!empty($options)) {
            foreach ($options as $key => $arr) {
                if (is_array($arr) && count($arr > 1)) {
                    $this->addOption($key, $arr[1]);
                }
            }
        }
    }

    public function getPluginDisplayName() {
        return 'Kml Google Maps';
    }

	public function getPluginSlugName() {
        return 'kml-google-maps';
    }

    protected function getMainPluginFileName() {
        return 'kml-google-maps.php';
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
        //            `id` INTEGER NOT NULL");
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }


    /**
     * Perform actions when upgrading from version X to version Y
     * See: http://plugin.michael-simpson.com/?page_id=35
     * @return void
     */
    public function upgrade() {
    }

    public function addActionsAndFilters() {
        $meta = new KmlGoogleMaps_Meta($this);

        // Add options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));

        // Example adding a script & style just for the options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        //        if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
        //            wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
        //            wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        }


        // Add Actions & Filters
        // http://plugin.michael-simpson.com/?page_id=37


        // Adding scripts & styles to all pages
        // Examples:
        //        wp_enqueue_script('jquery');
        //        wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));


        // Register short codes
        // http://plugin.michael-simpson.com/?page_id=39
        add_shortcode('ShowKmlGoogleMap', array($meta, 'showShortcode'));

        // Register AJAX hooks
        // http://plugin.michael-simpson.com/?page_id=41

        //Add KML files to media
        function plugin_types($mime_types){
            $mime_types['kml'] = 'application/vnd.google-earth.kml+xml';
            return $mime_types;
        }
        add_filter('upload_mimes', 'plugin_types', 1, 1);
    }
}
