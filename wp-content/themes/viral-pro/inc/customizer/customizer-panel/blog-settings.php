<?php

/**
 * Viral Pro Theme Customizer
 *
 * @package Viral Pro
 */
$wp_customize->add_section('viral_pro_blog_options_section', array(
    'title' => __('Blog/Single Post Settings', 'viral-pro'),
    'priority' => 30
));

$wp_customize->add_setting('viral_pro_blog_sec_nav', array(
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_kses_post',
));

$wp_customize->add_control(new Viral_Pro_Tab_Control($wp_customize, 'viral_pro_blog_sec_nav', array(
    'section' => 'viral_pro_blog_options_section',
    'priority' => 1,
    'buttons' => array(
        array(
            'name' => esc_html__('BLog Page', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_display_frontpage_sections',
                'viral_pro_blog_layout',
                'viral_pro_blog_cat',
                'viral_pro_archive_content',
                'viral_pro_archive_excerpt_length',
                'viral_pro_archive_readmore',
                'viral_pro_blog_display_date_option',
                'viral_pro_blog_date',
                'viral_pro_blog_author',
                'viral_pro_blog_comment',
                'viral_pro_blog_category',
                'viral_pro_blog_tag',
            ),
            'active' => true,
        ),
        array(
            'name' => esc_html__('Single Post', 'viral-pro'),
            'icon' => 'dashicons dashicons-welcome-write-blog',
            'fields' => array(
                'viral_pro_single_layout',
                'viral_pro_display_date_option',
                'viral_pro_single_categories',
                'viral_pro_single_seperator1',
                'viral_pro_single_author',
                'viral_pro_single_date',
                'viral_pro_single_comment_count',
                'viral_pro_single_views',
                'viral_pro_single_reading_time',
                'viral_pro_single_seperator2',
                'viral_pro_single_tags',
                'viral_pro_single_social_share',
                'viral_pro_single_author_box',
                'viral_pro_single_seperator3',
                'viral_pro_single_prev_next_post',
                'viral_pro_single_comments',
                'viral_pro_single_related_posts',
                'viral_pro_single_related_heading',
                'viral_pro_single_related_post_title',
                'viral_pro_single_related_post_style',
                'viral_pro_single_related_post_count'
            ),
        ),
    ),
)));

$wp_customize->add_setting('viral_pro_display_frontpage_sections', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'off'
));

$wp_customize->add_control(new Viral_Pro_Switch_Control($wp_customize, 'viral_pro_display_frontpage_sections', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Front Page Sections', 'viral-pro'),
    'on_off_label' => array(
        'on' => esc_html__('Yes', 'viral-pro'),
        'off' => esc_html__('No', 'viral-pro')
    ),
    'description' => sprintf(esc_html__('Display Front Page sections before the blog. Customize Front Page sections %s', 'viral-pro'), '<a href="javascript:wp.customize.panel( \'viral_pro_front_page_panel\' ).focus()">' . esc_html__('here', 'viral-pro') . '</a>'),
)));

$wp_customize->add_setting('viral_pro_blog_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'layout7'
));

