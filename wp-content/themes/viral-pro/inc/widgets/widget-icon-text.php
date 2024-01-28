<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_icon_text');

function viral_pro_register_icon_text() {
    register_widget('viral_pro_icon_text');
}

class viral_pro_icon_text extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display Text with Icon', 'viral-pro'));
        $control_ops = array('width' => 400, 'height' => 400);
        parent::__construct('viral_pro_icon_text', '&bull; VP : Icon Text', $widget_ops, $control_ops);
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
                'viral_pro_widgets_default' => 'icon_lightbulb_alt'
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
            'button_text' => array(
                'viral_pro_widgets_name' => 'button_text',
                'viral_pro_widgets_title' => __('Button Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => __('Read More', 'viral-pro')
            ),
            'button_link' => array(
                'viral_pro_widgets_name' => 'button_link',
                'viral_pro_widgets_title' => __('Button Link', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'url'
            ),
            'input_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'settings_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content',
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
            'icon_position' => array(
                'viral_pro_widgets_name' => 'icon_position',
                'viral_pro_widgets_title' => __('Icon Position', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'top' => __('Top', 'viral-pro'),
                    'left' => __('Left', 'viral-pro'),
                    'right' => __('Right', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'h5'
            ),
            'icon_style' => array(
                'viral_pro_widgets_name' => 'icon_style',
                'viral_pro_widgets_title' => __('Icon Style', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'default' => __('Default', 'viral-pro'),
                    'circle' => __('Circle Line', 'viral-pro'),
                    'square' => __('Square Line', 'viral-pro'),
                    'circle-bg' => __('Circle Background', 'viral-pro'),
                    'square-bg' => __('Square Background', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'default'
            ),
            'icon_color' => array(
                'viral_pro_widgets_name' => 'icon_color',
                'viral_pro_widgets_title' => __('Icon Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'title_color' => array(
                'viral_pro_widgets_name' => 'title_color',
                'viral_pro_widgets_title' => __('Title Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'text_color' => array(
                'viral_pro_widgets_name' => 'text_color',
                'viral_pro_widgets_title' => __('Short Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'link_color' => array(
                'viral_pro_widgets_name' => 'link_color',
                'viral_pro_widgets_title' => __('Link Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
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

        $icon = isset($instance['icon']) ? $instance['icon'] : 'icofont-angry-monster';
        $title = isset($instance['title']) ? $instance['title'] : '';
        $text = isset($instance['text']) ? $instance['text'] : '';
        $name = isset($instance['name']) ? $instance['name'] : '';
        $button_link = isset($instance['button_link']) ? $instance['button_link'] : '';
        $button_text = isset($instance['button_text']) ? $instance['button_text'] : esc_html__('Read More', 'viral-pro');
        $title_html_tag = isset($instance['title_html_tag']) ? $instance['title_html_tag'] : 'h5';
        $icon_position = isset($instance['icon_position']) ? $instance['icon_position'] : 'left';
        $icon_style = isset($instance['icon_style']) ? $instance['icon_style'] : 'default';
        $icon_color = isset($instance['icon_color']) ? $instance['icon_color'] : '';
        $title_color = isset($instance['title_color']) ? $instance['title_color'] : '';
        $text_color = isset($instance['text_color']) ? $instance['text_color'] : '';
        $link_color = isset($instance['link_color']) ? $instance['link_color'] : '';
        $class = 'ht-it-pos-' . $icon_position . ' ht-it-style-' . $icon_style;
        $style = array();
        $title_style = $text_style = $link_style = '';

        if (!empty($icon_color) && $icon_style == 'default') {
            $style[] = "color:$icon_color";
        }

        if (!empty($icon_color) && $icon_style == 'circle' || $icon_style == 'square') {
            $style[] = "border-color:$icon_color";
            $style[] = "color:$icon_color";
        }

        if (!empty($icon_color) && $icon_style == 'circle-bg' || $icon_style == 'square-bg') {
            $check_luminance = ariColor::newColor($icon_color);
            $textcolor = ( 127 < $check_luminance->luminance ) ? '#222222' : '#FFFFFF';
            $style[] = "background-color:$icon_color";
            $style[] = "border-color:$icon_color";
            $style[] = "color:$textcolor";
        }

        if (!empty($title_color)) {
            $title_style = 'style="color:' . $title_color . '"';
        }

        if (!empty($text_color)) {
            $text_style = 'style="color:' . $text_color . '"';
        }

        if (!empty($link_color)) {
            $link_style = 'style="color:' . $link_color . '"';
        }

        echo $before_widget;
        ?>
        <div class="ht-icon-text <?php echo esc_attr($class); ?>">
            <?php
            if (!empty($icon)):
                ?>
                <i class="<?php echo esc_attr($icon); ?>" style="<?php echo implode(';', $style); ?>"></i>
                <?php
            endif;
            ?>

            <div class="ht-it-content">
                <?php
                if (!empty($title)):
                    ?>
                    <<?php echo $title_html_tag; ?> class="ht-it-title" <?php echo $title_style; ?>><?php echo wp_kses_post($title); ?></<?php echo $title_html_tag; ?>>
                    <?php
                endif;

                if (!empty($text)):
                    ?>
                    <div class="ht-it-excerpt" <?php echo $text_style; ?>><?php echo wp_kses_post(wpautop($text)); ?></div>
                    <?php
                endif;

                if (!empty($button_link)):
                    echo '<div class="ht-it-readmore">';
                    echo '<a href="' . esc_url($button_link) . '" ' . $link_style . '>' . esc_html($button_text) . '<i class="ei arrow_right"></i></a>';
                    echo '</div>';
                endif;
                ?>
            </div>
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
