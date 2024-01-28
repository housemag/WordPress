<?php

namespace ViralPro\Blocks\Modules;

use \ViralPro\Blocks\Viral_Pro_Posts_Block;

class Viral_Pro_News_Block_Fourteen extends Viral_Pro_Posts_Block {

    public $source;
    public $index;
    public $last;

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
        $data_atts['content_align'] = $settings['content_align'];
        $data_atts['post_excerpt_length'] = $settings['post_excerpt_length'];
        $data_atts['post_author'] = $settings['post_author'];
        $data_atts['post_date'] = $settings['post_date'];
        $data_atts['post_comment'] = $settings['post_comment'];
        $data_atts['date_format'] = $settings['date_format'];
        $data_atts['custom_date_format'] = $settings['custom_date_format'];

        $data_atts['post_column_tablet']['size'] = isset($settings['post_column_tablet']['size']) ? $settings['post_column_tablet']['size'] : 2;
        $data_atts['post_column_mobile']['size'] = isset($settings['post_column_mobile']['size']) ? $settings['post_column_mobile']['size'] : 1;
        $data_atts['post_column']['size'] = isset($settings['post_column']['size']) ? $settings['post_column']['size'] : 1;

        /* Pagination */
        $data_atts['pagination'] = $settings['pagination'];
        $data_atts['show_remaining'] = $settings['show_remaining'];

        return $data_atts;
    }

    public function inner($posts, $settings) {
        $post_column_tablet = isset($settings['post_column_tablet']['size']) ? $settings['post_column_tablet']['size'] : 2;
        $post_column_mobile = isset($settings['post_column_mobile']['size']) ? $settings['post_column_mobile']['size'] : 1;
        $post_column = isset($settings['post_column']['size']) ? $settings['post_column']['size'] : 4;
        $vl_news_module_class = array(
            'vl-fwnews-block-style6',
            'vl-row',
            'vl-col-' . $post_column,
            'vl-tablet-col-' . $post_column_tablet,
            'vl-mobile-col-' . $post_column_mobile
        );
        $output = '';
        $output .= '<div class="' . esc_attr(implode(' ', $vl_news_module_class)) . '">';
        if (!empty($posts)) {
            $this->last = count($posts);
            foreach ($posts as $key => $post) {
                $this->source = new \ViralPro\Blocks\Viral_Pro_Posts_Source($post);
                $this->index = $key + 1;
                $output .= $this->render_content($settings);
            };
        };
        $output .= '</div>';
        return $output;
    }

    public function render_content($settings) {
        $source = $this->source;
        $display_cat = $settings['post_category'];
        $post_image_size = $settings['post_image_size'];
        $content_align_class = $settings['content_align'];

        ob_start();
        ?>
        <div class="vl-post-item vl-post-list vp-module <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">
            <div class="vl-post-thumb">
                <a href="<?php echo $source->get_permalink(); ?>">
                    <div class="vl-thumb-container">
                        <?php echo $source->get_featured_image($post_image_size); ?>
                    </div>
                </a>
                <?php
                if ($display_cat) {
                    echo $source->get_primary_category();
                }
                ?>
            </div>

            <div class="vl-post-content <?php echo esc_attr($content_align_class); ?>">
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
        return 'vl-fwnews-block style6';
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
