<?php
$viral_pro_sidebar_layout = rwmb_meta('sidebar_layout');
$viral_pro_post_layout = rwmb_meta('post_layout');
$viral_pro_image_size = 'viral-pro-800x500';

if (!$viral_pro_sidebar_layout || $viral_pro_sidebar_layout == 'default-sidebar') {
    $viral_pro_sidebar_layout = get_theme_mod('viral_pro_post_layout', 'right-sidebar');
}

if (!$viral_pro_post_layout || $viral_pro_post_layout == 'default') {
    $viral_pro_post_layout = get_theme_mod('viral_pro_single_layout', 'layout1');
}

if ($viral_pro_sidebar_layout == 'no-sidebar' || $viral_pro_sidebar_layout == 'no-sidebar-narrow' || $viral_pro_post_layout == 'layout7') {
    $viral_pro_image_size = 'viral-pro-1300x540';
}

if (has_post_thumbnail() && ($viral_pro_post_layout !== 'layout3' && $viral_pro_post_layout !== 'layout4' && $viral_pro_post_layout !== 'layout5' && $viral_pro_post_layout !== 'layout6')) {
    ?>
    <figure class="single-entry-link">
        <?php echo get_the_post_thumbnail(get_the_ID(), $viral_pro_image_size); ?>
    </figure>
    <?php
}