<?php
/**
 * The template for displaying all pages.
 *
 * @package Viral Pro
 */
get_header();

$hide_titlebar = rwmb_meta('hide_titlebar');

if (!$hide_titlebar) {
    $viral_pro_show_title = get_theme_mod('viral_pro_show_title', true);
    $sub_title = rwmb_meta('sub_title');
    $parallax = '';
    ?>
    <header class="ht-main-header">
        <div class="ht-container">
            <?php
            if ($viral_pro_show_title) {
                the_title('<h1 class="ht-main-title">', '</h1>');

                if ($sub_title) {
                    ?>
                    <div class="ht-sub-title"><?php echo wp_kses_post($sub_title); ?></div>
                    <?php
                }
            }

            do_action('viral_pro_breadcrumbs');
            ?>
        </div>
    </header><!-- .entry-header -->
    <?php
}

$container_class = array('ht-main-content', 'ht-clearfix');

$content_width = rwmb_meta('content_width');
if (!($content_width) || $content_width == 'container') {
    $container_class[] = 'ht-container';
}
?>
<div class="<?php echo implode(' ', $container_class); ?>">
    <div class="ht-site-wrapper">
        <div id="primary" class="content-area">

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('template-parts/content', 'page'); ?>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; // End of the loop.  ?>

        </div><!-- #primary -->

        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();
