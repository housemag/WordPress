<?php

/**
 * The header for our theme.
 *
 * @package Viral Pro
 */
function viral_pro_preloader() {
    $enable_preloader = get_theme_mod('viral_pro_preloader', 'off');
    $preloader_type = get_theme_mod('viral_pro_preloader_type', 'preloader1');
    $preloader_image = get_theme_mod('viral_pro_preloader_image', 'off');

    if ($enable_preloader == 'on' && !viral_pro_is_amp()) {
        echo '<div id="ht-preloader-wrap">';
        if ($preloader_type != 'custom') {
            get_template_part('inc/customizer/preloader/' . $preloader_type);
        } else {
            echo '<img src="' . esc_url($preloader_image) . '" alt="Preloader"/>';
        }
        echo '</div>';
    }
}

add_action('viral_pro_before_page', 'viral_pro_preloader');

function viral_pro_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    $viral_pro_hide_titlebar = $viral_pro_sidebar_layout = $disable_space_below_header = $disable_space_above_footer = '';

    $customizer_home_settings = of_get_option('customizer_home_settings', '1');
    $viral_pro_enable_frontpage = get_theme_mod('viral_pro_enable_frontpage', true);

    if (is_front_page() && $customizer_home_settings && $viral_pro_enable_frontpage) {
        $classes[] = 'ht-enable-frontpage';
    }

    if (is_singular('page')) {
        $viral_pro_hide_titlebar = rwmb_meta('hide_titlebar');
        $disable_space_below_header = rwmb_meta('disable_space_below_header');
        $disable_space_above_footer = rwmb_meta('disable_space_above_footer');
        $viral_pro_sidebar_layout = rwmb_meta('sidebar_layout');
        if (!$viral_pro_sidebar_layout || $viral_pro_sidebar_layout == 'default-sidebar') {
            $viral_pro_sidebar_layout = get_theme_mod('viral_pro_page_layout', 'right-sidebar');
        }
    } elseif (is_singular('post')) {
        $viral_pro_sidebar_layout = rwmb_meta('sidebar_layout');
        if (!$viral_pro_sidebar_layout || $viral_pro_sidebar_layout == 'default-sidebar') {
            $viral_pro_sidebar_layout = get_theme_mod('viral_pro_post_layout', 'right-sidebar');
        }
    } elseif (viral_pro_is_woocommerce_activated() && is_woocommerce()) {
        if (is_singular()) {
            $viral_pro_hide_titlebar = rwmb_meta('hide_titlebar');
            $viral_pro_sidebar_layout = rwmb_meta('sidebar_layout');
        }

        if (!$viral_pro_sidebar_layout || $viral_pro_sidebar_layout == 'default-sidebar') {
            $viral_pro_sidebar_layout = get_theme_mod('viral_pro_shop_layout', 'right-sidebar');
        }
    } elseif (is_archive() && !is_home() && !is_search()) {
        $viral_pro_sidebar_layout = get_theme_mod('viral_pro_archive_layout', 'right-sidebar');
    } elseif (is_home()) {
        $viral_pro_sidebar_layout = get_theme_mod('viral_pro_home_blog_layout', 'right-sidebar');
    } elseif (is_search()) {
        $viral_pro_sidebar_layout = get_theme_mod('viral_pro_search_layout', 'right-sidebar');
    } else {
        $viral_pro_sidebar_layout = 'right-sidebar';
    }

    $classes[] = 'ht-' . $viral_pro_sidebar_layout;

    $sticky_header = get_theme_mod('viral_pro_sticky_header', 'off');
    $viral_pro_top_header = get_theme_mod('viral_pro_top_header', 'on');
    $website_layout = get_theme_mod('viral_pro_website_layout', 'wide');
    $header_style = get_theme_mod('viral_pro_mh_layout', 'header-style4');
    $sidebar_style = get_theme_mod('viral_pro_sidebar_style', 'sidebar-style1');
    $sticky_sidebar = get_theme_mod('viral_pro_sticky_sidebar', true);
    $image_hover_effect = get_theme_mod('viral_pro_image_hover_effect', 'shine');
    $block_title_style = get_theme_mod('viral_pro_block_title_style', 'style2');

    if (is_singular('post')) {
        $viral_pro_post_layout = rwmb_meta('post_layout');

        if (!$viral_pro_post_layout || $viral_pro_post_layout == 'default') {
            $viral_pro_post_layout = get_theme_mod('viral_pro_single_layout', 'layout1');
        }
        $classes[] = 'ht-single-' . $viral_pro_post_layout;
    }

    $classes[] = 'ht-top-header-' . $viral_pro_top_header;

    if ($sticky_header == 'on') {
        $classes[] = 'ht-sticky-header';
    }

    if ($viral_pro_hide_titlebar) {
        $classes[] = 'ht-hide-titlebar';
    }

    if ($disable_space_below_header) {
        $classes[] = 'ht-no-header-space';
    }

    if ($disable_space_above_footer) {
        $classes[] = 'ht-no-footer-space';
    }

    if ($sticky_sidebar) {
        $classes[] = 'ht-sticky-sidebar';
    }

    $classes[] = 'ht-' . $website_layout;

    $classes[] = 'ht-' . $header_style;

    $classes[] = 'ht-' . $sidebar_style;

    $classes[] = 'ht-thumb-' . $image_hover_effect;

    $classes[] = 'ht-block-title-' . $block_title_style;

    if (is_archive() || is_home() || is_search()) {
        $blog_layout = get_theme_mod('viral_pro_blog_layout', 'layout7');
        $classes[] = 'ht-blog-' . $blog_layout;
    }

    return $classes;
}

