<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_image_box');

function viral_pro_register_image_box() {
    register_widget('viral_pro_image_box');
}

class viral_pro_image_box extends WP_Widget {

    public function __construct() {
        parent::__construct(
                'viral_pro_image_box', '&bull; VP : Image Text', array(
            'description' => __('A widget to display Text with Image', 'viral-pro')
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
            'image' => array(
                'viral_pro_widgets_name' => 'image',
                'viral_pro_widgets_title' => __('Upload Image', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'upload'
            ),
            'title' => array(
                'viral_pro_widgets_name' => 'title',
                'viral_pro_widgets_title' => __('Title', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'text' => array(
                'viral_pro_widgets_name' => 'text',
                'viral_pro_widgets_title' => __('Text', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'textarea',
                'viral_pro_widgets_row' => '4'
            ),
            'use_paragraph' => array(
                'viral_pro_widgets_name' => 'use_paragraph',
                'viral_pro_widgets_title' => __('Use Paragraph', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox'
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
            'image_position' => array(
                'viral_pro_widgets_name' => 'image_position',
                'viral_pro_widgets_title' => __('Image Position', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'top' => __('Top', 'viral-pro'),
                    'left' => __('Left', 'viral-pro'),
                    'right' => __('Right', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'top'
            ),
            'image_size' => array(
                'viral_pro_widgets_name' => 'image_size',
                'viral_pro_widgets_title' => __('Image Size', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => viral_pro_get_image_sizes(),
                'viral_pro_widgets_field_default' => 'full'
            ),
            'image_width' => array(
                'viral_pro_widgets_name' => 'image_width',
                'viral_pro_widgets_title' => __('Image Width', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    '10' => __('10%', 'viral-pro'),
                    '20' => __('20%', 'viral-pro'),
                    '30' => __('30%', 'viral-pro'),
                    '40' => __('40%', 'viral-pro'),
                    '50' => __('50%', 'viral-pro'),
                    '60' => __('60%', 'viral-pro'),
                    '70' => __('70%', 'viral-pro'),
                    '80' => __('80%', 'viral-pro'),
                    '90' => __('90%', 'viral-pro'),
                    '100' => __('100%', 'viral-pro')
                ),
                'viral_pro_widgets_default' => '100'
            ),
            'content_position' => array(
                'viral_pro_widgets_name' => 'content_position',
                'viral_pro_widgets_title' => __('Content Position', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'image-title-text' => __('Image, Title, Text', 'viral-pro'),
                    'title-image-text' => __('Title, Image, Text', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'image-title-text'
            ),
            'content_align' => array(
                'viral_pro_widgets_name' => 'content_align',
                'viral_pro_widgets_title' => __('Content Align', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'ht-left' => __('Left', 'viral-pro'),
                    'ht-right' => __('Right', 'viral-pro'),
                    'ht-center' => __('Center', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'ht-left'
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

        $image = isset($instance['image']) ? $instance['image'] : '';
        $title = isset($instance['title']) ? $instance['title'] : '';
        $text = isset($instance['text']) ? $instance['text'] : '';
        $button_link = isset($instance['button_link']) ? $instance['button_link'] : '';
        $button_text = isset($instance['button_text']) ? $instance['button_text'] : esc_html__('Read More', 'viral-pro');
        $title_html_tag = isset($instance['title_html_tag']) ? $instance['title_html_tag'] : 'h5';
        $image_position = isset($instance['image_position']) ? $instance['image_position'] : 'top';
        $image_width = isset($instance['image_width']) ? $instance['image_width'] : '50';
        $content_position = isset($instance['content_position']) ? $instance['content_position'] : 'image-title-text';
        $content_align = isset($instance['content_align']) ? $instance['content_align'] : 'ht-left';
        $image_size = isset($instance['image_size']) ? $instance['image_size'] : 'full';
        $title_color = isset($instance['title_color']) ? $instance['title_color'] : '';
        $text_color = isset($instance['text_color']) ? $instance['text_color'] : '';
        $link_color = isset($instance['link_color']) ? $instance['link_color'] : '';
        $use_paragraph = (isset($instance['use_paragraph']) && $instance['use_paragraph'] == '1') ? true : false;
        $title_css = $text_css = $link_css = '';

        if ($title_color) {
            $title_css = 'style="color:' . $title_color . '"';
        }

        if ($text_color) {
            $text_css = 'style="color:' . $text_color . '"';
        }

        if ($link_color) {
            $link_css = 'style="color:' . $link_color . '"';
        }

        $content_width = 100;
        if ($image_position !== 'top') {
            $content_width = 100 - $image_width;
        }

        $image_url = $image;
        $image_id = attachment_url_to_postid($image);
        if ($image_id) {
            $image_array = wp_get_attachment_image_src($image_id, $image_size);
            $image_url = $image_array[0];
        }

        $style = array();

        echo $before_widget;
        ?>
        <div class="ht-image-box image-<?php echo esc_attr($image_position) . ' ' . $content_align; ?>">
            <?php
            if (!empty($title) && $content_position == 'title-image-text'):
                ?>
                <<?php echo $title_html_tag; ?> class="ht-ib-title" <?php echo $title_css; ?>><?php echo wp_kses_post($title); ?></<?php echo $title_html_tag; ?>>
                <?php
            endif;
            ?>
            <div class="ht-image-box-wrap">
                <?php if (!empty($image_url)) { ?>
                    <div class="ht-ib-image" style="width:<?php echo $image_width; ?>%">
                        <?php
                        if (!empty($button_link)) {
                            echo '<a href="' . esc_url($button_link) . '">';
                        }
                        ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                        <?php
                        if (!empty($button_link)) {
                            echo '</a>';
                        }
                        ?>
                    </div>
                <?php }
                ?>

                <div class="ht-ib-content" style="width:<?php echo $content_width; ?>%">
                    <?php
                    if (!empty($title) && $content_position == 'image-title-text'):
                        ?>
                        <<?php echo $title_html_tag; ?> class="ht-ib-title" <?php echo $title_css; ?>><?php echo wp_kses_post($title); ?></<?php echo $title_html_tag; ?>>
                        <?php
                    endif;

                    if (!empty($text)):
                        if ($use_paragraph) {
                            $text = wpautop($text);
                        }
                        ?>
                        <div class="ht-ib-excerpt" <?php echo $text_css; ?>><?php echo wp_kses_post($text); ?></div>
                        <?php
                    endif;

                    if (!empty($button_link)):
                        echo '<div class="ht-ib-readmore">';
                        echo '<a href="' . esc_url($button_link) . '" ' . $link_css . '>' . esc_html($button_text) . '<i class="ei arrow_right"></i></a>';
                        echo '</div>';
                    endif;
                    ?>
                </div>
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
