<?php
/**
 * The template for displaying all pages.
 *
 * @package Viral Pro
 */
get_header();
?>

<div class="ht-main-content ht-container" style="margin-top: 100px">
    <div class="content-area">

        <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part('template-parts/content', 'page'); ?>

        <?php endwhile; // End of the loop.  ?>

    </div><!-- #primary -->
</div>

<?php
get_footer();
