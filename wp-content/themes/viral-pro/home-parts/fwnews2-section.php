<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_fwnews2_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_fwnews2_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_fwnews2_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-fwnews2-section" class="ht-section ht-fwnews2-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('fwnews2'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('fwnews2'); ?>
            <div class="ht-container ht-fwnews2-container">
                <?php viral_pro_frontpage_fwnews2_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('fwnews2'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_fwnews2_content() {

    viral_pro_frontpage_add_top_widget('fwnews2');

    $fwnews2_blocks = get_theme_mod('viral_pro_frontpage_fwnews2_blocks', json_encode(array(
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

    if ($fwnews2_blocks) {
        $fwnews2_blocks = json_decode($fwnews2_blocks);
        foreach ($fwnews2_blocks as $fwnews2_block) {
            if ($fwnews2_block->enable == 'on') {
                $args = array(
                    'title' => $fwnews2_block->title,
                    'cat' => $fwnews2_block->category,
                    'display_cat' => $fwnews2_block->display_cat,
                    'display_author' => $fwnews2_block->display_author,
                    'display_date' => $fwnews2_block->display_date,
                    'layout' => $fwnews2_block->layout
                );

                do_action('viral_pro_fwnews2_section', $args);
            }
        }
    }

    viral_pro_frontpage_add_bottom_widget('fwnews2');
}
