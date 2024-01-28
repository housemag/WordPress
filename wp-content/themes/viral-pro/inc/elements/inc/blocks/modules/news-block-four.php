<?php

namespace ViralPro\Blocks\Modules;

use \ViralPro\Blocks\Viral_Pro_Posts_Block;

class Viral_Pro_News_Block_Four extends Viral_Pro_Posts_Block {

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
        $data_atts['block_type'] = $this->settings['block_type'];

        /* Post Content */
        $data_atts['top_post_image_size'] = $settings['top_post_image_size'];
        $data_atts['bottom_post_image_size'] = $settings['bottom_post_image_size'];
        $data_atts['content_align'] = $settings['content_align'];
        $data_atts['top_block_post_category'] = $settings['top_block_post_category'];
        $data_atts['bottom_block_post_category'] = $settings['bottom_block_post_category'];
        $data_atts['top_excerpt_length'] = $settings['top_excerpt_length'];
        $data_atts['bottom_excerpt_length'] = $settings['bottom_excerpt_length'];
        $data_atts['top_post_author'] = $settings['top_post_author'];
        $data_atts['top_post_date'] = $settings['top_post_date'];
        $data_atts['top_post_comment'] = $settings['top_post_comment'];
        $data_atts['bottom_post_author'] = $settings['bottom_post_author'];
        $data_atts['bottom_post_date'] = $settings['bottom_post_date'];
        $data_atts['bottom_post_comment'] = $settings['bottom_post_comment'];
        $data_atts['date_format'] = $settings['date_format'];
        $data_atts['custom_date_format'] = $settings['custom_date_format'];

        /* Pagination */
        $data_atts['pagination'] = $settings['pagination'];
        $data_atts['show_remaining'] = $settings['show_remaining'];

        return $data_atts;
    }

    public function inner($posts, $settings) {
        $output = '';
        $output .= '<div class="vl-fwnews-block-style4">';
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
        $top_post_image_size = $settings['top_post_image_size'];
        $bottom_post_image_size = $settings['bottom_post_image_size'];
        $content_align_class = $settings['content_align'];
        $index = $this->index;
        $last = $this->last;
        $title_class = ($index == 1 || $index == 2) ? 'vl-big-title' : '';

        ob_start();
        ?>
        <div class="vl-post-item vp-module <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">
            <div class="vl-post-thumb">
                <a href="<?php echo $source->get_permalink(); ?>">
                    <div class="vl-thumb-container">
                        <?php
                        $image_size = ($index <= 2) ? $top_post_image_size : $bottom_post_image_size;
                        echo $source->get_featured_image($image_size);
                        ?>
                    </div>
                </a>
                <?php
                if ($index == 1 || $index == 2) {
                    if ($settings['top_block_post_category'] == 'yes')
                        echo $source->get_category_list();
                } else {
                    if ($settings['bottom_block_post_category'] == 'yes')
                        echo $source->get_primary_category();
                }
                ?>
            </div>

            <div class="vl-post-content <?php echo esc_attr($content_align_class); ?>">
                <h3 class="vl-post-title <?php echo esc_attr($title_class) ?>"><a href="<?php echo $source->get_permalink(); ?>"><?php echo $source->get_title(); ?></a></h3>
                <?php $this->get_post_meta($settings, $index); ?>
                <?php $this->get_post_excerpt($settings, $index); ?>
            </div>
        </div>
        <?php
        $output = ob_get_clean();

        return $output;
    }

    protected function get_block_class() {
        return 'vl-fwnews-block';
    }

    protected function get_post_excerpt($settings, $count) {
        $source = $this->source;
        $excerpt_length = $count > 2 ? $settings['bottom_excerpt_length'] : $settings['top_excerpt_length'];
        if ($excerpt_length) {
            ?>
            <div class="vl-excerpt"><?php echo $source->get_custom_excerpt($excerpt_length); ?></div>
            <?php
        }
    }

    protected function get_post_meta($settings, $count) {
        $source = $this->source;
        $post_author = $count <= 2 ? $settings['top_post_author'] : $settings['bottom_post_author'];
        $post_date = $count <= 2 ? $settings['top_post_date'] : $settings['bottom_post_date'];
        $post_comment = $count <= 2 ? $settings['top_post_comment'] : $settings['bottom_post_comment'];

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
