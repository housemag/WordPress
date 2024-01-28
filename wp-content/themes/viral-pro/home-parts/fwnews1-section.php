<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_fwnews1_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_fwnews1_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_fwnews1_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-fwnews1-section" class="ht-section ht-fwnews1-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('fwnews1'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('fwnews1'); ?>
            <div class="ht-container ht-fwnews1-container">
                <?php viral_pro_frontpage_fwnews1_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('fwnews1'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_fwnews1_content() {

    viral_pro_frontpage_add_top_widget('fwnews1');

    $fwnews1_blocks = get_theme_mod('viral_pro_frontpage_fwnews1_blocks', json_encode(array(
        array(
            'title' => __('Title', 'viral-pro'),
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'enable' => 'on'
        )
    )));

    if ($fwnews1_blocks) {
        $fwnews1_blocks = json_decode($fwnews1_blocks);
        foreach ($fwnews1_blocks as $fwnews1_block) {
            if ($fwnews1_block->enable == 'on') {
                $args = array(
                    'title' => $fwnews1_block->title,
                    'cat' => $fwnews1_block->category,
                    'display_cat' => $fwnews1_block->display_cat,
                    'display_author' => $fwnews1_block->display_author,
                    'display_date' => $fwnews1_block->display_date,
                    'layout' => $fwnews1_block->layout
                );

                do_action('viral_pro_fwnews1_section', $args);
            }
        }
    }

    viral_pro_frontpage_add_bottom_widget('fwnews1');
}
