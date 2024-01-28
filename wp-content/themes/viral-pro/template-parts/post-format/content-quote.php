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

$viral_pro_post_quote = rwmb_meta('post_quote');
$viral_pro_post_quote_author = rwmb_meta('post_quote_author');
$viral_pro_post_quote_image = rwmb_meta('post_quote_image', array('size' => $viral_pro_image_size));
$viral_pro_class = $viral_pro_post_quote_image ? 'single-entry-quote-image' : '';
?>
<figure class="single-entry-quote <?php echo esc_attr($viral_pro_class); ?>" style="background-image: url('<?php echo esc_url($viral_pro_post_quote_image['url']) ?>')">
    <div class="single-entry-quote-wrap">
        <div class="single-author-quote">
            <?php echo esc_html($viral_pro_post_quote); ?>
        </div>

        <div class="single-author-name">
            <?php echo esc_html($viral_pro_post_quote_author); ?>
        </div>
    </div>
</figure>