add_filter('body_class', 'viral_pro_body_classes');

if (!function_exists('viral_pro_change_wp_page_menu_args')) {

    function viral_pro_change_wp_page_menu_args($args) {
        $args['menu_class'] = 'ht-menu ht-clearfix';
        return $args;
    }

}

add_filter('wp_page_menu_args', 'viral_pro_change_wp_page_menu_args');

function viral_pro_breadcrumbs() {
    $viral_pro_breadcrumb = get_theme_mod('viral_pro_breadcrumb', true);
    if (!$viral_pro_breadcrumb) {
        return;
    }

    $args = array(
        'show_browse' => false,
        'show_on_front' => false,
    );
    breadcrumb_trail($args);
}

add_action('viral_pro_breadcrumbs', 'viral_pro_breadcrumbs');

function viral_pro_convert_to_negative($arg) {
    return('-' . $arg);
}

function viral_pro_remove_category($query) {
    $category = get_theme_mod('viral_pro_blog_cat');
    $category_array = explode(',', $category);
    $category_array = array_map('viral_pro_convert_to_negative', $category_array);
    $category = implode(',', $category_array);
    if ($query->is_home() && $query->is_main_query()) {
        $query->set('cat', $category);
    }
}

add_action('pre_get_posts', 'viral_pro_remove_category');

// Allow HTML in author bio section 
remove_filter('pre_user_description', 'wp_filter_kses');

/* Add Author Links */
if (!function_exists('viral_pro_add_to_author_profile')) {

    function viral_pro_add_to_author_profile($contactmethods) {
        $contactmethods['twitter_profile'] = __('Twitter Profile URL', 'viral-pro');
        $contactmethods['facebook_profile'] = __('Facebook Profile URL', 'viral-pro');
        $contactmethods['linkedin_profile'] = __('Linkedin Profile URL', 'viral-pro');
        $contactmethods['instagram_profile'] = __('Instagram Profile URL', 'viral-pro');
        $contactmethods['rss_url'] = __('RSS URL', 'viral-pro');

        return $contactmethods;
    }

}

add_filter('user_contactmethods', 'viral_pro_add_to_author_profile', 10, 1);

function viral_pro_siteorigin_cpt() {
    if (class_exists('SiteOrigin_Panels')) {
        $post_types = SiteOrigin_Panels_Settings::single()->get('post-types');
        if (!in_array('portfolio', $post_types) && !in_array('ht-megamenu', $post_types)) {
            $new_post_type = array('portfolio', 'ht-megamenu');
            $post_types = array_merge($new_post_type, $post_types);
            SiteOrigin_Panels_Settings::single()->set('post-types', $post_types);
        }
    }
}

