<?php

/**
 * Front Page
 *
 * @package Viral Pro
 */
get_header();

$customizer_home_settings = of_get_option('customizer_home_settings', '1');
$viral_pro_enable_frontpage = get_theme_mod('viral_pro_enable_frontpage', false);

if ($viral_pro_enable_frontpage && $customizer_home_settings) {
    $sections = viral_pro_frontpage_sections();

    foreach ($sections as $section) {
        $section();
    }
} else {
    if ('posts' == get_option('show_on_front')) {
        include( get_home_template() );
    } else {
        include( get_page_template() );
    }
}
get_footer();
