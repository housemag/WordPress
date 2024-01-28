<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_slider2_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_slider2_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_slider2_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-slider2-section" class="ht-section ht-slider2-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('slider2'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('slider2'); ?>
            <div class="ht-container ht-slider2-container">
                <?php viral_pro_frontpage_slider2_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('slider2'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_slider2_content() {

    viral_pro_frontpage_add_top_widget('slider2');

    $slider_blocks = get_theme_mod('viral_pro_frontpage_slider2_blocks', json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'post_count' => 5,
            'enable' => 'on'
        )
    )));

    if ($slider_blocks) {
        $slider_blocks = json_decode($slider_blocks);
        foreach ($slider_blocks as $slider_block) {
            if ($slider_block->enable == 'on') {
                $title = $slider_block->title;
                $category = $slider_block->category;
                $layout = $slider_block->layout;
                $display_cat = $slider_block->display_cat;
                $display_author = $slider_block->display_author;
                $display_date = $slider_block->display_date;
                $post_count = $slider_block->post_count;

                $args = array(
                    'title' => $title,
                    'cat' => $category,
                    'layout' => $layout,
                    'display_cat' => $display_cat,
                    'display_author' => $display_author,
                    'display_date' => $display_date,
                    'post_count' => $post_count
                );

                do_action('viral_pro_slider2_section', $args);
            }
        }
    }

    viral_pro_frontpage_add_bottom_widget('slider2');
}