//add_action('init', 'viral_pro_siteorigin_cpt', 15);

function viral_pro_add_cpt_support() {
    $cpt_support = get_option('elementor_cpt_support');

    if (!$cpt_support) {
        $cpt_support = ['page', 'post', 'portfolio', 'ht-megamenu'];
        update_option('elementor_cpt_support', $cpt_support);
    } else if (!in_array('portfolio', $cpt_support) || !in_array('ht-megamenu', $cpt_support)) {
        $cpt_support[] = 'portfolio';
        $cpt_support[] = 'ht-megamenu';
        update_option('elementor_cpt_support', $cpt_support);
    }
}

add_action('after_switch_theme', 'viral_pro_add_cpt_support');

function viral_pro_add_top_seperator($section_name) {
    $section_seperator = get_theme_mod("viral_pro_{$section_name}_section_seperator", "no");
    if ($section_seperator == 'top' || $section_seperator == 'top-bottom') {
        $top_seperator = get_theme_mod("viral_pro_{$section_name}_top_seperator", 'big-triangle-center');

        echo '<div class="ht-section-seperator top-section-seperator svg-' . $top_seperator . '-wrap">';
        get_template_part("inc/svg/{$top_seperator}");
        echo '</div>';
    }
}

function viral_pro_add_bottom_seperator($section_name) {
    $section_seperator = get_theme_mod("viral_pro_{$section_name}_section_seperator", "no");
    $bg_type = get_theme_mod("viral_pro_{$section_name}_bg_type");
    $bg_video = get_theme_mod("viral_pro_{$section_name}_bg_video", '6O9Nd1RSZSY');

    if ($section_seperator == 'bottom' || $section_seperator == 'top-bottom') {
        $bottom_seperator = get_theme_mod("viral_pro_{$section_name}_bottom_seperator", 'big-triangle-center');

        echo '<div class="ht-section-seperator bottom-section-seperator svg-' . $bottom_seperator . '-wrap">';
        get_template_part("inc/svg/{$bottom_seperator}");
        echo '</div>';
    }

    if ($bg_type == "video-bg" && !empty($bg_video)) {
        wp_enqueue_script('YTPlayer');
    }
}

function viral_pro_frontpage_add_top_widget($section_name) {
    $widget = get_theme_mod("viral_pro_{$section_name}_top_widget", "none");
    if (is_active_sidebar($widget)) {
        dynamic_sidebar($widget);
    }
}

function viral_pro_frontpage_add_bottom_widget($section_name) {
    $widget = get_theme_mod("viral_pro_{$section_name}_bottom_widget", "none");
    if (is_active_sidebar($widget)) {
        dynamic_sidebar($widget);
    }
}

function viral_pro_maintenance_mode() {
    global $pagenow;
    $viral_pro_maintenance = get_theme_mod('viral_pro_maintenance', 'off');
    $customizer_maintenance_mode = of_get_option('customizer_maintenance_mode', '1');

    if ($customizer_maintenance_mode && $viral_pro_maintenance == 'on' && $pagenow !== 'wp-login.php' && !current_user_can('manage_options') && !is_admin()) {
        if (file_exists(get_template_directory() . '/inc/maintenance.php')) {
            require_once get_template_directory() . '/inc/maintenance.php';
        }
        die();
    }
}

add_action('wp_loaded', 'viral_pro_maintenance_mode');

function viral_pro_maintenance_mode_on_adminbar($wp_admin_bar) {
    $maintenance_mode = get_theme_mod('viral_pro_maintenance', 'off');
    $customizer_maintenance_mode = of_get_option('customizer_maintenance_mode', '1');

    if ($customizer_maintenance_mode && $maintenance_mode == 'on') {
        $args = array(
            'id' => 'viral-pro-maintenance-mode',
            'title' => 'Maintenance Mode Active',
            'href' => admin_url('/customize.php?autofocus[section]=viral_pro_maintenance_section')
        );
        $wp_admin_bar->add_node($args);
    }
}

