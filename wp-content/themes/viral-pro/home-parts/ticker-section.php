<?php

/**
 * @package Viral
 */
function viral_pro_frontpage_ticker_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_ticker_sec_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_ticker_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-ticker-section" class="ht-section ht-ticker-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('ticker'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('ticker'); ?>
            <div class="ht-container ht-ticker-container">
                <?php viral_pro_frontpage_ticker_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('ticker'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_ticker_content() {

    viral_pro_frontpage_add_top_widget('ticker');

    $ticker_category = get_theme_mod('viral_pro_ticker_category', '-1');
    $ticker_post_count = get_theme_mod('viral_pro_ticker_post_count', 5);
    $ticker_style = get_theme_mod('viral_pro_ticker_style', 'style1');
    $ticker_icon = get_theme_mod('viral_pro_ticker_icon', 'icon_target');
    $ticker_animation = get_theme_mod('viral_pro_ticker_animation', 'flip-top-bottom');
    $ticker_pause = get_theme_mod('viral_pro_ticker_pause', 5);

    $parameters = array(
        'animation' => $ticker_animation,
        'pause' => intval($ticker_pause)
    );

    $parameters_json = json_encode($parameters);

    if ($ticker_category) {
        $args = array(
            'posts_per_page' => absint($ticker_post_count),
            'ignore_sticky_posts' => true
        );

        if ($ticker_category != '-1') {
            $args['cat'] = $ticker_category;
        }

        $query = new WP_Query($args);
        if ($query->have_posts()):
            ?>
            <div class="vl-ticker <?php echo esc_attr($ticker_style); ?>">
                <span class="vl-ticker-title">
                    <i class="<?php echo esc_attr($ticker_icon) ?>"></i>
                    <?php
                    $ticker_title = get_theme_mod('viral_pro_ticker_title', esc_html__('Breaking News', 'viral-pro'));
                    if ($ticker_title) {
                        echo esc_html($ticker_title);
                    } else {
                        echo get_cat_name($ticker_category);
                    }
                    ?>
                </span>
                <div class="owl-carousel" data-params='<?php echo esc_attr($parameters_json); ?>'>
                    <?php
                    while ($query->have_posts()): $query->the_post();
                        echo '<h3 class="vl-post-title"><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h3>';
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php
        endif;
        ?>
        <?php
    }

    viral_pro_frontpage_add_bottom_widget('ticker');
}
