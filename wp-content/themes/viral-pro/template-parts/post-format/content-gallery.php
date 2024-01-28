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

$viral_pro_gallery_images = rwmb_meta('post_gallery_image', array('size' => $viral_pro_image_size));

if ($viral_pro_gallery_images) {
    ?>
    <div class="single-entry-gallery">
        <div class="owl-carousel">
            <?php
            foreach ($viral_pro_gallery_images as $image) {
                echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
            }
            ?>
        </div>
    </div>
    <?php
}

