<?php

$customizer_home_settings = of_get_option('customizer_home_settings', '1');
if (!$customizer_home_settings) {
    return;
}

/**
 * Viral Pro Theme Customizer
 *
 * @package Viral Pro
 */
/* ============FRONT PAGE PANEL============ */
$wp_customize->add_panel('viral_pro_front_page_panel', array(
    'title' => __('Front Page Sections', 'viral-pro'),
    'description' => esc_html__('Drag and Drop to Reorder', 'viral-pro') . '<img class="viral-pro-drag-spinner" src="' . admin_url('/images/spinner.gif') . '">',
    'priority' => 20
));

$wp_customize->add_section(new Viral_Pro_Upgrade_Section($wp_customize, 'viral-pro-frontpage-notice', array(
    'title' => sprintf(esc_html('Important! Front Page Sections are not enabled. Enable it %1shere%2s.', 'viral-pro'), '<a href="javascript:wp.customize.section( \'static_front_page\' ).focus()">', '</a>'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => -99,
    'active_callback' => 'viral_pro_check_frontpage'
)));

/* ============FRONT PAGE TICKER SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_ticker_section', array(
    'title' => esc_html__('Ticker Module', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_ticker_section'),
    'hiding_control' => 'viral_pro_frontpage_ticker_sec_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_ticker_sec_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_ticker_sec_disable', array(
    'section' => 'viral_pro_frontpage_ticker_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_ticker_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_ticker_nav', array(
    'section' => 'viral_pro_frontpage_ticker_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_ticker_title',
                'viral_pro_ticker_category',
                'viral_pro_ticker_post_count',
                'viral_pro_ticker_style',
                'viral_pro_ticker_icon',
                'viral_pro_ticker_animation',
                'viral_pro_ticker_pause',
                'viral_pro_ticker_widget_heading',
                'viral_pro_ticker_top_widget',
                'viral_pro_ticker_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_ticker_cs_heading',
                'viral_pro_ticker_title_color',
                'viral_pro_ticker_text_color',
                'viral_pro_ticker_link_color',
                'viral_pro_ticker_block_color_seperator',
                'viral_pro_ticker_overwrite_block_title_color',
                'viral_pro_ticker_block_title_color',
                'viral_pro_ticker_block_title_background_color',
                'viral_pro_ticker_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_ticker_enable_fullwindow',
                'viral_pro_ticker_align_item',
                'viral_pro_ticker_fw_seperator',
                'viral_pro_ticker_bg_type',
                'viral_pro_ticker_bg_color',
                'viral_pro_ticker_bg_gradient',
                'viral_pro_ticker_bg_image',
                'viral_pro_ticker_parallax_effect',
                'viral_pro_ticker_bg_video',
                'viral_pro_ticker_overlay_color',
                'viral_pro_ticker_cs_seperator',
                'viral_pro_ticker_padding',
                'viral_pro_ticker_margin',
                'viral_pro_ticker_seperator0',
                'viral_pro_ticker_section_seperator',
                'viral_pro_ticker_seperator1',
                'viral_pro_ticker_top_seperator',
                'viral_pro_ticker_ts_color',
                'viral_pro_ticker_ts_height',
                'viral_pro_ticker_seperator2',
                'viral_pro_ticker_bottom_seperator',
                'viral_pro_ticker_bs_color',
                'viral_pro_ticker_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_ticker_title', array(
    'default' => __('Breaking News', 'viral-pro'),
    'transport' => 'postMessage',
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control('viral_pro_ticker_title', array(
    'settings' => 'viral_pro_ticker_title',
    'section' => 'viral_pro_frontpage_ticker_section',
    'label' => __('Ticker Title', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_ticker_category', array(
    'default' => '-1',
    'transport' => 'postMessage',
    'sanitize_callback' => 'viral_pro_sanitize_integer'
));

$wp_customize->add_control('viral_pro_ticker_category', array(
    'section' => 'viral_pro_frontpage_ticker_section',
    'type' => 'select',
    'label' => __('Choose Ticker Category', 'viral-pro'),
    'choices' => viral_pro_cat(true)
));

$wp_customize->add_setting('viral_pro_ticker_post_count', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage',
    'default' => 5
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_ticker_post_count', array(
    'section' => 'viral_pro_frontpage_ticker_section',
    'label' => esc_html__('No of Posts', 'viral-pro'),
    'input_attrs' => array(
        'min' => 1,
        'max' => 20,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_ticker_icon', array(
    'default' => 'icon_target',
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Icon_Selector_Control($wp_customize, 'viral_pro_ticker_icon', array(
    'settings' => 'viral_pro_ticker_icon',
    'section' => 'viral_pro_frontpage_ticker_section',
    'label' => __('Choose Ticker Icon', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_ticker_animation', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'flip-top-bottom',
    'transport' => 'postMessage',
));

$wp_customize->add_control('viral_pro_ticker_animation', array(
    'section' => 'viral_pro_frontpage_ticker_section',
    'type' => 'select',
    'label' => esc_html__('Ticker Animation Style', 'viral-pro'),
    'choices' => array(
        'left-right' => esc_html__('Slide Left To Right', 'viral-pro'),
        'top-bottom' => esc_html__('Slide Top To Bottom', 'viral-pro'),
        'flip-top-bottom' => esc_html__('Flip Top To Bottom', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_ticker_pause', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage',
    'default' => 5
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_ticker_pause', array(
    'section' => 'viral_pro_frontpage_ticker_section',
    'label' => esc_html__('Ticker Pause Duration(Seconds)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 2,
        'max' => 20,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_ticker_style', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'style1',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_ticker_style', array(
    'section' => 'viral_pro_frontpage_ticker_section',
    'label' => esc_html__('Ticker Style', 'viral-pro'),
    'class' => 'ht--full-width',
    'options' => array(
        'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/ticker/style1.png',
        'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/ticker/style2.png',
        'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/ticker/style3.png',
        'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/ticker/style4.png',
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_title", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_category", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_post_count", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_style", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_icon", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_animation", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_pause", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_top_widget", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_ticker_bottom_widget", array(
    'selector' => ".ht-ticker-container",
    'render_callback' => "viral_pro_frontpage_ticker_content",
    'container_inclusive' => false
));


/* ============MINI NEWS MODULE============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_mininews_section', array(
    'title' => esc_html__('Mini News Module', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_mininews_section'),
    'hiding_control' => 'viral_pro_frontpage_mininews_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_mininews_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_mininews_section_disable', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_mininews_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_mininews_nav', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_mininews_cat',
                'viral_pro_mininews_display_author',
                'viral_pro_mininews_display_cat',
                'viral_pro_mininews_display_date',
                'viral_pro_mininews_post_count_big',
                'viral_pro_mininews_post_count',
                'viral_pro_mininews_fullwidth',
                'viral_pro_mininews_style',
                'viral_pro_mininews_image_size',
                'viral_pro_mininews_widget_heading',
                'viral_pro_mininews_top_widget',
                'viral_pro_mininews_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_mininews_cs_heading',
                'viral_pro_mininews_title_color',
                'viral_pro_mininews_text_color',
                'viral_pro_mininews_link_color',
                'viral_pro_mininews_block_color_seperator',
                'viral_pro_mininews_overwrite_block_title_color',
                'viral_pro_mininews_block_title_color',
                'viral_pro_mininews_block_title_background_color',
                'viral_pro_mininews_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_mininews_enable_fullwindow',
                'viral_pro_mininews_align_item',
                'viral_pro_mininews_fw_seperator',
                'viral_pro_mininews_bg_type',
                'viral_pro_mininews_bg_color',
                'viral_pro_mininews_bg_gradient',
                'viral_pro_mininews_bg_image',
                'viral_pro_mininews_parallax_effect',
                'viral_pro_mininews_bg_video',
                'viral_pro_mininews_overlay_color',
                'viral_pro_mininews_cs_seperator',
                'viral_pro_mininews_padding',
                'viral_pro_mininews_margin',
                'viral_pro_mininews_seperator0',
                'viral_pro_mininews_section_seperator',
                'viral_pro_mininews_seperator1',
                'viral_pro_mininews_top_seperator',
                'viral_pro_mininews_ts_color',
                'viral_pro_mininews_ts_height',
                'viral_pro_mininews_seperator2',
                'viral_pro_mininews_bottom_seperator',
                'viral_pro_mininews_bs_color',
                'viral_pro_mininews_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_mininews_cat', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
));

$wp_customize->add_control(new Viral_Pro_Multiple_Checkbox_Control($wp_customize, 'viral_pro_mininews_cat', array(
    'label' => esc_html__('Select Category', 'viral-pro'),
    'section' => 'viral_pro_frontpage_mininews_section',
    'choices' => viral_pro_cat(),
    'description' => esc_html__('All latest post will display if no category is selected', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mininews_display_cat', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_mininews_display_cat', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'label' => esc_html__('Display Category', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mininews_display_author', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_mininews_display_author', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'label' => esc_html__('Display Author', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mininews_display_date', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_mininews_display_date', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'label' => esc_html__('Display Date', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mininews_fullwidth', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => false
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_mininews_fullwidth', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'label' => esc_html__('Enable Full Width', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_mininews_post_count_big', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage',
    'default' => 5
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_mininews_post_count_big', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'label' => esc_html__('No of Posts In Bigger Screen', 'viral-pro'),
    'description' => esc_html__('Displays in the screen bigger than 1400px', 'viral-pro'),
    'input_attrs' => array(
        'min' => 4,
        'max' => 10,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_mininews_post_count', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage',
    'default' => 3
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_mininews_post_count', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'label' => esc_html__('No of Posts', 'viral-pro'),
    'description' => esc_html__('Displays in the screen smaller than 1400px', 'viral-pro'),
    'input_attrs' => array(
        'min' => 2,
        'max' => 6,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_mininews_style', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'style1',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_mininews_style', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'label' => esc_html__('Mini News Style', 'viral-pro'),
    'class' => 'ht--full-width',
    'options' => array(
        'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/mini-news/style1.png',
        'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/mini-news/style2.png'
    )
)));

$wp_customize->add_setting('viral_pro_mininews_image_size', array(
    'default' => 'viral-pro-150x150',
    'transport' => 'postMessage',
    'sanitize_callback' => 'viral_pro_sanitize_choices'
));

$wp_customize->add_control('viral_pro_mininews_image_size', array(
    'section' => 'viral_pro_frontpage_mininews_section',
    'type' => 'select',
    'label' => esc_html__('Image Size', 'viral-pro'),
    'choices' => viral_pro_get_image_sizes()
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_fullwidth", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_cat", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_display_cat", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_display_author", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_display_date", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_post_count_big", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_post_count", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_style", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_top_widget", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_bottom_widget", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_mininews_image_size", array(
    'selector' => ".ht-mininews-container",
    'render_callback' => "viral_pro_frontpage_mininews_content",
    'container_inclusive' => false
));

/* ============FRONT PAGE SLIDER SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_slider1_section', array(
    'title' => esc_html__('Slider Module One', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_slider1_section'),
    'hiding_control' => 'viral_pro_frontpage_slider1_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_slider1_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_slider1_section_disable', array(
    'section' => 'viral_pro_frontpage_slider1_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));


$wp_customize->add_setting('viral_pro_frontpage_slider1_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_slider1_nav', array(
    'section' => 'viral_pro_frontpage_slider1_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_slider1_blocks',
                'viral_pro_slider1_widget_heading',
                'viral_pro_slider1_top_widget',
                'viral_pro_slider1_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_slider1_cs_heading',
                'viral_pro_slider1_title_color',
                'viral_pro_slider1_text_color',
                'viral_pro_slider1_link_color',
                'viral_pro_slider1_block_color_seperator',
                'viral_pro_slider1_overwrite_block_title_color',
                'viral_pro_slider1_block_title_color',
                'viral_pro_slider1_block_title_background_color',
                'viral_pro_slider1_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_slider1_enable_fullwindow',
                'viral_pro_slider1_align_item',
                'viral_pro_slider1_fw_seperator',
                'viral_pro_slider1_bg_type',
                'viral_pro_slider1_bg_color',
                'viral_pro_slider1_bg_gradient',
                'viral_pro_slider1_bg_image',
                'viral_pro_slider1_parallax_effect',
                'viral_pro_slider1_bg_video',
                'viral_pro_slider1_overlay_color',
                'viral_pro_slider1_cs_seperator',
                'viral_pro_slider1_padding',
                'viral_pro_slider1_margin',
                'viral_pro_slider1_seperator0',
                'viral_pro_slider1_section_seperator',
                'viral_pro_slider1_seperator1',
                'viral_pro_slider1_top_seperator',
                'viral_pro_slider1_ts_color',
                'viral_pro_slider1_ts_height',
                'viral_pro_slider1_seperator2',
                'viral_pro_slider1_bottom_seperator',
                'viral_pro_slider1_bs_color',
                'viral_pro_slider1_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_slider1_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'post_count' => 5,
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_slider1_blocks', array(
    'label' => __('Slider Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_slider1_section',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/slider/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/slider/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/slider/style3.png',
            'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/slider/style4.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Categories', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'post_count' => array(
        'type' => 'range',
        'label' => __('No of Posts', 'viral-pro'),
        'options' => array(
            'val' => 5,
            'min' => 1,
            'max' => 20,
            'step' => 1,
            'unit' => ''
        )
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_slider1_blocks", array(
    'selector' => ".ht-slider1-container",
    'render_callback' => "viral_pro_frontpage_slider1_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_slider1_top_widget", array(
    'selector' => ".ht-slider1-container",
    'render_callback' => "viral_pro_frontpage_slider1_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_slider1_bottom_widget", array(
    'selector' => ".ht-slider1-container",
    'render_callback' => "viral_pro_frontpage_slider1_content",
    'container_inclusive' => false
));

/* ============FRONT PAGE SLIDER SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_slider2_section', array(
    'title' => esc_html__('Slider Module Two', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_slider2_section'),
    'hiding_control' => 'viral_pro_frontpage_slider2_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_slider2_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_slider2_section_disable', array(
    'section' => 'viral_pro_frontpage_slider2_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));


$wp_customize->add_setting('viral_pro_frontpage_slider2_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_slider2_nav', array(
    'section' => 'viral_pro_frontpage_slider2_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_slider2_blocks',
                'viral_pro_slider2_widget_heading',
                'viral_pro_slider2_top_widget',
                'viral_pro_slider2_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_slider2_cs_heading',
                'viral_pro_slider2_title_color',
                'viral_pro_slider2_text_color',
                'viral_pro_slider2_link_color',
                'viral_pro_slider2_block_color_seperator',
                'viral_pro_slider2_overwrite_block_title_color',
                'viral_pro_slider2_block_title_color',
                'viral_pro_slider2_block_title_background_color',
                'viral_pro_slider2_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_slider2_enable_fullwindow',
                'viral_pro_slider2_align_item',
                'viral_pro_slider2_fw_seperator',
                'viral_pro_slider2_bg_type',
                'viral_pro_slider2_bg_color',
                'viral_pro_slider2_bg_gradient',
                'viral_pro_slider2_bg_image',
                'viral_pro_slider2_parallax_effect',
                'viral_pro_slider2_bg_video',
                'viral_pro_slider2_overlay_color',
                'viral_pro_slider2_cs_seperator',
                'viral_pro_slider2_padding',
                'viral_pro_slider2_margin',
                'viral_pro_slider2_seperator0',
                'viral_pro_slider2_section_seperator',
                'viral_pro_slider2_seperator1',
                'viral_pro_slider2_top_seperator',
                'viral_pro_slider2_ts_color',
                'viral_pro_slider2_ts_height',
                'viral_pro_slider2_seperator2',
                'viral_pro_slider2_bottom_seperator',
                'viral_pro_slider2_bs_color',
                'viral_pro_slider2_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_slider2_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'post_count' => 5,
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_slider2_blocks', array(
    'label' => __('Slider Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_slider2_section',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/slider/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/slider/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/slider/style3.png',
            'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/slider/style4.png'
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Categories', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'post_count' => array(
        'type' => 'range',
        'label' => __('No of Posts', 'viral-pro'),
        'options' => array(
            'val' => 5,
            'min' => 1,
            'max' => 20,
            'step' => 1,
            'unit' => ''
        )
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_slider2_blocks", array(
    'selector' => ".ht-slider2-container",
    'render_callback' => "viral_pro_frontpage_slider2_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_slider2_top_widget", array(
    'selector' => ".ht-slider2-container",
    'render_callback' => "viral_pro_frontpage_slider2_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_slider2_bottom_widget", array(
    'selector' => ".ht-slider2-container",
    'render_callback' => "viral_pro_frontpage_slider2_content",
    'container_inclusive' => false
));

/* ============FRONT FEATURED SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_featured_section', array(
    'title' => esc_html__('Featured Image Module', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_featured_section'),
    'hiding_control' => 'viral_pro_frontpage_featured_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_featured_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_featured_section_disable', array(
    'section' => 'viral_pro_frontpage_featured_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));


$wp_customize->add_setting('viral_pro_frontpage_featured_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_featured_nav', array(
    'section' => 'viral_pro_frontpage_featured_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_featured_blocks',
                'viral_pro_featured_setting_heading',
                'viral_pro_featured_image_size',
                'viral_pro_featured_column',
                'viral_pro_featured_style',
                'viral_pro_featured_widget_heading',
                'viral_pro_featured_top_widget',
                'viral_pro_featured_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_featured_cs_heading',
                'viral_pro_featured_title_color',
                'viral_pro_featured_text_color',
                'viral_pro_featured_link_color',
                'viral_pro_featured_block_color_seperator',
                'viral_pro_featured_overwrite_block_title_color',
                'viral_pro_featured_block_title_color',
                'viral_pro_featured_block_title_background_color',
                'viral_pro_featured_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_featured_enable_fullwindow',
                'viral_pro_featured_align_item',
                'viral_pro_featured_fw_seperator',
                'viral_pro_featured_bg_type',
                'viral_pro_featured_bg_color',
                'viral_pro_featured_bg_gradient',
                'viral_pro_featured_bg_image',
                'viral_pro_featured_parallax_effect',
                'viral_pro_featured_bg_video',
                'viral_pro_featured_overlay_color',
                'viral_pro_featured_cs_seperator',
                'viral_pro_featured_padding',
                'viral_pro_featured_margin',
                'viral_pro_featured_seperator0',
                'viral_pro_featured_section_seperator',
                'viral_pro_featured_seperator1',
                'viral_pro_featured_top_seperator',
                'viral_pro_featured_ts_color',
                'viral_pro_featured_ts_height',
                'viral_pro_featured_seperator2',
                'viral_pro_featured_bottom_seperator',
                'viral_pro_featured_bs_color',
                'viral_pro_featured_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_featured_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'image' => '',
            'title' => '',
            'link' => '',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_featured_blocks', array(
    'label' => __('Featured Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_featured_section',
    'box_label' => __('Featured Block', 'viral-pro'),
    'add_label' => __('Add Block', 'viral-pro'),
        ), array(
    'image' => array(
        'type' => 'upload',
        'label' => esc_html__('Upload Image', 'viral-pro'),
        'default' => ''
    ),
    'title' => array(
        'type' => 'text',
        'label' => esc_html__('Title', 'viral-pro'),
        'default' => ''
    ),
    'link' => array(
        'type' => 'text',
        'label' => esc_html__('Link', 'viral-pro'),
        'default' => ''
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Block', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->add_setting('viral_pro_featured_setting_heading', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, 'viral_pro_featured_setting_heading', array(
    'section' => 'viral_pro_frontpage_featured_section',
    'label' => esc_html__('Settings', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_featured_image_size', array(
    'default' => 'viral-pro-650x500',
    'transport' => 'postMessage',
    'sanitize_callback' => 'viral_pro_sanitize_choices'
));

$wp_customize->add_control('viral_pro_featured_image_size', array(
    'section' => 'viral_pro_frontpage_featured_section',
    'type' => 'select',
    'label' => esc_html__('Image Size', 'viral-pro'),
    'choices' => viral_pro_get_image_sizes()
));

$wp_customize->add_setting('viral_pro_featured_column', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage',
    'default' => 3
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_featured_column', array(
    'section' => 'viral_pro_frontpage_featured_section',
    'label' => esc_html__('No of Columns', 'viral-pro'),
    'input_attrs' => array(
        'min' => 2,
        'max' => 4,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_featured_style', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'style1',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_featured_style', array(
    'section' => 'viral_pro_frontpage_featured_section',
    'label' => esc_html__('Featured Module Style', 'viral-pro'),
    'options' => array(
        'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/featured/style1.png',
        'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/featured/style2.png'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_featured_blocks", array(
    'selector' => ".ht-featured-container",
    'render_callback' => "viral_pro_frontpage_featured_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_featured_image_size", array(
    'selector' => ".ht-featured-container",
    'render_callback' => "viral_pro_frontpage_featured_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_featured_column", array(
    'selector' => ".ht-featured-container",
    'render_callback' => "viral_pro_frontpage_featured_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_featured_style", array(
    'selector' => ".ht-featured-container",
    'render_callback' => "viral_pro_frontpage_featured_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_featured_top_widget", array(
    'selector' => ".ht-featured-container",
    'render_callback' => "viral_pro_frontpage_featured_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_featured_bottom_widget", array(
    'selector' => ".ht-featured-container",
    'render_callback' => "viral_pro_frontpage_featured_content",
    'container_inclusive' => false
));

/* ============FRONT PAGE TILE SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_tile1_section', array(
    'title' => esc_html__('Tile Module One', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_tile1_section'),
    'hiding_control' => 'viral_pro_frontpage_tile1_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_tile1_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_tile1_section_disable', array(
    'section' => 'viral_pro_frontpage_tile1_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_tile1_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_tile1_nav', array(
    'section' => 'viral_pro_frontpage_tile1_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_tile1_blocks',
                'viral_pro_tile1_widget_heading',
                'viral_pro_tile1_top_widget',
                'viral_pro_tile1_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_tile1_cs_heading',
                'viral_pro_tile1_title_color',
                'viral_pro_tile1_text_color',
                'viral_pro_tile1_link_color',
                'viral_pro_tile1_block_color_seperator',
                'viral_pro_tile1_overwrite_block_title_color',
                'viral_pro_tile1_block_title_color',
                'viral_pro_tile1_block_title_background_color',
                'viral_pro_tile1_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_tile1_enable_fullwindow',
                'viral_pro_tile1_align_item',
                'viral_pro_tile1_fw_seperator',
                'viral_pro_tile1_bg_type',
                'viral_pro_tile1_bg_color',
                'viral_pro_tile1_bg_gradient',
                'viral_pro_tile1_bg_image',
                'viral_pro_tile1_parallax_effect',
                'viral_pro_tile1_bg_video',
                'viral_pro_tile1_overlay_color',
                'viral_pro_tile1_cs_seperator',
                'viral_pro_tile1_padding',
                'viral_pro_tile1_margin',
                'viral_pro_tile1_seperator0',
                'viral_pro_tile1_section_seperator',
                'viral_pro_tile1_seperator1',
                'viral_pro_tile1_top_seperator',
                'viral_pro_tile1_ts_color',
                'viral_pro_tile1_ts_height',
                'viral_pro_tile1_seperator2',
                'viral_pro_tile1_bottom_seperator',
                'viral_pro_tile1_bs_color',
                'viral_pro_tile1_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_tile1_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'enable' => 'on',
            'gap' => 'space-0'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_tile1_blocks', array(
    'label' => __('Tile Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_tile1_section',
    'settings' => 'viral_pro_frontpage_tile1_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style3.png',
            'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style4.png',
            'style5' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style5.png',
            'style6' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style6.png',
            'style7' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style7.png',
            'style8' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style8.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Categories', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'gap' => array(
        'type' => 'select',
        'label' => __('Space Between Thumbs', 'viral-pro'),
        'options' => array(
            'space-0' => __('No Space', 'viral-pro'),
            'space-5' => __('5px', 'viral-pro'),
            'space-10' => __('10px', 'viral-pro'),
            'space-20' => __('20px', 'viral-pro'),
            'space-30' => __('30px', 'viral-pro')
        ),
        'default' => 'space-0'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_tile1_blocks", array(
    'selector' => ".ht-tile1-container",
    'render_callback' => "viral_pro_frontpage_tile1_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_tile1_top_widget", array(
    'selector' => ".ht-tile1-container",
    'render_callback' => "viral_pro_frontpage_tile1_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_tile1_bottom_widget", array(
    'selector' => ".ht-tile1-container",
    'render_callback' => "viral_pro_frontpage_tile1_content",
    'container_inclusive' => false
));

/* ============FRONT PAGE TILE SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_tile2_section', array(
    'title' => esc_html__('Tile Module Two', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_tile2_section'),
    'hiding_control' => 'viral_pro_frontpage_tile2_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_tile2_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_tile2_section_disable', array(
    'section' => 'viral_pro_frontpage_tile2_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_tile2_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_tile2_nav', array(
    'section' => 'viral_pro_frontpage_tile2_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_tile2_blocks',
                'viral_pro_tile2_widget_heading',
                'viral_pro_tile2_top_widget',
                'viral_pro_tile2_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_tile2_cs_heading',
                'viral_pro_tile2_title_color',
                'viral_pro_tile2_text_color',
                'viral_pro_tile2_link_color',
                'viral_pro_tile2_block_color_seperator',
                'viral_pro_tile2_overwrite_block_title_color',
                'viral_pro_tile2_block_title_color',
                'viral_pro_tile2_block_title_background_color',
                'viral_pro_tile2_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_tile2_enable_fullwindow',
                'viral_pro_tile2_align_item',
                'viral_pro_tile2_fw_seperator',
                'viral_pro_tile2_bg_type',
                'viral_pro_tile2_bg_color',
                'viral_pro_tile2_bg_gradient',
                'viral_pro_tile2_bg_image',
                'viral_pro_tile2_parallax_effect',
                'viral_pro_tile2_bg_video',
                'viral_pro_tile2_overlay_color',
                'viral_pro_tile2_cs_seperator',
                'viral_pro_tile2_padding',
                'viral_pro_tile2_margin',
                'viral_pro_tile2_seperator0',
                'viral_pro_tile2_section_seperator',
                'viral_pro_tile2_seperator1',
                'viral_pro_tile2_top_seperator',
                'viral_pro_tile2_ts_color',
                'viral_pro_tile2_ts_height',
                'viral_pro_tile2_seperator2',
                'viral_pro_tile2_bottom_seperator',
                'viral_pro_tile2_bs_color',
                'viral_pro_tile2_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_tile2_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'enable' => 'on',
            'gap' => 'space-0'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_tile2_blocks', array(
    'label' => __('Tile Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_tile2_section',
    'settings' => 'viral_pro_frontpage_tile2_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style3.png',
            'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style4.png',
            'style5' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style5.png',
            'style6' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style6.png',
            'style7' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style7.png',
            'style8' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/tile/style8.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Categories', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'gap' => array(
        'type' => 'select',
        'label' => __('Space Between Thumbs', 'viral-pro'),
        'options' => array(
            'space-0' => __('No Space', 'viral-pro'),
            'space-5' => __('5px', 'viral-pro'),
            'space-10' => __('10px', 'viral-pro'),
            'space-20' => __('20px', 'viral-pro'),
            'space-30' => __('30px', 'viral-pro')
        ),
        'default' => 'space-0'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_tile2_blocks", array(
    'selector' => ".ht-tile2-container",
    'render_callback' => "viral_pro_frontpage_tile2_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_tile2_top_widget", array(
    'selector' => ".ht-tile2-container",
    'render_callback' => "viral_pro_frontpage_tile2_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_tile2_bottom_widget", array(
    'selector' => ".ht-tile2-container",
    'render_callback' => "viral_pro_frontpage_tile2_content",
    'container_inclusive' => false
));

/* ============FRONT PAGE NEWS SECTION - RIGHT SIDEBAR============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_leftnews_section', array(
    'title' => esc_html__('News Module - Right Sidebar', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_leftnews_section'),
    'hiding_control' => 'viral_pro_frontpage_leftnews_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_leftnews_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_leftnews_section_disable', array(
    'section' => 'viral_pro_frontpage_leftnews_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));


$wp_customize->add_setting('viral_pro_frontpage_leftnews_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_leftnews_nav', array(
    'section' => 'viral_pro_frontpage_leftnews_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_leftnews_sticky_sidebar',
                'viral_pro_frontpage_leftnews_blocks',
                'viral_pro_leftnews_widget_heading',
                'viral_pro_leftnews_top_widget',
                'viral_pro_leftnews_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_leftnews_cs_heading',
                'viral_pro_leftnews_title_color',
                'viral_pro_leftnews_text_color',
                'viral_pro_leftnews_link_color',
                'viral_pro_leftnews_block_color_seperator',
                'viral_pro_leftnews_overwrite_block_title_color',
                'viral_pro_leftnews_block_title_color',
                'viral_pro_leftnews_block_title_background_color',
                'viral_pro_leftnews_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_leftnews_enable_fullwindow',
                'viral_pro_leftnews_align_item',
                'viral_pro_leftnews_fw_seperator',
                'viral_pro_leftnews_bg_type',
                'viral_pro_leftnews_bg_color',
                'viral_pro_leftnews_bg_gradient',
                'viral_pro_leftnews_bg_image',
                'viral_pro_leftnews_parallax_effect',
                'viral_pro_leftnews_bg_video',
                'viral_pro_leftnews_overlay_color',
                'viral_pro_leftnews_cs_seperator',
                'viral_pro_leftnews_padding',
                'viral_pro_leftnews_margin',
                'viral_pro_leftnews_seperator0',
                'viral_pro_leftnews_section_seperator',
                'viral_pro_leftnews_seperator1',
                'viral_pro_leftnews_top_seperator',
                'viral_pro_leftnews_ts_color',
                'viral_pro_leftnews_ts_height',
                'viral_pro_leftnews_seperator2',
                'viral_pro_leftnews_bottom_seperator',
                'viral_pro_leftnews_bs_color',
                'viral_pro_leftnews_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_leftnews_sticky_sidebar', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_frontpage_leftnews_sticky_sidebar', array(
    'section' => 'viral_pro_frontpage_leftnews_section',
    'label' => esc_html__('Sticky Sidebar', 'viral-pro'),
    'description' => esc_html__('A sidebar will stick at the top on scrolling down', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_frontpage_leftnews_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => __('Title', 'viral-pro'),
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_leftnews_blocks', array(
    'label' => __('News Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_leftnews_section',
    'settings' => 'viral_pro_frontpage_leftnews_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'default' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'class' => 'ht--one-third-width',
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style3.png',
            'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style4.png',
            'style5' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style5.png',
            'style6' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style6.png',
            'style7' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style7.png',
            'style8' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style8.png',
            'style9' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style9.png',
            'style10' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style10.png',
            'style11' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style11.png',
            'style12' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style12.png',
            'style13' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style13.png',
            'style14' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style14.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Category', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => esc_attr__('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_leftnews_blocks", array(
    'selector' => ".ht-leftnews-container",
    'render_callback' => "viral_pro_frontpage_leftnews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_leftnews_sticky_sidebar", array(
    'selector' => ".ht-leftnews-section",
    'render_callback' => "viral_pro_frontpage_leftnews_section",
    'container_inclusive' => true
));

$wp_customize->selective_refresh->add_partial("viral_pro_leftnews_top_widget", array(
    'selector' => ".ht-leftnews-section",
    'render_callback' => "viral_pro_frontpage_leftnews_section",
    'container_inclusive' => true
));

$wp_customize->selective_refresh->add_partial("viral_pro_leftnews_bottom_widget", array(
    'selector' => ".ht-leftnews-section",
    'render_callback' => "viral_pro_frontpage_leftnews_section",
    'container_inclusive' => true
));

/* ============FRONT PAGE NEWS SECTION - LEFT SIDEBAR============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_rightnews_section', array(
    'title' => esc_html__('News Module - Left Sidebar', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_rightnews_section'),
    'hiding_control' => 'viral_pro_frontpage_rightnews_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_rightnews_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_rightnews_section_disable', array(
    'section' => 'viral_pro_frontpage_rightnews_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_rightnews_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_rightnews_nav', array(
    'section' => 'viral_pro_frontpage_rightnews_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_rightnews_sticky_sidebar',
                'viral_pro_frontpage_rightnews_blocks',
                'viral_pro_rightnews_widget_heading',
                'viral_pro_rightnews_top_widget',
                'viral_pro_rightnews_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_rightnews_cs_heading',
                'viral_pro_rightnews_title_color',
                'viral_pro_rightnews_text_color',
                'viral_pro_rightnews_link_color',
                'viral_pro_rightnews_block_color_seperator',
                'viral_pro_rightnews_overwrite_block_title_color',
                'viral_pro_rightnews_block_title_color',
                'viral_pro_rightnews_block_title_background_color',
                'viral_pro_rightnews_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_rightnews_enable_fullwindow',
                'viral_pro_rightnews_align_item',
                'viral_pro_rightnews_fw_seperator',
                'viral_pro_rightnews_bg_type',
                'viral_pro_rightnews_bg_color',
                'viral_pro_rightnews_bg_gradient',
                'viral_pro_rightnews_bg_image',
                'viral_pro_rightnews_parallax_effect',
                'viral_pro_rightnews_bg_video',
                'viral_pro_rightnews_overlay_color',
                'viral_pro_rightnews_cs_seperator',
                'viral_pro_rightnews_padding',
                'viral_pro_rightnews_margin',
                'viral_pro_rightnews_seperator0',
                'viral_pro_rightnews_section_seperator',
                'viral_pro_rightnews_seperator1',
                'viral_pro_rightnews_top_seperator',
                'viral_pro_rightnews_ts_color',
                'viral_pro_rightnews_ts_height',
                'viral_pro_rightnews_seperator2',
                'viral_pro_rightnews_bottom_seperator',
                'viral_pro_rightnews_bs_color',
                'viral_pro_rightnews_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_rightnews_sticky_sidebar', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_frontpage_rightnews_sticky_sidebar', array(
    'section' => 'viral_pro_frontpage_rightnews_section',
    'label' => esc_html__('Sticky Sidebar', 'viral-pro'),
    'description' => esc_html__('A sidebar will stick at the top on scrolling down', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_frontpage_rightnews_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => __('Title', 'viral-pro'),
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_rightnews_blocks', array(
    'label' => __('News Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_rightnews_section',
    'settings' => 'viral_pro_frontpage_rightnews_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'default' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'class' => 'ht--one-third-width',
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style3.png',
            'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style4.png',
            'style5' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style5.png',
            'style6' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style6.png',
            'style7' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style7.png',
            'style8' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style8.png',
            'style9' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style9.png',
            'style10' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style10.png',
            'style11' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style11.png',
            'style12' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style12.png',
            'style13' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style13.png',
            'style14' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/news/style14.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Category', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => esc_attr__('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_rightnews_blocks", array(
    'selector' => ".ht-rightnews-container",
    'render_callback' => "viral_pro_frontpage_rightnews_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_rightnews_sticky_sidebar", array(
    'selector' => ".ht-rightnews-section",
    'render_callback' => "viral_pro_frontpage_rightnews_section",
    'container_inclusive' => true
));

$wp_customize->selective_refresh->add_partial("viral_pro_rightnews_top_widget", array(
    'selector' => ".ht-rightnews-section",
    'render_callback' => "viral_pro_frontpage_rightnews_section",
    'container_inclusive' => true
));

$wp_customize->selective_refresh->add_partial("viral_pro_rightnews_bottom_widget", array(
    'selector' => ".ht-rightnews-section",
    'render_callback' => "viral_pro_frontpage_rightnews_section",
    'container_inclusive' => true
));

/* ============FRONT PAGE FULL WIDTH CAROUSEL SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_fwcarousel_section', array(
    'title' => esc_html__('Carousel Module - Fullwidth', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_fwcarousel_section'),
    'hiding_control' => 'viral_pro_frontpage_fwcarousel_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_fwcarousel_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_fwcarousel_section_disable', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_fwcarousel_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_fwcarousel_nav', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_fwcarousel_cat',
                'viral_pro_fwcarousel_display_cat',
                'viral_pro_fwcarousel_display_author',
                'viral_pro_fwcarousel_display_date',
                'viral_pro_fwcarousel_slide_count',
                'viral_pro_fwcarousel_post_count',
                'viral_pro_fwcarousel_auto_slide',
                'viral_pro_fwcarousel_slide_pause',
                'viral_pro_fwcarousel_image_size',
                'viral_pro_fwcarousel_title_size',
                'viral_pro_fwcarousel_style',
                'viral_pro_fwcarousel_widget_heading',
                'viral_pro_fwcarousel_top_widget',
                'viral_pro_fwcarousel_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_fwcarousel_cs_heading',
                'viral_pro_fwcarousel_title_color',
                'viral_pro_fwcarousel_text_color',
                'viral_pro_fwcarousel_link_color',
                'viral_pro_fwcarousel_block_color_seperator',
                'viral_pro_fwcarousel_overwrite_block_title_color',
                'viral_pro_fwcarousel_block_title_color',
                'viral_pro_fwcarousel_block_title_background_color',
                'viral_pro_fwcarousel_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_fwcarousel_enable_fullwindow',
                'viral_pro_fwcarousel_align_item',
                'viral_pro_fwcarousel_fw_seperator',
                'viral_pro_fwcarousel_bg_type',
                'viral_pro_fwcarousel_bg_color',
                'viral_pro_fwcarousel_bg_gradient',
                'viral_pro_fwcarousel_bg_image',
                'viral_pro_fwcarousel_parallax_effect',
                'viral_pro_fwcarousel_bg_video',
                'viral_pro_fwcarousel_overlay_color',
                'viral_pro_fwcarousel_cs_seperator',
                'viral_pro_fwcarousel_padding',
                'viral_pro_fwcarousel_margin',
                'viral_pro_fwcarousel_seperator0',
                'viral_pro_fwcarousel_section_seperator',
                'viral_pro_fwcarousel_seperator1',
                'viral_pro_fwcarousel_top_seperator',
                'viral_pro_fwcarousel_ts_color',
                'viral_pro_fwcarousel_ts_height',
                'viral_pro_fwcarousel_seperator2',
                'viral_pro_fwcarousel_bottom_seperator',
                'viral_pro_fwcarousel_bs_color',
                'viral_pro_fwcarousel_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_fwcarousel_cat', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
));

$wp_customize->add_control(new Viral_Pro_Multiple_Checkbox_Control($wp_customize, 'viral_pro_fwcarousel_cat', array(
    'label' => esc_html__('Select Category', 'viral-pro'),
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'choices' => viral_pro_cat(),
    'description' => esc_html__('All latest post will display if no category is selected', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_fwcarousel_display_cat', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_fwcarousel_display_cat', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('Display Category', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_fwcarousel_display_author', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_fwcarousel_display_author', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('Display Author', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_fwcarousel_display_date', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_fwcarousel_display_date', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('Display Date', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_fwcarousel_post_count', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage',
    'default' => 5
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_fwcarousel_post_count', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('No of Posts', 'viral-pro'),
    'input_attrs' => array(
        'min' => 2,
        'max' => 20,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_fwcarousel_slide_count', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage',
    'default' => 3
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_fwcarousel_slide_count', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('No of Slides', 'viral-pro'),
    'input_attrs' => array(
        'min' => 2,
        'max' => 6,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_fwcarousel_slide_pause', array(
    'sanitize_callback' => 'absint',
    'transport' => 'postMessage',
    'default' => 5
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_fwcarousel_slide_pause', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('Slides Pause Duration(Seconds)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 1,
        'max' => 20,
        'step' => 1
    ),
)));

$wp_customize->add_setting('viral_pro_fwcarousel_auto_slide', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_fwcarousel_auto_slide', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('Auto Slide', 'viral-pro'),
    'description' => esc_html__('Move Slide Automatically', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_fwcarousel_image_size', array(
    'default' => 'viral-pro-500x500',
    'transport' => 'postMessage',
    'sanitize_callback' => 'viral_pro_sanitize_choices'
));

$wp_customize->add_control('viral_pro_fwcarousel_image_size', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'type' => 'select',
    'label' => esc_html__('Image Size', 'viral-pro'),
    'choices' => viral_pro_get_image_sizes()
));

$wp_customize->add_setting('viral_pro_fwcarousel_title_size', array(
    'default' => 'vl-mid-title',
    'transport' => 'postMessage',
    'sanitize_callback' => 'viral_pro_sanitize_choices'
));

$wp_customize->add_control('viral_pro_fwcarousel_title_size', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'type' => 'select',
    'label' => esc_html__('Title Font Size', 'viral-pro'),
    'choices' => array(
        'vl-small-title' => esc_html__('Normal', 'viral-pro'),
        'vl-mid-title' => esc_html__('Medium', 'viral-pro'),
        'vl-big-title' => esc_html__('Big', 'viral-pro'),
    )
));

$wp_customize->add_setting('viral_pro_fwcarousel_style', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'style1',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_fwcarousel_style', array(
    'section' => 'viral_pro_frontpage_fwcarousel_section',
    'label' => esc_html__('Carousel Style', 'viral-pro'),
    'options' => array(
        'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-carousel/style1.png',
        'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-carousel/style2.png'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_cat", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_display_cat", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_display_author", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_display_date", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_slide_count", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_post_count", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_auto_slide", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_slide_pause", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_image_size", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_title_size", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_style", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_top_widget", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwcarousel_bottom_widget", array(
    'selector' => ".ht-fwcarousel-container",
    'render_callback' => "viral_pro_frontpage_fwcarousel_content",
    'container_inclusive' => false
));

/* ============FRONT PAGE CAROUSEL SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_carousel1_section', array(
    'title' => esc_html__('Carousel Module One', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_carousel1_section'),
    'hiding_control' => 'viral_pro_frontpage_carousel1_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_carousel1_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_carousel1_section_disable', array(
    'section' => 'viral_pro_frontpage_carousel1_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_carousel1_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_carousel1_nav', array(
    'section' => 'viral_pro_frontpage_carousel1_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_carousel1_blocks',
                'viral_pro_carousel1_widget_heading',
                'viral_pro_carousel1_top_widget',
                'viral_pro_carousel1_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_carousel1_cs_heading',
                'viral_pro_carousel1_title_color',
                'viral_pro_carousel1_text_color',
                'viral_pro_carousel1_link_color',
                'viral_pro_carousel1_block_color_seperator',
                'viral_pro_carousel1_overwrite_block_title_color',
                'viral_pro_carousel1_block_title_color',
                'viral_pro_carousel1_block_title_background_color',
                'viral_pro_carousel1_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_carousel1_enable_fullwindow',
                'viral_pro_carousel1_align_item',
                'viral_pro_carousel1_fw_seperator',
                'viral_pro_carousel1_bg_type',
                'viral_pro_carousel1_bg_color',
                'viral_pro_carousel1_bg_gradient',
                'viral_pro_carousel1_bg_image',
                'viral_pro_carousel1_parallax_effect',
                'viral_pro_carousel1_bg_video',
                'viral_pro_carousel1_overlay_color',
                'viral_pro_carousel1_cs_seperator',
                'viral_pro_carousel1_padding',
                'viral_pro_carousel1_margin',
                'viral_pro_carousel1_seperator0',
                'viral_pro_carousel1_section_seperator',
                'viral_pro_carousel1_seperator1',
                'viral_pro_carousel1_top_seperator',
                'viral_pro_carousel1_ts_color',
                'viral_pro_carousel1_ts_height',
                'viral_pro_carousel1_seperator2',
                'viral_pro_carousel1_bottom_seperator',
                'viral_pro_carousel1_bs_color',
                'viral_pro_carousel1_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_carousel1_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'post_count' => 5,
            'slide_count' => 4,
            'slide_pause' => 5,
            'auto_slide' => 'on',
            'image_size' => 'viral-pro-650x500',
            'title_size' => 'vl-small-title',
            'gap' => '20',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_carousel1_blocks', array(
    'label' => __('Carousel Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_carousel1_section',
    'settings' => 'viral_pro_frontpage_carousel1_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/carousel/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/carousel/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/carousel/style3.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Category', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'post_count' => array(
        'type' => 'range',
        'label' => __('No of Posts', 'viral-pro'),
        'options' => array(
            'val' => 5,
            'min' => 2,
            'max' => 20,
            'step' => 1,
            'unit' => ''
        )
    ),
    'slide_count' => array(
        'type' => 'range',
        'label' => __('No of slides', 'viral-pro'),
        'options' => array(
            'val' => 4,
            'min' => 2,
            'max' => 6,
            'step' => 1,
            'unit' => ''
        )
    ),
    'slide_pause' => array(
        'type' => 'range',
        'label' => __('Slides Pause Duration(Seconds)', 'viral-pro'),
        'options' => array(
            'val' => 5,
            'min' => 4,
            'max' => 20,
            'step' => 1,
            'unit' => ''
        )
    ),
    'auto_slide' => array(
        'type' => 'toggle',
        'label' => __('Auto Slide', 'viral-pro'),
        'default' => 'yes'
    ),
    'image_size' => array(
        'type' => 'select',
        'label' => __('Image Size', 'viral-pro'),
        'options' => viral_pro_get_image_sizes(),
        'default' => 'viral-pro-650x500'
    ),
    'title_size' => array(
        'type' => 'select',
        'label' => __('Title Font Size', 'viral-pro'),
        'options' => array(
            'vl-small-title' => esc_html__('Normal', 'viral-pro'),
            'vl-mid-title' => esc_html__('Medium', 'viral-pro'),
            'vl-big-title' => esc_html__('Big', 'viral-pro'),
        ),
        'default' => 'vl-small-title'
    ),
    'gap' => array(
        'type' => 'select',
        'label' => __('Space Between Slides', 'viral-pro'),
        'options' => array(
            '0' => __('No Space', 'viral-pro'),
            '10' => __('10px', 'viral-pro'),
            '20' => __('20px', 'viral-pro'),
            '30' => __('30px', 'viral-pro'),
        ),
        'default' => '20'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_carousel1_blocks", array(
    'selector' => ".ht-carousel1-container",
    'render_callback' => "viral_pro_frontpage_carousel1_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_carousel1_top_widget", array(
    'selector' => ".ht-carousel1-container",
    'render_callback' => "viral_pro_frontpage_carousel1_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_carousel1_bottom_widget", array(
    'selector' => ".ht-carousel1-container",
    'render_callback' => "viral_pro_frontpage_carousel1_content",
    'container_inclusive' => false
));

/* ============FRONT PAGE CAROUSEL SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_carousel2_section', array(
    'title' => esc_html__('Carousel Module Two', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_carousel2_section'),
    'hiding_control' => 'viral_pro_frontpage_carousel2_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_carousel2_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_carousel2_section_disable', array(
    'section' => 'viral_pro_frontpage_carousel2_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_carousel2_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_carousel2_nav', array(
    'section' => 'viral_pro_frontpage_carousel2_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_carousel2_blocks',
                'viral_pro_carousel2_widget_heading',
                'viral_pro_carousel2_top_widget',
                'viral_pro_carousel2_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_carousel2_cs_heading',
                'viral_pro_carousel2_title_color',
                'viral_pro_carousel2_text_color',
                'viral_pro_carousel2_link_color',
                'viral_pro_carousel2_block_color_seperator',
                'viral_pro_carousel2_overwrite_block_title_color',
                'viral_pro_carousel2_block_title_color',
                'viral_pro_carousel2_block_title_background_color',
                'viral_pro_carousel2_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_carousel2_enable_fullwindow',
                'viral_pro_carousel2_align_item',
                'viral_pro_carousel2_fw_seperator',
                'viral_pro_carousel2_bg_type',
                'viral_pro_carousel2_bg_color',
                'viral_pro_carousel2_bg_gradient',
                'viral_pro_carousel2_bg_image',
                'viral_pro_carousel2_parallax_effect',
                'viral_pro_carousel2_bg_video',
                'viral_pro_carousel2_overlay_color',
                'viral_pro_carousel2_cs_seperator',
                'viral_pro_carousel2_padding',
                'viral_pro_carousel2_margin',
                'viral_pro_carousel2_seperator0',
                'viral_pro_carousel2_section_seperator',
                'viral_pro_carousel2_seperator1',
                'viral_pro_carousel2_top_seperator',
                'viral_pro_carousel2_ts_color',
                'viral_pro_carousel2_ts_height',
                'viral_pro_carousel2_seperator2',
                'viral_pro_carousel2_bottom_seperator',
                'viral_pro_carousel2_bs_color',
                'viral_pro_carousel2_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_carousel2_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => '',
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'post_count' => 5,
            'slide_count' => 4,
            'slide_pause' => 5,
            'auto_slide' => 'on',
            'image_size' => 'viral-pro-650x500',
            'title_size' => 'vl-small-title',
            'gap' => '20',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_carousel2_blocks', array(
    'label' => __('Carousel Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_carousel2_section',
    'settings' => 'viral_pro_frontpage_carousel2_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/carousel/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/carousel/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/carousel/style3.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Category', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'post_count' => array(
        'type' => 'range',
        'label' => __('No of Posts', 'viral-pro'),
        'options' => array(
            'val' => 5,
            'min' => 2,
            'max' => 20,
            'step' => 1,
            'unit' => ''
        )
    ),
    'slide_count' => array(
        'type' => 'range',
        'label' => __('No of slides', 'viral-pro'),
        'options' => array(
            'val' => 4,
            'min' => 2,
            'max' => 6,
            'step' => 1,
            'unit' => ''
        )
    ),
    'slide_pause' => array(
        'type' => 'range',
        'label' => __('Slides Pause Duration(Seconds)', 'viral-pro'),
        'options' => array(
            'val' => 5,
            'min' => 4,
            'max' => 20,
            'step' => 1,
            'unit' => ''
        )
    ),
    'auto_slide' => array(
        'type' => 'toggle',
        'label' => __('Auto Slide', 'viral-pro'),
        'default' => 'yes'
    ),
    'image_size' => array(
        'type' => 'select',
        'label' => __('Image Size', 'viral-pro'),
        'options' => viral_pro_get_image_sizes(),
        'default' => 'viral-pro-650x500'
    ),
    'title_size' => array(
        'type' => 'select',
        'label' => __('Title Font Size', 'viral-pro'),
        'options' => array(
            'vl-small-title' => esc_html__('Normal', 'viral-pro'),
            'vl-mid-title' => esc_html__('Medium', 'viral-pro'),
            'vl-big-title' => esc_html__('Big', 'viral-pro'),
        ),
        'default' => 'vl-small-title'
    ),
    'gap' => array(
        'type' => 'select',
        'label' => __('Space Between Slides', 'viral-pro'),
        'options' => array(
            '0' => __('No Space', 'viral-pro'),
            '10' => __('10px', 'viral-pro'),
            '20' => __('20px', 'viral-pro'),
            '30' => __('30px', 'viral-pro'),
        ),
        'default' => '20'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_carousel2_blocks", array(
    'selector' => ".ht-carousel2-container",
    'render_callback' => "viral_pro_frontpage_carousel2_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_carousel2_top_widget", array(
    'selector' => ".ht-carousel2-container",
    'render_callback' => "viral_pro_frontpage_carousel2_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_carousel2_bottom_widget", array(
    'selector' => ".ht-carousel2-container",
    'render_callback' => "viral_pro_frontpage_carousel2_content",
    'container_inclusive' => false
));

/* ============NEWS MODULE SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_fwnews1_section', array(
    'title' => esc_html__('News Module One - Fullwidth', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_fwnews1_section'),
    'hiding_control' => 'viral_pro_frontpage_fwnews1_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_fwnews1_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_fwnews1_section_disable', array(
    'section' => 'viral_pro_frontpage_fwnews1_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_fwnews1_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_fwnews1_nav', array(
    'section' => 'viral_pro_frontpage_fwnews1_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_fwnews1_blocks',
                'viral_pro_fwnews1_widget_heading',
                'viral_pro_fwnews1_top_widget',
                'viral_pro_fwnews1_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_fwnews1_cs_heading',
                'viral_pro_fwnews1_title_color',
                'viral_pro_fwnews1_text_color',
                'viral_pro_fwnews1_link_color',
                'viral_pro_fwnews1_block_color_seperator',
                'viral_pro_fwnews1_overwrite_block_title_color',
                'viral_pro_fwnews1_block_title_color',
                'viral_pro_fwnews1_block_title_background_color',
                'viral_pro_fwnews1_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_fwnews1_enable_fullwindow',
                'viral_pro_fwnews1_align_item',
                'viral_pro_fwnews1_fw_seperator',
                'viral_pro_fwnews1_bg_type',
                'viral_pro_fwnews1_bg_color',
                'viral_pro_fwnews1_bg_gradient',
                'viral_pro_fwnews1_bg_image',
                'viral_pro_fwnews1_parallax_effect',
                'viral_pro_fwnews1_bg_video',
                'viral_pro_fwnews1_overlay_color',
                'viral_pro_fwnews1_cs_seperator',
                'viral_pro_fwnews1_padding',
                'viral_pro_fwnews1_margin',
                'viral_pro_fwnews1_seperator0',
                'viral_pro_fwnews1_section_seperator',
                'viral_pro_fwnews1_seperator1',
                'viral_pro_fwnews1_top_seperator',
                'viral_pro_fwnews1_ts_color',
                'viral_pro_fwnews1_ts_height',
                'viral_pro_fwnews1_seperator2',
                'viral_pro_fwnews1_bottom_seperator',
                'viral_pro_fwnews1_bs_color',
                'viral_pro_fwnews1_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_fwnews1_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => __('Title', 'viral-pro'),
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_fwnews1_blocks', array(
    'label' => __('News Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_fwnews1_section',
    'settings' => 'viral_pro_frontpage_fwnews1_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'default' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style3.png',
            'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style4.png',
            'style5' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style5.png',
            'style6' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style6.png',
            'style7' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style7.png',
            'style8' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style8.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Category', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => esc_attr__('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_fwnews1_blocks", array(
    'selector' => ".ht-fwnews1-container",
    'render_callback' => "viral_pro_frontpage_fwnews1_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwnews1_top_widget", array(
    'selector' => ".ht-fwnews1-container",
    'render_callback' => "viral_pro_frontpage_fwnews1_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwnews1_bottom_widget", array(
    'selector' => ".ht-fwnews1-container",
    'render_callback' => "viral_pro_frontpage_fwnews1_content",
    'container_inclusive' => false
));

/* ============NEWS MODULE SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_fwnews2_section', array(
    'title' => esc_html__('News Module Two - Fullwidth', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_fwnews2_section'),
    'hiding_control' => 'viral_pro_frontpage_fwnews2_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_fwnews2_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_fwnews2_section_disable', array(
    'section' => 'viral_pro_frontpage_fwnews2_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_fwnews2_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_fwnews2_nav', array(
    'section' => 'viral_pro_frontpage_fwnews2_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_fwnews2_blocks',
                'viral_pro_fwnews2_widget_heading',
                'viral_pro_fwnews2_top_widget',
                'viral_pro_fwnews2_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_fwnews2_cs_heading',
                'viral_pro_fwnews2_title_color',
                'viral_pro_fwnews2_text_color',
                'viral_pro_fwnews2_link_color',
                'viral_pro_fwnews2_block_color_seperator',
                'viral_pro_fwnews2_overwrite_block_title_color',
                'viral_pro_fwnews2_block_title_color',
                'viral_pro_fwnews2_block_title_background_color',
                'viral_pro_fwnews2_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_fwnews2_enable_fullwindow',
                'viral_pro_fwnews2_align_item',
                'viral_pro_fwnews2_fw_seperator',
                'viral_pro_fwnews2_bg_type',
                'viral_pro_fwnews2_bg_color',
                'viral_pro_fwnews2_bg_gradient',
                'viral_pro_fwnews2_bg_image',
                'viral_pro_fwnews2_parallax_effect',
                'viral_pro_fwnews2_bg_video',
                'viral_pro_fwnews2_overlay_color',
                'viral_pro_fwnews2_cs_seperator',
                'viral_pro_fwnews2_padding',
                'viral_pro_fwnews2_margin',
                'viral_pro_fwnews2_seperator0',
                'viral_pro_fwnews2_section_seperator',
                'viral_pro_fwnews2_seperator1',
                'viral_pro_fwnews2_top_seperator',
                'viral_pro_fwnews2_ts_color',
                'viral_pro_fwnews2_ts_height',
                'viral_pro_fwnews2_seperator2',
                'viral_pro_fwnews2_bottom_seperator',
                'viral_pro_fwnews2_bs_color',
                'viral_pro_fwnews2_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_fwnews2_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'title' => __('Title', 'viral-pro'),
            'category' => '',
            'layout' => 'style1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_fwnews2_blocks', array(
    'label' => __('News Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_fwnews2_section',
    'settings' => 'viral_pro_frontpage_fwnews2_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'title' => array(
        'type' => 'text',
        'label' => __('Title', 'viral-pro'),
        'default' => __('Title', 'viral-pro'),
        'description' => __('Optional - Leave blank to hide Title', 'viral-pro')
    ),
    'category' => array(
        'type' => 'multicategory',
        'label' => __('Select Category', 'viral-pro'),
        'default' => '',
        'description' => __('All latest post will display if no category is selected', 'viral-pro')
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style2.png',
            'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style3.png',
            'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style4.png',
            'style5' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style5.png',
            'style6' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style6.png',
            'style7' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style7.png',
            'style8' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/full-news/style8.png',
        ),
        'default' => 'style1'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Category', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => esc_attr__('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_fwnews2_blocks", array(
    'selector' => ".ht-fwnews2-container",
    'render_callback' => "viral_pro_frontpage_fwnews2_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwnews2_top_widget", array(
    'selector' => ".ht-fwnews2-container",
    'render_callback' => "viral_pro_frontpage_fwnews2_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_fwnews2_bottom_widget", array(
    'selector' => ".ht-fwnews2-container",
    'render_callback' => "viral_pro_frontpage_fwnews2_content",
    'container_inclusive' => false
));

/* ============THREE COLUMN SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_threecol_section', array(
    'title' => esc_html__('Three Column Module', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_threecol_section'),
    'hiding_control' => 'viral_pro_frontpage_threecol_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_threecol_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_threecol_section_disable', array(
    'section' => 'viral_pro_frontpage_threecol_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_threecol_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_threecol_nav', array(
    'section' => 'viral_pro_frontpage_threecol_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_frontpage_threecol_blocks',
                'viral_pro_threecol_widget_heading',
                'viral_pro_threecol_top_widget',
                'viral_pro_threecol_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_threecol_cs_heading',
                'viral_pro_threecol_title_color',
                'viral_pro_threecol_text_color',
                'viral_pro_threecol_link_color',
                'viral_pro_threecol_block_color_seperator',
                'viral_pro_threecol_overwrite_block_title_color',
                'viral_pro_threecol_block_title_color',
                'viral_pro_threecol_block_title_background_color',
                'viral_pro_threecol_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_threecol_enable_fullwindow',
                'viral_pro_threecol_align_item',
                'viral_pro_threecol_fw_seperator',
                'viral_pro_threecol_bg_type',
                'viral_pro_threecol_bg_color',
                'viral_pro_threecol_bg_gradient',
                'viral_pro_threecol_bg_image',
                'viral_pro_threecol_parallax_effect',
                'viral_pro_threecol_bg_video',
                'viral_pro_threecol_overlay_color',
                'viral_pro_threecol_cs_seperator',
                'viral_pro_threecol_padding',
                'viral_pro_threecol_margin',
                'viral_pro_threecol_seperator0',
                'viral_pro_threecol_section_seperator',
                'viral_pro_threecol_seperator1',
                'viral_pro_threecol_top_seperator',
                'viral_pro_threecol_ts_color',
                'viral_pro_threecol_ts_height',
                'viral_pro_threecol_seperator2',
                'viral_pro_threecol_bottom_seperator',
                'viral_pro_threecol_bs_color',
                'viral_pro_threecol_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_frontpage_threecol_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'category1' => '-1',
            'category2' => '-1',
            'category3' => '-1',
            'display_cat' => 'yes',
            'display_author' => 'yes',
            'display_date' => 'yes',
            'post_count' => 3,
            'layout' => 'style1',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_threecol_blocks', array(
    'label' => __('News Blocks', 'viral-pro'),
    'section' => 'viral_pro_frontpage_threecol_section',
    'settings' => 'viral_pro_frontpage_threecol_blocks',
    'box_label' => __('News Section', 'viral-pro'),
    'add_label' => __('Add Section', 'viral-pro'),
        ), array(
    'category1' => array(
        'type' => 'category',
        'label' => __('Category', 'viral-pro'),
        'default' => '-1',
        'class' => 'vl-bottom-block-cat1'
    ),
    'category2' => array(
        'type' => 'category',
        'label' => __('Category', 'viral-pro'),
        'default' => '-1',
        'class' => 'vl-bottom-block-cat2'
    ),
    'category3' => array(
        'type' => 'category',
        'label' => __('Category', 'viral-pro'),
        'default' => '-1',
        'class' => 'vl-bottom-block-cat3'
    ),
    'display_cat' => array(
        'type' => 'toggle',
        'label' => __('Display Category', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_author' => array(
        'type' => 'toggle',
        'label' => __('Display Author', 'viral-pro'),
        'default' => 'yes'
    ),
    'display_date' => array(
        'type' => 'toggle',
        'label' => __('Display Date', 'viral-pro'),
        'default' => 'yes'
    ),
    'post_count' => array(
        'type' => 'range',
        'label' => __('No of Posts', 'viral-pro'),
        'options' => array(
            'val' => 3,
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'unit' => ''
        )
    ),
    'layout' => array(
        'type' => 'selector',
        'label' => __('Layouts', 'viral-pro'),
        'description' => __('Select the Block Layout', 'viral-pro'),
        'options' => array(
            'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/three-col/style1.png',
            'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/three-col/style2.png',
        ),
        'default' => 'style1',
        'class' => 'vl-bottom-block-layout'
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Section', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_threecol_blocks", array(
    'selector' => ".ht-threecol-container",
    'render_callback' => "viral_pro_frontpage_threecol_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_threecol_top_widget", array(
    'selector' => ".ht-threecol-container",
    'render_callback' => "viral_pro_frontpage_threecol_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_threecol_bottom_widget", array(
    'selector' => ".ht-threecol-container",
    'render_callback' => "viral_pro_frontpage_threecol_content",
    'container_inclusive' => false
));

/* ============VIDEO SECTION============ */
$wp_customize->add_section(new Viral_Pro_Toggle_Section($wp_customize, 'viral_pro_frontpage_video_section', array(
    'title' => esc_html__('Video Module', 'viral-pro'),
    'panel' => 'viral_pro_front_page_panel',
    'priority' => viral_pro_get_section_position('viral_pro_frontpage_video_section'),
    'hiding_control' => 'viral_pro_frontpage_video_section_disable'
)));

$wp_customize->add_setting('viral_pro_frontpage_video_section_disable', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_frontpage_video_section_disable', array(
    'section' => 'viral_pro_frontpage_video_section',
    'label' => esc_html__('Disable Section', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'class' => 'ht--switch-section',
    'priority' => -1,
)));