$wp_customize->add_control(new Viral_Pro_Image_Selector_Control($wp_customize, 'viral_pro_blog_layout', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Blog & Archive Layout', 'viral-pro'),
    'image_path' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/blog-layouts/',
    'image_type' => 'png',
    'choices' => array(
        'layout1' => esc_html__('Layout 1', 'viral-pro'),
        'layout2' => esc_html__('Layout 2', 'viral-pro'),
        'layout3' => esc_html__('Layout 3', 'viral-pro'),
        'layout4' => esc_html__('Layout 4', 'viral-pro'),
        'layout5' => esc_html__('Layout 5', 'viral-pro'),
        'layout6' => esc_html__('Layout 6', 'viral-pro'),
        'layout7' => esc_html__('Layout 7', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_blog_cat', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Multiple_Checkbox_Control($wp_customize, 'viral_pro_blog_cat', array(
    'label' => esc_html__('Exclude Category', 'viral-pro'),
    'section' => 'viral_pro_blog_options_section',
    'choices' => viral_pro_cat(),
    'description' => esc_html__('Post with selected category will not display in the blog page', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_archive_content', array(
    'default' => 'excerpt',
    'sanitize_callback' => 'viral_pro_sanitize_choices'
));

$wp_customize->add_control('viral_pro_archive_content', array(
    'section' => 'viral_pro_blog_options_section',
    'type' => 'radio',
    'label' => esc_html__('Archive Content', 'viral-pro'),
    'choices' => array(
        'full-content' => esc_html__('Full Content', 'viral-pro'),
        'excerpt' => esc_html__('Excerpt', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_archive_excerpt_length', array(
    'sanitize_callback' => 'absint',
    'default' => 100
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_archive_excerpt_length', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Excerpt Length (words)', 'viral-pro'),
    'input_attrs' => array(
        'min' => 50,
        'max' => 200,
        'step' => 1
    )
)));

$wp_customize->add_setting('viral_pro_archive_readmore', array(
    'default' => esc_html__('Read More', 'viral-pro'),
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control('viral_pro_archive_readmore', array(
    'section' => 'viral_pro_blog_options_section',
    'type' => 'text',
    'label' => esc_html__('Read More Text', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_blog_display_date_option', array(
    'default' => 'posted',
    'sanitize_callback' => 'viral_pro_sanitize_choices'
));

$wp_customize->add_control('viral_pro_blog_display_date_option', array(
    'section' => 'viral_pro_blog_options_section',
    'type' => 'radio',
    'label' => esc_html__('Display Posted/Updated Date', 'viral-pro'),
    'choices' => array(
        'posted' => esc_html__('Posted Date', 'viral-pro'),
        'updated' => esc_html__('Updated Date', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_blog_date', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_blog_date', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Posted Date', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_blog_author', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_blog_author', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Author', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_blog_comment', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_blog_comment', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Comment', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_blog_category', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_blog_category', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Category', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_blog_tag', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_blog_tag', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Tag', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_layout', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'layout1'
));

$wp_customize->add_control(new Viral_Pro_Image_Selector_Control($wp_customize, 'viral_pro_single_layout', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Single Post Layout', 'viral-pro'),
    'description' => esc_html__('This option can be overwritten in single page settings.', 'viral-pro'),
    'image_path' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/single-layouts/',
    'image_type' => 'png',
    'choices' => array(
        'layout1' => esc_html__('Layout 1', 'viral-pro'),
        'layout2' => esc_html__('Layout 2', 'viral-pro'),
        'layout3' => esc_html__('Layout 3', 'viral-pro'),
        'layout4' => esc_html__('Layout 4', 'viral-pro'),
        'layout5' => esc_html__('Layout 5', 'viral-pro'),
        'layout6' => esc_html__('Layout 6', 'viral-pro'),
        'layout7' => esc_html__('Layout 7', 'viral-pro')
    )
)));

$wp_customize->add_setting('viral_pro_display_date_option', array(
    'default' => 'posted',
    'sanitize_callback' => 'viral_pro_sanitize_choices'
));

$wp_customize->add_control('viral_pro_display_date_option', array(
    'section' => 'viral_pro_blog_options_section',
    'type' => 'radio',
    'label' => esc_html__('Display Posted/Updated Date', 'viral-pro'),
    'choices' => array(
        'posted' => esc_html__('Posted Date', 'viral-pro'),
        'updated' => esc_html__('Updated Date', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_single_categories', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_categories', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Categories', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_seperator1', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_single_seperator1', array(
    'section' => 'viral_pro_blog_options_section',
)));

$wp_customize->add_setting('viral_pro_single_author', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_author', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Author', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_date', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_date', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Posted Date', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_comment_count', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_comment_count', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Comment Count', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_views', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_views', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Post Views', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_reading_time', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_reading_time', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Reading Time', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_seperator2', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_single_seperator2', array(
    'section' => 'viral_pro_blog_options_section',
)));

$wp_customize->add_setting('viral_pro_single_tags', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_tags', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Tags', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_social_share', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'sticky'
));

$wp_customize->add_control('viral_pro_single_social_share', array(
    'section' => 'viral_pro_blog_options_section',
    'type' => 'select',
    'label' => esc_html__('Social Share Buttons', 'viral-pro'),
    'choices' => array(
        'hide' => esc_html__('Hide', 'viral-pro'),
        'sticky' => esc_html__('Sticky on Left', 'viral-pro'),
        'bottom' => esc_html__('Bottom of Post', 'viral-pro'),
        'both' => esc_html__('Both', 'viral-pro')
    )
));

$wp_customize->add_setting('viral_pro_single_author_box', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_setting('viral_pro_single_seperator3', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'transport' => 'postMessage'
));

$wp_customize->add_control(new Viral_Pro_Separator_Control($wp_customize, 'viral_pro_single_seperator3', array(
    'section' => 'viral_pro_blog_options_section',
)));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_author_box', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Author Box', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_prev_next_post', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_prev_next_post', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Prev/Next Post', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_comments', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_comments', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Comments', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_related_posts', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => true
));

$wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_single_related_posts', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Display Related Posts', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_related_heading', array(
    'sanitize_callback' => 'viral_pro_sanitize_text'
));

$wp_customize->add_control(new Viral_Pro_Heading_Control($wp_customize, 'viral_pro_single_related_heading', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Related Post Settings', 'viral-pro')
)));

$wp_customize->add_setting('viral_pro_single_related_post_title', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => esc_html__('Related Posts', 'viral-pro'),
));

$wp_customize->add_control('viral_pro_single_related_post_title', array(
    'section' => 'viral_pro_blog_options_section',
    'type' => 'text',
    'label' => esc_html__('Title', 'viral-pro')
));

$wp_customize->add_setting('viral_pro_single_related_post_style', array(
    'sanitize_callback' => 'viral_pro_sanitize_text',
    'default' => 'style1'
));

$wp_customize->add_control(new Viral_Pro_Selector_Control($wp_customize, 'viral_pro_single_related_post_style', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('Layouts', 'viral-pro'),
    'options' => array(
        'style1' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/related-posts/style1.png',
        'style2' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/related-posts/style2.png',
        'style3' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/related-posts/style3.png',
        'style4' => VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/images/related-posts/style4.png',
    )
)));

$wp_customize->add_setting('viral_pro_single_related_post_count', array(
    'sanitize_callback' => 'absint',
    'default' => 3
));

$wp_customize->add_control(new Viral_Pro_Range_Slider_Control($wp_customize, 'viral_pro_single_related_post_count', array(
    'section' => 'viral_pro_blog_options_section',
    'label' => esc_html__('No of Posts', 'viral-pro'),
    'input_attrs' => array(
        'min' => 3,
        'max' => 9,
        'step' => 1
    )
)));
