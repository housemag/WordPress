<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Viral Pro
 */
$content_display_featured_image = rwmb_meta('content_display_featured_image');

if (has_post_thumbnail() && $content_display_featured_image) {
    ?>
    <figure class="entry-figure">
        <?php
        $viral_pro_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'viral-pro-840x420');
        ?>
        <img src="<?php echo esc_url($viral_pro_image[0]); ?>" alt="<?php echo esc_attr(get_the_title()) ?>">
    </figure>
<?php }
?>

<div class="entry-content">
    <?php the_content(); ?>
    <?php
    wp_link_pages(array(
        'before' => '<div class="page-links">' . esc_html__('Pages:', 'viral-pro'),
        'after' => '</div>',
    ));
    ?>
</div><!-- .entry-content -->

