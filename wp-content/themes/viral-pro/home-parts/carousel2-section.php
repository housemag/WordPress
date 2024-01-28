<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_carousel2_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_carousel2_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_carousel2_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-carousel2-section" class="ht-section ht-carousel2-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('carousel2'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('carousel2'); ?>
            <div class="ht-container ht-carousel2-container">
                <?php viral_pro_frontpage_carousel2_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('carousel2'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_carousel2_content() {

    viral_pro_frontpage_add_top_widget('carousel2');

    $carousel2_blocks = get_theme_mod('viral_pro_frontpage_carousel2_blocks', json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'post_count' => 5,
            'slide_count' => 4,
            'slide_pause' => 5,
            'auto_slide' => 'on',
            'image_size' => 'viral-pro-650x500',
            'title_size' => 'vl-small-title',
            'gap' => '20',
            'enable' => 'on'
        )
    )));

    if ($carousel2_blocks) {
        $carousel2_blocks = json_decode($carousel2_blocks);
        foreach ($carousel2_blocks as $carousel2_block) {
            if ($carousel2_block->enable == 'on') {
                $title = $carousel2_block->title;
                $category = $carousel2_block->category;
                $layout = $carousel2_block->layout;
                $display_cat = $carousel2_block->display_cat;
                $display_author = $carousel2_block->display_author;
                $display_date = $carousel2_block->display_date;
                $post_count = $carousel2_block->post_count;
                $slide_count = $carousel2_block->slide_count;
                $slide_pause = $carousel2_block->slide_pause;
                $auto_slide = $carousel2_block->auto_slide;
                $image_size = $carousel2_block->image_size;
                $title_size = $carousel2_block->title_size;
                $gap = $carousel2_block->gap;

                $args = array(
                    'title' => $title,
                    'cat' => $category,
                    'layout' => $layout,
                    'display_cat' => $display_cat,
                    'display_author' => $display_author,
                    'display_date' => $display_date,
                    'post_count' => $post_count,
                    'slide_count' => $slide_count,
                    'slide_pause' => $slide_pause,
                    'auto_slide' => $auto_slide,
                    'image_size' => $image_size,
                    'title_size' => $title_size,
                    'gap' => $gap,
                );

                do_action('viral_pro_carousel2_section', $args);
            }
        }
    }

    viral_pro_frontpage_add_bottom_widget('carousel2');
}
