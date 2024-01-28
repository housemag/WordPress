<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_contact_detail');

function viral_pro_register_contact_detail() {
    register_widget('viral_pro_contact_detail');
}

class viral_pro_contact_detail extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display Contact Detail', 'viral-pro'));
        $control_ops = array('width' => 400, 'height' => 400);
        parent::__construct('viral_pro_contact_detail', '&bull; VP : Contact Detail', $widget_ops, $control_ops);
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
                    'ht-location' => __('Location', 'viral-pro'),
                    'ht-phone' => __('Phone', 'viral-pro'),
                    'ht-email' => __('Email', 'viral-pro'),
                    'ht-style' => __('Style', 'viral-pro')
                ),
                'viral_pro_widgets_field_type' => 'tab'
            ),
            'tab_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content-wrap',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'location_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content',
                'viral_pro_widgets_data_id' => 'ht-location',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'location_icon' => array(
                'viral_pro_widgets_name' => 'location_icon',
                'viral_pro_widgets_title' => __('Icon', 'viral-pro'),
                'viral_pro_widgets_default' => 'icon_pin',
                'viral_pro_widgets_field_type' => 'icon'
            ),
            'location_main_text' => array(
                'viral_pro_widgets_name' => 'location_main_text',
                'viral_pro_widgets_title' => __('Main Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => __('Find Us', 'viral-pro')
            ),
            'location_sub_text' => array(
                'viral_pro_widgets_name' => 'location_sub_text',
                'viral_pro_widgets_title' => __('Sub Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'textarea',
                'viral_pro_widgets_default' => __('Arizona Park, Australia', 'viral-pro')
            ),
            'location_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'phone_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content',
                'viral_pro_widgets_data_id' => 'ht-phone',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'phone_icon' => array(
                'viral_pro_widgets_name' => 'phone_icon',
                'viral_pro_widgets_title' => __('Icon', 'viral-pro'),
                'viral_pro_widgets_default' => 'icon_phone',
                'viral_pro_widgets_field_type' => 'icon'
            ),
            'phone_main_text' => array(
                'viral_pro_widgets_name' => 'phone_main_text',
                'viral_pro_widgets_title' => __('Main Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => __('Ring Us', 'viral-pro')
            ),
            'phone_sub_text' => array(
                'viral_pro_widgets_name' => 'phone_sub_text',
                'viral_pro_widgets_title' => __('Sub Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'textarea',
                'viral_pro_widgets_default' => __('+61 45768202', 'viral-pro')
            ),
            'phone_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'email_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content',
                'viral_pro_widgets_data_id' => 'ht-email',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'email_icon' => array(
                'viral_pro_widgets_name' => 'email_icon',
                'viral_pro_widgets_title' => __('Icon', 'viral-pro'),
                'viral_pro_widgets_default' => 'icon_mail',
                'viral_pro_widgets_field_type' => 'icon'
            ),
            'email_main_text' => array(
                'viral_pro_widgets_name' => 'email_main_text',
                'viral_pro_widgets_title' => __('Main Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text',
                'viral_pro_widgets_default' => __('Mail Us', 'viral-pro')
            ),
            'email_sub_text' => array(
                'viral_pro_widgets_name' => 'email_sub_text',
                'viral_pro_widgets_title' => __('Sub Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'textarea',
                'viral_pro_widgets_default' => __('info@hashthemes.com', 'viral-pro')
            ),
            'email_close' => array(
                'viral_pro_widgets_field_type' => 'close'
            ),
            'style_open' => array(
                'viral_pro_widgets_class' => 'ht-widget-tab-content',
                'viral_pro_widgets_data_id' => 'ht-style',
                'viral_pro_widgets_field_type' => 'open'
            ),
            'ht_layout' => array(
                'viral_pro_widgets_name' => 'ht_layout',
                'viral_pro_widgets_title' => __('Contact Detail Style', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'selector',
                'viral_pro_widgets_field_options' => array(
                    'style1' => $image_path . '/inc/widgets/images/contact-detail1.png',
                    'style2' => $image_path . '/inc/widgets/images/contact-detail2.png',
                    'style3' => $image_path . '/inc/widgets/images/contact-detail3.png'
                ),
                'viral_pro_widgets_default' => 'style1'
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
                'viral_pro_widgets_title' => __('Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'style_close' => array(
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

        $ht_layout = isset($instance['ht_layout']) ? $instance['ht_layout'] : '';
        $location_icon = isset($instance['location_icon']) ? $instance['location_icon'] : 'location_icon';
        $location_main_text = isset($instance['location_main_text']) ? $instance['location_main_text'] : 'Find Us';
        $location_sub_text = isset($instance['location_sub_text']) ? $instance['location_sub_text'] : 'Arizona Park, Australia';
        $phone_icon = isset($instance['phone_icon']) ? $instance['phone_icon'] : 'phone_icon';
        $phone_main_text = isset($instance['phone_main_text']) ? $instance['phone_main_text'] : 'Ring Us';
        $phone_sub_text = isset($instance['phone_sub_text']) ? $instance['phone_sub_text'] : '+61 45768202';
        $email_icon = isset($instance['email_icon']) ? $instance['email_icon'] : 'email_icon';
        $email_main_text = isset($instance['email_main_text']) ? $instance['email_main_text'] : 'Mail Us';
        $email_sub_text = isset($instance['email_sub_text']) ? $instance['email_sub_text'] : 'info@hashthemes.com';
        $icon_color = isset($instance['icon_color']) ? $instance['icon_color'] : '';
        $title_color = isset($instance['title_color']) ? $instance['title_color'] : '';
        $text_color = isset($instance['text_color']) ? $instance['text_color'] : '';
        $icon_style = $title_style = $text_style = $border_style = '';

        if (!empty($icon_color)) {
            $icon_style = 'style="color:' . $icon_color . '"';
        }

        if (!empty($title_color)) {
            $title_style = 'style="color:' . $title_color . '"';
        }

        if (!empty($text_color)) {
            $text_style = 'style="color:' . $text_color . '"';
            $border_style = 'style="border-color:' . $text_color . '"';
        }

        echo $before_widget;
        ?>
        <div class="ht-contact-box <?php echo esc_attr($ht_layout); ?>">
            <?php if (!empty($location_main_text) && !empty($location_sub_text)) { ?>
                <div class="ht-contact-field">
                    <i class="<?php echo esc_attr($location_icon); ?>" <?php echo $icon_style; ?>></i>
                    <div class="ht-contact-text">
                        <h6 <?php echo $title_style; ?>><?php echo esc_html($location_main_text); ?></h6>
                        <div <?php echo $text_style; ?>><?php echo wp_kses_post(wpautop($location_sub_text)); ?></div>
                    </div>
                    <span <?php echo $border_style; ?>></span>
                </div>
            <?php } ?>

            <?php if (!empty($phone_main_text) && !empty($phone_sub_text)) { ?>
                <div class="ht-contact-field">
                    <i class="<?php echo esc_attr($phone_icon); ?>" <?php echo $icon_style; ?>></i>
                    <div class="ht-contact-text">
                        <h6 <?php echo $title_style; ?>><?php echo esc_html($phone_main_text); ?></h6>
                        <div <?php echo $text_style; ?>><?php echo wp_kses_post(wpautop($phone_sub_text)); ?></div>
                    </div>
                    <span <?php echo $border_style; ?>></span>
                </div>
            <?php } ?>

            <?php if (!empty($email_main_text) || !empty($email_sub_text)) { ?>
                <div class="ht-contact-field">
                    <i class="<?php echo esc_attr($email_icon); ?>" <?php echo $icon_style; ?>></i>
                    <div class="ht-contact-text">
                        <h6 <?php echo $title_style; ?>><?php echo esc_html($email_main_text); ?></h6>
                        <div <?php echo $text_style; ?>><?php echo wp_kses_post(wpautop($email_sub_text)); ?></div>
                    </div>
                </div>
            <?php } ?>
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
