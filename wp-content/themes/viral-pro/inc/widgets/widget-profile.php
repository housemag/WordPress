<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_profile');

function viral_pro_register_profile() {
    register_widget('viral_pro_profile');
}

class viral_pro_profile extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display Personal/Company Information', 'viral-pro'));
        //$control_ops = array('width' => 500, 'height' => 400);
        parent::__construct('viral_pro_profile', '&bull; VP : Profile', $widget_ops);
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            'ht_tab' => array(
                'viral_pro_widgets_tabs' => array(
                    'ht-input' => __('Inputs', 'viral-pro'),
                    'ht-settings' => __('Settings', 'viral-pro')
                ),
                'viral_pro_widgets_field_type' => 'tab'
            ),
            'tab_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content-wrap',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'input_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content',
                'viral_pro_widgets_data_id' => 'ht-input',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'title' => array(
                'viral_pro_widgets_name' => 'title',
                'viral_pro_widgets_title' => __('Title', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'image' => array(
                'viral_pro_widgets_name' => 'image',
                'viral_pro_widgets_title' => __('Image', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'upload'
            ),
            'intro' => array(
                'viral_pro_widgets_name' => 'intro',
                'viral_pro_widgets_title' => __('Short Intro', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'inline_editor',
                'viral_pro_widgets_row' => '4'
            ),
            'name' => array(
                'viral_pro_widgets_name' => 'name',
                'viral_pro_widgets_title' => __('Name', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'readmore_text' => array(
                'viral_pro_widgets_name' => 'readmore_text',
                'viral_pro_widgets_title' => __('Read More Text', 'viral-pro'),
                'viral_pro_widgets_default' => __('Read More', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'readmore_link' => array(
                'viral_pro_widgets_name' => 'readmore_link',
                'viral_pro_widgets_title' => __('Read More Link', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'alignment' => array(
                'viral_pro_widgets_name' => 'alignment',
                'viral_pro_widgets_title' => __('Content Alignment', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'left' => __('Left', 'viral-pro'),
                    'center' => __('Center', 'viral-pro'),
                    'right' => __('Right', 'viral-pro'),
                ),
                'viral_pro_widgets_field_default' => 'left'
            ),
            'image_size' => array(
                'viral_pro_widgets_name' => 'image_size',
                'viral_pro_widgets_title' => __('Image Size', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => viral_pro_get_image_sizes(),
                'viral_pro_widgets_field_default' => 'full'
            ),
            'round_image' => array(
                'viral_pro_widgets_name' => 'round_image',
                'viral_pro_widgets_title' => __('Round Image (Upload or Choose Square Image size)', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox',
            ),
            'input_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'settings_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content',
                'viral_pro_widgets_data_id' => 'ht-settings',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'text_color' => array(
                'viral_pro_widgets_name' => 'text_color',
                'viral_pro_widgets_title' => __('Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'link_color' => array(
                'viral_pro_widgets_name' => 'link_color',
                'viral_pro_widgets_title' => __('Read More Link Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'background_color' => array(
                'viral_pro_widgets_name' => 'background_color',
                'viral_pro_widgets_title' => __('Background Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'padding' => array(
                'viral_pro_widgets_name' => 'padding',
                'viral_pro_widgets_title' => __('Padding', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number'
            ),
            'settings_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'tab_close' => array(
                'viral_pro_widgets_field_type' => 'close'
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

        $title = isset($instance['title']) ? $instance['title'] : '';
        $image = isset($instance['image']) ? $instance['image'] : '';
        $intro = isset($instance['intro']) ? $instance['intro'] : '';
        $name = isset($instance['name']) ? $instance['name'] : '';
        $alignment = isset($instance['alignment']) ? $instance['alignment'] : 'left';
        $readmore_link = isset($instance['readmore_link']) ? $instance['readmore_link'] : '';
        $readmore_text = isset($instance['readmore_text']) ? $instance['readmore_text'] : esc_html__('Read More', 'viral-pro');
        $image_size = isset($instance['image_size']) ? $instance['image_size'] : 'full';
        $text_color = isset($instance['text_color']) ? $instance['text_color'] : '';
        $link_color = isset($instance['link_color']) ? $instance['link_color'] : '';
        $background_color = isset($instance['background_color']) ? $instance['background_color'] : '';
        $padding = isset($instance['padding']) ? $instance['padding'] : '';
        $round_image = (isset($instance['round_image']) && $instance['round_image']) ? ' ht-round-image' : '';

        $title_style = $text_style = $link_style = $wrap_style = '';
        $wrap_css = array();

        if (!empty($text_color)) {
            $text_style = 'style="color:' . $text_color . '"';
        }

        if (!empty($link_color)) {
            $link_style = 'style="color:' . $link_color . '"';
        }

        if (!empty($background_color)) {
            $wrap_css[] = "background-color:$background_color";
        }

        if (!empty($padding)) {
            $wrap_css[] = "padding:" . $padding . "px";
        }

        if (!empty($wrap_css)) {
            $wrap_style = 'style="' . implode(';', $wrap_css) . '"';
        }

        $image_url = $image;
        $image_id = attachment_url_to_postid($image);
        if ($image_id) {
            $image_array = wp_get_attachment_image_src($image_id, $image_size);
            $image_url = $image_array[0];
        }

        echo $before_widget;

        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;
        ?>
        <div class="ht-personal-info ht-pi-<?php echo esc_attr($alignment); ?>" <?php echo $wrap_style; ?>>

            <?php
            if (!empty($image_url)):
                echo '<div class="ht-pi-image' . $round_image . '"><img alt="' . esc_html($title) . '" src="' . esc_url($image_url) . '"/></div>';
            endif;

            if (!empty($name)):
                echo '<div class="ht-pi-name"><h5 ' . $text_style . '>' . esc_html($name) . '</h5></div>';
            endif;

            if (!empty($intro)):
                echo '<div class="ht-pi-intro" ' . $text_style . '>' . wp_kses_post(wpautop($intro)) . '</div>';
            endif;

            if (!empty($readmore_link)):
                echo '<div class="ht-pi-readmore">';
                echo '<a href="' . esc_url($readmore_link) . '" ' . $link_style . '>' . esc_html($readmore_text) . '<i class="ei arrow_right"></i></a>';
                echo '</div>';
            endif;
            ?>
        </div>
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
