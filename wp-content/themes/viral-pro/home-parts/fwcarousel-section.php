<?php

/**
 * @package Viral Pro
 */
function viral_pro_frontpage_fwcarousel_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_fwcarousel_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_fwcarousel_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on') {
        return;
    }
    ?>
    <section id="ht-fwcarousel-section" class="ht-section ht-fwcarousel-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('fwcarousel'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('fwcarousel'); ?>
            <div class="ht-container ht-fwcarousel-container">
                <?php viral_pro_frontpage_fwcarousel_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('fwcarousel'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_fwcarousel_content() {

    viral_pro_frontpage_add_top_widget('fwcarousel');

    $cats = get_theme_mod('viral_pro_fwcarousel_cat');
    $display_cat = get_theme_mod('viral_pro_fwcarousel_display_cat', true);
    $display_author = get_theme_mod('viral_pro_fwcarousel_display_author', true);
    $display_date = get_theme_mod('viral_pro_fwcarousel_display_date', true);
    $slide_count = get_theme_mod('viral_pro_fwcarousel_slide_count', '3');
    $post_count = get_theme_mod('viral_pro_fwcarousel_post_count', '5');
    $auto_slide = get_theme_mod('viral_pro_fwcarousel_auto_slide', true);
    $slide_pause = get_theme_mod('viral_pro_fwcarousel_slide_pause', '5');
    $image_size = !viral_pro_is_amp() ? get_theme_mod('viral_pro_fwcarousel_image_size', 'viral-pro-500x500') : 'viral-pro-500x500';
    $title_size = get_theme_mod('viral_pro_fwcarousel_title_size', 'vl-mid-title');
    $layout = get_theme_mod('viral_pro_fwcarousel_style', 'style1');
    $auto_slide = $auto_slide ? true : false;

    $parameters = array(
        'items' => intval($slide_count),
        'autoplay' => $auto_slide,
        'pause' => intval($slide_pause)
    );

    $parameters_json = json_encode($parameters);

    $args = array(
        'cat' => $cats,
        'posts_per_page' => $post_count,
        'ignore_sticky_posts' => true
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        ?>
        <div class="vl-fwcarousel-block <?php echo esc_attr($layout); ?>">
            <?php
            echo viral_pro_is_amp() ? '<amp-base-carousel class="amp-slider ht-post-carousel" layout="responsive" width="1" height="1" heights="(min-width: 1199px) ' . (100 / $slide_count) . '%,(min-width: 900px) 31.33%,(min-width: 600px) 48%, 100%" visible-count="(min-width: 1199px) ' . $slide_count . ',(min-width: 900px) 3,(min-width: 600px) 2, 1" ' . ($auto_slide ? 'auto-advance="true" loop="true"' : '') . ' auto-advance-interval="' . ($slide_pause * 1000) . '">' : '<div class="owl-carousel" data-params=' . $parameters_json . '>';
            while ($query->have_posts()): $query->the_post();
                if (has_post_thumbnail()) {
                    ?>
                    <div class="vl-fwcarousel-item">
                        <div class="vl-fwcarousel-thumb vl-post-thumb">
                            <a href="<?php the_permalink(); ?>">
                                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), $image_size); ?>
                                <img alt="<?php echo esc_attr(get_the_title()) ?>" src="<?php echo esc_url($image[0]); ?>"/>
                            </a>
                            <?php
                            if ($display_cat && $layout == 'style1' && !viral_pro_is_amp()) {
                                echo viral_pro_post_primary_category();
                            }

                            if ($layout == 'style2') {
                                ?>
                                <div class="vl-post-content vl-gradient-overlay">
                                    <?php
                                    if ($display_cat) {
                                        echo viral_pro_post_primary_category();
                                    }
                                    ?>
                                    <h3 class="vl-post-title <?php echo esc_attr($title_size) ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php
                                    if ($display_author || $display_date) {
                                        echo '<div class="vl-post-metas">';
                                        if ($display_author) {
                                            echo viral_pro_post_author();
                                        }

                                        if ($display_date) {
                                            echo viral_pro_post_date();
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        if ($layout == 'style1') {
                            if (viral_pro_is_amp()) {
                                ?>
                                <div class="vl-post-content vl-gradient-overlay">
                                    <?php
                                    if ($display_cat) {
                                        echo viral_pro_post_primary_category();
                                    }
                                }
                                ?>
                                <h3 class="vl-post-title <?php echo esc_attr($title_size) ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php
                                    if ($display_author || $display_date) {
                                        echo '<div class="vl-post-metas">';
                                        if ($display_author) {
                                            echo viral_pro_post_author();
                                        }

                                        if ($display_date) {
                                            echo viral_pro_post_date();
                                        }
                                        echo '</div>';
                                    }
                                    if (viral_pro_is_amp()) {
                                        ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
            endwhile;
            wp_reset_postdata();
            echo viral_pro_is_amp() ? '</amp-base-carousel>' : '</div>';
            ?>
        </div>
        <?php
    }

    viral_pro_frontpage_add_bottom_widget('fwcarousel');
}
