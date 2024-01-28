<?php

// Add the typography panel.
$wp_customize->add_panel('viral_pro_typography_panel', array(
    'priority' => 1,
    'title' => esc_html__('Typography Settings', 'viral-pro')
));

// Add the body typography section.
$wp_customize->add_section('body_typography', array(
    'panel' => 'viral_pro_typography_panel',
    'title' => esc_html__('Body', 'viral-pro')
));

$wp_customize->add_setting('body_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('body_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('body_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('body_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('body_font_size', array(
    'default' => '15',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('body_line_height', array(
    'default' => '1.6',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('body_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('body_color', array(
    'default' => '#333333',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'body_typography', array(
    'label' => esc_html__('Body Typography', 'viral-pro'),
    'description' => __('Select how you want your body to appear.', 'viral-pro'),
    'section' => 'body_typography',
    'settings' => array(
        'family' => 'body_font_family',
        'style' => 'body_font_style',
        'text_decoration' => 'body_text_decoration',
        'text_transform' => 'body_text_transform',
        'size' => 'body_font_size',
        'line_height' => 'body_line_height',
        'letter_spacing' => 'body_letter_spacing',
        'color' => 'body_color'
    ),
    'input_attrs' => array(
        'min' => 10,
        'max' => 40,
        'step' => 1
    )
)));

// Add H1 typography section.
$wp_customize->add_section('header_typography', array(
    'panel' => 'viral_pro_typography_panel',
    'title' => esc_html__('Headers(H1, H2, H3, H4, H5, H6)', 'viral-pro')
));

$wp_customize->add_setting('common_header_typography', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'common_header_typography', array(
    'section' => 'header_typography',
    'label' => esc_html__('Use Common Typography for all Headers', 'viral-pro')
)));

// Add H typography section.
$wp_customize->add_setting('h_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('h_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'h_typography', array(
    'label' => esc_html__('Header Typography', 'viral-pro'),
    'description' => __('Select how you want your Header to appear.', 'viral-pro'),
    'section' => 'header_typography',
    'settings' => array(
        'family' => 'h_font_family',
        'style' => 'h_font_style',
        'text_decoration' => 'h_text_decoration',
        'text_transform' => 'h_text_transform',
        'line_height' => 'h_line_height',
        'letter_spacing' => 'h_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('h_typography_seperator', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'h_typography_seperator', array(
    'section' => 'header_typography'
)));

$wp_customize->add_setting('hh1_font_size', array(
    'sanitize_callback' => 'absint',
    'default' => 38,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'hh1_font_size', array(
    'section' => 'header_typography',
    'label' => esc_html__('H1 Font Size', 'viral-pro'),
    'input_attrs' => array(
        'min' => 14,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('hh2_font_size', array(
    'sanitize_callback' => 'absint',
    'default' => 34,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'hh2_font_size', array(
    'section' => 'header_typography',
    'label' => esc_html__('H2 Font Size', 'viral-pro'),
    'input_attrs' => array(
        'min' => 14,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('hh3_font_size', array(
    'sanitize_callback' => 'absint',
    'default' => 30,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'hh3_font_size', array(
    'section' => 'header_typography',
    'label' => esc_html__('H3 Font Size', 'viral-pro'),
    'input_attrs' => array(
        'min' => 14,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('hh4_font_size', array(
    'sanitize_callback' => 'absint',
    'default' => 26,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'hh4_font_size', array(
    'section' => 'header_typography',
    'label' => esc_html__('H4 Font Size', 'viral-pro'),
    'input_attrs' => array(
        'min' => 14,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('hh5_font_size', array(
    'sanitize_callback' => 'absint',
    'default' => 22,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'hh5_font_size', array(
    'section' => 'header_typography',
    'label' => esc_html__('H5 Font Size', 'viral-pro'),
    'input_attrs' => array(
        'min' => 14,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('hh6_font_size', array(
    'sanitize_callback' => 'absint',
    'default' => 18,
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'hh6_font_size', array(
    'section' => 'header_typography',
    'label' => esc_html__('H6 Font Size', 'viral-pro'),
    'input_attrs' => array(
        'min' => 14,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_setting('header_typography_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'header_typography_nav', array(
    'section' => 'header_typography',
    //'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('H1', 'viral-pro'),
            'fields' => array(
                'h1_typography_heading',
                'h1_typography',
            ),
            'active' => true
        ),
        array(
            'name' => esc_html__('H2', 'viral-pro'),
            'fields' => array(
                'h2_typography_heading',
                'h2_typography',
            )
        ),
        array(
            'name' => esc_html__('H3', 'viral-pro'),
            'fields' => array(
                'h3_typography_heading',
                'h3_typography',
            )
        ),
        array(
            'name' => esc_html__('H4', 'viral-pro'),
            'fields' => array(
                'h4_typography_heading',
                'h4_typography',
            )
        ),
        array(
            'name' => esc_html__('H5', 'viral-pro'),
            'fields' => array(
                'h5_typography_heading',
                'h5_typography',
            )
        ),
        array(
            'name' => esc_html__('H6', 'viral-pro'),
            'fields' => array(
                'h6_typography_heading',
                'h6_typography',
            )
        )
    ),
)));

// Add H1 typography section.
$wp_customize->add_setting('h1_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('h1_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h1_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h1_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h1_font_size', array(
    'default' => '38',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h1_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h1_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'h1_typography', array(
    'label' => esc_html__('Header H1 Typography', 'viral-pro'),
    'description' => __('Select how you want your H1 to appear.', 'viral-pro'),
    'section' => 'header_typography',
    'settings' => array(
        'family' => 'h1_font_family',
        'style' => 'h1_font_style',
        'text_decoration' => 'h1_text_decoration',
        'text_transform' => 'h1_text_transform',
        'size' => 'h1_font_size',
        'line_height' => 'h1_line_height',
        'letter_spacing' => 'h1_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

// Add H2 typography section.
$wp_customize->add_setting('h2_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('h2_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h2_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h2_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h2_font_size', array(
    'default' => '34',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h2_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h2_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'h2_typography', array(
    'label' => esc_html__('Header H2 Typography', 'viral-pro'),
    'description' => __('Select how you want your H2 to appear.', 'viral-pro'),
    'section' => 'header_typography',
    'settings' => array(
        'family' => 'h2_font_family',
        'style' => 'h2_font_style',
        'text_decoration' => 'h2_text_decoration',
        'text_transform' => 'h2_text_transform',
        'size' => 'h2_font_size',
        'line_height' => 'h2_line_height',
        'letter_spacing' => 'h2_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

// Add H3 typography section.
$wp_customize->add_setting('h3_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('h3_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h3_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h3_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h3_font_size', array(
    'default' => '30',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h3_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h3_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'h3_typography', array(
    'label' => esc_html__('Header H3 Typography', 'viral-pro'),
    'description' => __('Select how you want your H3 to appear.', 'viral-pro'),
    'section' => 'header_typography',
    'settings' => array(
        'family' => 'h3_font_family',
        'style' => 'h3_font_style',
        'text_decoration' => 'h3_text_decoration',
        'text_transform' => 'h3_text_transform',
        'size' => 'h3_font_size',
        'line_height' => 'h3_line_height',
        'letter_spacing' => 'h3_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

// Add H4 typography section.
$wp_customize->add_setting('h4_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('h4_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h4_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h4_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h4_font_size', array(
    'default' => '26',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h4_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h4_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'h4_typography', array(
    'label' => esc_html__('Header H4 Typography', 'viral-pro'),
    'description' => __('Select how you want your H4 to appear.', 'viral-pro'),
    'section' => 'header_typography',
    'settings' => array(
        'family' => 'h4_font_family',
        'style' => 'h4_font_style',
        'text_decoration' => 'h4_text_decoration',
        'text_transform' => 'h4_text_transform',
        'size' => 'h4_font_size',
        'line_height' => 'h4_line_height',
        'letter_spacing' => 'h4_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

// Add H5 typography section.
$wp_customize->add_setting('h5_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('h5_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h5_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h5_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h5_font_size', array(
    'default' => '22',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h5_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h5_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'h5_typography', array(
    'label' => esc_html__('Header H5 Typography', 'viral-pro'),
    'description' => __('Select how you want your H6 to appear.', 'viral-pro'),
    'section' => 'header_typography',
    'settings' => array(
        'family' => 'h5_font_family',
        'style' => 'h5_font_style',
        'text_decoration' => 'h5_text_decoration',
        'text_transform' => 'h5_text_transform',
        'size' => 'h5_font_size',
        'line_height' => 'h5_line_height',
        'letter_spacing' => 'h5_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

// Add H6 typography section.
$wp_customize->add_setting('h6_font_family', array(
    'default' => 'Roboto',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_setting('h6_font_style', array(
    'default' => '400',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h6_text_decoration', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h6_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h6_font_size', array(
    'default' => '18',
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h6_line_height', array(
    'default' => '1.3',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_setting('h6_letter_spacing', array(
    'default' => '0',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Typography_Control($wp_customize, 'h6_typography', array(
    'label' => esc_html__('Header H6 Typography', 'viral-pro'),
    'description' => __('Select how you want your H6 to appear.', 'viral-pro'),
    'section' => 'header_typography',
    'settings' => array(
        'family' => 'h6_font_family',
        'style' => 'h6_font_style',
        'text_decoration' => 'h6_text_decoration',
        'text_transform' => 'h6_text_transform',
        'size' => 'h6_font_size',
        'line_height' => 'h6_line_height',
        'letter_spacing' => 'h6_letter_spacing'
    ),
    'input_attrs' => array(
        'min' => 20,
        'max' => 100,
        'step' => 1
    )
)));

$wp_customize->add_section(new Viral_Pro_Upgrade_Section($wp_customize, 'viral_pro_more_typography_section', array(
    'title' => esc_html__('Other Typography', 'viral-pro'),
    'panel' => 'viral_pro_typography_panel',
    'priority' => 1000,
    'class' => 'ht--boxed',
    'options' => array(
        '<a href="javascript:wp.customize.section(\'title_tagline\').focus();">' . esc_html__('Site Title & Tagline', 'viral-pro') . '</a>',
        '<a href="javascript:wp.customize.section(\'viral_pro_menu_section\').focus();">' . esc_html__('Menu & Sub Menu', 'viral-pro') . '</a>',
        '<a href="javascript:wp.customize.section(\'viral_pro_title_bar_section\').focus();">' . esc_html__('Page Banner (Header Title)', 'viral-pro') . '</a>',
        '<a href="javascript:wp.customize.section(\'viral_pro_frontpage_settings\').focus();">' . esc_html__('Front Page Block Title', 'viral-pro') . '</a>',
        '<a href="javascript:wp.customize.section(\'viral_pro_frontpage_settings\').focus();">' . esc_html__('Front Page Post Title', 'viral-pro') . '</a>',
        '<a href="javascript:wp.customize.section(\'viral_pro_layout_options_section\').focus();">' . esc_html__('Sidebar Widget Title', 'viral-pro') . '</a>',
    )
)));

$wp_customize->add_section(new Viral_Pro_Upgrade_Section($wp_customize, 'viral-pro-hcfu-section', array(
    'title' => esc_html__('Want To Use Custom Fonts?', 'viral-pro'),
    'panel' => 'viral_pro_typography_panel',
    'priority' => 1001,
    'class' => 'ht--boxed',
    'options' => array(
        esc_html__('Upload custom fonts. The uploaded font will display in the typography font family list.', 'viral-pro'),
    ),
    'upgrade_text' => esc_html__('Purchase Custom Font Uploader', 'viral-pro'),
    'upgrade_url' => 'https://hashthemes.com/downloads/hash-custom-font-uploader/',
    'active_callback' => 'viral_pro_check_cfu'
)));