add_action('admin_bar_menu', 'viral_pro_maintenance_mode_on_adminbar', 999);

function viral_pro_login_logo() {
    $admin_logo = get_theme_mod('viral_pro_admin_logo');
    $width = get_theme_mod('viral_pro_admin_logo_width', 180);
    $height = get_theme_mod('viral_pro_admin_logo_height', 80);
    if ($admin_logo) {
        ?> 
        <style type="text/css"> 
            body.login div#login h1 a {
                background-image: url(<?php echo esc_url($admin_logo); ?>); 
                width: <?php echo absint($width) ?>px;
                height: <?php echo absint($height) ?>px;
                background-size: contain;
            } 
        </style>
        <?php
    }
}

add_action('login_enqueue_scripts', 'viral_pro_login_logo');

function viral_pro_login_link() {
    $admin_logo_link = get_theme_mod('viral_pro_admin_logo_link');
    if ($admin_logo_link) {
        return $admin_logo_link;
    }
}

add_filter('login_headerurl', 'viral_pro_login_link');

function viral_pro_gdpr_notice() {
    $enable_notice = get_theme_mod('viral_pro_enable_gdpr', 'off');
    $customizer_gdpr_settings = of_get_option('customizer_gdpr_settings', '1');
    if ($customizer_gdpr_settings && ($enable_notice == 'on' || is_customize_preview())) {
        $policy_class = array('viral-pro-privacy-policy');
        $viral_pro_gdpr_notice = get_theme_mod('viral_pro_gdpr_notice', esc_html__('Our website use cookies to improve and personalize your experience and to display advertisements(if any). Our website may also include cookies from third parties like Google Adsense, Google Analytics, Youtube. By using the website, you consent to the use of cookies. We have updated our Privacy Policy. Please click on the button to check our Privacy Policy.', 'viral-pro'));
        $viral_pro_gdpr_button_text = get_theme_mod('viral_pro_gdpr_button_text', __('Privacy Policy', 'viral-pro'));
        $viral_pro_gdpr_button_link = get_theme_mod('viral_pro_gdpr_button_link');
        $policy_class[] = get_theme_mod('viral_pro_gdpr_position', 'bottom-full-width');
        $confirm_button = get_theme_mod('viral_pro_gdpr_confirm_button_text', __('Ok, I Agree', 'viral-pro'));
        $viral_pro_gdpr_new_tab = get_theme_mod('viral_pro_gdpr_new_tab', true);
        $hide_in_mobile = get_theme_mod('viral_pro_gdpr_hide_mobile', false);
        $new_tab = $viral_pro_gdpr_new_tab ? 'target="_blank"' : '';
        $policy_class[] = $hide_in_mobile ? 'policy-hide-mobile' : '';
        ?>
        <div class="<?php echo esc_attr(implode(' ', $policy_class)); ?>">
            <div class="ht-container">
                <div class="policy-text">
                    <?php echo wp_kses_post($viral_pro_gdpr_notice) ?>
                </div>

                <div class="policy-buttons">
                    <a id="viral-pro-confirm" href="#"><?php echo esc_html($confirm_button); ?></a>
                    <?php if ($viral_pro_gdpr_button_link) { ?>
                        <a href="<?php echo esc_url($viral_pro_gdpr_button_link); ?>" <?php echo esc_attr($new_tab); ?>><?php echo esc_html($viral_pro_gdpr_button_text); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }
}

add_action('viral_pro_before_page', 'viral_pro_gdpr_notice');

function viral_pro_edit_archive_title($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    }

    return $title;
}

add_filter('get_the_archive_title', 'viral_pro_edit_archive_title');

function viral_pro_remove_more_link_scroll($link) {
    $link = preg_replace('|#more-[0-9]+|', '', $link);
    return $link;
}

add_filter('the_content_more_link', 'viral_pro_remove_more_link_scroll');

