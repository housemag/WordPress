<?php

namespace ViralPro\Blocks\Modules;

use \ViralPro\Blocks\Viral_Pro_Posts_Block;

class Viral_Pro_Tile_Block_Five extends Viral_Pro_Posts_Block {

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
        $data_atts['thumb_spaces'] = $settings['thumb_spaces'];
        $data_atts['post_image_size'] = $settings['post_image_size'];
        $data_atts['content_align'] = $settings['content_align'];
        $data_atts['post_category'] = $settings['post_category'];
        $data_atts['post_author'] = $settings['post_author'];
        $data_atts['post_date'] = $settings['post_date'];
        $data_atts['post_comment'] = $settings['post_comment'];
        $data_atts['date_format'] = $settings['date_format'];
        $data_atts['custom_date_format'] = $settings['custom_date_format'];

        /* Pagination */
        $data_atts['pagination'] = $settings['pagination'];
        $data_atts['show_remaining'] = $settings['show_remaining'];

        return $data_atts;
    }

    public function inner($posts, $settings) {
        $gap = $settings['thumb_spaces'];
        $output = '';
        $output .= '<div class="vl-tile-block ht-clearfix style5 ' . esc_attr($gap) . '">';
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
        $content_align_class = $settings['content_align'];

        ob_start();
        ?>
        <div class="vl-width-33 vl-height-100 vl-thumb">
            <div class="vl-thumb-inner vl-post-thumb vp-module <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">
                <a href="<?php echo $source->get_permalink(); ?>">
                    <?php echo $source->get_featured_image($image_size); ?>
                </a>

                <?php
                if ($display_cat == 'yes') {
                    echo $source->get_primary_category();
                }
                ?>

                <div class="vl-title-container <?php echo esc_attr($content_align_class); ?>">
                    <a href="<?php echo $source->get_permalink(); ?>">
                        <h3 class="vl-mid-title vl-post-title"><span><?php echo $source->get_title(); ?></span></h3>
                        <?php $this->get_post_meta($settings) ?>
                    </a>
                </div>
            </div>
        </div>
        <?php
        $output = ob_get_clean();

        return $output;
    }

    protected function get_block_class() {
        return 'vl-tile-block-wrap';
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
