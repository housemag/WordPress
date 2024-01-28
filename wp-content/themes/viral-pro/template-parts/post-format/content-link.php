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

$viral_pro_post_link = rwmb_meta('post_link');
$viral_pro_post_link_title = rwmb_meta('post_link_title');
$viral_pro_post_link_image = rwmb_meta('post_link_image', array('size' => $viral_pro_image_size));
$viral_pro_class = $viral_pro_post_link_image ? 'single-entry-link-image' : '';
?>
<figure class="single-entry-link <?php echo esc_attr($viral_pro_class); ?>">
    <?php
    if ($viral_pro_post_link_image) {
        echo '<img src="' . $viral_pro_post_link_image['url'] . '" alt="' . $viral_pro_post_link_image['alt'] . '">';
    }

    if ($viral_pro_post_link) {
        echo '<a href="' . esc_url($viral_pro_post_link) . '" title="' . esc_attr($viral_pro_post_link_title) . '" target="_blank">' . esc_html($viral_pro_post_link_title) . '<i class="mdi mdi-open-in-new"></i></a>';
    }
    ?>
</figure>