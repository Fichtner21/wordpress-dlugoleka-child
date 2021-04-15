<?php
/**
* @package Declaration
*/

/*
Plugin Name: Declaration
Description: Wtyczka tworzy stronę z deklaracją dostępności.
Author: Przemysław Drożniak & Ernest Fichtner
Text Domain: declaration
Version: 1.3.0
*/

defined( 'ABSPATH' ) or die('Sorry, you cant access to this site!');

if(defined('WP_DEBUG') && WP_DEBUG) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'debugger.php';
}

if(! class_exists('Declaration')) {
    class Declaration {
        public $plugin_name;

        function __construct() {
            $this->plugin_name = dirname(plugin_basename( __FILE__ ));
        }

        function update() {
            // Update Checker
            require dirname(__FILE__) . '/plugin-update-checker/plugin-update-checker.php';

            $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
                'https://github.com/Fichtner21/declaration/',
                __FILE__, //Full path to the main plugin file or functions.php.
                'declaration'
            );

            //Optional: If you're using a private repository, specify the access token like this:
            $myUpdateChecker->setAuthentication('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');

            //Optional: Set the branch that contains the stable release.
            $myUpdateChecker->setBranch('master');

            //Enable realese assets
            $myUpdateChecker->getVcsApi()->enableReleaseAssets();            
        }

        function activate() {
            require_once plugin_dir_path( __FILE__ ) . 'inc/declaration-activation.php';
            DeclarationActivation::activate();
        }

        function deactivate() {
            require_once plugin_dir_path( __FILE__ ) . 'inc/declaration-deactivation.php';
            DeclarationDeactivation::deactivate();
        }

        function register() {
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );
        }

        function enqueue_admin_assets() {
            // enqueue all our styles
            wp_enqueue_style( $this->plugin_name . '_admin_styles', plugins_url( '/admin/css/style.css', __FILE__ ) );
            wp_enqueue_script( $this->plugin_name . '_admin_scripts', plugins_url( '/admin/js/main.js', __FILE__ ) );
        }

        function enqueue_public_assets() {
            // enqueue all our styles
            wp_enqueue_style( $this->plugin_name . '_admin_styles', plugins_url( '/public/css/style.css', __FILE__ ) );
            wp_enqueue_script( $this->plugin_name . '_admin_scripts', plugins_url( '/public/js/main.js', __FILE__ ) );
        }

        function page_options() {
            add_action( 'admin_init', array( $this, 'theme_files' ) );
            add_action( 'admin_init', array( $this, 'hide_editor' ) );
            add_action( 'add_meta_boxes', array( $this, 'add_custom_fields_boxes' ) );
            add_action( 'wp_head', array( $this, 'add_meta_link' ) );
            add_action( 'save_post', array( $this, 'save_details' ), 100 );
        }

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

        function theme_files() {
            // Template with form to add post
            $filename = ABSPATH . 'wp-content/themes/' . get_option('stylesheet') . '/declaration.php';
            $content = __DIR__ . DIRECTORY_SEPARATOR . 'declaration-page-template.php';
            // Get content from declaration-content & create file in active theme folder
            if(!$this->compareFiles($filename, $content)) {
                $declaration_template = file_get_contents($content);

                file_put_contents($filename, $declaration_template);
            }
        }

        // Hide editor
        function hide_editor() {
            if(isset($_GET['post']) || isset($_POST['post_ID'])) {
                $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
            }
            if( !isset( $post_id ) ) return;

            $template_file = get_post_meta($post_id, '_wp_page_template', true);

            if($template_file == 'declaration.php'){ // edit the template name
                remove_post_type_support('page', 'thumbnail');
                remove_post_type_support('page', 'editor');
                remove_post_type_support('page', 'excerpt');
                remove_post_type_support('page', 'author');
                remove_post_type_support('page', 'comments');
                remove_post_type_support('page', 'postcustom');
                remove_meta_box( 'postcustom' , 'page' , 'normal' );
                remove_meta_box( 'slugdiv' , 'page' , 'normal' );
            }
        }
        // Add Metaboxes
        function add_custom_fields_boxes() {
            global $post;

            if(!empty($post)) {
                $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

                if($pageTemplate == 'declaration.php' ) {
                    add_meta_box(
                        'declaration_meta', // $id
                        'Pola dla deklaracji', // $title
                        array($this, 'display_custom_meta_boxes'), // $callback
                        'page', // $page
                        'normal', // $context
                        'high' // $priority
                    );
                }
            }
        }
        // Add meta content with link
        function add_meta_link() {
            if(get_page_by_title( 'Deklaracja dostępności' )) {
                $declaration_page_id = get_option('declaration_page_id');
            }

            $page_link = get_the_permalink( $declaration_page_id );

            echo '<meta name="deklaracja-dostępności" content="'. $page_link .'"/>';
        }
        function display_custom_meta_boxes() {
            global $post;

            $custom = get_post_custom($post->ID);

            $fullname = isset($custom["fullname"][0]) ? $custom["fullname"] : " ";
            $publish_date = isset($custom["publish-date"][0]) ? $custom["publish-date"] : " ";
            $address_email = isset($custom["address-email"][0]) ? $custom["address-email"] : " ";
            $page_date = isset($custom["page-date"][0]) ? $custom["page-date"] : " ";
            $attention_optional = isset($custom["attention-optional"][0]) ? $custom["attention-optional"] : " ";
            $phone_number = isset($custom["phone-number"][0]) ? $custom["phone-number"] : " ";
            $update_date = isset($custom["update-date"][0]) ? $custom["update-date"] : " ";
            $status = isset($custom["status"][0]) ? $custom["status"] : " ";
            $status2 = isset($custom["status2"][0]) ? $custom["status2"] : " ";

            $status_field_0 = isset($custom["status_field_0"][0]) ? $custom["status_field_0"] : " ";

            $status_field_1 = isset($custom["status_field_1"][0]) ? $custom["status_field_1"] : " ";
            $status_field_2 = isset($custom["status_field_2"][0]) ? $custom["status_field_2"] : " ";
            $status_field_3 = isset($custom["status_field_3"][0]) ? $custom["status_field_3"] : " ";
            $status_field_4 = isset($custom["status_field_4"][0]) ? $custom["status_field_4"] : " ";

            $rating_on = isset($custom["rating_on"][0]) ? $custom["rating_on"] : " ";
            $rating = isset($custom["rating"][0]) ? $custom["rating"] : " ";

            $accessibility_1 = isset($custom["accessibility-1"][0]) ? $custom["accessibility-1"] : " ";
            $accessibility_2 = isset($custom["accessibility-2"][0]) ? $custom["accessibility-2"] : " ";
            $accessibility_3 = isset($custom["accessibility-3"][0]) ? $custom["accessibility-3"] : " ";
            $accessibility_4 = isset($custom["accessibility-4"][0]) ? $custom["accessibility-4"] : " ";
            $accessibility_5 = isset($custom["accessibility-5"][0]) ? $custom["accessibility-5"] : " ";
            $accessibility_6 = isset($custom["accessibility-6"][0]) ? $custom["accessibility-6"] : " ";
            $accessibility_7 = isset($custom["accessibility-7"][0]) ? $custom["accessibility-7"] : " ";

            $mobile_app_android = isset($custom["mobile-app-android"][0]) ? $custom["mobile-app-android"] : " ";
            $mobile_app_ios = isset($custom["mobile-app-ios"][0]) ? $custom["mobile-app-ios"] : " ";

            require_once dirname(__FILE__) . '/declaration-admin-template.php' ;
        }
        // Save custom meta data when post publish
        function save_details() {
            global $post;

            if(!empty($post)) {
                $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

                if($pageTemplate == 'declaration.php' ) {
                    if(isset($_POST['dec_test'])){
                        update_post_meta($post->ID, "dec_test", $_POST["dec_test"]);
                    }
                    if(isset($_POST['fullname'])) {
                        update_post_meta($post->ID, "fullname", strip_tags( $_POST["fullname"] ));
                    }
                    if(isset($_POST['publish-date'])) {
                        update_post_meta($post->ID, "publish-date", strip_tags( $_POST["publish-date"] ));
                    }
                    if(isset($_POST['page-date'])) {
                        update_post_meta($post->ID, "page-date", strip_tags( $_POST["page-date"] ));
                    }
                    if(isset($_POST['update-date'])) {
                        update_post_meta($post->ID, "update-date", strip_tags( $_POST["update-date"] ));
                    }   
                    if(isset($_POST['status_field_0'])) {
                        update_post_meta($post->ID, "status_field_0", $_POST["status_field_0"]);
                    }                

                    if(isset($_POST['status_field_1'])) {
                        update_post_meta($post->ID, "status_field_1", $_POST["status_field_1"]);
                    }
                    if(isset($_POST['status_field_2'])) {
                        update_post_meta($post->ID, "status_field_2", $_POST["status_field_2"]);
                    }
                    if(isset($_POST['status_field_3'])) {
                        update_post_meta($post->ID, "status_field_3", $_POST["status_field_3"]);
                    }
                    if(isset($_POST['status_field_4'])) {
                        update_post_meta($post->ID, "status_field_4", $_POST["status_field_4"]);
                    }
                    if(isset($_POST['status'])) {
                        update_post_meta($post->ID, "status", strip_tags( $_POST["status"] ));
                    }
                    if(isset($_POST['status2'])) {
                        update_post_meta($post->ID, "status2", strip_tags( $_POST["status2"] ));
                    }
                    if(isset($_POST['rating_on']) && $_POST['rating_on'] == 'on' ) {
                        update_post_meta($post->ID, "rating_on", strip_tags( $_POST["rating_on"] ));
                    } else {
                        update_post_meta($post->ID, "rating_on", ' ');
                    }
                    if(isset($_POST['rating'])) {
                        update_post_meta($post->ID, "rating", strip_tags( $_POST["rating"] ));
                    }
                    if(isset($_POST['attention-optional'])) {
                        update_post_meta($post->ID, "attention-optional", $_POST["attention-optional"] );
                    }
                    if(isset($_POST['address-email'])) {
                        update_post_meta($post->ID, "address-email", strip_tags( $_POST["address-email"] ));
                    }
                    if(isset($_POST['phone-number'])) {
                        update_post_meta($post->ID, "phone-number", strip_tags( $_POST["phone-number"] ));
                    }
                    if(isset($_POST['accessibility-1'])) {
                        update_post_meta($post->ID, "accessibility-1", $_POST["accessibility-1"] );
                    }
                    if(isset($_POST['accessibility-2'])) {
                        update_post_meta($post->ID, "accessibility-2", $_POST["accessibility-2"] );
                    }
                    if(isset($_POST['accessibility-3'])) {
                        update_post_meta($post->ID, "accessibility-3", $_POST["accessibility-3"] );
                    }
                    if(isset($_POST['accessibility-4'])) {
                        update_post_meta($post->ID, "accessibility-4", $_POST["accessibility-4"] );
                    }
                    if(isset($_POST['accessibility-5'])) {
                        update_post_meta($post->ID, "accessibility-5", $_POST["accessibility-5"] );
                    }
                    if(isset($_POST['accessibility-6'])) {
                        update_post_meta($post->ID, "accessibility-6", $_POST["accessibility-6"] );
                    }
                    if(isset($_POST['accessibility-7'])) {
                        update_post_meta($post->ID, "accessibility-7", $_POST["accessibility-7"] );
                    }
                    if(isset($_POST['mobile-app-android'])) {
                        update_post_meta($post->ID, "mobile-app-android", $_POST["mobile-app-android"] );
                    }
                    if(isset($_POST['mobile-app-ios'])) {
                        update_post_meta($post->ID, "mobile-app-ios",  $_POST["mobile-app-ios"] );
                    }
                }
            }
        }
        // Restore page from trash
        function restore_page() {
            if(get_page_by_title( 'Deklaracja dostępności' )) {
                $declaration_page_id = get_option('declaration_page_id');

                wp_untrash_post($declaration_page_id);
            }
        }

        function register_ajax() {
            add_action( 'wp_ajax_change_status', array( $this, 'change_status' ) );
            add_action( 'wp_ajax_checkbox_change', array( $this, 'checkbox_change' ) );
        }

        function change_status() {
            $custom = get_post_custom( $_REQUEST['postID'] );
            $getStatus = $custom['status'][0];

            $updateStatus = update_post_meta( $_REQUEST['postID'], "status", strip_tags( $_REQUEST["status"] ) );

            if($updateStatus) {
                $result['type'] = 'success';
                $result['status'] = $_REQUEST['status'];
            } else {
                $result['type'] = 'error';
                $result['status'] = $getStatus;
            }

            // Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $result['request'] = $_REQUEST;

                $result = json_encode($result, JSON_UNESCAPED_UNICODE);

                echo $result;
            }
            else {
                header("Location: ". $_SERVER["HTTP_REFERER"]);
            }

            die();
        }

        function checkbox_change() {
            $custom = get_post_custom( $_REQUEST['postID'] );
            $getChecked = $custom['rating_on'][0];

            $updateCheckbox = update_post_meta( $_REQUEST['postID'], "rating_on", strip_tags( $_REQUEST['checked'] ) );

            if($updateCheckbox) {
                $result['type'] = 'success';
                $result['checked'] = $_REQUEST['checked'];
            } else {
                $result['type'] = 'error';
                $result['checked'] = ' ';
            }

            // Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $result['request'] = $_REQUEST;

                $result = json_encode($result, JSON_UNESCAPED_UNICODE);

                echo $result;
            }
            else {
                header("Location: ". $_SERVER["HTTP_REFERER"]);
            }

            die();
        }
    }

    $declaration = new Declaration();
    $declaration->register();
    $declaration->update();
    $declaration->page_options();
    $declaration->register_ajax();
    // activation
    register_activation_hook( __FILE__, array( $declaration, 'activate' ) );

    // deactivation
    register_deactivation_hook( __FILE__, array( $declaration, 'deactivate' ) );
}