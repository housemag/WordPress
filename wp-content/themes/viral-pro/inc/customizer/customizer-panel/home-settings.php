<?php

/**
 * Viral Pro Theme Customizer
 *
 * @package Viral Pro
 */
$wp_customize->add_section('viral_pro_frontpage_settings', array(
    'title' => __('Front Page Settings', 'viral-pro'),
    'priority' => 25
));

$wp_customize->add_setting('viral_pro_frontpage_settings_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_settings_nav', array(
    'section' => 'viral_pro_frontpage_settings',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_block_title_style',
                'viral_pro_block_title_end',
                'viral_pro_display_time_ago',
                'viral_pro_lazy_load',
                'viral_pro_image_hover_effect'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_block_title_color',
                'viral_pro_block_title_background_color',
                'viral_pro_block_title_border_color',
                'viral_pro_block_title_end',
                'viral_pro_placeholder_image',
                'viral_pro_frontpage_section_spacing'
            ),
        ),
        array(
            'name' => esc_html__('Typography', 'viral-pro'),
            'icon' => 'dashicons dashicons-edit',
            'fields' => array(
                'frontpage_block_title_typography',
                'frontpage_title_typography'
            ),
        )
    ),
)));

$wp_customize->add_setting('viral_pro_block_title_style', array(
    'default' => 'style2',
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Image_Selector_Control($wp_customize, 'viral_pro_block_title_style', array(
    'section' => 'viral_pro_frontpage_settings',
    'type' => 'select',
    'label' => esc_html__('Block Title Bar Style', 'viral-pro'),
    'description' => sprintf(esc_html__('Change Typography %s', 'viral-pro'), '<a href="javascript:wp.customize.section( \'frontpage_block_title_typography\' ).focus()">' . esc_html__('here', 'viral-pro') . '</a>'),
    'image_path' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/title-bar-styles/',
    'image_type' => 'png',
    'choices' => array(
        'style1' => esc_html__('Style 1', 'viral-pro'),
        'style2' => esc_html__('Style 2', 'viral-pro'),
        'style3' => esc_html__('Style 3', 'viral-pro'),
        'style4' => esc_html__('Style 4', 'viral-pro'),
        'style5' => esc_html__('Style 5', 'viral-pro'),
        'style6' => esc_html__('Style 6', 'viral-pro'),
        'style7' => esc_html__('Style 7', 'viral-pro'),
        'style8' => esc_html__('Style 8', 'viral-pro'),
        'style9' => esc_html__('Style 9', 'viral-pro'),
        'style10' => esc_html__('Style 10', 'viral-pro'),
        'style11' => esc_html__('Style 11', 'viral-pro'),
        'style12' => esc_html__('Style 12', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_block_title_color', array(
    'default' => '#333333',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_block_title_color', array(
    'section' => 'viral_pro_frontpage_settings',
    'label' => esc_html__('Block Title Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_block_title_background_color', array(
    'default' => '#0078af',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_block_title_background_color', array(
    'section' => 'viral_pro_frontpage_settings',
    'label' => esc_html__('Block Title Background Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_block_title_border_color', array(
    'default' => '#333333',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'viral_pro_block_title_border_color', array(
    'section' => 'viral_pro_frontpage_settings',
    'label' => esc_html__('Block Title Border Color', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_block_title_end', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_block_title_end', array(
    'section' => 'viral_pro_frontpage_settings'
)));

$wp_customize->add_setting('viral_pro_display_time_ago', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => false
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_display_time_ago', array(
    'section' => 'viral_pro_frontpage_settings',
    'label' => esc_html__('Display Post Date as Time Ago', 'viral-pro'),
    'description' => esc_html__('Turn on this option to display time ago instead of date.', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_lazy_load', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => false
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_lazy_load', array(
    'section' => 'viral_pro_frontpage_settings',
    'label' => esc_html__('Enable Lazy Load', 'viral-pro'),
    'description' => esc_html__('The image will load as you scroll down.', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_image_hover_effect', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'shine',
    'transport' => 'postMessage'
));

$wp_customize->add_control('viral_pro_image_hover_effect', array(
    'section' => 'viral_pro_frontpage_settings',
    'type' => 'select',
    'label' => esc_html__('Thumb Image Hover Effect', 'viral-pro'),
    'choices' => array(
        'no-effect' => esc_html__('No Effect', 'viral-pro'),
        'zoom-in' => esc_html__('Zoom In', 'viral-pro'),
        'zoom-out' => esc_html__('Zoom Out', 'viral-pro'),
        'slide-left' => esc_html__('Slide Left', 'viral-pro'),
        'slide-right' => esc_html__('Slide Right', 'viral-pro'),
        'slide-top' => esc_html__('Slide Top', 'viral-pro'),
        'slide-bottom' => esc_html__('Slide Bottom', 'viral-pro'),
        'rotate-zoom-in' => esc_html__('Rotate & Zoom Out', 'viral-pro'),
        'opacity' => esc_html__('Opacity', 'viral-pro'),
        'shine' => esc_html__('Shine', 'viral-pro'),
        'circle' => esc_html__('Circle', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_placeholder_image', array(
    'sanitize_callback' => 'esc_url_raw'
));

$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'viral_pro_placeholder_image', array(
    'section' => 'viral_pro_frontpage_settings',
    'label' => esc_html__('Placeholder Image', 'viral-pro'),
    'description' => esc_html__('If the featured image is not uploaded, this image will show by default. Default image will show if the placeholder image is not uploaded.', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_frontpage_section_spacing', array(
    'default' => 40,
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_frontpage_section_spacing', array(
    'section' => 'viral_pro_frontpage_settings',
    'label' => esc_html__('Spacing Between Repeater Section', 'viral-pro'),
    'description' => esc_html__('(in px) Ajust the spacing between the sections.', 'viral-pro'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1
    )
)));


// Add the Frontpage Block Title typography
$wp_customize->add_setting('frontpage_block_title_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('frontpage_block_title_font_style', array(
    'default' => '700',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_block_title_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_block_title_text_transform', array(
    'default' => 'uppercase',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_block_title_font_size', array(
    'default' => '20',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_block_title_line_height', array(
    'default' => '1.1',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_block_title_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'frontpage_block_title_typography', array(
    'label' => esc_html__('Front Page Block Title Typography', 'viral-pro'),
    'description' => __('Select how you want your frontpage block title to appear.', 'viral-pro'),
    'section' => 'viral_pro_frontpage_settings',
    'settings' => array(
        'family' => 'frontpage_block_title_font_family',
        'style' => 'frontpage_block_title_font_style',
        'text_decoration' => 'frontpage_block_title_text_decoration',
        'text_transform' => 'frontpage_block_title_text_transform',
        'size' => 'frontpage_block_title_font_size',
        'line_height' => 'frontpage_block_title_line_height',
        'letter_spacing' => 'frontpage_block_title_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 12,
        'max' => 40,
        'step' => 1
    )
)));

// Add the Frontpage Title typography
$wp_customize->add_setting('frontpage_title_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('frontpage_title_font_style', array(
    'default' => '500',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_title_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_title_text_transform', array(
    'default' => 'capitalize',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_title_font_size', array(
    'default' => '16',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_title_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('frontpage_title_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'frontpage_title_typography', array(
    'label' => esc_html__('Front Page Post Title Typography', 'viral-pro'),
    'description' => __('Select how you want your frontpage post title to appear.', 'viral-pro'),
    'section' => 'viral_pro_frontpage_settings',
    'settings' => array(
        'family' => 'frontpage_title_font_family',
        'style' => 'frontpage_title_font_style',
        'text_decoration' => 'frontpage_title_text_decoration',
        'text_transform' => 'frontpage_title_text_transform',
        'size' => 'frontpage_title_font_size',
        'line_height' => 'frontpage_title_line_height',
        'letter_spacing' => 'frontpage_title_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 12,
        'max' => 40,
        'step' => 1
    )
)));
