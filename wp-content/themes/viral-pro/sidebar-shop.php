<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Viral Pro
 */
$viral_pro_sidebar_layout = "right-sidebar";
$viral_pro_sidebar_left = 'viral-pro-shop-left-sidebar';
$viral_pro_sidebar_right = 'viral-pro-shop-right-sidebar';

if (is_singular('product')) {
    $viral_pro_sidebar_layout = rwmb_meta('sidebar_layout');
    $viral_pro_sidebar_left = rwmb_meta('left_sidebar') ? rwmb_meta('left_sidebar') : $viral_pro_sidebar_left;
    $viral_pro_sidebar_right = rwmb_meta('right_sidebar') ? rwmb_meta('right_sidebar') : $viral_pro_sidebar_right;

    if (!$viral_pro_sidebar_layout || $viral_pro_sidebar_layout == 'default-sidebar') {
        $viral_pro_sidebar_layout = get_theme_mod('viral_pro_shop_layout', 'right-sidebar');
    }
} else {
    $viral_pro_sidebar_layout = get_theme_mod('viral_pro_shop_layout', 'right-sidebar');
}

if ($viral_pro_sidebar_layout == "no-sidebar" || $viral_pro_sidebar_layout == "no-sidebar-narrow") {
    return;
}

if (is_active_sidebar($viral_pro_sidebar_right) && $viral_pro_sidebar_layout == "right-sidebar") {
    ?>
    <div id="secondary" class="widget-area" <?php echo viral_pro_get_schema_attribute('sidebar'); ?>>
        <div class="secondary-wrap">
            <?php dynamic_sidebar($viral_pro_sidebar_right); ?>
        </div>
    </div><!-- #secondary -->
    <?php
}

if (is_active_sidebar($viral_pro_sidebar_left) && $viral_pro_sidebar_layout == "left-sidebar") {
    ?>
    <div id="secondary" class="widget-area" <?php echo viral_pro_get_schema_attribute('sidebar'); ?>>
        <div class="secondary-wrap">
            <?php dynamic_sidebar($viral_pro_sidebar_left); ?>
        </div>
    </div><!-- #secondary -->
    <?php
}
