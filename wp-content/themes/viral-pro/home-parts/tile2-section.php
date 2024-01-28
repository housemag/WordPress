<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_tile2_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_tile2_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_tile2_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-tile2-section" class="ht-section ht-tile2-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('tile2'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('tile2'); ?>
            <div class="ht-container ht-tile2-container">
                <?php viral_pro_frontpage_tile2_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('tile2'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_tile2_content() {

    viral_pro_frontpage_add_top_widget('tile2');

    $tile2_blocks = get_theme_mod('viral_pro_frontpage_tile2_blocks', json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'on',
            'display_author' => 'on',
            'display_date' => 'on',
            'enable' => 'on',
            'gap' => 'space-0'
        )
    )));

    if ($tile2_blocks) {
        $tile2_blocks = json_decode($tile2_blocks);
        foreach ($tile2_blocks as $tile2_block) {
            if ($tile2_block->enable == 'on') {
                $title = $tile2_block->title;
                $category = $tile2_block->category;
                $layout = $tile2_block->layout;
                $display_cat = $tile2_block->display_cat;
                $display_author = $tile2_block->display_author;
                $display_date = $tile2_block->display_date;
                $gap = $tile2_block->gap;

                $args = array(
                    'title' => $title,
                    'cat' => $category,
                    'layout' => $layout,
                    'display_cat' => $display_cat,
                    'display_author' => $display_author,
                    'display_date' => $display_date,
                    'gap' => $gap
                );

                do_action('viral_pro_tile2_section', $args);
            }
        }
    }

    viral_pro_frontpage_add_bottom_widget('tile2');
}
