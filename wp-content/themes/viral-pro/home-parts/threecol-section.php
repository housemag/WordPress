<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_threecol_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_threecol_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_threecol_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-threecol-section" class="ht-section ht-threecol-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('threecol'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('threecol'); ?>
            <div class="ht-container ht-threecol-container">
                <?php viral_pro_frontpage_threecol_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('threecol'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_threecol_content() {

    viral_pro_frontpage_add_top_widget('threecol');

    $threecol_blocks = get_theme_mod('viral_pro_frontpage_threecol_blocks', json_encode(array(
        array(
            'category1' => '-1',
            'category2' => '-1',
            'category3' => '-1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'post_count' => 3,
            'layout' => 'style1',
            'enable' => 'on'
        )
    )));

    if ($threecol_blocks) {
        $threecol_blocks = json_decode($threecol_blocks);
        foreach ($threecol_blocks as $threecol_block) {
            if ($threecol_block->enable == 'on') {
                $args = array(
                    'cat1' => $threecol_block->category1,
                    'cat2' => $threecol_block->category2,
                    'cat3' => $threecol_block->category3,
                    'display_cat' => $threecol_block->display_cat,
                    'display_author' => $threecol_block->display_author,
                    'display_date' => $threecol_block->display_date,
                    'post_count' => $threecol_block->post_count,
                    'layout' => $threecol_block->layout
                );

                do_action('viral_pro_threecol_section', $args);
            }
        }
    }

    viral_pro_frontpage_add_bottom_widget('threecol');
}
