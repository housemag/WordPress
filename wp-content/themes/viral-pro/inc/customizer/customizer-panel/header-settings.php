<?php

/**
 * Viral Pro Theme Customizer
 *
 * @package Viral Pro
 */
/* HEADER PANEL */
$wp_customize->remove_control('header_text');
$wp_customize->add_panel('viral_pro_header_settings_panel', array(
    'title' => esc_html__('Header Settings', 'viral-pro'),
    'priority' => 15
));

$wp_customize->add_setting('viral_pro_title_tagline_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_title_tagline_nav', array(
    'section' => 'title_tagline',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'custom_logo',
                'blogname',
                'blogdescription',
                'viral_pro_hide_title',
                'viral_pro_hide_tagline',
                'viral_pro_tagline_position',
                'site_icon'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_logo_height',
                'viral_pro_logo_padding',
            ),
        ),
        array(
            'name' => esc_html__('Typography', 'viral-pro'),
            'icon' => 'dashicons dashicons-edit',
            'fields' => array(
                'title_typography',
                'tagline_typography',
            ),
        )
    ),
)));

$wp_customize->get_section('title_tagline')->panel = 'viral_pro_header_settings_panel';
$wp_customize->get_section('title_tagline')->title = esc_html__('Logo & Favicon', 'viral-pro');

