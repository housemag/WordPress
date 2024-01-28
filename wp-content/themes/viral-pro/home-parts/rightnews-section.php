<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_rightnews_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_rightnews_section_disable', 'off');
    $sticky_sidebar = get_theme_mod('viral_pro_frontpage_rightnews_sticky_sidebar', true);
    $overwrite = get_theme_mod('viral_pro_rightnews_overwrite_block_title_color', false);
    $class = array();
    $class[] = $sticky_sidebar ? 'ht-enable-sticky-sidebar' : '';
    $class[] = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-rightnews-section" class="ht-section ht-rightnews-section <?php echo esc_attr(implode(' ', $class)); ?>" <?php echo viral_pro_parallax_background('rightnews'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('rightnews'); ?>
            <div class="ht-container ht-rightnews-container ht-clearfix">
                <?php viral_pro_frontpage_rightnews_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('rightnews'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_rightnews_content() {
    ?>
    <div class="primary">
        <?php
        viral_pro_frontpage_add_top_widget('rightnews');

        $rightnews_blocks = get_theme_mod('viral_pro_frontpage_rightnews_blocks', json_encode(array(
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

        if ($rightnews_blocks) {
            $rightnews_blocks = json_decode($rightnews_blocks);
            foreach ($rightnews_blocks as $rightnews_block) {
                if ($rightnews_block->enable == 'on') {
                    $args = array(
                        'cat' => $rightnews_block->category,
                        'layout' => $rightnews_block->layout,
                        'display_cat' => $rightnews_block->display_cat,
                        'display_author' => $rightnews_block->display_author,
                        'display_date' => $rightnews_block->display_date,
                        'title' => $rightnews_block->title
                    );

                    do_action('viral_pro_rightnews_section', $args);
                }
            }
        }

        viral_pro_frontpage_add_bottom_widget('rightnews');
        ?>
    </div>

    <div class="secondary widget-area">
        <div class="theiaStickySidebar">
            <?php dynamic_sidebar('viral-pro-frontpage-left-sidebar') ?>
        </div>
    </div>
    <?php
}
