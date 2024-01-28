<?php
/**
 * @package Viral Pro
 */
add_action('widgets_init', 'viral_pro_register_latest_posts');

function viral_pro_register_latest_posts() {
    register_widget('viral_pro_latest_posts');
}

class viral_pro_latest_posts extends WP_Widget {

    public function __construct() {
        $widget_ops = array('description' => __('A widget to display latest post with thumbnail.', 'viral-pro'));
        parent::__construct('viral_pro_latest_posts', '&bull; VP : Latest Posts', $widget_ops);
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
            'post_count' => array(
                'viral_pro_widgets_name' => 'post_count',
                'viral_pro_widgets_title' => __('No of Posts to Display', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'number',
                'viral_pro_widgets_default' => '5'
            ),
            'display_thumb' => array(
                'viral_pro_widgets_name' => 'display_thumb',
                'viral_pro_widgets_title' => __('Display Thumbnail', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox'
            ),
            'thumbnail_size' => array(
                'viral_pro_widgets_name' => 'thumbnail_size',
                'viral_pro_widgets_title' => __('Thumbnail Size', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => viral_pro_get_image_sizes(),
                'viral_pro_widgets_default' => 'viral-pro-150x150'
            ),
            'thumbnail_width' => array(
                'viral_pro_widgets_name' => 'thumbnail_width',
                'viral_pro_widgets_title' => __('Thumbnail Width', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'select',
                'viral_pro_widgets_field_options' => array(
                    '10' => __('10%', 'viral-pro'),
                    '20' => __('20%', 'viral-pro'),
                    '30' => __('30%', 'viral-pro'),
                    '40' => __('40%', 'viral-pro'),
                    '50' => __('50%', 'viral-pro')
                ),
                'viral_pro_widgets_default' => '30'
            ),
            'display_date' => array(
                'viral_pro_widgets_name' => 'display_date',
                'viral_pro_widgets_title' => __('Display Date', 'viral-pro'),
                'viral_pro_widgets_field_type' => 'checkbox'
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
                'viral_pro_widgets_title' => __('Excerpt Text Color', 'viral-pro'),
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
        $display_thumb = (isset($instance['display_thumb']) && $instance['display_thumb']) ? true : false;
        $thumbnail_size = isset($instance['thumbnail_size']) ? $instance['thumbnail_size'] : 'viral-pro-150x150';
        $thumbnail_width = isset($instance['thumbnail_width']) ? $instance['thumbnail_width'] : 30;
        $display_date = (isset($instance['display_date']) && $instance['display_date']) ? true : false;
        $display_excerpt = (isset($instance['display_excerpt']) && $instance['display_excerpt']) ? true : false;
        $excerpt_letter_count = isset($instance['excerpt_letter_count']) ? $instance['excerpt_letter_count'] : 100;
        $title_html_tag = isset($instance['title_html_tag']) ? $instance['title_html_tag'] : 'div';
        $title_color = isset($instance['title_color']) ? $instance['title_color'] : '';
        $excerpt_color = isset($instance['excerpt_color']) ? $instance['excerpt_color'] : '';
        $content_width = 100;

        $title_style = $excerpt_style = "";
        $class = 'ht-pl-title';

        if ($title_html_tag == 'default') {
            $title_html_tag = 'h3';
            $class = 'ht-pl-title vl-post-title';
        }

        if (!empty($title_color)) {
            $title_style = 'style="color:' . $title_color . '"';
        }

        if (!empty($excerpt_color)) {
            $excerpt_style = 'style="color:' . $excerpt_color . '"';
        }

        echo $before_widget;
        if (!empty($title)):
            echo $before_title . apply_filters('widget_title', $title) . $after_title;
        endif;
        ?>
        <ul class="ht-latest-posts">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $post_count,
                'ignore_sticky_posts' => true
            );

            $query = new WP_Query($args);

            while ($query->have_posts()) : $query->the_post();
                ?>
                <li class="ht-clearfix">
                    <?php
                    if ($display_thumb) {
                        $content_width = 100 - $thumbnail_width;
                        ?>
                        <div class="ht-lp-image" style="width:<?php echo $thumbnail_width; ?>%">
                            <a href="<?php echo the_permalink(); ?>">
                                <?php viral_pro_post_featured_image($thumbnail_size, false); ?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="ht-lp-content" style="width:<?php echo $content_width; ?>%">
                        <<?php echo $title_html_tag; ?> class="<?php echo $class ?>" <?php echo $title_style; ?>>
                        <a href="<?php echo the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                        </<?php echo $title_html_tag; ?>>

                        <?php if ($display_date) { ?>
                            <div class="ht-lp-date" <?php echo $excerpt_style; ?>>
                                <?php echo get_the_date(); ?>
                            </div>
                        <?php } ?>

                        <?php if ($display_excerpt) { ?>
                            <div class="ht-lp-excerpt" <?php echo $excerpt_style; ?>>
                                <?php echo viral_pro_excerpt(get_the_content(), $excerpt_letter_count); ?>
                            </div>
                        <?php } ?>
                    </div>
                </li>   
                <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </ul>
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
