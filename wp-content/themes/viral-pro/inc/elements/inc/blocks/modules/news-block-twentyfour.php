<?php

namespace ViralPro\Blocks\Modules;

use \ViralPro\Blocks\Viral_Pro_Posts_Block;

class Viral_Pro_News_Block_Twentyfour extends Viral_Pro_Posts_Block {

    public $source;

    public function render($settings) {
        $output = parent::render($settings);
        return $output;
    }

    protected function get_settings_data_atts() {
        $data_atts = array();
        $settings = $this->settings;
        /* Block Content */
        $data_atts['block_type'] = $settings['block_type'];

        /* Post Content */
        $data_atts['post_image_size'] = $settings['post_image_size'];
        $data_atts['post_category'] = $settings['post_category'];
        $data_atts['no_of_posts'] = $settings['no_of_posts'];
        $data_atts['post_excerpt_length'] = $settings['post_excerpt_length'];
        $data_atts['post_author'] = $settings['post_author'];
        $data_atts['post_date'] = $settings['post_date'];
        $data_atts['post_comment'] = $settings['post_comment'];
        $data_atts['date_format'] = $settings['date_format'];
        $data_atts['custom_date_format'] = $settings['custom_date_format'];

        $data_atts['column_count_tablet']['size'] = isset($settings['column_count_tablet']['size']) ? $settings['column_count_tablet']['size'] : 3;
        $data_atts['column_count_mobile']['size'] = isset($settings['column_count_mobile']['size']) ? $settings['column_count_mobile']['size'] : 1;
        $data_atts['column_count']['size'] = isset($settings['column_count']['size']) ? $settings['column_count']['size'] : 1;

        /* Pagination */
        $data_atts['pagination'] = $settings['pagination'];
        $data_atts['show_remaining'] = $settings['show_remaining'];

        return $data_atts;
    }

    public function inner($posts, $settings) {
        $column_count_tablet = isset($settings['column_count_tablet']['size']) ? $settings['column_count_tablet']['size'] : 3;
        $column_count_mobile = isset($settings['column_count_mobile']['size']) ? $settings['column_count_mobile']['size'] : 1;
        $column_count = isset($settings['column_count']['size']) ? $settings['column_count']['size'] : 1;
        $vl_news_module_class = array(
            'vl-mininews-block',
            'style2',
            'vl-row',
            'vl-col-' . $column_count,
            'vl-tablet-col-' . $column_count_tablet,
            'vl-mobile-col-' . $column_count_mobile
        );
        $output = '';
        $output .= '<div class="' . esc_attr(implode(' ', $vl_news_module_class)) . '">';
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                $this->source = new \ViralPro\Blocks\Viral_Pro_Posts_Source($post);
                $output .= $this->render_content($settings);
            };
        };
        $output .= '</div>';
        return $output;
    }

    public function render_content($settings) {
        $source = $this->source;
        $display_cat = $settings['post_category'];
        $image_size = $settings['post_image_size'];
        $post_count = $settings['no_of_posts'];

        ob_start();
        ?>
        <div class="vl-post-item vl-post-list vp-module <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">
            <div class="vl-post-thumb">
                <a href="<?php echo $source->get_permalink(); ?>">
                    <div class="vl-thumb-container">
                        <?php echo $source->get_featured_image($image_size); ?>
                    </div>
                </a>
            </div>

            <div class="vl-post-content">
                <?php
                if ($display_cat == 'yes')
                    echo $source->get_primary_category();
                ?>
                <h3 class="vl-post-title"><a href="<?php echo $source->get_permalink(); ?>"><?php echo $source->get_title(); ?></a></h3>
                <?php $this->get_post_meta($settings) ?>

                <?php $this->get_post_excerpt($settings); ?>
            </div>
        </div>
        <?php
        $output = ob_get_clean();

        return $output;
    }

    protected function get_block_class() {
        return '';
    }

    protected function get_post_excerpt($settings) {
        $source = $this->source;
        $excerpt_length = $settings['post_excerpt_length'];
        if ($excerpt_length) {
            ?>
            <div class="vl-excerpt"><?php echo $source->get_custom_excerpt($excerpt_length); ?></div>
            <?php
        }
    }

    protected function get_post_meta($settings) {
        $source = $this->source;
        $post_author = $settings['post_author'];
        $post_date = $settings['post_date'];
        $post_comment = $settings['post_comment'];

        if ($post_author == 'yes' || $post_date == 'yes' || $post_comment == 'yes') {
            ?>
            <div class="vl-post-metas">
                <?php
                if ($post_author == 'yes') {
                    $source->get_author_name();
                }

                if ($post_date == 'yes') {
                    $date_format = $settings['date_format'];

                    if ($date_format == 'relative_format') {
                        $source->get_time_ago();
                    } else if ($date_format == 'default') {
                        $source->get_post_date();
                    } else if ($date_format == 'custom') {
                        $format = $settings['custom_date_format'];
                        $source->get_post_date($format);
                    }
                }

                if ($post_comment == 'yes') {
                    $source->get_comment_count();
                }
                ?>
            </div>
            <?php
        }
    }

}
