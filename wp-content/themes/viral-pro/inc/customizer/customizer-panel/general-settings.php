<?php

/**
 * Viral Pro Theme Customizer
 *
 * @package Viral Pro
 */
/* GENERAL SETTINGS PANEL */
$wp_customize->add_panel('viral_pro_general_settings_panel', array(
    'title' => esc_html__('General Settings', 'viral-pro'),
    'priority' => 1
));

//GENERAL SETTINGS
$wp_customize->add_section('viral_pro_general_options_section', array(
    'title' => esc_html__('General Options', 'viral-pro'),
    'panel' => 'viral_pro_general_settings_panel'
));

//MOVE BACKGROUND AND COLOR SETTING INTO GENERAL SETTING SECTION
$wp_customize->get_control('background_image')->section = 'viral_pro_general_options_section';
$wp_customize->get_control('background_color')->section = 'viral_pro_general_options_section';
$wp_customize->get_control('background_preset')->section = 'viral_pro_general_options_section';
$wp_customize->get_control('background_position')->section = 'viral_pro_general_options_section';
$wp_customize->get_control('background_size')->section = 'viral_pro_general_options_section';
$wp_customize->get_control('background_repeat')->section = 'viral_pro_general_options_section';
$wp_customize->get_control('background_attachment')->section = 'viral_pro_general_options_section';

$wp_customize->get_control('background_color')->priority = 20;
$wp_customize->get_control('background_image')->priority = 20;
$wp_customize->get_control('background_preset')->priority = 20;
$wp_customize->get_control('background_position')->priority = 20;
$wp_customize->get_control('background_size')->priority = 20;
$wp_customize->get_control('background_repeat')->priority = 20;
$wp_customize->get_control('background_attachment')->priority = 20;

$wp_customize->add_setting('viral_pro_style_option', array(
    'default' => 'head',
    'sanitize_callback' => 'viral_pro_sanitize_choices',
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_style_option', array(
    'section' => 'viral_pro_general_options_section',
    'type' => 'radio',
    'label' => esc_html__('Dynamic Style Option', 'viral-pro'),
    'choices' => array(
        'head' => esc_html__('WP Head', 'viral-pro'),
        'file' => esc_html__('Custom File', 'viral-pro')
    ),
    'description' => esc_html__('WP Head option will save the custom CSS in the header of the HTML file and Custom file option will save the custom CSS in a seperate file.', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_website_layout', array(
    'default' => 'wide',
    'sanitize_callback' => 'viral_pro_sanitize_choices',
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_website_layout', array(
    'section' => 'viral_pro_general_options_section',
    'type' => 'radio',
    'label' => esc_html__('Website Layout', 'viral-pro'),
    'choices' => array(
        'wide' => esc_html__('Wide', 'viral-pro'),
        'boxed' => esc_html__('Boxed', 'viral-pro'),
        'fluid' => esc_html__('Fluid', 'viral-pro')
    )
));


$wp_customize->add_setting('viral_pro_fluid_container_width', array(
    'sanitize_callback' => 'absint',
    'default' => 80,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_fluid_container_width', array(
    'section' => 'viral_pro_general_options_section',
    'label' => esc_html__('Website Container Width (%)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_website_width', array(
    'sanitize_callback' => 'absint',
    'default' => 1170,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_website_width', array(
    'section' => 'viral_pro_general_options_section',
    'label' => esc_html__('Website Container Width (px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 900,
        'max' => 1800,
        'step' => 10
    )
)));

$wp_customize->add_setting('viral_pro_container_padding', array(
    'sanitize_callback' => 'absint',
    'default' => 40,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_container_padding', array(
    'section' => 'viral_pro_general_options_section',
    'label' => esc_html__('Website Container Padding (px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 10,
        'max' => 200,
        'step' => 5
    )
)));

$wp_customize->add_setting('viral_pro_sidebar_width', array(
    'sanitize_callback' => 'absint',
    'default' => 30,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_sidebar_width', array(
    'section' => 'viral_pro_general_options_section',
    'label' => esc_html__('Sidebar Width (%)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 20,
        'max' => 50,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_scroll_animation_seperator', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_scroll_animation_seperator', array(
    'section' => 'viral_pro_general_options_section'
)));

$wp_customize->add_setting('viral_pro_background_heading', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
));

$wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, 'viral_pro_background_heading', array(
    'section' => 'viral_pro_general_options_section',
    'label' => esc_html__('Background', 'viral-pro'),
)));


