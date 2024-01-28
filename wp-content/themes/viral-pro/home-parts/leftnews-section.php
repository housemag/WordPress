<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_leftnews_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_leftnews_section_disable', 'off');
    $sticky_sidebar = get_theme_mod('viral_pro_frontpage_leftnews_sticky_sidebar', true);
    $overwrite = get_theme_mod('viral_pro_leftnews_overwrite_block_title_color', false);
    $class = array();
    $class[] = $sticky_sidebar ? 'ht-enable-sticky-sidebar' : '';
    $class[] = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-leftnews-section" class="ht-section ht-leftnews-section <?php echo esc_attr(implode(' ', $class)); ?>" <?php echo viral_pro_parallax_background('leftnews'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('leftnews'); ?>
            <div class="ht-container ht-leftnews-container ht-clearfix">
                <?php viral_pro_frontpage_leftnews_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('leftnews'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_leftnews_content() {
    ?>
    <div class="primary">
        <?php
        viral_pro_frontpage_add_top_widget('leftnews');

        $leftnews_blocks = get_theme_mod('viral_pro_frontpage_leftnews_blocks', json_encode(array(
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

        if ($leftnews_blocks) {
            $leftnews_blocks = json_decode($leftnews_blocks);
            foreach ($leftnews_blocks as $leftnews_block) {
                if ($leftnews_block->enable == 'on') {
                    $args = array(
                        'cat' => $leftnews_block->category,
                        'layout' => $leftnews_block->layout,
                        'display_cat' => $leftnews_block->display_cat,
                        'display_author' => $leftnews_block->display_author,
                        'display_date' => $leftnews_block->display_date,
                        'title' => $leftnews_block->title
                    );

                    do_action('viral_pro_leftnews_section', $args);
                }
            }
        }

        viral_pro_frontpage_add_bottom_widget('leftnews');
        ?>
    </div>

    <div class="secondary widget-area">
        <div class="theiaStickySidebar">
            <?php dynamic_sidebar('viral-pro-frontpage-right-sidebar') ?>
        </div>
    </div>
    <?php
}