function viral_pro_move_comment_field_to_bottom($fields) {
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter('comment_form_fields', 'viral_pro_move_comment_field_to_bottom');

function viral_pro_filter_widget_title_tag($params) {

    $exclude = viral_pro_get_default_widgets();
    $viral_pro_enable_frontpage = get_theme_mod('viral_pro_enable_frontpage', true);

    if (!in_array($params[0]['id'], $exclude) && (is_page_template('templates/home-template.php') || ($viral_pro_enable_frontpage && is_front_page()) )) {
        $params[0]['before_title'] = '<div class="vl-block-header"><h3 class="vl-block-title"><span class="vl-title">';
        $params[0]['after_title'] = '</span></h3></div>';
    }

    $instance = viral_pro_get_widget_instance($params[0]['widget_id'], $params[1]['number']);

    if (!isset($instance['title']) || empty($instance['title'])) {
        $before_widget_string = $params[0]['before_widget'];
        $params[0]['before_widget'] = str_replace('widget ', 'widget widget-no-title ', $before_widget_string);
    }

    return $params;
}

add_filter('dynamic_sidebar_params', 'viral_pro_filter_widget_title_tag');

function viral_pro_get_widget_instance($widget_id, $number) {
    global $wp_registered_widgets;
    $widget_instance = null;
    if (isset($wp_registered_widgets[$widget_id])) {
        $widget = $wp_registered_widgets[$widget_id];
        $widget_instances = get_option($widget['callback'][0]->option_name);
        $widget_instance = $widget_instances[$number];
    }
    return $widget_instance;
}

function viral_pro_display_content_widget($content) {
    if (is_single()) {
        ob_start();
        if (is_active_sidebar('viral-pro-single-post-before-article')) {
            ?>
            <div class="content-widget-area">
                <?php dynamic_sidebar('viral-pro-single-post-before-article'); ?>
            </div>
            <?php
        }

        echo $content;

        if (is_active_sidebar('viral-pro-single-post-after-article')) {
            ?>
            <div class="content-widget-area">
                <?php dynamic_sidebar('viral-pro-single-post-after-article'); ?>
            </div>
            <?php
        }

        $content = ob_get_contents();
        ob_clean();
    }

    return $content;
}

add_filter('the_content', 'viral_pro_display_content_widget');

function viral_pro_demo_config($demos) {
    return include get_template_directory() . '/inc/theme-panel/demo-importer/import_config.php';
}

add_action('hdi_import_files', 'viral_pro_demo_config');

if (!function_exists('viral_pro_add_custom_fonts')) {

    function viral_pro_add_custom_fonts($fonts) {
        if (class_exists('Hash_Custom_Font_Uploader_Public')) {
            if (!empty(Hash_Custom_Font_Uploader_Public::get_all_fonts_list())) {
                $new_fonts = array(
                    'label' => esc_html__('Custom Fonts', 'viral-pro'),
                    'fonts' => Hash_Custom_Font_Uploader_Public::get_all_fonts_list()
                );
                array_unshift($fonts, $new_fonts);
            }
        }
        return $fonts;
    }

}

add_filter('viral_pro_regsiter_fonts', 'viral_pro_add_custom_fonts');

function viral_pro_scrollbar_hide_show() {
    if (viral_pro_is_amp()) {
        ?>
        <amp-animation id="showAnim" layout="nodisplay">
            <script type="application/json">
                {
                "duration": "100ms",
                "fill": "both",
                "iterations": "1",
                "direction": "alternate",
                "animations": [{
                "selector": "#ht-back-top",
                "keyframes": [{
                "opacity": "1",
                "visibility": "visible"
                }]
                }]
                }
            </script>
        </amp-animation>
        <amp-animation id="hideAnim" layout="nodisplay">
            <script type="application/json">
                {
                "duration": "100ms",
                "fill": "both",
                "iterations": "1",
                "direction": "alternate",
                "animations": [{
                "selector": "#ht-back-top",
                "keyframes": [{
                "opacity": "0",
                "visibility": "hidden"
                }]
                }]
                }
            </script>
        </amp-animation>
        <amp-position-observer on="enter:hideAnim.start; exit:showAnim.start" layout="nodisplay"></amp-position-observer>
        <?php
    }
}

add_action('viral_pro_header_content', 'viral_pro_scrollbar_hide_show');
