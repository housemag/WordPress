<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_social_icons');

function viral_pro_register_social_icons() {
    register_widget('viral_pro_social_icons');
}

class viral_pro_social_icons extends WP_Widget {

    public function __construct() {
        parent::__construct('viral_pro_social_icons', '&bull; VP : Social Icons', array(
            'description' => __('A widget to display Social Icons', 'viral-pro')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $image_path = get_template_directory_uri();
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
            'items' => array(
                'viral_pro_widgets_name' => 'items',
                'viral_pro_widgets_title' => __('Icons Box', 'viral-pro'),
                'viral_pro_widgets_repeater_title' => __('Icons', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'repeater',
                'viral_pro_widgets_repeater_fields_title' => 'title',
                'viral_pro_widgets_default' => array(
                    array(
                        'title' => __('Facebook', 'viral-pro'),
                        'icon' => 'social_facebook',
                        'url' => 'https://facebook.com'
                    )
                ),
                'viral_pro_widgets_repeater_fields' => array(
                    'title' => array(
                        'title' => __('Title', 'viral-pro'),
                        'type' => 'text'
                    ),
                    'icon' => array(
                        'title' => __('Icon', 'viral-pro'),
                        'type' => 'icon',
                        'icon_array' => viral_pro_widget_icofont_icon_array()
                    ),
                    'url' => array(
                        'title' => __('URL', 'viral-pro'),
                        'type' => 'text'
                    )
                ),
                'viral_pro_widgets_add_button' => __('Add New', 'viral-pro')
            ),
            'input_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'settings_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content',
                'viral_pro_widgets_data_id' => 'ht-settings',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'style' => array(
                'viral_pro_widgets_name' => 'style',
                'viral_pro_widgets_title' => __('Style', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'style1' => __('Square', 'viral-pro'),
                    'style2' => __('Circle', 'viral-pro'),
                    'style3' => __('Square Outline', 'viral-pro'),
                    'style4' => __('Circle Outline', 'viral-pro'),
                    'style5' => __('Rounded Corner', 'viral-pro'),
                    'style6' => __('Rounded Corner With Whtie Circle', 'viral-pro'),
                    'style7' => __('3D', 'viral-pro'),
                    'style8' => __('Icon Only', 'viral-pro'),
                )
            ),
            'hover_effect' => array(
                'viral_pro_widgets_name' => 'hover_effect',
                'viral_pro_widgets_title' => __('Hover Effect', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'si-no-effect' => __('No Effect', 'viral-pro'),
                    'si-fade-in' => __('Fade In', 'viral-pro'),
                    'si-zoom' => __('Zoom', 'viral-pro'),
                    'si-rotate' => __('Rotate', 'viral-pro'),
                    'si-slide-up' => __('Slide Up', 'viral-pro')
                )
            ),
            'align' => array(
                'viral_pro_widgets_name' => 'align',
                'viral_pro_widgets_title' => __('Alignment', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'left' => __('Left', 'viral-pro'),
                    'center' => __('Center', 'viral-pro'),
                    'right' => __('Right', 'viral-pro')
                )
            ),
            'size' => array(
                'viral_pro_widgets_name' => 'size',
                'viral_pro_widgets_title' => __('Size', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'small' => __('Small', 'viral-pro'),
                    'normal' => __('Normal', 'viral-pro'),
                    'big' => __('Big', 'viral-pro'),
                    'large' => __('Large', 'viral-pro')
                )
            ),
            'bg-color' => array(
                'viral_pro_widgets_name' => 'bg-color',
                'viral_pro_widgets_title' => __('Icon Background Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_field_default' => '#FFFFFF'
            ),
            'icon-color' => array(
                'viral_pro_widgets_name' => 'icon-color',
                'viral_pro_widgets_title' => __('Icon Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_field_default' => '#333333'
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
        $bg_color = isset($instance['bg-color']) ? $instance['bg-color'] : '#FFFFFF';
        $icon_color = isset($instance['icon-color']) ? $instance['icon-color'] : '#333333';
        $style = isset($instance['style']) ? $instance['style'] : 'style1';
        $hover_effect = isset($instance['hover_effect']) ? $instance['hover_effect'] : 'si-no-effect';
        $size = isset($instance['size']) ? $instance['size'] : 'normal';
        $align = isset($instance['align']) ? $instance['align'] : 'center';
        $items = isset($instance['items']) ? $instance['items'] : '';
        $css_style = '';
        $css_styles = array();
        if (!empty($bg_color) && ($style == 'style1' || $style == 'style2' || $style == 'style5' || $style == 'style6' || $style == 'style7')) {
            $css_styles[] = "background-color:$bg_color";
        }

        if (!empty($icon_color)) {
            $css_styles[] = "color:$icon_color";
            $css_styles[] = "border-color:$icon_color";
        }

        if (!empty($css_styles)) {
            $css_style = 'style="' . implode(';', $css_styles) . '"';
        }

        $class = array(
            'ht-social-icons',
            $style,
            'icon-' . $size,
            'icon-' . $align,
            $hover_effect
        );

        if ($style == 'style5' || $style == 'style6' || $style == 'style7') {
            $class[] = 'rounded-corner';
        }

        echo $before_widget;

        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;
        ?>
        <div class="<?php echo esc_attr(implode(' ', $class)); ?>">
            <?php
            if (!empty($items)) {
                foreach ($items as $item) {
                    $title = $item['title'];
                    $icon = $item['icon'];
                    $url = $item['url'];
                    ?>
                    <a <?php echo $css_style; ?> class="ht-social-button" href="<?php echo esc_attr($url); ?>" title="<?php echo esc_attr($title); ?>" target="_blank">
                        <i class='<?php echo esc_attr($icon) ?>'></i>
                    </a>
                    <?php
                }
            }
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
