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
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('viral-pro-hentry', 'blog-layout3')); ?> <?php echo viral_pro_get_schema_attribute('article'); ?>>

    <div class="ht-post-wrapper">

        <figure class="entry-figure">
            <?php
            if (has_post_thumbnail()) {
                $viral_pro_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'viral-pro-500x600');
                $viral_pro_image_url = $viral_pro_image[0];
            } else {
                $viral_pro_image_url = get_template_directory_uri() . '/images/placeholder-500x600.jpg';
            }
            ?>
            <a href="<?php the_permalink(); ?>">
                <div class="entry-thumb-container">
                    <img src="<?php echo esc_url($viral_pro_image_url); ?>" alt="<?php echo esc_attr(get_the_title()) ?>">
                </div>
            </a>
            <header class="entry-header">
                <?php if ('post' == get_post_type() && $viral_pro_blog_date) : ?>
                    <div class="entry-meta">
                        <?php
                        if ($viral_pro_blog_date) {
                            viral_pro_entry_date();
                        }
                        ?>
                    </div><!-- .entry-meta -->
                <?php endif; ?>   

                <?php the_title(sprintf('<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>

                <div class="entry-readmore">
                    <a href="<?php the_permalink(); ?>"><?php echo $viral_pro_archive_readmore; ?></a>
                </div>
            </header><!-- .entry-header -->
        </figure>
    </div>
</article><!-- #post-## -->