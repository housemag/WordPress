<?php

namespace ViralPro\Blocks\Modules;

use \ViralPro\Blocks\Viral_Pro_Posts_Block;

class Viral_Pro_Tile_Block_Six extends Viral_Pro_Posts_Block {

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
        $data_atts['thumb_spaces'] = $settings['thumb_spaces'];
        $data_atts['featured_post_image_size'] = $settings['featured_post_image_size'];
        $data_atts['side_post_image_size'] = $settings['side_post_image_size'];
        $data_atts['content_align'] = $settings['content_align'];
        $data_atts['featured_post_category'] = $settings['featured_post_category'];
        $data_atts['side_post_category'] = $settings['side_post_category'];
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
        $gap = $settings['thumb_spaces'];
        $output = '';
        $output .= '<div class="vl-tile-block ht-clearfix style6 ' . esc_attr($gap) . '">';
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
        $featured_display_cat = $settings['featured_post_category'];
        $side_display_cat = $settings['side_post_category'];
        $featured_image_size = $settings['featured_post_image_size'];
        $side_image_size = $settings['side_post_image_size'];
        $content_align_class = $settings['content_align'];
        $index = $this->index;
        $last = $this->last;

        ob_start();
        if ($index == 1) {
            ?>
            <div class="vl-width-35 vl-height-100 vl-thumb vl-left-col">
                <div class="vl-thumb-inner vl-post-thumb vp-module <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">
                    <a class="" href="<?php echo $source->get_permalink(); ?>">
                        <?php echo $source->get_featured_image($featured_image_size); ?>
                    </a>

                    <?php
                    if ($featured_display_cat == 'yes') {
                        echo $source->get_category_list();
                    }
                    ?>

                    <div class="vl-title-container <?php echo esc_attr($content_align_class); ?>">
                        <a href="<?php echo $source->get_permalink(); ?>">
                            <h3 class="vl-mid-title vl-post-title"><span><?php echo $source->get_title(); ?></span></h3>
                            <?php $this->get_post_meta($settings, $index) ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        } else {
            if ($index == 2)
                echo '<div class="vl-width-65 vl-height-100 vl-parent vl-right-col">';
            ?>

            <?php if ($index > 1) { ?>
                <div class="vl-height-50 vl-width-50 vl-thumb">
                    <div class="vl-thumb-inner vl-post-thumb vp-module <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">
                        <a href="<?php echo $source->get_permalink(); ?>">
                            <?php echo $source->get_featured_image($side_image_size); ?>
                        </a>

                        <?php
                        if ($side_display_cat == 'yes') {
                            echo $source->get_primary_category();
                        }
                        ?>

                        <div class="vl-title-container <?php echo esc_attr($content_align_class); ?>">
                            <a href="<?php echo $source->get_permalink(); ?>">
                                <h3 class="vl-mid-title vl-post-title"><span><?php echo $source->get_title(); ?></span></h3>
                                <?php $this->get_post_meta($settings, $index) ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($index == $last) echo '</div>'; ?>
        <?php } ?>
        <?php
        $output = ob_get_clean();

        return $output;
    }

    protected function get_block_class() {
        return 'vl-tile-block-wrap';
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
