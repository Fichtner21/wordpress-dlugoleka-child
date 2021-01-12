<?php
// Creating the widget
if(!class_exists('custom_news')) {
    class custom_news extends WP_Widget {
        function __construct() {
            parent::__construct(

            // Base ID of your widget
            'custom_news',

            // Widget name will appear in UI
            __('Aktualności', 'sputnik_wp_theme'),

            // Widget description
            array( 'description' => __( 'Wyświetli aktualności', 'sputnik_wp_theme' ), )
            );
        }

        // Creating widget front-end

        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );

            // before and after widget arguments are defined by themes
            echo $args['before_widget'];

            if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];

            // This is where you run the code and display the output
            // ! news query no repeatable posts with category & cat_color
            require CUSTOM_PARTS . '/loops/loop-news.php';

            echo $args['after_widget'];
        }

        // Widget Backend
        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
            } else {
                $title = __( 'Inne aktualności', 'sputnik_wp_theme' );
            }
        // Widget admin form ?>

            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

        <?php }

        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();

            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

            return $instance;
        }

        // Class custom_news ends here
    }


    // Register and load the widget
    function custom_news_load() {
        register_widget( 'custom_news' );
    }

    add_action( 'widgets_init', 'custom_news_load' );
}