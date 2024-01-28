<?php
/**
 * Template Name: Blank Template(For Page Builders)
 *
 * @package Viral Pro
 */
get_header();
?>

<div class="ht-main-content ht-container ht-clearfix">

    <?php while (have_posts()) : the_post(); ?>

        <?php the_content(); ?>

    <?php endwhile; // End of the loop.  ?>

</div>

<?php
get_footer();