$wp_customize->add_setting('viral_pro_frontpage_video_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_frontpage_video_nav', array(
    'section' => 'viral_pro_frontpage_video_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('Content', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_youtube_api',
                'viral_pro_frontpage_video_blocks',
                'viral_pro_video_widget_heading',
                'viral_pro_video_top_widget',
                'viral_pro_video_bottom_widget'
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Style', 'viral-pro'),
            'icon' => 'dashicons dashicons-art',
            'fields' => array(
                'viral_pro_video_cs_heading',
                'viral_pro_video_title_color',
                'viral_pro_video_text_color',
                'viral_pro_video_link_color',
                'viral_pro_video_block_color_seperator',
                'viral_pro_video_overwrite_block_title_color',
                'viral_pro_video_block_title_color',
                'viral_pro_video_block_title_background_color',
                'viral_pro_video_block_title_border_color'
            ),
        ),
        array(
            'name' => esc_html__('Advanced', 'viral-pro'),
            'icon' => 'dashicons dashicons-admin-tools',
            'fields' => array(
                'viral_pro_video_enable_fullwindow',
                'viral_pro_video_align_item',
                'viral_pro_video_fw_seperator',
                'viral_pro_video_bg_type',
                'viral_pro_video_bg_color',
                'viral_pro_video_bg_gradient',
                'viral_pro_video_bg_image',
                'viral_pro_video_parallax_effect',
                'viral_pro_video_bg_video',
                'viral_pro_video_overlay_color',
                'viral_pro_video_cs_seperator',
                'viral_pro_video_padding',
                'viral_pro_video_margin',
                'viral_pro_video_seperator0',
                'viral_pro_video_section_seperator',
                'viral_pro_video_seperator1',
                'viral_pro_video_top_seperator',
                'viral_pro_video_ts_color',
                'viral_pro_video_ts_height',
                'viral_pro_video_seperator2',
                'viral_pro_video_bottom_seperator',
                'viral_pro_video_bs_color',
                'viral_pro_video_bs_height'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_youtube_api', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
));

$wp_customize->add_control('viral_pro_youtube_api', array(
    'section' => 'viral_pro_frontpage_video_section',
    'type' => 'text',
    'label' => esc_html__('Youtube API Key', 'viral-pro'),
    'description' => sprintf(esc_html__('Create own API key. %s. The Video Module will work without API key as well. The API key is only required to generate the title and time automatically.', 'viral-pro'), '<a target="_blank" href="https://hashthemes.com/how-to-create-a-youtube-api-key/">' . esc_html__('Guide on creating Youtube API Key', 'viral-pro') . '</a>')
));

$wp_customize->add_setting('viral_pro_frontpage_video_blocks', array(
    'sanitize_callback' => 'viral_pro_sanitize_repeater',
    //'transport' => 'postMessage',
    'default' => json_encode(array(
        array(
            'id' => 'wRzoewOkafk',
            'title' => '',
            'enable' => 'on'
        ),
        array(
            'id' => 'G1I3psDbD94',
            'title' => '',
            'enable' => 'on'
        ),
        array(
            'id' => 'eJxrbXO65uY',
            'title' => '',
            'enable' => 'on'
        ),
        array(
            'id' => 'XtTL1UVikzI',
            'title' => '',
            'enable' => 'on'
        ),
        array(
            'id' => 'y8bv1Uskw1w',
            'title' => '',
            'enable' => 'on'
        )
    ))
));

$wp_customize->add_control(new Viral_Pro_Repeater_Control($wp_customize, 'viral_pro_frontpage_video_blocks', array(
    'label' => __('Videos', 'viral-pro'),
    'section' => 'viral_pro_frontpage_video_section',
    'settings' => 'viral_pro_frontpage_video_blocks',
    'box_label' => __('Video', 'viral-pro'),
    'add_label' => __('Add Video', 'viral-pro'),
        ), array(
    'id' => array(
        'type' => 'text',
        'label' => __('Video ID', 'viral-pro'),
        'description' => __('Enter the video id.', 'viral-pro'),
        'default' => ''
    ),
    'title' => array(
        'type' => 'text',
        'label' => __('Video Title', 'viral-pro'),
        'default' => '',
    ),
    'enable' => array(
        'type' => 'switch',
        'label' => __('Enable Video', 'viral-pro'),
        'switch' => array(
            'on' => 'Yes',
            'off' => 'No'
        ),
        'default' => 'on'
    )
)));

$wp_customize->selective_refresh->add_partial("viral_pro_frontpage_video_blocks", array(
    'selector' => ".ht-video-container",
    'render_callback' => "viral_pro_frontpage_video_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_video_top_widget", array(
    'selector' => ".ht-video-container",
    'render_callback' => "viral_pro_frontpage_video_content",
    'container_inclusive' => false
));

$wp_customize->selective_refresh->add_partial("viral_pro_video_bottom_widget", array(
    'selector' => ".ht-video-container",
    'render_callback' => "viral_pro_frontpage_video_content",
    'container_inclusive' => false
));

/* ============DESIGN SETTINGS============ */

$viral_pro_home_sections = viral_pro_frontpage_sections();

foreach ($viral_pro_home_sections as $viral_pro_home_section) {
    $id = str_replace(array('viral_pro_frontpage_', '_section'), array('', ''), $viral_pro_home_section);

    $wp_customize->add_setting("viral_pro_{$id}_widget_heading", array(
        'sanitize_callback' => 'viral_pro_sanitize_text'
    ));

    $wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, "viral_pro_{$id}_widget_heading", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Choose Widgets', 'viral-pro'),
        'description' => sprintf(esc_html('Add unlimited widget %1shere%2s. It can be used to display Advertisement or Custom Content.', 'viral-pro'), '<a href="' . admin_url('admin.php?page=viral-pro-add-widgets') . '" target="_blank">', '</a>'),
        'priority' => 10
    )));

    $wp_customize->add_setting("viral_pro_{$id}_top_widget", array(
        'default' => 'none',
        'sanitize_callback' => 'viral_pro_sanitize_choices',
    ));

    $wp_customize->add_control("viral_pro_{$id}_top_widget", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'type' => 'select',
        'label' => esc_html__('Display Widget Above The Section', 'viral-pro'),
        'choices' => viral_pro_widget_list(),
        'priority' => 10
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bottom_widget", array(
        'default' => 'none',
        'sanitize_callback' => 'viral_pro_sanitize_choices',
    ));

    $wp_customize->add_control("viral_pro_{$id}_bottom_widget", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'type' => 'select',
        'label' => esc_html__('Display Widget Below The Section', 'viral-pro'),
        'choices' => viral_pro_widget_list(),
        'priority' => 15
    ));

    $wp_customize->add_setting("viral_pro_{$id}_enable_fullwindow", array(
        'default' => 'off',
        'sanitize_callback' => 'viral_pro_sanitize_text',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, "viral_pro_{$id}_enable_fullwindow", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Full Window Section', 'viral-pro'),
        'on_off_label' => array(
            'on' => esc_html__('Yes', 'viral-pro'),
            'off' => esc_html__('No', 'viral-pro')
        ),
        'priority' => 5
    )));

    $wp_customize->add_setting("viral_pro_{$id}_align_item", array(
        'sanitize_callback' => 'viral_pro_sanitize_text',
        'default' => 'top',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control("viral_pro_{$id}_align_item", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'type' => 'radio',
        'label' => esc_html__('Content Alignment', 'viral-pro'),
        'choices' => array(
            'top' => esc_html__('Top', 'viral-pro'),
            'middle' => esc_html__('Middle', 'viral-pro'),
            'bottom' => esc_html__('Bottom', 'viral-pro')
        ),
        'priority' => 10
    ));

    $wp_customize->add_setting("viral_pro_{$id}_fw_seperator", array(
        'sanitize_callback' => 'viral_pro_sanitize_text',
    ));

    $wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, "viral_pro_{$id}_fw_seperator", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 10
    )));

    $wp_customize->add_setting("viral_pro_{$id}_bg_type", array(
        'default' => 'color-bg',
        'sanitize_callback' => 'viral_pro_sanitize_choices',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control("viral_pro_{$id}_bg_type", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'type' => 'select',
        'label' => esc_html__('Background Type', 'viral-pro'),
        'choices' => array(
            'color-bg' => esc_html__('Color Background', 'viral-pro'),
            'gradient-bg' => esc_html__('Gradient Background', 'viral-pro'),
            'image-bg' => esc_html__('Image Background', 'viral-pro'),
            'video-bg' => esc_html__('Video Background', 'viral-pro')
        ),
        'priority' => 15
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bg_color", array(
        'default' => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_bg_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Background Color', 'viral-pro'),
        'priority' => 20
    )));

    $wp_customize->add_setting("viral_pro_{$id}_bg_gradient", array(
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Gradient_Control($wp_customize, "viral_pro_{$id}_bg_gradient", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Gradient Background', 'viral-pro'),
        'priority' => 25
    )));

    $wp_customize->add_setting("viral_pro_{$id}_bg_image_url", array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bg_image_id", array(
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bg_image_repeat", array(
        'default' => 'no-repeat',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bg_image_size", array(
        'default' => 'cover',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bg_position", array(
        'default' => 'center-center',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bg_image_attach", array(
        'default' => 'fixed',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Background_Image_Control($wp_customize, "viral_pro_{$id}_bg_image", array(
        'label' => esc_html__('Background Image', 'viral-pro'),
        'section' => "viral_pro_frontpage_{$id}_section",
        'settings' => array(
            'image_url' => "viral_pro_{$id}_bg_image_url",
            'image_id' => "viral_pro_{$id}_bg_image_id",
            'repeat' => "viral_pro_{$id}_bg_image_repeat", // Use false to hide the field
            'size' => "viral_pro_{$id}_bg_image_size",
            'position' => "viral_pro_{$id}_bg_position",
            'attachment' => "viral_pro_{$id}_bg_image_attach"
        ),
        'priority' => 30
    )));

    $wp_customize->add_setting("viral_pro_{$id}_parallax_effect", array(
        'sanitize_callback' => 'viral_pro_sanitize_text',
        'default' => 'none',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control("viral_pro_{$id}_parallax_effect", array(
        'type' => 'radio',
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Background Effect', 'viral-pro'),
        'choices' => array(
            'none' => esc_html__('None', 'viral-pro'),
            'parallax' => esc_html__('Enable Parallax', 'viral-pro'),
            'scroll' => esc_html__('Horizontal Moving', 'viral-pro')
        ),
        'priority' => 35
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bg_video", array(
        'default' => '6O9Nd1RSZSY',
        'sanitize_callback' => 'viral_pro_sanitize_text'
    ));

    $wp_customize->add_control("viral_pro_{$id}_bg_video", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'type' => 'text',
        'label' => esc_html__('Youtube Video ID', 'viral-pro'),
        'description' => esc_html__('https://www.youtube.com/watch?v=yNAsk4Zw2p0. Add only yNAsk4Zw2p0', 'viral-pro'),
        'priority' => 40
    ));

    $wp_customize->add_setting("viral_pro_{$id}_overlay_color", array(
        'default' => 'rgba(255,255,255,0)',
        'sanitize_callback' => 'viral_pro_sanitize_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Alpha_Color_Control($wp_customize, "viral_pro_{$id}_overlay_color", array(
        'label' => esc_html__('Background Overlay Color', 'viral-pro'),
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 45
    )));

    $wp_customize->add_setting("viral_pro_{$id}_cs_heading", array(
        'sanitize_callback' => 'viral_pro_sanitize_text'
    ));

    $wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, "viral_pro_{$id}_cs_heading", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Color Settings', 'viral-pro'),
        'priority' => 50
    )));

    $wp_customize->add_setting("viral_pro_{$id}_title_color", array(
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_title_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Section Title Color(H1, H2, H3, H4, H5, H6)', 'viral-pro'),
        'priority' => 55
    )));

    $wp_customize->add_setting("viral_pro_{$id}_text_color", array(
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_text_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Section Text Color', 'viral-pro'),
        'priority' => 55
    )));

    $wp_customize->add_setting("viral_pro_{$id}_link_color", array(
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_link_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Section Link Color', 'viral-pro'),
        'priority' => 55
    )));

    $wp_customize->add_setting("viral_pro_{$id}_block_color_seperator", array(
        'sanitize_callback' => 'viral_pro_sanitize_text'
    ));

    $wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, "viral_pro_{$id}_block_color_seperator", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 55
    )));

    $wp_customize->add_setting("viral_pro_{$id}_overwrite_block_title_color", array(
        'sanitize_callback' => 'viral_pro_sanitize_text',
        'default' => false,
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, "viral_pro_{$id}_overwrite_block_title_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 55,
        'label' => esc_html__('OverWrite Block Title Colors', 'viral-pro')
    )));

    $wp_customize->add_setting("viral_pro_{$id}_block_title_color", array(
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_block_title_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 55,
        'label' => esc_html__('Block Title Color', 'viral-pro')
    )));

    $wp_customize->add_setting("viral_pro_{$id}_block_title_background_color", array(
        'default' => '#0078af',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_block_title_background_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 55,
        'label' => esc_html__('Block Title Background Color', 'viral-pro')
    )));

    $wp_customize->add_setting("viral_pro_{$id}_block_title_border_color", array(
        'default' => '#0078af',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_block_title_border_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 55,
        'label' => esc_html__('Block Title Border Color', 'viral-pro')
    )));

    $wp_customize->add_setting("viral_pro_{$id}_cs_seperator", array(
        'sanitize_callback' => 'viral_pro_sanitize_text'
    ));

    $wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, "viral_pro_{$id}_cs_seperator", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 80
    )));

    $wp_customize->add_setting("viral_pro_{$id}_padding_top", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'default' => 20,
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_padding_bottom", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'default' => 20,
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_tablet_padding_top", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_tablet_padding_bottom", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_mobile_padding_top", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_mobile_padding_bottom", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Dimensions_Control($wp_customize, "viral_pro_{$id}_padding", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Top & Bottom Paddings (px)', 'viral-pro'),
        'settings' => array(
            'desktop_top' => "viral_pro_{$id}_padding_top",
            'desktop_bottom' => "viral_pro_{$id}_padding_bottom",
            'tablet_top' => "viral_pro_{$id}_tablet_padding_top",
            'tablet_bottom' => "viral_pro_{$id}_tablet_padding_bottom",
            'mobile_top' => "viral_pro_{$id}_mobile_padding_top",
            'mobile_bottom' => "viral_pro_{$id}_mobile_padding_bottom",
        ),
        'input_attrs' => array(
            'min' => 0,
            'max' => 400,
            'step' => 1,
        ),
        'priority' => 85
    )));

    $wp_customize->add_setting("viral_pro_{$id}_margin_top", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_margin_bottom", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_tablet_margin_top", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_tablet_margin_bottom", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_mobile_margin_top", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_mobile_margin_bottom", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Dimensions_Control($wp_customize, "viral_pro_{$id}_margin", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Top & Bottom Margin (px)', 'viral-pro'),
        'settings' => array(
            'desktop_top' => "viral_pro_{$id}_margin_top",
            'desktop_bottom' => "viral_pro_{$id}_margin_bottom",
            'tablet_top' => "viral_pro_{$id}_tablet_margin_top",
            'tablet_bottom' => "viral_pro_{$id}_tablet_margin_bottom",
            'mobile_top' => "viral_pro_{$id}_mobile_margin_top",
            'mobile_bottom' => "viral_pro_{$id}_mobile_margin_bottom",
        ),
        'input_attrs' => array(
            'min' => 0,
            'max' => 400,
            'step' => 1,
        ),
        'priority' => 85
    )));

    $wp_customize->add_setting("viral_pro_{$id}_seperator0", array(
        'sanitize_callback' => 'viral_pro_sanitize_text'
    ));

    $wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, "viral_pro_{$id}_seperator0", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 90
    )));

    $wp_customize->add_setting("viral_pro_{$id}_section_seperator", array(
        'sanitize_callback' => 'viral_pro_sanitize_text',
        'default' => 'no',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control("viral_pro_{$id}_section_seperator", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'type' => 'select',
        'label' => esc_html__('Enable Separator', 'viral-pro'),
        'choices' => array(
            'no' => esc_html__('Disable', 'viral-pro'),
            'top' => esc_html__('Enable Top Separator', 'viral-pro'),
            'bottom' => esc_html__('Enable Bottom Separator', 'viral-pro'),
            'top-bottom' => esc_html__('Enable Top & Bottom Separator', 'viral-pro')
        ),
        'priority' => 95
    ));

    $wp_customize->add_setting("viral_pro_{$id}_seperator1", array(
        'sanitize_callback' => 'viral_pro_sanitize_text',
    ));

    $wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, "viral_pro_{$id}_seperator1", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 100
    )));

    $wp_customize->add_setting("viral_pro_{$id}_top_seperator", array(
        'sanitize_callback' => 'viral_pro_sanitize_text',
        'default' => 'big-triangle-center',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control("viral_pro_{$id}_top_seperator", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'type' => 'select',
        'label' => esc_html__('Top Separator', 'viral-pro'),
        'choices' => viral_pro_svg_seperator(),
        'priority' => 105
    ));

    $wp_customize->add_setting("viral_pro_{$id}_ts_color", array(
        'default' => '#FF0000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_ts_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Top Separator Color', 'viral-pro'),
        'priority' => 115
    )));

    $wp_customize->add_setting("viral_pro_{$id}_ts_height", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'default' => 60,
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_ts_height_tablet", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_ts_height_mobile", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, "viral_pro_{$id}_ts_height", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Top Separator Height (px)', 'viral-pro'),
        'settings' => array(
            'desktop' => "viral_pro_{$id}_ts_height",
            'tablet' => "viral_pro_{$id}_ts_height_tablet",
            'mobile' => "viral_pro_{$id}_ts_height_mobile",
        ),
        'input_attrs' => array(
            'min' => 20,
            'max' => 200,
            'step' => 1,
        ),
        'priority' => 120
    )));

    $wp_customize->add_setting("viral_pro_{$id}_seperator2", array(
        'sanitize_callback' => 'viral_pro_sanitize_text'
    ));

    $wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, "viral_pro_{$id}_seperator2", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'priority' => 125
    )));

    $wp_customize->add_setting("viral_pro_{$id}_bottom_seperator", array(
        'sanitize_callback' => 'viral_pro_sanitize_text',
        'default' => 'big-triangle-center',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control("viral_pro_{$id}_bottom_seperator", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'type' => 'select',
        'label' => esc_html__('Bottom Separator', 'viral-pro'),
        'choices' => viral_pro_svg_seperator(),
        'priority' => 130
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bs_color", array(
        'default' => '#FF0000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "viral_pro_{$id}_bs_color", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Bottom Separator Color', 'viral-pro'),
        'priority' => 135,
    )));

    $wp_customize->add_setting("viral_pro_{$id}_bs_height", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'default' => 60,
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bs_height_tablet", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_setting("viral_pro_{$id}_bs_height_mobile", array(
        'sanitize_callback' => 'viral_pro_sanitize_number_blank',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, "viral_pro_{$id}_bs_height", array(
        'section' => "viral_pro_frontpage_{$id}_section",
        'label' => esc_html__('Bottom Separator Height (px)', 'viral-pro'),
        'input_attrs' => array(
            'min' => 20,
            'max' => 200,
            'step' => 1,
        ),
        'settings' => array(
            'desktop' => "viral_pro_{$id}_bs_height",
            'tablet' => "viral_pro_{$id}_bs_height_tablet",
            'mobile' => "viral_pro_{$id}_bs_height_mobile",
        ),
        'priority' => 140
    )));

    $wp_customize->selective_refresh->add_partial("viral_pro_{$id}_bg_type", array(
        'selector' => "#ht-{$id}-section",
        'render_callback' => "viral_pro_frontpage_{$id}_section",
        'container_inclusive' => true
    ));

    $wp_customize->selective_refresh->add_partial("viral_pro_{$id}_parallax_effect", array(
        'selector' => "#ht-{$id}-section",
        'render_callback' => "viral_pro_frontpage_{$id}_section",
        'container_inclusive' => true
    ));

    $wp_customize->selective_refresh->add_partial("viral_pro_{$id}_section_seperator", array(
        'selector' => "#ht-{$id}-section",
        'render_callback' => "viral_pro_frontpage_{$id}_section",
        'container_inclusive' => true
    ));

    $wp_customize->selective_refresh->add_partial("viral_pro_{$id}_top_seperator", array(
        'selector' => "#ht-{$id}-section",
        'render_callback' => "viral_pro_frontpage_{$id}_section",
        'container_inclusive' => true
    ));

    $wp_customize->selective_refresh->add_partial("viral_pro_{$id}_bottom_seperator", array(
        'selector' => "#ht-{$id}-section",
        'render_callback' => "viral_pro_frontpage_{$id}_section",
        'container_inclusive' => true
    ));
}