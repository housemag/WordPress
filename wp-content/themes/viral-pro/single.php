<?php

/**
 * The template for displaying all single posts.
 *
 * @package Viral Pro
 */
get_header();
viral_pro_set_post_view();

$viral_pro_single_layout = get_theme_mod('viral_pro_single_layout', 'layout1');
$post_layout = rwmb_meta('post_layout');

if ($post_layout && $post_layout != 'default') {
    $viral_pro_single_layout = rwmb_meta('post_layout');
}

get_template_part('template-parts/single/single', $viral_pro_single_layout);

get_footer();