//PRELOADER SETTINGS
$wp_customize->add_section('viral_pro_preloader_options_section', array(
    'title' => esc_html__('Preloader Options', 'viral-pro'),
    'panel' => 'viral_pro_general_settings_panel'
));

$wp_customize->add_setting('viral_pro_preloader', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_preloader', array(
    'section' => 'viral_pro_preloader_options_section',
    'label' => esc_html__('Enable Preloader', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_preloader_type', array(
    'default' => 'preloader1',
    'sanitize_callback' => 'viral_pro_sanitize_choices',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Preloader_Selector_Control($wp_customize, 'viral_pro_preloader_type', array(
    'section' => 'viral_pro_preloader_options_section',
    'file_path' => VIRAL_PRO_CUSTOMIZER_PATH . 'preloader',
    'label' => esc_html__('Preloader Type', 'viral-pro'),
    'choices' => array(
        'preloader1' => esc_html__('Preloader 1', 'viral-pro'),
        'preloader2' => esc_html__('Preloader 2', 'viral-pro'),
        'preloader3' => esc_html__('Preloader 3', 'viral-pro'),
        'preloader4' => esc_html__('Preloader 4', 'viral-pro'),
        'preloader5' => esc_html__('Preloader 5', 'viral-pro'),
        'preloader6' => esc_html__('Preloader 6', 'viral-pro'),
        'preloader7' => esc_html__('Preloader 7', 'viral-pro'),
        'preloader8' => esc_html__('Preloader 8', 'viral-pro'),
        'preloader9' => esc_html__('Preloader 9', 'viral-pro'),
        'preloader10' => esc_html__('Preloader 10', 'viral-pro'),
        'preloader11' => esc_html__('Preloader 11', 'viral-pro'),
        'preloader12' => esc_html__('Preloader 12', 'viral-pro'),
        'preloader13' => esc_html__('Preloader 13', 'viral-pro'),
        'preloader14' => esc_html__('Preloader 14', 'viral-pro'),
        'preloader15' => esc_html__('Preloader 15', 'viral-pro'),
        'preloader16' => esc_html__('Preloader 16', 'viral-pro'),
        'custom' => esc_html__('Custom', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_preloader_color', array(
    'default' => '#000000',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_preloader_color', array(
    'section' => 'viral_pro_preloader_options_section',
    'label' => esc_html__('Preloader Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_preloader_image', array(
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'viral_pro_preloader_image', array(
    'section' => 'viral_pro_preloader_options_section',
    'description' => esc_html__('Custom Preloader Image - gif image is preferable', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_preloader_bg_color', array(
    'default' => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_preloader_bg_color', array(
    'section' => 'viral_pro_preloader_options_section',
    'label' => esc_html__('Preloader Background Color', 'viral-pro')
)));

//ADMIN LOGO
$wp_customize->add_section('viral_pro_admin_logo_section', array(
    'title' => esc_html__('Admin Logo', 'viral-pro'),
    'panel' => 'viral_pro_general_settings_panel',
    'description' => esc_html__('The logo will appear in the admin login page.', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_admin_logo', array(
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'viral_pro_admin_logo', array(
    'section' => 'viral_pro_admin_logo_section',
    'label' => esc_html__('Upload Admin Logo', 'viral-pro'),
)));

$wp_customize->add_setting('viral_pro_admin_logo_width', array(
    'sanitize_callback' => 'absint',
    'default' => 180,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_admin_logo_width', array(
    'section' => 'viral_pro_admin_logo_section',
    'label' => esc_html__('Logo Width', 'viral-pro'),
    'input_attrs' => array(
        'min' => 80,
        'max' => 320,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_admin_logo_height', array(
    'sanitize_callback' => 'absint',
    'default' => 80,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_admin_logo_height', array(
    'section' => 'viral_pro_admin_logo_section',
    'label' => esc_html__('Logo Height', 'viral-pro'),
    'input_attrs' => array(
        'min' => 30,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_admin_logo_link', array(
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_admin_logo_link', array(
    'section' => 'viral_pro_admin_logo_section',
    'type' => 'text',
    'label' => esc_html__('Admin Logo Link', 'viral-pro'),
    'description' => esc_html__('This is the url that is opened when clicked on the admin logo.', 'viral-pro')
));


/* GOOGLE FONT SECTION */
$wp_customize->add_section('viral_pro_google_font_section', array(
    'title' => esc_html__('Google Fonts', 'viral-pro'),
    'panel' => 'viral_pro_general_settings_panel',
    'priority' => 1000
));

$wp_customize->add_setting('viral_pro_load_google_font_locally', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_load_google_font_locally', array(
    'section' => 'viral_pro_google_font_section',
    'label' => esc_html__('Load Google Fonts Locally', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'description' => esc_html__('It is required to load the Google Fonts locally in order to comply with GDPR. However, if your website is not required to comply with Google Fonts then you can check this field off. Loading the Fonts locally with lots of different Google fonts can decrease the speed of the website slightly.', 'viral-pro'),
)));


/* SCROLL TOP SECTION */
$wp_customize->add_section('viral_pro_scroll_top_section', array(
    'title' => esc_html__('Scroll Top', 'viral-pro'),
    'panel' => 'viral_pro_general_settings_panel',
));

$wp_customize->add_setting('viral_pro_backtotop', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_backtotop', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Back to Top Button', 'viral-pro'),
    'description' => esc_html__('A button on click scrolls to the top of the page.', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_scroll_top_icon', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'arrow_up'
));

$wp_customize->add_control(new Viral_Pro_Icon_Selector_Control($wp_customize, 'viral_pro_scroll_top_icon', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Choose Icon', 'viral-pro'),
    'icon_array' => array(
        array(
            'name' => 'viral-pro-scroll-top-icons',
            'prefix' => '',
            'displayPrefix' => '',
            'url' => '',
            'icons' => viral_pro_scroll_top_icons_array()
        )
    ),
)));

$wp_customize->add_setting('viral_pro_scroll_top_position', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'right',
));

$wp_customize->add_control(new Viral_Pro_Text_Selector_Control($wp_customize, 'viral_pro_scroll_top_position', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Position', 'viral-pro'),
    'choices' => array(
        'left' => array(
            'label' => esc_html__('Left', 'viral-pro'),
        ),
        'center' => array(
            'label' => esc_html__('Center', 'viral-pro'),
        ),
        'right' => array(
            'label' => esc_html__('Right', 'viral-pro'),
        )
    ),
)));

$wp_customize->add_setting('viral_pro_scroll_top_type', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'stacked',
));

$wp_customize->add_control(new Viral_Pro_Text_Selector_Control($wp_customize, 'viral_pro_scroll_top_type', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Type', 'viral-pro'),
    'choices' => array(
        'stacked' => array(
            'label' => esc_html__('Stacked', 'viral-pro'),
        ),
        'framed' => array(
            'label' => esc_html__('Framed', 'viral-pro'),
        )
    ),
)));

$wp_customize->add_setting('viral_pro_scroll_top_height', array(
    'sanitize_callback' => 'viral_pro_sanitize_integer',
    'default' => 46,
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_scroll_top_height', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Height(px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1,
    )
)));

$wp_customize->add_setting('viral_pro_scroll_top_width', array(
    'sanitize_callback' => 'viral_pro_sanitize_integer',
    'default' => 46,
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_scroll_top_width', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Width(px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1,
    )
)));

