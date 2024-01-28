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
$current_post_count = $wp_query->current_post;
$total_post_count = $wp_query->post_count;
$imagesize = ($current_post_count == 0) ? 'viral-pro-800x500' : 'viral-pro-500x500';
$default_image = ($current_post_count == 0) ? get_template_directory_uri() . '/images/placeholder-800x500.jpg' : get_template_directory_uri() . '/images/placeholder-500x500.jpg';
$post_class = ($current_post_count == 0) ? 'blog-layout6 blog-layout6-first' : 'blog-layout6';
if ($current_post_count == 1) {
    echo '<div class="viral-pro-hentry-wrap viral-pro-blog-layout6-wrap">';
}
?>

<article id="post-<?php echo $current_post_count; ?>" <?php post_class(array('viral-pro-hentry', $post_class)); ?> <?php echo viral_pro_get_schema_attribute('article'); ?>>
    <div class="ht-article-wrap">
        <figure class="entry-figure">
            <?php
            if (has_post_thumbnail()) {
                $viral_pro_image = wp_get_attachment_image_src(get_post_thumbnail_id(), $imagesize);
                $viral_pro_image_url = $viral_pro_image[0];
            } else {
                $viral_pro_image_url = $default_image;
            }
            ?>
            <a href="<?php the_permalink(); ?>">
                <div class="entry-thumb-container">
                    <img src="<?php echo esc_url($viral_pro_image_url); ?>" alt="<?php echo esc_attr(get_the_title()) ?>">
                </div>
            </a>
        </figure>

        <div class="ht-post-content">
            <?php
            if ('post' == get_post_type() && $viral_pro_blog_date) {
                ?>
                <div class="entry-meta">
                    <?php echo viral_pro_entry_date(); ?>
                </div>
                <?php
            }
            ?>

            <header class="entry-header">
                <?php the_title(sprintf('<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>
            </header><!-- .entry-header -->

            <?php if ('post' == get_post_type() && ($viral_pro_blog_author || $viral_pro_blog_comment)) : ?>
                <div class="entry-meta">
                    <?php
                    if ($viral_pro_blog_author) {
                        viral_pro_entry_author();
                    }

                    if ($viral_pro_blog_comment) {
                        echo viral_pro_comment_link();
                    }
                    ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>

            <div class="entry-content">
                <?php
                echo wp_trim_words(strip_shortcodes(get_the_content()), 30);
                ?>
            </div><!-- .entry-content -->

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
        </div>
    </div>
</article><!-- #post-## -->

<?php
if ($total_post_count != 1 && $total_post_count == ($current_post_count + 1)) {
    echo '</div>';
}    