<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_timeline');

function viral_pro_register_timeline() {
    register_widget('viral_pro_timeline');
}

class viral_pro_timeline extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display category post in timeline.', 'viral-pro'));
        parent::__construct('viral_pro_timeline', '&bull; VP : Post Timeline ', $widget_ops);
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
            'category' => array(
                'viral_pro_widgets_name' => 'category',
                'viral_pro_widgets_title' => __('Select Categories', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'multicheckbox',
                'viral_pro_widgets_field_options' => viral_pro_category_list(),
                'viral_pro_widgets_description' => __('Latest Post will be displayed if category is not selected.', 'viral-pro'),
            ),
            'post_count' => array(
                'viral_pro_widgets_name' => 'post_count',
                'viral_pro_widgets_title' => __('No of Posts to Display', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number',
                'viral_pro_widgets_default' => '5'
            ),
            'display_date' => array(
                'viral_pro_widgets_name' => 'display_date',
                'viral_pro_widgets_title' => __('Display Posted Date', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox',
            ),
            'display_excerpt' => array(
                'viral_pro_widgets_name' => 'display_excerpt',
                'viral_pro_widgets_title' => __('Display Excerpt', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox',
            ),
            'excerpt_letter_count' => array(
                'viral_pro_widgets_name' => 'excerpt_letter_count',
                'viral_pro_widgets_title' => __('No of Letter to Display in Excerpt', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number',
                'viral_pro_widgets_default' => '100'
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
                    'default' => __('Default', 'viral-pro'),
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
                'viral_pro_widgets_default' => 'default'
            ),
            'title_color' => array(
                'viral_pro_widgets_name' => 'title_color',
                'viral_pro_widgets_title' => __('Title Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'excerpt_color' => array(
                'viral_pro_widgets_name' => 'excerpt_color',
                'viral_pro_widgets_title' => __('Posted Date & Excerpt Text Color', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'color'
            ),
            'border_color' => array(
                'viral_pro_widgets_name' => 'border_color',
                'viral_pro_widgets_title' => __('Timeline Left Border Color', 'viral-pro'),
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

        $title = isset($instance['title']) ? $instance['title'] : '';
        $post_count = isset($instance['post_count']) ? $instance['post_count'] : 5;
        $category = isset($instance['category']) ? $instance['category'] : '';
        $display_date = (isset($instance['display_date']) && $instance['display_date']) ? true : false;
        $display_excerpt = (isset($instance['display_excerpt']) && $instance['display_excerpt']) ? true : false;
        $excerpt_letter_count = isset($instance['excerpt_letter_count']) ? $instance['excerpt_letter_count'] : 100;
        $title_html_tag = isset($instance['title_html_tag']) ? $instance['title_html_tag'] : 'div';
        $title_color = isset($instance['title_color']) ? $instance['title_color'] : '';
        $excerpt_color = isset($instance['excerpt_color']) ? $instance['excerpt_color'] : '';
        $border_color = isset($instance['border_color']) ? $instance['border_color'] : '';

        $title_style = $excerpt_style = $border_style = $inherit_style = "";
        $class = 'ht-pt-title';

        if ($title_html_tag == 'default') {
            $title_html_tag = 'h3';
            $class = 'ht-pt-title vl-post-title';
        }

        if (!empty($title_color)) {
            $title_style = 'style="color:' . $title_color . '"';
        }

        if (!empty($excerpt_color)) {
            $excerpt_style = 'style="color:' . $excerpt_color . '"';
        }

        if (!empty($border_color)) {
            $border_style = 'style="border-color:' . $border_color . '"';
            $inherit_style = 'style="color:' . $border_color . '"';
        }

        echo $before_widget;
        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;
        ?>
        <div class="ht-post-timeline" <?php echo $border_style; ?>>
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $post_count,
                'ignore_sticky_posts' => true
            );

            if ($category) {
                $category = array_keys($category);
                $cat = join(',', $category);
                $args['cat'] = $cat;
            }

            $query = new WP_Query($args);

            while ($query->have_posts()) : $query->the_post();
                $index = $query->current_post + 1;
                ?>
                <div class="ht-post-list" <?php echo $inherit_style; ?>>
                    <?php if ($display_date) { ?>
                        <div class="ht-pt-date" <?php echo $excerpt_style; ?>>
                            <?php echo viral_pro_post_date(); ?>
                        </div>
                    <?php } ?>

                    <<?php echo $title_html_tag; ?> class="<?php echo $class; ?>">
                    <a href="<?php echo the_permalink(); ?>" <?php echo $title_style; ?>>
                        <?php the_title(); ?>
                    </a>
                    </<?php echo $title_html_tag; ?>>

                    <?php if ($display_excerpt) { ?>
                        <div class="ht-pt-excerpt" <?php echo $excerpt_style; ?>>
                            <?php echo viral_pro_excerpt(get_the_content(), $excerpt_letter_count); ?>
                        </div>
                    <?php } ?>
                </div>   
                <?php
            endwhile;
            wp_reset_postdata();
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
