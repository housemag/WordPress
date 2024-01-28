<?php

/**
 * Viral Pro Theme Customizer
 *
 * @package Viral Pro
 */
//LAYOUT OPTIONS
$wp_customize->add_section('viral_pro_layout_options_section', array(
    'title' => esc_html__('Sidebar Settings', 'viral-pro'),
    'priority' => 16
));

$wp_customize->add_setting('viral_pro_sidebar_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_sidebar_nav', array(
    'section' => 'viral_pro_layout_options_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Layouts', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_sticky_sidebar',
                'viral_pro_page_layout',
                'viral_pro_post_layout',
                'viral_pro_archive_layout',
                'viral_pro_home_blog_layout',
                'viral_pro_search_layout',
                'viral_pro_shop_layout'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Styles', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_sticky_sidebar',
                'viral_pro_sidebar_style',
                'viral_pro_content_widget_title_color'
            ),
        ),
        array(
            'name' => esc_html__('Typography', 'viral-pro'),
            'icon' => 'dashicons dashicons-edit',
            'fields' => array(
                'sidebar_title_typography'
            ),
        )
    ),
)));

$wp_customize->add_setting('viral_pro_sticky_sidebar', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_sticky_sidebar', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Sticky Sidebar', 'viral-pro'),
    'description' => esc_html__('The sidebar will stick at the top on scrolling', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_page_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'right-sidebar'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_page_layout', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Page Layout', 'viral-pro'),
    'class' => 'ht--one-forth-width',
    'description' => esc_html__('Applies to all the General Pages and Portfolio Pages.', 'viral-pro'),
    'options' => array(
        'right-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/right-sidebar.png',
        'left-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/left-sidebar.png',
        'no-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar.png',
        'no-sidebar-narrow' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar-narrow.png'
    )
)));

$wp_customize->add_setting('viral_pro_post_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'right-sidebar'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_post_layout', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Post Layout', 'viral-pro'),
    'class' => 'ht--one-forth-width',
    'description' => esc_html__('Applies to all the Posts.', 'viral-pro'),
    'options' => array(
        'right-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/right-sidebar.png',
        'left-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/left-sidebar.png',
        'no-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar.png',
        'no-sidebar-narrow' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar-narrow.png'
    )
)));

$wp_customize->add_setting('viral_pro_archive_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'right-sidebar'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_archive_layout', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Archive Page Layout', 'viral-pro'),
    'class' => 'ht--one-forth-width',
    'description' => esc_html__('Applies to all Archive Pages.', 'viral-pro'),
    'options' => array(
        'right-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/right-sidebar.png',
        'left-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/left-sidebar.png',
        'no-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar.png',
        'no-sidebar-narrow' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar-narrow.png'
    )
)));

$wp_customize->add_setting('viral_pro_home_blog_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'right-sidebar'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_home_blog_layout', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Blog Page Layout', 'viral-pro'),
    'class' => 'ht--one-forth-width',
    'description' => esc_html__('Applies to Blog Page.', 'viral-pro'),
    'options' => array(
        'right-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/right-sidebar.png',
        'left-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/left-sidebar.png',
        'no-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar.png',
        'no-sidebar-narrow' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar-narrow.png'
    )
)));

$wp_customize->add_setting('viral_pro_search_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'right-sidebar'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_search_layout', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Search Page Layout', 'viral-pro'),
    'class' => 'ht--one-forth-width',
    'description' => esc_html__('Applies to Search Page.', 'viral-pro'),
    'options' => array(
        'right-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/right-sidebar.png',
        'left-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/left-sidebar.png',
        'no-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar.png',
        'no-sidebar-narrow' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar-narrow.png'
    )
)));

$wp_customize->add_setting('viral_pro_shop_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'right-sidebar'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_shop_layout', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Shop Page Layout(WooCommerce)', 'viral-pro'),
    'class' => 'ht--one-forth-width',
    'description' => esc_html__('Applies to Shop Page, Product Category, Product Tag and all Single Products Pages.', 'viral-pro'),
    'options' => array(
        'right-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/right-sidebar.png',
        'left-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/left-sidebar.png',
        'no-sidebar' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar.png',
        'no-sidebar-narrow' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-layouts/no-sidebar-narrow.png'
    ),
        //'active_callback' => 'viral_pro_is_woocommerce_activated'
)));

$wp_customize->add_setting('viral_pro_sidebar_style', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'sidebar-style4',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_sidebar_style', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Sidebar Style', 'viral-pro'),
    'options' => array(
        'sidebar-style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-styles/sidebar-style1.png',
        'sidebar-style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-styles/sidebar-style2.png',
        'sidebar-style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-styles/sidebar-style3.png',
        'sidebar-style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-styles/sidebar-style4.png',
        'sidebar-style5' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-styles/sidebar-style5.png',
        'sidebar-style6' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-styles/sidebar-style6.png',
        'sidebar-style7' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-styles/sidebar-style7.png',
        'sidebar-style8' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/sidebar-styles/sidebar-style8.png'
    )
)));

$wp_customize->add_setting('viral_pro_content_widget_title_color', array(
    'default' => '#000000',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_content_widget_title_color', array(
    'section' => 'viral_pro_layout_options_section',
    'label' => esc_html__('Sidebar Widget Title Color', 'viral-pro')
)));

// Add the Widget typography
$wp_customize->add_setting('sidebar_title_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('sidebar_title_font_style', array(
    'default' => '700',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('sidebar_title_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('sidebar_title_text_transform', array(
    'default' => 'uppercase',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('sidebar_title_font_size', array(
    'default' => '18',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('sidebar_title_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('sidebar_title_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'sidebar_title_typography', array(
    'label' => esc_html__('Widget Title Typography', 'viral-pro'),
    'description' => __('Select how you want your widget title to appear. This settings applies for sidebar and footer widget titles', 'viral-pro'),
    'section' => 'viral_pro_layout_options_section',
    'settings' => array(
        'family' => 'sidebar_title_font_family',
        'style' => 'sidebar_title_font_style',
        'text_decoration' => 'sidebar_title_text_decoration',
        'text_transform' => 'sidebar_title_text_transform',
        'size' => 'sidebar_title_font_size',
        'line_height' => 'sidebar_title_line_height',
        'letter_spacing' => 'sidebar_title_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 12,
        'max' => 40,
        'step' => 1
    )
)));
