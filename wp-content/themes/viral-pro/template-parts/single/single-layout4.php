<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo viral_pro_get_schema_attribute('article'); ?>>

    <?php while (have_posts()) : the_post(); ?>

        <?php $viral_pro_featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>

        <div class="entry-header" style="background-image: url('<?php echo esc_url($viral_pro_featured_image[0]); ?>') ">
            <div class="entry-header-wrapper">
                <div class="ht-container">
                    <?php
                    viral_pro_single_category();

                    the_title('<h1 class="entry-title">', '</h1>');

                    $sub_title = rwmb_meta('sub_title');
                    if ($sub_title) {
                        ?>
                        <div class="entry-summary"><?php echo wp_kses_post($sub_title); ?></div>
                        <?php
                    }

                    viral_pro_single_post_meta();
                    ?>
                </div>
            </div>
        </div>

        <div class="ht-main-content ht-container ht-clearfix">

            <?php do_action('viral_pro_breadcrumbs'); ?>

            <div class="ht-site-wrapper">

                <div id="primary" class="content-area">


                    <div class="entry-wrapper">  

                        <?php viral_pro_single_sticky_social_share(); ?>

                        <?php get_template_part('template-parts/post-format/content', get_post_format()); ?>

                        <div class="entry-content">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'viral-pro'),
                                'after' => '</div>',
                            ));
                            ?>
                        </div><!-- .entry-content -->

                        <?php
                        viral_pro_single_tag();
                        viral_pro_single_social_share();
                        ?>

                    </div>

                    <?php
                    viral_pro_single_author_box();
                    viral_pro_single_pagination();
                    viral_pro_single_comment();
                    viral_pro_single_related_posts();
                    ?>
                </div><!-- #primary -->

                <?php get_sidebar(); ?>

            </div>

        </div>

    <?php endwhile; // End of the loop.   ?>

</article><!-- #post-## -->