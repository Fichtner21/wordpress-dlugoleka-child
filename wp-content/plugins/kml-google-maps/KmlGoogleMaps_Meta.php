<?php

class KmlGoogleMaps_Meta {
    private $parent;
    private $googleApiKey;
    private $activatedPageTypes;
    private $defaultData;
    private $frontData;

    function __construct($parent){
        $this->parent = $parent;
        $this->googleApiKey = $this->parent->getOption('GoogleApiKey');
        $this->activatedPageTypes = $this->parent->getOption('ActivatedPageTypes');
        $this->defaultData = $this->parent->getOption('GoogleMapDefaultData');

        add_action('add_meta_boxes', array(&$this, 'kml_google_maps_dynamic_add_meta_box'));
        add_action('admin_enqueue_scripts', array(&$this, 'kml_google_maps_add_admin_css_and_js'));
        add_action('save_post', array(&$this, 'kml_google_maps_save_post'));
    }

    /**
     * Summary of postMetaDefinition
     * @return array[]
     */
    private function postMetaDefinition() {
        return array(
            'GoogleMapPostData' => array(
                'map' => array('description' => 'Mapa', 'type' => 'map'),
                'lat' => array('val' => $this->defaultData[0], 'description' => 'Latitude', 'type' => 'hidden'),
                'lng' => array('val' => $this->defaultData[1], 'description' => 'Longitude', 'type' => 'hidden'),
                'zoom' => array('val' => $this->defaultData[2], 'description' => 'Zoom', 'type' => 'hidden'),
                'kmls' => array('val' => '', 'description' => 'Lista plików kml', 'type' => 'kmls'),
                'drawing' => array('val' => '', 'description' => 'Własne kształty', 'type' => 'drawing'),
                'popup' => array('val' => '', 'description' => 'Popup', 'type' => 'popup')
            )
        );
    }

    /**
     * Summary of getPostMeta
     * @param mixed $post_id
     * @return array
     */
    private function getPostMeta($post_id) {
        $fields = $this->postMetaDefinition();

        foreach($fields as $name => $data){
            $postMetaObject = get_post_meta($post_id, $name, true);
            if($postMetaObject != ''){
                foreach($data as $dataName => $dataValue){
                    if(array_key_exists('val', $dataValue)){
                        if(array_key_exists('json', $dataValue) && $dataValue['json']){
                            $fields[$name][$dataName]['val'] = json_encode($postMetaObject[$dataName]['val']);
                        }
                        else {
                            $fields[$name][$dataName]['val'] = $postMetaObject[$dataName]['val'];
                        }
                    }
                }
            }
        }

        return $fields;
    }

    /**
     * Summary of savePostMetaDBObject
     * @param mixed $post
     */
    private function savePostMetaDBObject($post) {
        $postMeta = $this->getPostMeta($post->ID);

        foreach ($postMeta as $name => $data) {
            $result = array();
            foreach ($data as $dataName => $dataValue) {
                if (isset($_POST[$dataName])) {
                    if(array_key_exists('json', $dataValue) && $dataValue['json']){
                        $result[$name][$dataName]['val'] = json_decode($_POST[$dataName]);
                    }
                    else {
                        $result[$name][$dataName]['val'] = $_POST[$dataName];
                    }
                }
            }
            update_post_meta($post->ID, $name, $result[$name]);
        }
    }

    public function kml_google_maps_save_post($post_id){
        $post = get_post($post_id);

        if (!in_array($post->post_type, $this->activatedPageTypes))
            return;

        $this->savePostMetaDBObject($post);
    }

