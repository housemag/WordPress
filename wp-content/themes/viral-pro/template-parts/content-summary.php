<?php

/**
 * Template part for displaying posts.
 *
 * @package Viral Pro
 */
$viral_pro_blog_layout = get_theme_mod('viral_pro_blog_layout', 'layout7');

//Added Code for demo
$defaults = array('layout1', 'layout2', 'layout3', 'layout4', 'layout5', 'layout6', 'layout7');
if (isset($_GET['layout']) && in_array($_GET['layout'], $defaults)) {
    $viral_pro_blog_layout = $_GET['layout'];
    if ($viral_pro_blog_layout == 'layout3') {
        ?>
        <style>.site-main-loop{margin: 0 -15px;display: flex;flex-wrap: wrap;}</style>
        <?php

    }
}
//Added Code for demo

get_template_part('template-parts/blog/blog', $viral_pro_blog_layout);

