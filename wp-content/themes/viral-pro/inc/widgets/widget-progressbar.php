<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_progressbar');

function viral_pro_register_progressbar() {
    register_widget('viral_pro_progressbar');
}

class viral_pro_progressbar extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display Progress Bar', 'viral-pro'));
        parent::__construct('viral_pro_progressbar', '&bull; VP : Progress Bar', $widget_ops);
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
            'items' => array(
                'viral_pro_widgets_name' => 'items',
                'viral_pro_widgets_title' => __('Progress Bar Box', 'viral-pro'),
                'viral_pro_widgets_repeater_title' => __('Progress Bar', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'repeater',
                'viral_pro_widgets_repeater_fields_title' => 'title',
                'viral_pro_widgets_repeater_fields' => array(
                    'title' => array(
                        'title' => __('Progress Bar Label', 'viral-pro'),
                        'type' => 'text'
                    ),
                    'percentage' => array(
                        'title' => __('Percentage', 'viral-pro'),
                        'type' => 'text',
                        'desc' => __('Enter Value between 1 and 100', 'viral-pro')
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
            'layout' => array(
                'viral_pro_widgets_name' => 'layout',
                'viral_pro_widgets_title' => __('Layout', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'ht-pb-style1' => __('Style 1', 'viral-pro'),
                    'ht-pb-style2' => __('Style 2', 'viral-pro'),
                    'ht-pb-style3' => __('Style 3', 'viral-pro'),
                    'ht-pb-style4' => __('Style 4', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'ht-pb-style1'
            ),
            'bg-color' => array(
                'viral_pro_widgets_name' => 'bg-color',
                'viral_pro_widgets_title' => __('Progress Bar Background Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#F6F6F6'
            ),
            'bar-color' => array(
                'viral_pro_widgets_name' => 'bar-color',
                'viral_pro_widgets_title' => __('Progress Bar Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#0078af'
            ),
            'label-color' => array(
                'viral_pro_widgets_name' => 'label-color',
                'viral_pro_widgets_title' => __('Progress Bar Label Color', 'viral-pro'),
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

        $title = isset($instance['title']) ? $instance['title'] : '';
        $layout = isset($instance['layout']) ? $instance['layout'] : 'ht-pb-style1';
        $bg_color = isset($instance['bg-color']) ? $instance['bg-color'] : '#F6F6F6';
        $bar_color = isset($instance['bar-color']) ? $instance['bar-color'] : '#0078af';
        $label_color = isset($instance['label-color']) ? $instance['label-color'] : '#333333';
        $items = isset($instance['items']) ? $instance['items'] : '';

        $check_luminance = ariColor::newColor($bar_color);
        $textcolor = ( 127 < $check_luminance->luminance ) ? '#222222' : '#FFFFFF';

        $span_bg = '';
        if ($layout == 'ht-pb-style4') {
            $span_bg = 'style="color:' . esc_attr($textcolor) . '; background:' . esc_attr($bar_color) . '"';
        } elseif ($layout == 'ht-pb-style1') {
            $span_bg = 'style="color:' . esc_attr($label_color) . '"';
        }

        echo $before_widget;

        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;

        if (!empty($items)) {
            foreach ($items as $item) {
                $progressbar_title = $item['title'];
                $progressbar_percentage = $item['percentage'];
                if ($progressbar_title || $progressbar_percentage) {
                    ?>
                    <div class="ht-progress <?php echo esc_attr($layout); ?>">
                        <h6 style="color:<?php echo esc_attr($label_color) ?>"><?php echo esc_html($progressbar_title); ?></h6>
                        <div class="ht-progress-bar" data-width="<?php echo absint($progressbar_percentage); ?>" style="background:<?php echo esc_attr($bg_color) ?>">
                            <div class="ht-progress-bar-length" style="background:<?php echo esc_attr($bar_color) ?>; <?php echo viral_pro_is_amp() ? ('width: ' . absint($progressbar_percentage) . '%') : ''; ?>">
                                <span <?php echo $span_bg; ?>><?php echo absint($progressbar_percentage) . "%"; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }

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