    public function kml_google_maps_add_admin_css_and_js($hook){
        global $post;
       
        if(isset($post) && (in_array($post->post_type, $this->activatedPageTypes) || $hook == "toplevel_page_KmlGoogleMaps_PluginSettings")){
            wp_enqueue_script('google_js', 'https://maps.googleapis.com/maps/api/js?key='.$this->googleApiKey.'&libraries=drawing');

            wp_register_script('kgm_helper', plugins_url('js/kml_google_maps_helper.js', __FILE__), array('jquery'), '1.0');
            wp_enqueue_script('kgm_helper');

            if(in_array($post->post_type, $this->activatedPageTypes)){
                wp_register_style('kgm_style', plugins_url('css/kml_google_maps_post.css', __FILE__));
                wp_enqueue_style('kgm_style');

                wp_register_script('kgm_main', plugins_url('js/kml_google_maps_post.js', __FILE__), array('jquery'), '1.0');
                wp_enqueue_script('kgm_main');

                wp_register_script('kgm_drawing_manager', plugins_url('js/kml_google_maps_drawing_manager.js', __FILE__), array('jquery'), '1.0');
                wp_enqueue_script('kgm_drawing_manager');

                wp_enqueue_media();

                wp_register_style('jquery_ui_css', plugins_url('jquery-ui/jquery-ui.min.css', __FILE__));
                wp_enqueue_style('jquery_ui_css');

                wp_register_script('jquery_ui_js', plugins_url('jquery-ui/jquery-ui.min.js', __FILE__), array('jquery'), '1.0');
                wp_enqueue_script('jquery_ui_js');

                wp_enqueue_style('context_menu_fontawesome_css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

                wp_register_style('context_menu_css', plugins_url('context-menu/jquery.contextMenu.min.css', __FILE__));
                wp_enqueue_style('context_menu_css');

                wp_register_script('context_menu_js', plugins_url('context-menu/jquery.contextMenu.min.js', __FILE__), array('jquery'), '1.0');
                wp_enqueue_script('context_menu_js');

                wp_register_script('kgm_io', plugins_url('js/kml_google_maps_IO.js', __FILE__), array('jquery'), '1.0');
                wp_enqueue_script('kgm_io');
            }

            if($hook == "toplevel_page_KmlGoogleMaps_PluginSettings"){
                wp_register_style('kgm_style_admin', plugins_url('css/kml_google_maps_settings.css', __FILE__));
                wp_enqueue_style('kgm_style_admin');

                wp_register_script('kgm_main_admin', plugins_url('js/kml_google_maps_settings.js', __FILE__), array('jquery'), '1.0');
                wp_enqueue_script('kgm_main_admin');
            }
        }
    }

    public function kml_google_maps_dynamic_add_meta_box() {
        foreach ($this->activatedPageTypes as $screen) {

            add_meta_box(
              'kml_google_maps_meta_sectionid',
              __( 'Mapa', 'layerswp' ),
              array(&$this, 'kml_google_maps_meta_box_callback'),
              $screen,
                  'normal',
                  'high'
             );
        }
    }

    public function kml_google_maps_meta_box_callback($post) {
        $postMeta = $this->getPostMeta($post->ID);
        foreach ($postMeta as $name => $data) {
            foreach($data as $dataName => $dataValue){
                $this->prepareField($dataName, $dataValue);
            }
        }
    }

    /**
     * Summary of prepareField
     * @param mixed $key
     * @param mixed $value
     */
    public function prepareField($id, $data){
        switch ($data['type']) {
            case "input":
                    ?>
                        <p><label for="<?php echo $id; ?>"><?php echo $data['description']; ?>: </label><input type="text" name="<?php echo $id ?>" id="<?php echo $id ?>"  value="<?php echo esc_attr($data['val']) ?>" size="50"/></p>
                    <?php
                break;
            case "hidden":
                    ?>
                        <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id ?>" value="<?php echo esc_attr($data['val']) ?>" size="50" />
                    <?php
                break;
            case "map":
                    ?>
                        <div id="<?php echo $id; ?>"></div>
                        <div id="previewModeContainer">
                            <input id="previewMode" type="checkbox" />
                            <label for="previewMode">Przełącz w tryb podglądu</label>
                        </div>
                    <?php
                break;
            case "kmls":
                    ?>
                        <ul id="kmlsList">
                            <?php
                                if($data['val'] != ''){
                                    $kmlIds = explode(',', $data['val']);
                                    foreach($kmlIds as $kmlId){
                                        $attachment = get_post($kmlId);
                                        $kmlUrl = $attachment->guid;
                                        ?>
                                            <li class="ui-state-default kml-li-item" data-id="<?php echo $kmlId; ?>" data-url="<?php echo $kmlUrl; ?>">
                                                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $attachment->post_title.' - '.basename($kmlUrl);  ?>
                                                <span class="remove-kml">
                                                    <span class="ui-icon ui-icon-trash" onclick="removeKml(this)"></span>
                                                </span>
                                            </li>
                                        <?php
                                    }
                                }
                            ?>
                        </ul>

                        <div id="kmlRemoveConfirm" title="Potwierdzenie usuwania" hidden="hidden">
                            <p>
                                <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
                                <p>Czy chcesz usunąć wybrany plik?</p>
                                <p id="kmlToRemoveUrl"></p>
                            </p>
                        </div>

                        <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id ?>" value="<?php echo $data['val']; ?>" />

                        <button type="button" id="kmlUploadButton" class="button button-primary button-large">
                            Dodaj plik KML
                    </button>                
                <?php
                break;
            case "drawing":
                ?>
                    <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id ?>" value='<?php echo $data['val']; ?>' />

                    <input type="color" id="colorPicker" style="display: none;" />

                    <div id="itemRemoveConfirm" title="Potwierdzenie usuwania" hidden="hidden">
                        <p>
                            <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
                            <p>Czy chcesz usunąć wybrany element?</p>
                            <p class="bold">Tej akcji nie można cofnąć</p>
                        </p>
                    </div>
                <?php
                break;
            case 'popup':
                ?>
                    <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id ?>" value='<?php echo $data['val']; ?>' />

                    <div id="popUpData" title="Dane obiektu" hidden="hidden">
                        <input type="hidden" id="popup_id" />
                        <input type="text" id="popup_title" spellcheck="true" autocomplete="off" placeholder="Nagłówek" />
                        <?php wp_editor('', 'popup_content', array('textarea_rows' => 20, 'tinymce' => false)); ?>
                        <div id="popup_hidden_zone">
                            <input type="checkbox" id="popup_hidden" value="hidden" />
                            <label for="popup_hidden">Ukryj PopUp dla edytowanego elementu</label>
                        </div>
                    </div>
                <?php
        }
    }

    public function showShortcode($atts){
        ob_start();
        $mapHeight = !isset($atts['height']) ? '500px' : $atts['height'];
        $mapId = !isset($atts['id']) ? null : $atts['id'];
        $post = get_post($mapId);
        $postMetaData = $this->getPostMeta($post->ID);
        $googleMapPostData = $postMetaData['GoogleMapPostData'];

        wp_enqueue_script('google_js', 'https://maps.googleapis.com/maps/api/js?key='.$this->googleApiKey.'&libraries=drawing');
        wp_register_script('kgm_io', plugins_url('js/kml_google_maps_IO.js', __FILE__), array('jquery'), '1.0');
        wp_print_scripts('kgm_io');
        wp_register_script('kgmfront', plugins_url('js/kml_google_maps_front.js', __FILE__), array('jquery'), '1.0', true);
        wp_print_scripts('kgmfront');

        $kmlUrls = array();
        if ($googleMapPostData['kmls']['val'] != '') {
            $kmlIds = explode(',', $googleMapPostData['kmls']['val']);
            foreach($kmlIds as $kmlId){
                $attachment = get_post($kmlId);
                array_push($kmlUrls, $attachment->guid);
            }
        }
?>
            <div id="kmlGoogleMap_<?php echo $post->ID; ?>" class="kml_map" style="height: <?php echo $mapHeight; ?>"></div>
            
            <script>
                function init_kmlGoogleMap_<?php echo $post->ID; ?>() {
                    var mapSettings = {
                        map_id: 'kmlGoogleMap_<?php echo $post->ID; ?>',
                        lat: <?php echo $googleMapPostData['lat']['val']; ?>,
                        lng: <?php echo $googleMapPostData['lng']['val']; ?>,
                        zoom: <?php echo $googleMapPostData['zoom']['val']; ?>,
                        drawings: <?php echo $googleMapPostData['drawing']['val']; ?>,
                        kml_urls: ['<?php echo implode("','", $kmlUrls); ?>'],
                        popups_data: <?php echo $googleMapPostData['popup']['val'];; ?>
                    }
                    createMap(mapSettings);
                }
            </script>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;      
    }
}
?>