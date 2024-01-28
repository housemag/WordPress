<?php

namespace ViralPro\Blocks\Modules;

use \ViralPro\Blocks\Viral_Pro_Posts_Block;

class Viral_Pro_News_Block_Ten extends Viral_Pro_Posts_Block {

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
        $data_atts['listing_post_image_size'] = $settings['listing_post_image_size'];
        $data_atts['listing_post_category'] = $settings['listing_post_category'];
        $data_atts['listing_excerpt_length'] = $settings['listing_excerpt_length'];
        $data_atts['listing_post_author'] = $settings['listing_post_author'];
        $data_atts['listing_post_date'] = $settings['listing_post_date'];
        $data_atts['listing_post_comment'] = $settings['listing_post_comment'];
        $data_atts['date_format'] = $settings['date_format'];
        $data_atts['custom_date_format'] = $settings['custom_date_format'];

        /* Pagination */
        $data_atts['pagination'] = $settings['pagination'];
        $data_atts['show_remaining'] = $settings['show_remaining'];

        return $data_atts;
    }

    public function inner($posts, $settings) {
        $output = '';
        $output .= '<div class="vl-three-column-block-wrap">';
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
        $listing_post_image_size = $settings['listing_post_image_size'];

        ob_start();
        ?>
        <div class="vl-post-item ht-clearfix vp-module <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">
            <div class="vl-post-thumb">
                <a href="<?php echo $source->get_permalink(); ?>">
                    <div class="vl-thumb-container">
                        <?php echo $source->get_featured_image($listing_post_image_size); ?>
                    </div>
                </a>
            </div>

            <div class="vl-post-content">
                <?php
                if ($settings['listing_post_category'] == 'yes')
                    echo $source->get_primary_category();
                ?>
                <h3 class="vl-post-title"><a href="<?php echo $source->get_permalink(); ?>"><?php echo $source->get_title(); ?></a></h3>
                <?php $this->get_post_meta($settings); ?>
                <?php $this->get_post_excerpt($settings); ?>
            </div>
        </div>
        <?php
        $output = ob_get_clean();

        return $output;
    }

    protected function get_block_class() {
        return 'vl-three-column-block';
    }

    protected function get_post_excerpt($settings) {
        $source = $this->source;
        $excerpt_length = $settings['listing_excerpt_length'];
        if ($excerpt_length) {
            ?>
            <div class="vl-excerpt"><?php echo $source->get_custom_excerpt($excerpt_length); ?></div>
            <?php
        }
    }

    protected function get_post_meta($settings) {
        $source = $this->source;
        $post_author = $settings['listing_post_author'];
        $post_date = $settings['listing_post_date'];
        $post_comment = $settings['listing_post_comment'];

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
