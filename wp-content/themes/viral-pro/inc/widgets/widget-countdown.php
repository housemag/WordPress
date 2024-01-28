<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_countdown');

function viral_pro_register_countdown() {
    register_widget('viral_pro_countdown');
}

class viral_pro_countdown extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display Countdown', 'viral-pro'));
        $control_ops = array('width' => 400, 'height' => 400);
        parent::__construct('viral_pro_countdown', '&bull; VP : Countdown', $widget_ops, $control_ops);
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
                'viral_pro_widgets_class' => 'ht-widget-tab-content ht-flex-wrap',
                'viral_pro_widgets_data_id' => 'ht-input',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'title' => array(
                'viral_pro_widgets_name' => 'title',
                'viral_pro_widgets_title' => __('Title', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'date' => array(
                'viral_pro_widgets_name' => 'date',
                'viral_pro_widgets_title' => __('Countdown Date', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'datepicker'
            ),
            'days' => array(
                'viral_pro_widgets_name' => 'days',
                'viral_pro_widgets_title' => __('Days Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => esc_html__('Days', 'viral-pro'),
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'hours' => array(
                'viral_pro_widgets_name' => 'hours',
                'viral_pro_widgets_title' => __('Hours Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => esc_html__('Hours', 'viral-pro'),
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'minutes' => array(
                'viral_pro_widgets_name' => 'minutes',
                'viral_pro_widgets_title' => __('Minutes Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => esc_html__('Minutes', 'viral-pro'),
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'seconds' => array(
                'viral_pro_widgets_name' => 'seconds',
                'viral_pro_widgets_title' => __('Seconds Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => esc_html__('Seconds', 'viral-pro'),
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'input_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'settings_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content ht-flex-wrap',
                'viral_pro_widgets_data_id' => 'ht-settings',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'style' => array(
                'viral_pro_widgets_name' => 'style',
                'viral_pro_widgets_title' => __('Counter Style', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'block' => __('Block', 'viral-pro'),
                    'border-block' => __('Top Bordered Block', 'viral-pro'),
                    'circular' => __('Circular', 'viral-pro'),
                    'diamond' => __('Diamond', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'block'
            ),
            'shadow' => array(
                'viral_pro_widgets_name' => 'shadow',
                'viral_pro_widgets_title' => __('Enable Shadow', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox',
                'viral_pro_widgets_default' => true
            ),
            'num-size' => array(
                'viral_pro_widgets_name' => 'num-size',
                'viral_pro_widgets_title' => __('Number Size', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number',
                'viral_pro_widgets_default' => '62',
                'viral_pro_widgets_class' => 'ht-col6',
                'viral_pro_widgets_description' => __('in px', 'viral-pro')
            ),
            'text-size' => array(
                'viral_pro_widgets_name' => 'text-size',
                'viral_pro_widgets_title' => __('Text Size', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number',
                'viral_pro_widgets_default' => '16',
                'viral_pro_widgets_class' => 'ht-col6',
                'viral_pro_widgets_description' => __('in px', 'viral-pro')
            ),
            'text-color' => array(
                'viral_pro_widgets_name' => 'text-color',
                'viral_pro_widgets_title' => __('Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#333333'
            ),
            'background-color' => array(
                'viral_pro_widgets_name' => 'background-color',
                'viral_pro_widgets_title' => __('Background Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_description' => __('Leave Blank if you don\'t want to apply it.', 'viral-pro'),
            ),
            'border-color' => array(
                'viral_pro_widgets_name' => 'border-color',
                'viral_pro_widgets_title' => __('Border Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_description' => __('Leave Blank if you don\'t want to apply it.', 'viral-pro')
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

        $class = array();
        $title = isset($instance['title']) ? $instance['title'] : '';
        $date = isset($instance['date']) ? $instance['date'] : '';
        $days = isset($instance['days']) ? $instance['days'] : esc_html__('Days', 'viral-pro');
        $hours = isset($instance['hours']) ? $instance['hours'] : esc_html__('Hours', 'viral-pro');
        $minutes = isset($instance['minutes']) ? $instance['minutes'] : esc_html__('Minutes', 'viral-pro');
        $seconds = isset($instance['seconds']) ? $instance['seconds'] : esc_html__('Seconds', 'viral-pro');
        $bg_color = isset($instance['background-color']) ? $instance['background-color'] : '';
        $text_color = isset($instance['text-color']) ? $instance['text-color'] : '#333333';
        $border_color = isset($instance['border-color']) ? $instance['border-color'] : '';
        $class[] = isset($instance['style']) ? $instance['style'] : 'block';
        $class[] = (isset($instance['shadow']) && ($instance['shadow'] == true) ) ? 'ht-enable-shadow' : '';
        $num_size = isset($instance['num-size']) ? $instance['num-size'] : '62';
        $text_size = isset($instance['text-size']) ? $instance['text-size'] : '16';
        $classes = implode(' ', $class);
        $selector = 'viral_pro_' . md5(uniqid(rand(), true));

        $css_array = array();
        $css = $num_style = '';

        if ($bg_color) {
            $css_array[] = "background:$bg_color";
        }

        if ($text_color) {
            $css_array[] = "color:$text_color";
        }

        if ($border_color) {
            $css_array[] = "border-color:$border_color";
        }

        if ($num_size) {
            $css_array[] = "font-size:{$num_size}px";
        }

        if ($text_size) {
            $text_size = 'style="font-size:' . $text_size . 'px"';
        }

        if ($css_array) {
            $css = 'style="' . implode(';', $css_array) . '"';
        }

        echo $before_widget;

        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;
        ?>
        <?php if (viral_pro_is_amp()) { ?>
            <amp-date-countdown timestamp-seconds="<?php echo strtotime($date) ?>" layout="fixed-height" height="220">
                <template type="amp-mustache">
                    <div class="ht-countdown <?php echo $classes; ?>" id="<?php echo $selector ?>-wrap">
                        <div <?php echo $css; ?>><div>{{d}}<label <?php echo $text_size; ?>><?php echo $days; ?></label> </div></div>
                        <div <?php echo $css; ?>><div>{{h}}<label <?php echo $text_size; ?>><?php echo $hours; ?></label> </div></div>
                        <div <?php echo $css; ?>><div>{{m}}<label <?php echo $text_size; ?>><?php echo $minutes; ?></label> </div></div>
                        <div <?php echo $css; ?>><div>{{s}}<label <?php echo $text_size; ?>><?php echo $seconds; ?></label> </div></div>
                    </div>
                </template>
            </amp-date-countdown>
        <?php } else { ?>
            <div class="ht-countdown <?php echo $classes; ?>" id="<?php echo $selector ?>-wrap"></div>
            <script>
                jQuery(function ($) {
                    $('#<?php echo $selector ?>-wrap').countdown('<?php echo $date; ?>', function (event) {
                        var $this = $(this).html(event.strftime(''
                                + '<div <?php echo $css; ?>><div>%D<label <?php echo $text_size; ?>><?php echo $days; ?></label> </div></div>'
                                + '<div <?php echo $css; ?>><div>%H<label <?php echo $text_size; ?>><?php echo $hours; ?></label> </div></div>'
                                + '<div <?php echo $css; ?>><div>%M<label <?php echo $text_size; ?>><?php echo $minutes; ?></label> </div></div>'
                                + '<div <?php echo $css; ?>><div>%S<label <?php echo $text_size; ?>><?php echo $seconds; ?></label> </div></div>'));
                    });
                });
            </script>
        <?php } ?>
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