$wp_customize->add_setting('viral_pro_hide_title', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => false,
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_hide_title', array(
    'type' => 'checkbox',
    'section' => 'title_tagline',
    'label' => esc_html__('Hide Site Title', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_hide_tagline', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => false,
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_hide_tagline', array(
    'type' => 'checkbox',
    'section' => 'title_tagline',
    'label' => esc_html__('Hide Site Tagline', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_tagline_position', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'ht-tagline-inline-logo',
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_tagline_position', array(
    'section' => 'title_tagline',
    'type' => 'select',
    'label' => esc_html__('Title/Tagline Position', 'viral-pro'),
    'choices' => array(
        'ht-tagline-inline-logo' => esc_html__('Inline With Logo', 'viral-pro'),
        'ht-tagline-below-logo' => esc_html__('Below Logo', 'viral-pro')
    )
));

$wp_customize->selective_refresh->add_partial('viral_pro_hide_title', array(
    'selector' => '#ht-site-branding',
    'render_callback' => 'viral_pro_header_logo'
));

$wp_customize->selective_refresh->add_partial('viral_pro_hide_tagline', array(
    'selector' => '#ht-site-branding',
    'render_callback' => 'viral_pro_header_logo'
));


$wp_customize->add_setting('viral_pro_logo_height', array(
    'sanitize_callback' => 'absint',
    'default' => 60,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_logo_height', array(
    'section' => 'title_tagline',
    'label' => esc_html__('Logo Height(px)', 'viral-pro'),
    'description' => esc_html__('The logo height will not increase beyond the header height. Increase the header height first. Logo will appear blur if the image size is small.', 'viral-pro'),
    'input_attrs' => array(
        'min' => 40,
        'max' => 200,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_logo_padding', array(
    'sanitize_callback' => 'absint',
    'default' => 15,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_logo_padding', array(
    'section' => 'title_tagline',
    'label' => esc_html__('Logo Top & Bottom Spacing(px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('title_font_family', array(
    'default' => 'Default',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('title_font_style', array(
    'default' => '700',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('title_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('title_text_transform', array(
    'default' => 'uppercase',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('title_font_size', array(
    'default' => '32',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('title_line_height', array(
    'default' => '1.2',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('title_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('title_color', array(
    'default' => '#333333',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'title_typography', array(
    'label' => esc_html__('Title Typography', 'viral-pro'),
    'section' => 'title_tagline',
    'settings' => array(
        'family' => 'title_font_family',
        'style' => 'title_font_style',
        'text_decoration' => 'title_text_decoration',
        'text_transform' => 'title_text_transform',
        'size' => 'title_font_size',
        'line_height' => 'title_line_height',
        'letter_spacing' => 'title_letter_spacing',
        'color' => 'title_color'
    ),
    'input_attrs' => array(
        'min' => 10,
        'max' => 90,
        'step' => 1
    )
)));

$wp_customize->add_setting('tagline_font_family', array(
    'default' => 'Default',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('tagline_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('tagline_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('tagline_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('tagline_font_size', array(
    'default' => '16',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('tagline_line_height', array(
    'default' => '1.2',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('tagline_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('tagline_color', array(
    'default' => '#333333',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'tagline_typography', array(
    'label' => esc_html__('Title Typography', 'viral-pro'),
    'section' => 'title_tagline',
    'settings' => array(
        'family' => 'tagline_font_family',
        'style' => 'tagline_font_style',
        'text_decoration' => 'tagline_text_decoration',
        'text_transform' => 'tagline_text_transform',
        'size' => 'tagline_font_size',
        'line_height' => 'tagline_line_height',
        'letter_spacing' => 'tagline_letter_spacing',
        'color' => 'tagline_color'
    ),
    'input_attrs' => array(
        'min' => 10,
        'max' => 40,
        'step' => 1
    )
)));

//TOP HEADER
$wp_customize->add_section('viral_pro_top_header_options', array(
    'title' => esc_html__('Top Header', 'viral-pro'),
    'panel' => 'viral_pro_header_settings_panel'
));

$wp_customize->add_setting('viral_pro_top_header_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_top_header_nav', array(
    'section' => 'viral_pro_top_header_options',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_top_header',
                'viral_pro_th_disable_mobile',
                'viral_pro_top_header_options_heading',
                'viral_pro_th_left_display',
                'viral_pro_th_right_display',
                'viral_pro_top_header_seperator',
                'viral_pro_social_link',
                'viral_pro_th_menu',
                'viral_pro_th_widget',
                'viral_pro_th_text',
                'viral_pro_th_ticker_title',
                'viral_pro_th_ticker_category'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_th_height',
                'viral_pro_th_bg_color',
                'viral_pro_th_bottom_border_color',
                'viral_pro_th_text_color',
                'viral_pro_th_anchor_color'
            ),
        )
    ),
)));

//TOP HEADER SETTINGS
$wp_customize->add_setting('viral_pro_top_header', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'on'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_top_header', array(
    'section' => 'viral_pro_top_header_options',
    'label' => esc_html__('Enable Top Header', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_th_height', array(
    'sanitize_callback' => 'absint',
    'default' => 45,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_th_height', array(
    'section' => 'viral_pro_top_header_options',
    'label' => esc_html__('Top Header Height', 'viral-pro'),
    'input_attrs' => array(
        'min' => 5,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_th_bg_color', array(
    'default' => '#0078af',
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Alpha_Color_Control($wp_customize, 'viral_pro_th_bg_color', array(
    'label' => esc_html__('Top Header Background', 'viral-pro'),
    'section' => 'viral_pro_top_header_options'
)));

$wp_customize->add_setting('viral_pro_th_bottom_border_color', array(
    'default' => '',
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Alpha_Color_Control($wp_customize, 'viral_pro_th_bottom_border_color', array(
    'label' => esc_html__('Top Header Bottom Border Color', 'viral-pro'),
    'description' => esc_html__('Leave Empty to Hide Border', 'viral-pro'),
    'section' => 'viral_pro_top_header_options'
)));

$wp_customize->add_setting('viral_pro_th_text_color', array(
    'default' => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_th_text_color', array(
    'section' => 'viral_pro_top_header_options',
    'label' => esc_html__('Text Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_th_anchor_color', array(
    'default' => '#EEEEEE',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_th_anchor_color', array(
    'section' => 'viral_pro_top_header_options',
    'label' => esc_html__('Anchor(Link) Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_th_disable_mobile', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => false,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_th_disable_mobile', array(
    'section' => 'viral_pro_top_header_options',
    'label' => esc_html__('Disable in Mobile', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_top_header_options_heading', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, 'viral_pro_top_header_options_heading', array(
    'section' => 'viral_pro_top_header_options',
    'label' => esc_html__('Top Header Content', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_th_left_display', array(
    'default' => 'date',
    'sanitize_callback' => 'viral_pro_sanitize_choices',
));

$wp_customize->add_control('viral_pro_th_left_display', array(
    'section' => 'viral_pro_top_header_options',
    'type' => 'select',
    'label' => esc_html__('Display in Left Header', 'viral-pro'),
    'choices' => array(
        'social' => esc_html__('Social Icons', 'viral-pro'),
        'menu' => esc_html__('Menu', 'viral-pro'),
        'widget' => esc_html__('Widget', 'viral-pro'),
        'text' => esc_html__('HTML Text', 'viral-pro'),
        'date' => esc_html__('Date & Time', 'viral-pro'),
        'ticker' => esc_html__('News Ticker', 'viral-pro'),
        'none' => esc_html__('None', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_th_right_display', array(
    'default' => 'social',
    'sanitize_callback' => 'viral_pro_sanitize_choices',
));

$wp_customize->add_control('viral_pro_th_right_display', array(
    'section' => 'viral_pro_top_header_options',
    'type' => 'select',
    'label' => esc_html__('Display in Right Header', 'viral-pro'),
    'choices' => array(
        'social' => esc_html__('Social Icons', 'viral-pro'),
        'menu' => esc_html__('Menu', 'viral-pro'),
        'widget' => esc_html__('Widget', 'viral-pro'),
        'text' => esc_html__('HTML Text', 'viral-pro'),
        'date' => esc_html__('Date & Time', 'viral-pro'),
        'none' => esc_html__('None', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_top_header_seperator', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_top_header_seperator', array(
    'section' => 'viral_pro_top_header_options'
)));

$wp_customize->add_setting('viral_pro_social_link', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Text_Info_Control($wp_customize, 'viral_pro_social_link', array(
    'label' => esc_html__('Social Icons', 'viral-pro'),
    'section' => 'viral_pro_top_header_options',
    'description' => sprintf(esc_html__('Add your %s here', 'viral-pro'), '<a href="#" target="_blank">Social Icons</a>')
)));

$wp_customize->add_setting('viral_pro_th_menu', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
));

$wp_customize->add_control('viral_pro_th_menu', array(
    'section' => 'viral_pro_top_header_options',
    'type' => 'select',
    'label' => esc_html__('Select Menu', 'viral-pro'),
    'choices' => viral_pro_menu_choice()
));

$wp_customize->add_setting('viral_pro_th_widget', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
));

$wp_customize->add_control('viral_pro_th_widget', array(
    'section' => 'viral_pro_top_header_options',
    'type' => 'select',
    'label' => esc_html__('Select Widget', 'viral-pro'),
    'choices' => viral_pro_widget_list()
));

$wp_customize->add_setting('viral_pro_th_text', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'California, TX 70240 | (1800) 456 7890',
));

$wp_customize->add_control(new Viral_Pro_Editor_Control($wp_customize, 'viral_pro_th_text', array(
    'section' => 'viral_pro_top_header_options',
    'label' => esc_html__('Html Text', 'viral-pro'),
    'include_admin_print_footer' => true
)));

$wp_customize->add_setting('viral_pro_th_ticker_title', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => esc_html__('Breaking News', 'viral-pro'),
));

$wp_customize->add_control('viral_pro_th_ticker_title', array(
    'section' => 'viral_pro_top_header_options',
    'type' => 'text',
    'label' => esc_html__('Ticker Title', 'viral-pro'),
));

$wp_customize->add_setting('viral_pro_th_ticker_category', array(
    'default' => '-1',
    'sanitize_callback' => 'viral_pro_sanitize_integer'
));

$wp_customize->add_control('viral_pro_th_ticker_category', array(
    'section' => 'viral_pro_top_header_options',
    'type' => 'select',
    'label' => __('Ticker Category', 'viral-pro'),
    'choices' => viral_pro_cat(true)
));


//MAIN HEADER
$wp_customize->add_section('viral_pro_main_header_options', array(
    'title' => esc_html__('Main Header', 'viral-pro'),
    'panel' => 'viral_pro_header_settings_panel'
));

$wp_customize->add_setting('viral_pro_main_header_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_main_header_nav', array(
    'section' => 'viral_pro_main_header_options',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_sticky_header',
                'viral_pro_mh_layout',
                'viral_pro_mh_show_search',
                'viral_pro_mh_show_cart',
                'viral_pro_mh_show_social',
                'viral_pro_mh_show_offcanvas',
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_mh_header_bg',
                'viral_pro_mh_bg_color',
                'viral_pro_mh_bg_color_mobile',
                'viral_pro_mh_height',
                'viral_pro_mh_border',
                'viral_pro_mh_button_color',
                'viral_pro_mh_border_sep_start',
                'viral_pro_mh_border_color',
                'viral_pro_toggle_button_color',
            ),
        )
    ),
)));

//MAIN HEADER SETTINGS
$wp_customize->add_setting('viral_pro_sticky_header', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_sticky_header', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Enable Sticky Header', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    )
)));

//HEADER LAYOUTS
$wp_customize->add_setting('viral_pro_mh_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'header-style4'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_mh_layout', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Header Layout', 'viral-pro'),
    'class' => 'ht--full-width',
    'options' => array(
        'header-style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/headers/header-1.png',
        'header-style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/headers/header-2.png',
        'header-style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/headers/header-3.png',
        'header-style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/headers/header-4.png',
        'header-style5' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/headers/header-5.png',
        'header-style6' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/headers/header-6.png',
        'header-style7' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/headers/header-7.png'
    )
)));

$wp_customize->add_setting('viral_pro_mh_height', array(
    'sanitize_callback' => 'absint',
    'default' => 65,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_mh_height', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Header Height', 'viral-pro'),
    'input_attrs' => array(
        'min' => 50,
        'max' => 200,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_mh_show_search', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_mh_show_search', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Show Search Button', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mh_show_cart', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => false
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_mh_show_cart', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Show Cart Button', 'viral-pro'),
    'active_callback' => 'viral_pro_is_woocommerce_activated'
)));

$wp_customize->add_setting('viral_pro_mh_show_social', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => false,
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_mh_show_social', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Show Social Icons', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mh_show_offcanvas', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_mh_show_offcanvas', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Show Offcanvas Menu', 'viral-pro')
)));


$wp_customize->add_setting('viral_pro_mh_button_color', array(
    'default' => '#000000',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_mh_button_color', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Buttons Color(Search, Social Icons, Offcanvas Menu)', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mh_bg_color', array(
    'default' => '#0078af',
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Alpha_Color_Control($wp_customize, 'viral_pro_mh_bg_color', array(
    'label' => esc_html__('Header Background Color', 'viral-pro'),
    'section' => 'viral_pro_main_header_options'
)));

$wp_customize->add_setting('viral_pro_mh_bg_color_mobile', array(
    'default' => '#0078af',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_mh_bg_color_mobile', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Header Bar Background Color(Mobile)', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_toggle_button_color', array(
    'default' => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_toggle_button_color', array(
    'section' => 'viral_pro_main_header_options',
    'label' => esc_html__('Mobile Menu Button Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mh_border_sep_start', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_mh_border_sep_start', array(
    'section' => 'viral_pro_main_header_options'
)));

$wp_customize->add_setting('viral_pro_mh_border', array(
    'default' => 'ht-no-border',
    'sanitize_callback' => 'viral_pro_sanitize_choices',
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_mh_border', array(
    'section' => 'viral_pro_main_header_options',
    'type' => 'select',
    'label' => esc_html__('Top and Bottom Border Settings', 'viral-pro'),
    'choices' => array(
        'ht-no-border' => esc_html__('Disable', 'viral-pro'),
        'ht-top-border' => esc_html__('Enable Top Border', 'viral-pro'),
        'ht-bottom-border' => esc_html__('Enable Bottom Border', 'viral-pro'),
        'ht-top-bottom-border' => esc_html__('Enable Top & Bottom Border', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_mh_border_color', array(
    'default' => '#EEEEEE',
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Alpha_Color_Control($wp_customize, 'viral_pro_mh_border_color', array(
    'label' => esc_html__('Border Color', 'viral-pro'),
    'section' => 'viral_pro_main_header_options'
)));

$wp_customize->add_setting('viral_pro_mh_header_bg_url', array(
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_mh_header_bg_id', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_mh_header_bg_repeat', array(
    'default' => 'no-repeat',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_mh_header_bg_size', array(
    'default' => 'cover',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_mh_header_bg_position', array(
    'default' => 'center-center',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_mh_header_bg_attach', array(
    'default' => 'scroll',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_mh_header_bg_overlay', array(
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_mh_header_bg_color', array(
    'default' => '#FFFFFF',
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

// Registers example_background control
$wp_customize->add_control(new Viral_Pro_Background_Image_Control($wp_customize, 'viral_pro_mh_header_bg', array(
    'label' => esc_html__('Header Background', 'viral-pro'),
    'section' => 'viral_pro_main_header_options',
    'settings' => array(
        'image_url' => 'viral_pro_mh_header_bg_url',
        'image_id' => 'viral_pro_mh_header_bg_id',
        'repeat' => 'viral_pro_mh_header_bg_repeat', // Use false to hide the field
        'size' => 'viral_pro_mh_header_bg_size',
        'position' => 'viral_pro_mh_header_bg_position',
        'attachment' => 'viral_pro_mh_header_bg_attach',
        'overlay' => 'viral_pro_mh_header_bg_overlay',
        'color' => 'viral_pro_mh_header_bg_color'
    )
)));

//MENU SETTINGS
$wp_customize->add_section('viral_pro_menu_section', array(
    'title' => esc_html__('Menu Settings', 'viral-pro'),
    'panel' => 'viral_pro_header_settings_panel'
));


$wp_customize->add_setting('viral_pro_menu_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_menu_nav', array(
    'section' => 'viral_pro_menu_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_add_menu',
                'viral_pro_mh_menu_hover_style',
                'viral_pro_responsive_width'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_mh_bg_color',
                'viral_pro_mh_bg_color_mobile',
                'viral_pro_mh_height',
                'viral_pro_mh_button_color',
                'viral_pro_mh_border_sep_start',
                'viral_pro_mh_border_color',
                'viral_pro_mh_border_sep_end',
                'viral_pro_mh_menu_color',
                'viral_pro_mh_menu_hover_color',
                'viral_pro_mh_menu_hover_bg_color',
                'viral_pro_submenu_seperator',
                'viral_pro_mh_submenu_bg_color',
                'viral_pro_mh_submenu_color',
                'viral_pro_mh_submenu_hover_color',
                'viral_pro_menuhover_seperator',
                'viral_pro_menu_dropdown_padding'
            ),
        ),
        array(
            'name' => esc_html__('Typography', 'viral-pro'),
            'icon' => 'dashicons dashicons-edit',
            'fields' => array(
                'menu_typography'
            ),
        ),
    ),
)));

//MAIN HEADER SETTINGS
$wp_customize->add_setting('viral_pro_add_menu', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Text_Info_Control($wp_customize, 'viral_pro_add_menu', array(
    'section' => 'viral_pro_menu_section',
    'description' => sprintf(esc_html__('Add %1$s and configure the below Settings.', 'viral-pro'), '<a href="' . admin_url() . '/nav-menus.php" target="_blank">Menu</a>')
)));

$wp_customize->add_setting('viral_pro_mh_menu_hover_style', array(
    'default' => 'hover-style6',
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Image_Selector_Control($wp_customize, 'viral_pro_mh_menu_hover_style', array(
    'section' => 'viral_pro_menu_section',
    'type' => 'select',
    'label' => esc_html__('Menu Hover Style', 'viral-pro'),
    'image_path' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/hover-styles/',
    'image_type' => 'png',
    'choices' => array(
        'hover-style1' => esc_html__('Hover Style 1', 'viral-pro'),
        'hover-style2' => esc_html__('Hover Style 2', 'viral-pro'),
        'hover-style3' => esc_html__('Hover Style 3', 'viral-pro'),
        'hover-style4' => esc_html__('Hover Style 4', 'viral-pro'),
        'hover-style5' => esc_html__('Hover Style 5', 'viral-pro'),
        'hover-style6' => esc_html__('Hover Style 6', 'viral-pro'),
        'hover-style7' => esc_html__('Hover Style 7', 'viral-pro'),
        'hover-style8' => esc_html__('Hover Style 8', 'viral-pro'),
        'hover-style9' => esc_html__('Hover Style 9', 'viral-pro'),
        'hover-style10' => esc_html__('Hover Style 10', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_responsive_width', array(
    'sanitize_callback' => 'absint',
    'default' => 780
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_responsive_width', array(
    'section' => 'viral_pro_menu_section',
    'label' => esc_html__('Enable Responsive Menu After(px)', 'viral-pro'),
    'description' => esc_html__('Set the value of the screen immediately after the menu item breaks into multiple line.', 'viral-pro'),
    'input_attrs' => array(
        'min' => 480,
        'max' => 1200,
        'step' => 10
    )
)));

$wp_customize->add_setting('viral_pro_mh_menu_color', array(
    'default' => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_mh_menu_color', array(
    'section' => 'viral_pro_menu_section',
    'label' => esc_html__('Menu Link Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mh_menu_hover_color', array(
    'default' => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_mh_menu_hover_color', array(
    'section' => 'viral_pro_menu_section',
    'label' => esc_html__('Menu Link Color - Hover', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mh_menu_hover_bg_color', array(
    'default' => '#0078af',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_mh_menu_hover_bg_color', array(
    'section' => 'viral_pro_menu_section',
    'label' => esc_html__('Menu Link Background Color - Hover', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_submenu_seperator', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_submenu_seperator', array(
    'section' => 'viral_pro_menu_section'
)));

$wp_customize->add_setting('viral_pro_mh_submenu_bg_color', array(
    'default' => '#F2F2F2',
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Alpha_Color_Control($wp_customize, 'viral_pro_mh_submenu_bg_color', array(
    'label' => esc_html__('SubMenu Background Color', 'viral-pro'),
    'section' => 'viral_pro_menu_section'
)));

$wp_customize->add_setting('viral_pro_mh_submenu_color', array(
    'default' => '#333333',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_mh_submenu_color', array(
    'section' => 'viral_pro_menu_section',
    'label' => esc_html__('SubMenu Text/Link Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mh_submenu_hover_color', array(
    'default' => '#333333',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_mh_submenu_hover_color', array(
    'section' => 'viral_pro_menu_section',
    'label' => esc_html__('SubMenu Link Color - Hover', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_menuhover_seperator', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_menuhover_seperator', array(
    'section' => 'viral_pro_menu_section'
)));

$wp_customize->add_setting('viral_pro_menu_dropdown_padding', array(
    'default' => 0,
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_menu_dropdown_padding', array(
    'section' => 'viral_pro_menu_section',
    'label' => esc_html__('Menu item Top/Bottom Padding', 'viral-pro'),
    'description' => sprintf(esc_html__('(in px) Select appropriate number so that the submenu on hover appears just below the header bar. %s', 'viral-pro'), '<a href="https://hashthemes.com/articles/menu-top-and-bottom-padding/" target="_blank">' . esc_html__('Detail Article Here', 'viral-pro') . '</a>'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1
    )
)));

// Add the Menu typography
$wp_customize->add_setting('menu_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('menu_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('menu_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('menu_text_transform', array(
    'default' => 'uppercase',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('menu_font_size', array(
    'default' => '14',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('menu_line_height', array(
    'default' => '3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('menu_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'menu_typography', array(
    'label' => esc_html__('Menu Typography', 'viral-pro'),
    'description' => __('Select how you want your menu to appear.', 'viral-pro'),
    'section' => 'viral_pro_menu_section',
    'settings' => array(
        'family' => 'menu_font_family',
        'style' => 'menu_font_style',
        'text_decoration' => 'menu_text_decoration',
        'text_transform' => 'menu_text_transform',
        'size' => 'menu_font_size',
        'line_height' => 'menu_line_height',
        'letter_spacing' => 'menu_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 10,
        'max' => 40,
        'step' => 1
    )
)));


//HEADER BUTTON SETTINGS
$wp_customize->add_section('viral_pro_header_button_section', array(
    'title' => esc_html__('Header CTA Button', 'viral-pro'),
    'panel' => 'viral_pro_header_settings_panel',
    'description' => esc_html__('The CTA button will show at the end of the menu', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_header_button_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'on',
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_header_button_disable', array(
    'section' => 'viral_pro_header_button_section',
    'label' => esc_html__('Disable Button', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_hb_text', array(
    'default' => esc_html__('Call Us', 'viral-pro'),
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_hb_text', array(
    'section' => 'viral_pro_header_button_section',
    'type' => 'text',
    'label' => esc_html__('Button Text', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_hb_link', array(
    'default' => 'tel:981123232',
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_hb_link', array(
    'section' => 'viral_pro_header_button_section',
    'type' => 'text',
    'label' => esc_html__('Button Link', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_hb_text_color', array(
    'default' => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_hb_text_hov_color', array(
    'default' => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_hb_bg_color', array(
    'default' => '#0078af',
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('viral_pro_hb_bg_hov_color', array(
    'default' => '#0078af',
    'sanitize_callback' => 'viral_pro_sanitize_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Color_Tab_Control($wp_customize, 'viral_pro_hb_color_group', array(
    'label' => esc_html__('Button Colors', 'viral-pro'),
    'section' => 'viral_pro_header_button_section',
    'show_opacity' => false,
    'settings' => array(
        'normal_viral_pro_hb_text_color' => 'viral_pro_hb_text_color',
        'normal_viral_pro_hb_bg_color' => 'viral_pro_hb_bg_color',
        'hover_viral_pro_hb_text_hov_color' => 'viral_pro_hb_text_hov_color',
        'hover_viral_pro_hb_bg_hov_color' => 'viral_pro_hb_bg_hov_color'
    ),
    'group' => array(
        'normal_viral_pro_hb_text_color' => 'Button Text Color',
        'normal_viral_pro_hb_bg_color' => 'Button Backgroud Color',
        'hover_viral_pro_hb_text_hov_color' => 'Button Text Color',
        'hover_viral_pro_hb_bg_hov_color' => 'Button Backgroud Color'
    )
)));

$wp_customize->add_setting('viral_pro_hb_borderradius', array(
    'sanitize_callback' => 'absint',
    'default' => 0,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_hb_borderradius', array(
    'section' => 'viral_pro_header_button_section',
    'label' => esc_html__('Button Border Radius', 'viral-pro'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_hb_disable_mobile', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_hb_disable_mobile', array(
    'section' => 'viral_pro_header_button_section',
    'label' => esc_html__('Disable in Mobile', 'viral-pro')
)));

//TITLE BAR SETTINGS
$wp_customize->add_section('viral_pro_title_bar_section', array(
    'title' => esc_html__('Page Title', 'viral-pro'),
    'panel' => 'viral_pro_header_settings_panel'
));

$wp_customize->add_setting('viral_pro_title_bar_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_title_bar_nav', array(
    'section' => 'viral_pro_title_bar_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_page_title_heading',
                'viral_pro_show_title',
                'viral_pro_breacrumb_heading',
                'viral_pro_breadcrumb'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Typography', 'viral-pro'),
            'icon' => 'dashicons dashicons-edit',
            'fields' => array(
                'page_title_typography'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_page_title_heading', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'refresh'
));

$wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, 'viral_pro_page_title_heading', array(
    'section' => 'viral_pro_title_bar_section',
    'label' => esc_html__('Page Title', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_show_title', array(
    'sanitize_callback' => 'viral_pro_sanitize_checkbox',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_show_title', array(
    'section' => 'viral_pro_title_bar_section',
    'label' => esc_html__('Page Title/SubTitle', 'viral-pro'),
    'description' => esc_html__('The title of the page and archives that appears below the menu. It does not apply for post title.', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_breacrumb_heading', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'refresh'
));

$wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, 'viral_pro_breacrumb_heading', array(
    'section' => 'viral_pro_title_bar_section',
    'label' => esc_html__('Breadcrumb', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_breadcrumb', array(
    'sanitize_callback' => 'viral_pro_sanitize_checkbox',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_breadcrumb', array(
    'section' => 'viral_pro_title_bar_section',
    'label' => esc_html__('BreadCrumb', 'viral-pro'),
    'description' => esc_html__('Breadcrumbs are a great way of letting your visitors find out where they are on your site.', 'viral-pro')
)));

// Add the Page Title typography
$wp_customize->add_setting('page_title_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('page_title_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('page_title_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('page_title_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('page_title_font_size', array(
    'default' => '40',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('page_title_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('page_title_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('page_title_color', array(
    'default' => '#333333',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'page_title_typography', array(
    'label' => esc_html__('Page Title Typography', 'viral-pro'),
    'description' => __('Page/Post/Archive Titles', 'viral-pro'),
    'section' => 'viral_pro_title_bar_section',
    'settings' => array(
        'family' => 'page_title_font_family',
        'style' => 'page_title_font_style',
        'text_decoration' => 'page_title_text_decoration',
        'text_transform' => 'page_title_text_transform',
        'size' => 'page_title_font_size',
        'line_height' => 'page_title_line_height',
        'letter_spacing' => 'page_title_letter_spacing',
        'color' => 'page_title_color'
    ),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

