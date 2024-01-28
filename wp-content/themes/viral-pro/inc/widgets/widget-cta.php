<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_cta');

function viral_pro_register_cta() {
    register_widget('viral_pro_cta');
}

class viral_pro_cta extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display Call To Action', 'viral-pro'));
        $control_ops = array('width' => 500, 'height' => 400);
        parent::__construct('viral_pro_cta', '&bull; VP : Call To Action', $widget_ops, $control_ops);
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
            'text' => array(
                'viral_pro_widgets_name' => 'text',
                'viral_pro_widgets_title' => __('Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'inline_editor',
                'viral_pro_widgets_row' => '4'
            ),
            'button_text1' => array(
                'viral_pro_widgets_name' => 'button_text1',
                'viral_pro_widgets_title' => __('First Button Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => __('Read More', 'viral-pro')
            ),
            'button_link1' => array(
                'viral_pro_widgets_name' => 'button_link1',
                'viral_pro_widgets_title' => __('First Button Link', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'url'
            ),
            'button_text2' => array(
                'viral_pro_widgets_name' => 'button_text2',
                'viral_pro_widgets_title' => __('Second Button Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => __('Buy Now', 'viral-pro')
            ),
            'button_link2' => array(
                'viral_pro_widgets_name' => 'button_link2',
                'viral_pro_widgets_title' => __('Second Button Link', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'url'
            ),
            'input_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'settings_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content ht-flex-wrap',
                'viral_pro_widgets_data_id' => 'ht-settings',
                'viral_pro_widgets_field_type' => 'open'
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
                'viral_pro_widgets_default' => 'h5'
            ),
            'button_position' => array(
                'viral_pro_widgets_name' => 'button_position',
                'viral_pro_widgets_title' => __('Button Position', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'left' => __('Left', 'viral-pro'),
                    'right' => __('Right', 'viral-pro'),
                    'center' => __('Center Bottom', 'viral-pro'),
                    'left-bottom' => __('Left Bottom', 'viral-pro'),
                    'right-bottom' => __('Right Bottom', 'viral-pro'),
                ),
                'viral_pro_widgets_default' => 'right'
            ),
            'title_color' => array(
                'viral_pro_widgets_name' => 'title_color',
                'viral_pro_widgets_title' => __('Title Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#333333',
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'text_color' => array(
                'viral_pro_widgets_name' => 'text_color',
                'viral_pro_widgets_title' => __('Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#333333',
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'button1_color' => array(
                'viral_pro_widgets_name' => 'button1_color',
                'viral_pro_widgets_title' => __('1st Button Background Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#000000',
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'button2_color' => array(
                'viral_pro_widgets_name' => 'button2_color',
                'viral_pro_widgets_title' => __('2nd Button Background Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#000000',
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'button1_text_color' => array(
                'viral_pro_widgets_name' => 'button1_text_color',
                'viral_pro_widgets_title' => __('1st Button Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#FFFFFF',
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'button2_text_color' => array(
                'viral_pro_widgets_name' => 'button2_text_color',
                'viral_pro_widgets_title' => __('2nd Button Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_default' => '#FFFFFF',
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'background_color' => array(
                'viral_pro_widgets_name' => 'background_color',
                'viral_pro_widgets_title' => __('Background Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color',
                'viral_pro_widgets_class' => 'ht-col6'
            ),
            'background_image' => array(
                'viral_pro_widgets_name' => 'background_image',
                'viral_pro_widgets_title' => __('Background Image', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'upload'
            ),
            'padding' => array(
                'viral_pro_widgets_name' => 'padding',
                'viral_pro_widgets_title' => __('Padding(Outer Space)', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number',
                'viral_pro_widgets_description' => __('in px', 'viral-pro'),
                'viral_pro_widgets_default' => 0
            ),
            'round_button' => array(
                'viral_pro_widgets_name' => 'round_button',
                'viral_pro_widgets_title' => __('Round Button', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox'
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
        $text = isset($instance['text']) ? $instance['text'] : '';
        $button_text1 = isset($instance['button_text1']) ? $instance['button_text1'] : esc_html__('Read More', 'viral-pro');
        $button_link1 = isset($instance['button_link1']) ? $instance['button_link1'] : '';
        $button_text2 = isset($instance['button_text2']) ? $instance['button_text2'] : esc_html__('Buy Now', 'viral-pro');
        $button_link2 = isset($instance['button_link2']) ? $instance['button_link2'] : '';
        $title_html_tag = isset($instance['title_html_tag']) ? $instance['title_html_tag'] : 'h5';
        $button_position = isset($instance['button_position']) ? $instance['button_position'] : 'right';
        $title_color = isset($instance['title_color']) ? $instance['title_color'] : '#333333';
        $text_color = isset($instance['text_color']) ? $instance['text_color'] : '#333333';
        $button1_color = isset($instance['button1_color']) ? $instance['button1_color'] : '#000000';
        $button2_color = isset($instance['button2_color']) ? $instance['button2_color'] : '#000000';
        $button1_textcolor = isset($instance['button1_text_color']) ? $instance['button1_text_color'] : '#FFFFFF';
        $button2_textcolor = isset($instance['button2_text_color']) ? $instance['button2_text_color'] : '#FFFFFF';
        $background_color = isset($instance['background_color']) ? $instance['background_color'] : '';
        $background_image = isset($instance['background_image']) ? $instance['background_image'] : '';
        $padding = isset($instance['padding']) ? $instance['padding'] : '0';
        $round_button = (isset($instance['round_button']) && $instance['round_button']) ? ' ht-round-button' : '';
        $style1 = $style2 = $wrap_css = array();
        $button1_style = $button2_style = $wrap_style = '';

        if ($background_color) {
            $wrap_css[] = "background-color:$background_color";
        }

        if ($background_image) {
            $wrap_css[] = "background-image:url($background_image)";
        }

        if ($padding) {
            $wrap_css[] = "padding:" . absint($padding) . "px";
        }

        if ($button1_color) {
            $style1[] = "background-color:$button1_color";
            $style1[] = "color:$button1_textcolor";
        }

        if ($button2_color) {
            $style2[] = "background-color:$button2_color";
            $style2[] = "color:$button2_textcolor";
        }

        if (!empty($style1)) {
            $button1_style = 'style="' . implode(';', $style1) . '"';
        }

        if (!empty($style2)) {
            $button2_style = 'style="' . implode(';', $style2) . '"';
        }

        if (!empty($wrap_css)) {
            $wrap_style = 'style="' . implode(';', $wrap_css) . '"';
        }

        echo $before_widget;
        ?>
        <div class="ht-cta ht-button-<?php echo esc_attr($button_position); ?>" <?php echo $wrap_style; ?>>
            <div class="ht-cta-content-wrap">
                <?php
                if (!empty($title)) {
                    ?>
                    <<?php echo $title_html_tag; ?> class="ht-cta-title" style="color:<?php echo $title_color; ?>"><?php echo wp_kses_post($title); ?></<?php echo $title_html_tag; ?>>
                    <?php
                }

                if (!empty($text)) {
                    ?>
                    <div class="ht-cta-content" style="color:<?php echo $text_color; ?>"><?php echo wp_kses_post($text); ?></div>
                    <?php
                }
                ?>
            </div>
            <?php
            if (!empty($button_link1) && !empty($button_link1)) {
                echo '<div class="ht-cta-buttons' . $round_button . '">';
                if (!empty($button_link1)) {
                    echo '<a ' . $button1_style . ' class="ht-cta-button ht-cta-button1" href="' . esc_url($button_link1) . '">' . esc_html($button_text1) . '</a>';
                }

                if (!empty($button_link2)) {
                    echo '<a ' . $button2_style . ' class="ht-cta-button ht-cta-button2" href="' . esc_url($button_link2) . '">' . esc_html($button_text2) . '</a>';
                }
                echo '</div>';
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
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	viral_pro_widgets_updated_field_value()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
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