$wp_customize->add_setting('viral_pro_scroll_top_border_radius', array(
    'sanitize_callback' => 'viral_pro_sanitize_integer',
    'default' => 0,
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_scroll_top_border_radius', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Border Radius(px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1,
    )
)));

$wp_customize->add_setting('viral_pro_scroll_top_icon_size', array(
    'sanitize_callback' => 'viral_pro_sanitize_integer',
    'default' => 20,
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_scroll_top_icon_size', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Icon Size(px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 10,
        'max' => 100,
        'step' => 1,
    )
)));

$wp_customize->add_setting('viral_pro_scroll_top_offset_heading', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
));

$wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, 'viral_pro_scroll_top_offset_heading', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Offset', 'viral-pro'),
    'description' => esc_html__('Move the position of the button', 'viral-pro'),
)));

$wp_customize->add_setting('viral_pro_scroll_top_offset_left', array(
    'sanitize_callback' => 'viral_pro_sanitize_integer',
    'default' => 40,
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_scroll_top_offset_left', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Offset Left(px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1,
    )
)));

$wp_customize->add_setting('viral_pro_scroll_top_offset_right', array(
    'sanitize_callback' => 'viral_pro_sanitize_integer',
    'default' => 40,
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_scroll_top_offset_right', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Offset Right(px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1,
    )
)));

