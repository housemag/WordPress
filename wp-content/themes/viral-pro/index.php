<?php
/**
 * The main template file.
 *
 * @package Viral Pro
 */
get_header();

if (is_home()) {
    $viral_pro_show_title = get_theme_mod('viral_pro_show_title', true);
    if ('page' == get_option('show_on_front')) {
        $blog_page_id = get_option('page_for_posts');
        $title = get_the_title($blog_page_id);
    }
    ?>
    <header class="ht-main-header">
        <div class="ht-container">
            <?php
            if ($viral_pro_show_title) {
                ?>
                <h1 class="ht-main-title"><?php echo esc_html($title); ?></h1>
                <?php
            }

            if (is_home() && 'page' == get_option('show_on_front')) {
                do_action('viral_pro_breadcrumbs');
            }
            ?>
        </div>
    </header><!-- .entry-header -->
    <?php
}

$customizer_home_settings = of_get_option('customizer_home_settings', '1');
$viral_pro_display_frontpage_sections = get_theme_mod('viral_pro_display_frontpage_sections', 'off');

if (is_front_page() && $customizer_home_settings && $viral_pro_display_frontpage_sections == 'on') {
    $sections = viral_pro_frontpage_sections();

    foreach ($sections as $section) {
        $section();
    }
}
?>
<div class="ht-main-content ht-clearfix ht-container">
    <div class="ht-site-wrapper">
        <div id="primary" class="content-area">

            <?php if (have_posts()) : ?>

                <div class="site-main-loop">
                    <?php while (have_posts()) : the_post(); ?>

                        <?php
                        get_template_part('template-parts/content', 'summary');
                        ?>

                    <?php endwhile; ?>
                </div>
                <?php
                the_posts_pagination(
                        array(
                            'prev_text' => __('Prev', 'viral-pro'),
                            'next_text' => __('Next', 'viral-pro'),
                        )
                );
                ?>

            <?php else : ?>

                <?php get_template_part('template-parts/content', 'none'); ?>

            <?php endif; ?>

        </div><!-- #primary -->

        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();
