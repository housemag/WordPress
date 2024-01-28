<?php
/**
 * Template Name: Home Page
 *
 * @package Viral Pro
 */
$customizer_home_settings = of_get_option('customizer_home_settings', '1');

get_header();
if ($customizer_home_settings) {
    $sections = viral_pro_frontpage_sections();

    foreach ($sections as $section) {
        $section();
    }
} else {
    $hide_titlebar = rwmb_meta('hide_titlebar');

    if (!$hide_titlebar) {
        $viral_pro_show_title = get_theme_mod('viral_pro_show_title', true);
        $sub_title = rwmb_meta('sub_title');
        $titlebar_background = rwmb_meta('titlebar_background');
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
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <?php while (have_posts()) : the_post(); ?>

                    <?php get_template_part('template-parts/content', 'page'); ?>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; // End of the loop.  ?>

            </main><!-- #main -->
        </div><!-- #primary -->

        <?php get_sidebar(); ?>
    </div>
    <?php
}
get_footer();