$wp_customize->add_setting('viral_pro_scroll_top_offset_bottom', array(
    'sanitize_callback' => 'viral_pro_sanitize_integer',
    'default' => 40,
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_scroll_top_offset_bottom', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Offset Bottom(px)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1,
    )
)));

$wp_customize->add_setting('viral_pro_scroll_top_color', array(
    'sanitize_callback' => 'viral_pro_sanitize_hex_color',
));

$wp_customize->add_setting('viral_pro_scroll_top_icon_color', array(
    'sanitize_callback' => 'viral_pro_sanitize_hex_color',
));

$wp_customize->add_setting('viral_pro_scroll_top_hov_color', array(
    'sanitize_callback' => 'viral_pro_sanitize_hex_color',
));

$wp_customize->add_setting('viral_pro_scroll_top_icon_hov_color', array(
    'sanitize_callback' => 'viral_pro_sanitize_hex_color',
));

$wp_customize->add_control(new Viral_Pro_Color_Tab_Control($wp_customize, 'viral_pro_scroll_top_color_group', array(
    'label' => esc_html__('Colors', 'viral-pro'),
    'section' => 'viral_pro_scroll_top_section',
    'show_opacity' => false,
    'hide_control' => false,
    'settings' => array(
        'normal_color' => 'viral_pro_scroll_top_color',
        'normal_icon_color' => 'viral_pro_scroll_top_icon_color',
        'hover_color' => 'viral_pro_scroll_top_hov_color',
        'hover_icon_color' => 'viral_pro_scroll_top_icon_hov_color',
    ),
    'group' => array(
        'normal_color' => esc_html__('Button Color', 'viral-pro'),
        'normal_icon_color' => esc_html__('Button Icon Color', 'viral-pro'),
        'hover_color' => esc_html__('Button Color', 'viral-pro'),
        'hover_icon_color' => esc_html__('Button Icon Color', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_scroll_top_mobile_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_boolean',
    'default' => false
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_scroll_top_mobile_disable', array(
    'section' => 'viral_pro_scroll_top_section',
    'label' => esc_html__('Disable in Mobile', 'viral-pro'),
)));


/* SEO SECTION */
$wp_customize->add_section('viral_pro_seo_section', array(
    'title' => esc_html__('SEO', 'viral-pro'),
    'panel' => 'viral_pro_general_settings_panel',
    'priority' => 1000
));

$wp_customize->add_setting('viral_pro_schema_markup', array(
    'sanitize_callback' => 'viral_pro_sanitize_checkbox',
    'default' => false,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_schema_markup', array(
    'section' => 'viral_pro_seo_section',
    'label' => esc_html__('Schema.org Markup', 'viral-pro'),
    'description' => esc_html__('Enable Schema.org markup feature for your site. You can disable this option if if you use a SEO plugin.', 'viral-pro'),
)));
