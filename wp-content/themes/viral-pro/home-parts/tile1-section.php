<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_tile1_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_tile1_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_tile1_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-tile1-section" class="ht-section ht-tile1-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('tile1'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('tile1'); ?>
            <div class="ht-container ht-tile1-container">
                <?php viral_pro_frontpage_tile1_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('tile1'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_tile1_content() {

    viral_pro_frontpage_add_top_widget('tile1');

    $tile1_blocks = get_theme_mod('viral_pro_frontpage_tile1_blocks', json_encode(array(
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

    if ($tile1_blocks) {
        $tile1_blocks = json_decode($tile1_blocks);
        foreach ($tile1_blocks as $tile1_block) {
            if ($tile1_block->enable == 'on') {
                $title = $tile1_block->title;
                $category = $tile1_block->category;
                $layout = $tile1_block->layout;
                $display_cat = $tile1_block->display_cat;
                $display_author = $tile1_block->display_author;
                $display_date = $tile1_block->display_date;
                $gap = $tile1_block->gap;

                $args = array(
                    'title' => $title,
                    'cat' => $category,
                    'layout' => $layout,
                    'display_cat' => $display_cat,
                    'display_author' => $display_author,
                    'display_date' => $display_date,
                    'gap' => $gap
                );

                do_action('viral_pro_tile1_section', $args);
            }
        }
    }

    viral_pro_frontpage_add_bottom_widget('tile1');
}
