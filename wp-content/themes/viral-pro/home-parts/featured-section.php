<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_featured_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_featured_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_featured_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-featured-section" class="ht-section ht-featured-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('featured'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('featured'); ?>
            <div class="ht-container ht-featured-container">
                <?php viral_pro_frontpage_featured_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('featured'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_featured_content() {

    viral_pro_frontpage_add_top_widget('featured');

    $featured_blocks = get_theme_mod('viral_pro_frontpage_featured_blocks', json_encode(array(
        array(
            'image' => '',
            'title' => '',
            'link' => '',
            'enable' => 'on'
        )
    )));
    $image_size = get_theme_mod('viral_pro_featured_image_size', 'viral-pro-650x500');
    $viral_pro_featured_column = get_theme_mod('viral_pro_featured_column', 3);
    $viral_pro_featured_style = get_theme_mod('viral_pro_featured_style', 'style1');

    $class = array(
        'ht-featured-block-wrap',
        'ht-clearfix',
        'ht-col-' . $viral_pro_featured_column,
        $viral_pro_featured_style
    );
    ?>
    <div class="<?php echo implode(' ', $class) ?>">
        <?php
        if ($featured_blocks) {
            $featured_blocks = json_decode($featured_blocks);
            foreach ($featured_blocks as $featured_block) {
                if ($featured_block->enable == 'on') {
                    $image = $featured_block->image;
                    $title = $featured_block->title;
                    $link = $featured_block->link;
                    $image_url = "";

                    if (!empty($image)) {
                        $image_id = attachment_url_to_postid($image);
                        if ($image_id) {
                            $image_array = wp_get_attachment_image_src($image_id, $image_size);
                            $image_url = $image_array[0];
                        } else {
                            $image_url = $image;
                        }
                    }
                    ?>
                    <div class="ht-featured-block vl-post-thumb">
                        <?php
                        echo '<a href="' . esc_url($link) . '">';
                        if ($image_url) {
                            ?>
                            <img src="<?php echo esc_url($image_url); ?>"/>
                            <?php
                        }

                        if (!empty($title)) {
                            ?> 
                            <span><?php echo esc_html($title); ?></span>
                            <?php
                        }
                        echo '</a>';
                        ?>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
    <?php
    viral_pro_frontpage_add_bottom_widget('featured');
}
