<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_flickr');

function viral_pro_register_flickr() {
    register_widget('viral_pro_flickr');
}

class viral_pro_flickr extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'viral_pro_flickr', '&bull; VP : Flickr', array(
            'description' => __('A widget to display Flickr Images', 'viral-pro')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            // Title
            'title' => array(
                'viral_pro_widgets_name' => 'title',
                'viral_pro_widgets_title' => esc_html__('Title', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            // Other fields
            'api_key' => array(
                'viral_pro_widgets_name' => 'api_key',
                'viral_pro_widgets_title' => esc_html__('API Key', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'flickr_id' => array(
                'viral_pro_widgets_name' => 'flickr_id',
                'viral_pro_widgets_title' => esc_html__('Flickr ID', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'count' => array(
                'viral_pro_widgets_name' => 'count',
                'viral_pro_widgets_title' => esc_html__('Number of Images', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number',
                'viral_pro_widgets_default' => '9'
            ),
            'image_size' => array(
                'viral_pro_widgets_name' => 'image_size',
                'viral_pro_widgets_title' => esc_html__('Image Size', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'q' => esc_html__('Small Square Size', 'viral-pro'),
                    't' => esc_html__('Thumbnail', 'viral-pro'),
                    'n' => esc_html__('Small Size', 'viral-pro'),
                    'z' => esc_html__('Medium Size', 'viral-pro'),
                    'b' => esc_html__('Large Size', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'q'
            ),
            'enable_space' => array(
                'viral_pro_widgets_name' => 'enable_space',
                'viral_pro_widgets_title' => esc_html__('Enable Space Between Images', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox'
            ),
            'show_caption' => array(
                'viral_pro_widgets_name' => 'show_caption',
                'viral_pro_widgets_title' => esc_html__('Show Caption', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox'
            ),
            'row_height' => array(
                'viral_pro_widgets_name' => 'row_height',
                'viral_pro_widgets_title' => esc_html__('Row Height', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number',
                'viral_pro_widgets_default' => 120,
                'viral_pro_widgets_description' => esc_html__('The height determines the no of image in row', 'viral-pro')
            )
        );

        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);

        $title = isset($instance['title']) ? apply_filters('title', $instance['title']) : '';
        $flickr_id = isset($instance['flickr_id']) ? $instance['flickr_id'] : '';
        $count = isset($instance['count']) ? $instance['count'] : '';
        $api_key = isset($instance['api_key']) ? $instance['api_key'] : '';
        $image_size = isset($instance['image_size']) ? $instance['image_size'] : '';
        $enable_space = (isset($instance['enable_space']) && $instance['enable_space']) ? 'enable-space' : '';
        $show_caption = (isset($instance['show_caption']) && $instance['show_caption']) ? 'true' : 'false';
        $margin = (isset($instance['enable_space']) && $instance['enable_space']) ? 10 : 0;
        $row_height = (isset($instance['row_height']) && $instance['row_height']) ? $instance['row_height'] : 120;
        $selector = 'viral_pro_' . md5(uniqid(rand(), true));

        echo $before_widget;

        // Show title
        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;
        ?>
        <div id="<?php echo esc_attr($selector); ?>wrapper" class="<?php echo $enable_space; ?>"></div>
        <script>
            jQuery(function ($) {
                $('#<?php echo esc_attr($selector); ?>wrapper').photostream({
                    api_key: '<?php echo $api_key; ?>',
                    user_id: '<?php echo $flickr_id; ?>',
                    image_size: '<?php echo $image_size; ?>',
                    image_count: '<?php echo $count; ?>',
                });

                $('#<?php echo esc_attr($selector); ?>wrapper').on('ps.complete', function () {
                    $(this).justifiedGallery({
                        rowHeight: <?php echo absint($row_height); ?>,
                        lastRow: 'nojustify',
                        captions: <?php echo $show_caption; ?>,
                        border: 0,
                        margins: <?php echo $margin; ?>
                    });
                });
            });
        </script>
        <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses    viral_pro_widgets_updated_field_value()        defined in widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {
            extract($widget_field);
            if (!viral_pro_exclude_widget_update($viral_pro_widgets_field_type)) {
                $new = isset($new_instance[$viral_pro_widgets_name]) ? $new_instance[$viral_pro_widgets_name] : '';
                // Use helper function to get updated field values
                $instance[$viral_pro_widgets_name] = viral_pro_widgets_updated_field_value($widget_field, $new);
            }
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses    viral_pro_widgets_show_widget_field()      defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();
        // Loop through fields
        foreach ($widget_fields as $widget_field) {
            // Make array elements available as variables
            extract($widget_field);

            if (!viral_pro_exclude_widget_update($viral_pro_widgets_field_type)) {
                $viral_pro_widgets_field_value = !empty($instance[$viral_pro_widgets_name]) ? $instance[$viral_pro_widgets_name] : '';
            } else {
                $viral_pro_widgets_field_value = '';
            }

            viral_pro_widgets_show_widget_field($this, $widget_field, $viral_pro_widgets_field_value);
        }
    }

}
