<?php

namespace ViralPro\Blocks\Modules;

use \ViralPro\Blocks\Viral_Pro_Posts_Block;

class Viral_Pro_News_Block_One extends Viral_Pro_Posts_Block {

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
        $data_atts['featured_post_image_size'] = $settings['featured_post_image_size'];
        $data_atts['side_post_image_size'] = $settings['side_post_image_size'];
        $data_atts['content_align'] = $settings['content_align'];
        $data_atts['featured_post_category'] = $settings['featured_post_category'];
        $data_atts['side_post_category'] = $settings['side_post_category'];
        $data_atts['featured_excerpt_length'] = $settings['featured_excerpt_length'];
        $data_atts['side_post_excerpt_length'] = $settings['side_post_excerpt_length'];
        $data_atts['featured_post_author'] = $settings['featured_post_author'];
        $data_atts['featured_post_date'] = $settings['featured_post_date'];
        $data_atts['featured_post_comment'] = $settings['featured_post_comment'];
        $data_atts['side_post_author'] = $settings['side_post_author'];
        $data_atts['side_post_date'] = $settings['side_post_date'];
        $data_atts['side_post_comment'] = $settings['side_post_comment'];
        $data_atts['date_format'] = $settings['date_format'];
        $data_atts['custom_date_format'] = $settings['custom_date_format'];

        /* Pagination */
        $data_atts['pagination'] = $settings['pagination'];
        $data_atts['show_remaining'] = $settings['show_remaining'];

        return $data_atts;
    }

    public function inner($posts, $settings) {
        $output = '';
        $output .= '<div class="vl-fwnews-block-style1">';
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
        $featured_post_image_size = $settings['featured_post_image_size'];
        $side_post_image_size = $settings['side_post_image_size'];
        $content_align_class = $settings['content_align'];
        $index = $this->index;
        $title_class = $index == 1 ? 'vl-large-title' : 'vl-big-title';

        ob_start();
        ?>
        <div data-index="<?php echo $index; ?>" class="vl-post-item vp-module <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">
            <div class="vl-post-thumb">
                <a href="<?php echo $source->get_permalink(); ?>">
                    <div class="vl-thumb-container">
                        <?php
                        $image_size = ($index == 1) ? $featured_post_image_size : $side_post_image_size;
                        echo $source->get_featured_image($image_size);
                        ?>
                    </div>
                </a>
                <?php
                if ($index == 1) {
                    if ($settings['featured_post_category'] == 'yes')
                        echo $source->get_category_list();
                } else {
                    if ($settings['side_post_category'] == 'yes')
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
        $excerpt_length = $count == 1 ? $settings['featured_excerpt_length'] : $settings['side_post_excerpt_length'];
        if ($excerpt_length) {
            ?>
            <div class="vl-excerpt"><?php echo $source->get_custom_excerpt($excerpt_length); ?></div>
            <?php
        }
    }

    protected function get_post_meta($settings, $count) {
        $source = $this->source;
        $post_author = $count == 1 ? $settings['featured_post_author'] : $settings['side_post_author'];
        $post_date = $count == 1 ? $settings['featured_post_date'] : $settings['side_post_date'];
        $post_comment = $count == 1 ? $settings['featured_post_comment'] : $settings['side_post_comment'];

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
