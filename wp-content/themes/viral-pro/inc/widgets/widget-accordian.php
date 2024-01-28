<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_accordian');

function viral_pro_register_accordian() {
    register_widget('viral_pro_accordian');
}

class viral_pro_accordian extends WP_Widget {

    public function __construct() {
        parent::__construct('viral_pro_accordian', '&bull; VP : Accordian', array(
            'description' => __('A widget to display Accordian', 'viral-pro')
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
                'viral_pro_widgets_title' => __('Accordian Box', 'viral-pro'),
                'viral_pro_widgets_repeater_title' => __('Accordian', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'repeater',
                'viral_pro_widgets_repeater_fields_title' => 'title',
                'viral_pro_widgets_repeater_fields' => array(
                    'title' => array(
                        'title' => __('Accordian Title', 'viral-pro'),
                        'type' => 'text'
                    ),
                    'content' => array(
                        'title' => __('Accordian Content', 'viral-pro'),
                        'type' => 'editor'
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
                'viral_pro_widgets_title' => __('Accordian Layout', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'ht-style1-accordion' => __('Style 1', 'viral-pro'),
                    'ht-style2-accordion' => __('Style 2', 'viral-pro')
                )
            ),
            'title_html_tag' => array(
                'viral_pro_widgets_name' => 'title_html_tag',
                'viral_pro_widgets_title' => __('Title HTMl Tag', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p'
                ),
                'viral_pro_widgets_default' => 'div'
            ),
            'open_state' => array(
                'viral_pro_widgets_name' => 'open_state',
                'viral_pro_widgets_title' => __('Open Accordian At Start', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'open-first' => __('Open First Accordian Only', 'viral-pro'),
                    'open-all' => __('Open All Accordians', 'viral-pro'),
                    'close-all' => __('Close All Accordians', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'open-first'
            ),
            'open_single' => array(
                'viral_pro_widgets_name' => 'open_single',
                'viral_pro_widgets_title' => __('Open a Single Accordion a Time', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox',
            ),
            'header_bg_color' => array(
                'viral_pro_widgets_name' => 'header_bg_color',
                'viral_pro_widgets_title' => __('Header Background Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
            ),
            'header_text_color' => array(
                'viral_pro_widgets_name' => 'header_text_color',
                'viral_pro_widgets_title' => __('Header Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
            ),
            'content_text_color' => array(
                'viral_pro_widgets_name' => 'content_text_color',
                'viral_pro_widgets_title' => __('Content Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
            ),
            'box_border_color' => array(
                'viral_pro_widgets_name' => 'box_border_color',
                'viral_pro_widgets_title' => __('Box Border Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
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
        $items = isset($instance['items']) ? $instance['items'] : '';
        $layout = isset($instance['layout']) ? $instance['layout'] : 'ht-style1-accordion';
        $open_state = isset($instance['open_state']) ? $instance['open_state'] : 'open-first';
        $title_html_tag = isset($instance['title_html_tag']) ? $instance['title_html_tag'] : 'div';
        $open_single = (isset($instance['open_single']) && $instance['open_single']) ? 'ht-single-open-accordian' : 'ht-all-open-accordian';
        $header_bg_color = isset($instance['header_bg_color']) ? $instance['header_bg_color'] : '';
        $header_text_color = isset($instance['header_text_color']) ? $instance['header_text_color'] : '';
        $content_text_color = isset($instance['content_text_color']) ? $instance['content_text_color'] : '';
        $box_border_color = isset($instance['box_border_color']) ? $instance['box_border_color'] : '';
        $accordion_open = $content_style = $header_style = $box_border_style = "";
        $header_styles = array();

        if (!empty($header_bg_color)) {
            $header_styles[] = 'background:' . $header_bg_color;
        }

        if (!empty($header_text_color)) {
            $header_styles[] = 'color:' . $header_text_color;
        }

        if (!empty($content_text_color)) {
            $content_style = 'style="color:' . $content_text_color . '"';
        }

        if (!empty($box_border_color)) {
            $box_border_style = 'style="border-color:' . $box_border_color . '"';
        }

        if (!empty($header_styles)) {
            $header_style = 'style="' . implode(';', $header_styles) . '"';
        }

        echo $before_widget;

        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;
        ?>
        <div class="ht-accordion <?php echo esc_attr($layout) . ' ' . esc_attr($open_single); ?>" data-accordion-group>
            <?php
            if (!empty($items)) {
                $count = 0;
                foreach ($items as $item) {
                    $id = uniqid('ht-pt-accordian-', false);
                    $count++;
                    $accordion_open = '';
                    if ($open_state == 'open-first' && $count === 1) {
                        $accordion_open = ' open';
                    } elseif ($open_state == 'open-all') {
                        $accordion_open = ' open';
                    }
                    ?>
                    <div id="<?php echo esc_attr($id); ?>" class="ht-accordion-box<?php echo esc_attr($accordion_open); ?>" data-accordion <?php echo $box_border_style; ?>>
                        <<?php echo $title_html_tag; ?> class="ht-accordion-header" data-control <?php echo $header_style . ' ' . viral_pro_amp_accordian_toggle($id); ?>>
                        <?php echo esc_html($item['title']); ?>
                        </<?php echo $title_html_tag; ?>>

                        <div class="ht-accordion-content" data-content <?php echo $content_style; ?>>
                            <div class="ht-accordion-content-wrap ht-clearfix" <?php echo $box_border_style; ?>>
                                <?php echo wp_kses_post(wpautop($item['content'])); ?>
                            </div>
                        </div>
                    </div>
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
