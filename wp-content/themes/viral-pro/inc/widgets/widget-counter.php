<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_counter');

function viral_pro_register_counter() {
    register_widget('viral_pro_counter');
}

class viral_pro_counter extends WP_Widget {

    public function __construct() {
        parent::__construct(
                'viral_pro_counter', '&bull; VP : Counter', array(
            'description' => __('A widget to display Counter', 'viral-pro')
                )
        );
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
            'icon' => array(
                'viral_pro_widgets_name' => 'icon',
                'viral_pro_widgets_title' => __('Icon', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'icon',
                'viral_pro_widgets_default' => 'icon_lightbulb_alt',
            ),
            'prefix' => array(
                'viral_pro_widgets_name' => 'prefix',
                'viral_pro_widgets_title' => __('Prefix', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_description' => __('Text that displays before counter', 'viral-pro')
            ),
            'count' => array(
                'viral_pro_widgets_name' => 'count',
                'viral_pro_widgets_title' => __('Count Value', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_description' => __('Add only Digits', 'viral-pro')
            ),
            'suffix' => array(
                'viral_pro_widgets_name' => 'suffix',
                'viral_pro_widgets_title' => __('Suffix', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_description' => __('Text that displays after counter', 'viral-pro')
            ),
            'title' => array(
                'viral_pro_widgets_name' => 'title',
                'viral_pro_widgets_title' => __('Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
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
                'viral_pro_widgets_title' => __('Counter Style', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'style1' => __('Style 1', 'viral-pro'),
                    'style2' => __('Style 2', 'viral-pro'),
                    'style3' => __('Style 3', 'viral-pro'),
                    'style4' => __('Style 4', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'style1'
            ),
            'counter-color' => array(
                'viral_pro_widgets_name' => 'counter-color',
                'viral_pro_widgets_title' => __('Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#333333'
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

        $icon = isset($instance['icon']) ? $instance['icon'] : '';
        $prefix = isset($instance['prefix']) ? $instance['prefix'] : '';
        $count = isset($instance['count']) ? $instance['count'] : '';
        $suffix = isset($instance['suffix']) ? $instance['suffix'] : '';
        $title = isset($instance['title']) ? $instance['title'] : '';
        $counter_color = isset($instance['counter-color']) ? $instance['counter-color'] : '#333333';
        $style = isset($instance['style']) ? $instance['style'] : 'style1';
        $data = $background_style = $border_style = $color_style = '';

        if ($prefix) {
            $data = 'data-prefix= "' . $prefix . '"';
        }

        if ($suffix) {
            $data .= ' data-suffix= "' . $suffix . '"';
        }

        if (!empty($counter_color)) {
            $background_style = 'style="background-color:' . $counter_color . '"';
            $border_style = 'style="border-color:' . $counter_color . '"';
            $color_style = 'style="color:' . $counter_color . '"';
        }

        echo $before_widget;
        ?>
        <div class="ht-counter-widget <?php echo $style; ?>">
            <?php
            if ($style == 'style1' || $style == 'style2') {
                ?>
                <div class="ht-counter">

                    <div class="ht-counter-count odometer" <?php echo $data; ?> data-count="<?php echo absint($count); ?>" <?php echo $color_style; ?>>
                        99
                    </div>

                    <div class="ht-counter-icon" <?php echo $color_style; ?>>
                        <span <?php echo $background_style; ?>></span>
                        <i class="<?php echo esc_attr($icon); ?>"></i>
                        <span <?php echo $background_style; ?>></span>
                    </div>

                    <h5 class="ht-counter-title" <?php echo $color_style; ?>>
                        <?php echo esc_html($title); ?>
                    </h5>
                </div>
                <?php
            } elseif ($style == 'style3') {
                ?>
                <div class="ht-counter">
                    <span <?php echo $border_style; ?>></span>
                    <div class="ht-counter-icon" <?php echo $color_style; ?>>
                        <i class="<?php echo esc_attr($icon); ?>"></i>
                    </div>

                    <div class="ht-counter-count odometer" <?php echo $data; ?> data-count="<?php echo absint($count); ?>" <?php echo $color_style; ?>>
                        99
                    </div>

                    <h5 class="ht-counter-title" <?php echo $color_style; ?>>
                        <?php echo esc_html($title); ?>
                    </h5>
                </div>
                <?php
            } elseif ($style == 'style4') {
                ?>
                <div class="ht-counter">
                    <div class="ht-counter-icon" <?php echo $color_style; ?>>
                        <i class="<?php echo esc_attr($icon); ?>"></i>
                    </div>

                    <div class="ht-counter-right-block">
                        <div class="ht-counter-count odometer" <?php echo $data; ?> data-count="<?php echo absint($count); ?>" <?php echo $color_style; ?>>
                            99

                        </div>
                        <h5 class="ht-counter-title" <?php echo $color_style; ?>>
                            <span <?php echo $background_style; ?>></span>
                            <?php echo esc_html($title); ?>
                        </h5>
                    </div>
                </div>
                <?php
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
