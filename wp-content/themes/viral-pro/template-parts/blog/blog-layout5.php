<?php
/**
 * Template part for displaying posts.
 *
 * @package Viral Pro
 */
$viral_pro_archive_content = get_theme_mod('viral_pro_archive_content', 'excerpt');
$viral_pro_blog_date = get_theme_mod('viral_pro_blog_date', true);
$viral_pro_blog_author = get_theme_mod('viral_pro_blog_author', true);
$viral_pro_blog_comment = get_theme_mod('viral_pro_blog_comment', true);
$viral_pro_blog_category = get_theme_mod('viral_pro_blog_category', true);
$viral_pro_blog_tag = get_theme_mod('viral_pro_blog_tag', true);
$viral_pro_archive_excerpt_length = get_theme_mod('viral_pro_archive_excerpt_length', '100');
$viral_pro_archive_readmore = get_theme_mod('viral_pro_archive_readmore', esc_html__('Read More', 'viral-pro'));
$viral_pro_sidebar_layout = 'right-sidebar';
if (is_archive() && !is_home() && !is_search()) {
    $viral_pro_sidebar_layout = get_theme_mod('viral_pro_archive_layout', 'right-sidebar');
} elseif (is_home()) {
    $viral_pro_sidebar_layout = get_theme_mod('viral_pro_home_blog_layout', 'right-sidebar');
} elseif (is_search()) {
    $viral_pro_sidebar_layout = get_theme_mod('viral_pro_search_layout', 'right-sidebar');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('viral-pro-hentry', 'blog-layout5')); ?> <?php echo viral_pro_get_schema_attribute('article'); ?>>
    <div class="ht-post-wrapper">
        <figure class="entry-figure">
            <?php
            if (has_post_thumbnail()) {
                $viral_pro_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'viral-pro-650x500');
                $viral_pro_image_url = $viral_pro_image[0];
            } else {
                $viral_pro_image_url = get_template_directory_uri() . '/images/placeholder-650x500.jpg';
            }
            ?>
            <a href="<?php the_permalink(); ?>">
                <div class="entry-thumb-container">
                    <img src="<?php echo esc_url($viral_pro_image_url); ?>" alt="<?php echo esc_attr(get_the_title()) ?>">
                </div>
            </a>
        </figure>

        <div class="ht-post-content">
            <header class="entry-header">

                <?php the_title(sprintf('<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>

                <?php if ('post' == get_post_type() && ($viral_pro_blog_author || $viral_pro_blog_comment || $viral_pro_blog_date)) { ?>
                    <div class="entry-meta">
                        <?php
                        if ($viral_pro_blog_date) {
                            echo viral_pro_entry_date();
                        }

                        if ($viral_pro_blog_author) {
                            echo viral_pro_entry_author();
                        }

                        if ($viral_pro_blog_comment) {
                            echo viral_pro_comment_link();
                        }
                        ?>
                    </div>
                <?php } ?>

                <?php if ($viral_pro_sidebar_layout == 'no-sidebar') { ?>
                    <div class = "entry-content">
                        <?php
                        echo wp_trim_words(strip_shortcodes(get_the_content()), $viral_pro_archive_excerpt_length);
                        ?>
                    </div><!-- .entry-content -->
                <?php } ?>

                <?php if ('post' == get_post_type() && ($viral_pro_blog_category || $viral_pro_blog_tag)) { ?>
                    <div class="entry-meta">
                        <?php
                        if ($viral_pro_blog_category) {
                            echo viral_pro_entry_category();
                        }

                        if ($viral_pro_blog_tag) {
                            echo viral_pro_entry_tag();
                        }
                        ?>
                    </div>
                <?php } ?>
            </header><!-- .entry-header -->

        </div>
    </div>
</article><!-- #post-## -->