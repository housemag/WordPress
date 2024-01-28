<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_image_category');

function viral_pro_register_image_category() {
    register_widget('viral_pro_image_category');
}

class viral_pro_image_category extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display Category With Image Banner', 'viral-pro'));
        parent::__construct('viral_pro_image_category', '&bull; VP : Image Category', $widget_ops);
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            'title' => array(
                'viral_pro_widgets_name' => 'title',
                'viral_pro_widgets_title' => __('Title', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'text'
            ),
            'layout' => array(
                'viral_pro_widgets_name' => 'layout',
                'viral_pro_widgets_title' => __('Layout', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    'ht-style1' => __('Style 1', 'viral-pro'),
                    'ht-style2' => __('Style 2', 'viral-pro'),
                    'ht-style3' => __('Style 3', 'viral-pro'),
                    'ht-style4' => __('Style 4', 'viral-pro'),
                    'ht-style5' => __('Style 5 - No Image', 'viral-pro')
                ),
                'viral_pro_widgets_default' => 'ht-style1'
            ),
            'post_count' => array(
                'viral_pro_widgets_name' => 'post_count',
                'viral_pro_widgets_title' => __('Show Post Count', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox'
            ),
            'items' => array(
                'viral_pro_widgets_name' => 'items',
                'viral_pro_widgets_title' => __('Category Items', 'viral-pro'),
                'viral_pro_widgets_repeater_title' => __('Category', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'repeater',
                'viral_pro_widgets_repeater_fields_title' => 'category',
                'viral_pro_widgets_repeater_fields' => array(
                    'image' => array(
                        'title' => __('Background Image', 'viral-pro'),
                        'type' => 'upload'
                    ),
                    'category' => array(
                        'title' => __('Select Category', 'viral-pro'),
                        'type' => 'select',
                        'options' => viral_pro_category_list(),
                    )
                ),
                'viral_pro_widgets_add_button' => __('Add New', 'viral-pro')
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
        $layout = isset($instance['layout']) ? $instance['layout'] : 'ht-style1';
        $post_count = (isset($instance['post_count']) && $instance['post_count'] == '1') ? 'true' : 'false';
        $items = isset($instance['items']) ? $instance['items'] : '';

        echo $before_widget;

        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;

        if (!empty($items)) {
            foreach ($items as $item) {
                $category = isset($item['category']) ? $item['category'] : "";
                $image = $item['image'];
                if ($category) {
                    $category_obj = get_category($category);
                    if ($category_obj) {
                        ?>
                        <div class="ht-image-category <?php echo esc_attr($layout); ?>" style="background-image:url(<?php echo esc_url($image) ?>)">
                            <?php
                            if ($layout == 'ht-style4') {
                                echo '<span></span>';
                            }
                            ?>
                            <a href="<?php echo esc_url(get_category_link($category_obj->term_id)); ?>" rel="bookmark">
                                <h5>
                                    <span class="htc-cat-name"><?php echo esc_html($category_obj->name); ?></span>
                                    <?php if ($post_count == 'true') { ?>
                                        <span class="htc-post-count"><?php echo esc_html($category_obj->category_count); ?></span>
                                    <?php } ?>
                                </h5>
                            </a>
                        </div>
                        <?php
                    }
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
