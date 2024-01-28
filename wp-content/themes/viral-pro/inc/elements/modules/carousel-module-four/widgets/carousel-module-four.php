<?php

namespace Viral_Pro_Elements\Modules\CarouselModuleFour\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Viral_Pro_Elements\Group_Control_Query;
use Viral_Pro_Elements\Group_Control_Header;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class CarouselModuleFour extends Widget_Base {

    /** Widget Name */
    public function get_name() {
        return 'vp-carousel-module-four';
    }

    /** Widget Title */
    public function get_title() {
        return esc_html__('Carousel Module 4', 'viral-pro');
    }

    /** Icon */
    public function get_icon() {
        return 'vp-carousel-module-four vp-elementor-icon';
    }

    /** Category */
    public function get_categories() {
        return ['viral-pro-carousel-elements'];
    }

    /** Controls */
    protected function register_controls() {

        $this->start_controls_section(
                'header', [
            'label' => esc_html__('Header', 'viral-pro'),
                ]
        );

        $this->add_group_control(
                Group_Control_Header::get_type(), [
            'name' => 'header',
            'label' => esc_html__('Header', 'viral-pro'),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_post_query', [
            'label' => esc_html__('Content Filter', 'viral-pro'),
                ]
        );

        $this->add_group_control(
                Group_Control_Query::get_type(), [
            'name' => 'posts',
            'label' => esc_html__('Posts', 'viral-pro'),
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_post_block', [
            'label' => esc_html__('Post Block', 'viral-pro'),
                ]
        );

        $this->add_group_control(
                Group_Control_Image_Size::get_type(), [
            'name' => 'post_image',
            'exclude' => ['custom'],
            'include' => [],
            'default' => 'viral-pro-500x500',
                ]
        );

        $this->add_control(
                'post_thumb_height', [
            'label' => esc_html__('Image Height(%)', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 30,
                    'max' => 150,
                    'step' => 1
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 70,
            ],
            'selectors' => [
                '{{WRAPPER}} .vl-carousel-block .vl-thumb-container' => 'padding-bottom: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'image_border_radius', [
            'label' => esc_html__('Image Border Radius(px)', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 30,
                    'step' => 1
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 0,
            ],
            'selectors' => [
                '{{WRAPPER}} .vl-post-thumb > a' => 'border-radius: {{SIZE}}{{UNIT}};'
            ],
                ]
        );

        $this->add_control(
                'post_count', [
            'label' => esc_html__('No of Posts to Show', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 1
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 6,
            ],
                ]
        );

        $this->add_control('post_excerpt_length', [
            'label' => esc_html__('Excerpt Length', 'viral-pro'),
            'description' => esc_html__('Enter 0 to hide excerpt', 'viral-pro'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'default' => 0
        ]);

        $this->add_control(
                'post_author', [
            'label' => esc_html__('Show Post Author', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'separator' => 'before'
                ]
        );

        $this->add_control(
                'post_date', [
            'label' => esc_html__('Show Post Date', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
                ]
        );

        $this->add_control(
                'post_comment', [
            'label' => esc_html__('Show Post Comments', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
                ]
        );

        $this->add_control(
                'post_category', [
            'label' => esc_html__('Show Category', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes'
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'carousel_section', [
            'label' => esc_html__('Carousel Settings', 'viral-pro'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'autoplay', [
            'label' => esc_html__('Autoplay', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'pause_duration', [
            'label' => esc_html__('Pause Duration', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['s'],
            'range' => [
                's' => [
                    'min' => 1,
                    'max' => 20,
                    'step' => 1
                ],
            ],
            'default' => [
                'unit' => 's',
                'size' => 5,
            ],
            'condition' => [
                'autoplay' => 'yes',
            ],
                ]
        );

        $this->add_responsive_control(
                'no_of_slides', [
            'label' => esc_html__('No of Slides', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'default' => [
                'size' => 3,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 2,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 1,
                'unit' => 'px',
            ],
                ]
        );

        $this->add_responsive_control(
                'slides_margin', [
            'label' => esc_html__('Spacing Between Slides', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'default' => [
                'size' => 30,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 30,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 30,
                'unit' => 'px',
            ],
                ]
        );

        $this->add_responsive_control(
                'slides_stagepadding', [
            'label' => esc_html__('Stage Padding', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 0,
                'unit' => 'px',
            ],
                ]
        );

        $this->add_control(
                'nav', [
            'label' => esc_html__('Nav Arrow', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'viral-pro'),
            'label_off' => esc_html__('Hide', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes'
                ]
        );

        $this->add_control(
                'dots', [
            'label' => esc_html__('Nav Dots', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'viral-pro'),
            'label_off' => esc_html__('Hide', 'viral-pro'),
            'return_value' => 'yes',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'additional_settings', [
            'label' => esc_html__('Additional Settings', 'viral-pro'),
                ]
        );

        $this->add_control(
                'date_format', [
            'label' => esc_html__('Date Format', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'relative_format' => esc_html__('Relative Format (Ago)', 'viral-pro'),
                'default' => esc_html__('WordPress Default Format', 'viral-pro'),
                'custom' => esc_html__('Custom Format', 'viral-pro'),
            ],
            'default' => 'default',
            'separator' => 'before',
            'label_block' => true
                ]
        );

        $this->add_control(
                'custom_date_format', [
            'label' => esc_html__('Custom Date Format', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'default' => 'F j, Y',
            'placeholder' => esc_html__('F j, Y', 'viral-pro'),
            'condition' => [
                'date_format' => 'custom'
            ]
                ]
        );

        $this->add_control(
                'image_hover_style', [
            'label' => __('Image Hover Animation Style', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'default' => 'vl-thumb-default',
            'options' => [
                'vl-thumb-default' => __('Default', 'viral-pro'),
                'vl-thumb-hover-style-no-effect' => __('No Effect', 'viral-pro'),
                'vl-thumb-hover-style-zoom-in' => __('Zoom In', 'viral-pro'),
                'vl-thumb-hover-style-zoom-out' => __('Zoom Out', 'viral-pro'),
                'vl-thumb-hover-style-slide-left' => __('Slide Left', 'viral-pro'),
                'vl-thumb-hover-style-slide-right' => __('Slide Right', 'viral-pro'),
                'vl-thumb-hover-style-slide-top' => __('Slide Top', 'viral-pro'),
                'vl-thumb-hover-style-slide-bottom' => __('Slide Bottom', 'viral-pro'),
                'vl-thumb-hover-style-rotate-zoom-in' => __('Rotate Zoom In', 'viral-pro'),
                'vl-thumb-hover-style-opacity' => __('Opacity', 'viral-pro'),
                'vl-thumb-hover-style-shine' => __('Shine', 'viral-pro'),
                'vl-thumb-hover-style-circle' => __('Circle', 'viral-pro'),
            ],
            'label_block' => true,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'header_title_style', [
            'label' => esc_html__('Header Title', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'header_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vp-block-title span.vl-title, {{WRAPPER}} .vl-block-title span.vl-title',
                ]
        );

        $this->add_control(
                'header_color', [
            'label' => esc_html__('Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-block-title span.vl-title' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'header_style' => ['vl-title-style1', 'vl-title-style2', 'vl-title-style3', 'vl-title-style4', 'vl-title-style5', 'vl-title-style6']
            ],
                ]
        );

        $this->add_control(
                'header_color_with_bg', [
            'label' => esc_html__('Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
                '{{WRAPPER}} .vp-block-title span.vl-title' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'header_style' => ['vl-title-style7', 'vl-title-style8', 'vl-title-style9', 'vl-title-style10', 'vl-title-style11', 'vl-title-style12']
            ],
                ]
        );

        $this->add_control(
                'header_background_color', [
            'label' => esc_html__('Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-title-style2.vp-block-header .vp-block-title:after, {{WRAPPER}} .vl-title-style5.vp-block-header .vp-block-title span.vl-title:before, {{WRAPPER}} .vl-title-style7.vp-block-header .vp-block-title span.vl-title, {{WRAPPER}} .vl-title-style8.vp-block-header .vp-block-title span.vl-title, {{WRAPPER}} .vl-title-style9.vp-block-header .vp-block-title span.vl-title, {{WRAPPER}} .vl-title-style10.vp-block-header, {{WRAPPER}} .vl-title-style11.vp-block-header, {{WRAPPER}} .vl-title-style12.vp-block-header' => 'background-color: {{VALUE}}',
                '{{WRAPPER}} .vl-title-style8.vp-block-header, {{WRAPPER}} .vl-title-style9.vp-block-header' => 'border-color: {{VALUE}}',
                '{{WRAPPER}} .vl-title-style10.vp-block-header .vp-block-title:before' => 'border-color: {{VALUE}} {{VALUE}} transparent transparent',
            ],
            'condition' => [
                'header_style' => ['vl-title-style2', 'vl-title-style5', 'vl-title-style7', 'vl-title-style8', 'vl-title-style9', 'vl-title-style10', 'vl-title-style11', 'vl-title-style12']
            ],
                ]
        );

        $this->add_control(
                'header_border_color', [
            'label' => esc_html__('Border Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-title-style2.vp-block-header .vp-block-title, {{WRAPPER}} .vl-title-style2.vp-block-header .vp-block-filter, {{WRAPPER}} .vl-title-style3.vp-block-header, {{WRAPPER}} .vl-title-style5.vp-block-header, {{WRAPPER}} .vl-title-style11.vp-block-header' => 'border-color: {{VALUE}}',
                '{{WRAPPER}} .vl-title-style4.vp-block-header .vp-block-title:after, {{WRAPPER}} .vl-title-style6.vp-block-header .vp-block-title:before, {{WRAPPER}} .vl-title-style6.vp-block-header .vp-block-title:after, {{WRAPPER}} .vl-title-style7.vp-block-header .vp-block-title:after, {{WRAPPER}} .vl-title-style11.vp-block-header .vp-block-title span.vl-title' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'header_style' => ['vl-title-style2', 'vl-title-style3', 'vl-title-style4', 'vl-title-style5', 'vl-title-style6', 'vl-title-style7', 'vl-title-style11']
            ],
                ]
        );

        $this->add_control(
                'header_title_padding', [
            'label' => esc_html__('Padding', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vl-title-style3.vp-block-header, {{WRAPPER}} .vl-title-style7.vp-block-header .vp-block-title span.vl-title, {{WRAPPER}} .vl-title-style8.vp-block-header .vp-block-title span.vl-title, {{WRAPPER}} .vl-title-style9.vp-block-header .vp-block-title span.vl-title, {{WRAPPER}} .vl-title-style10.vp-block-header, {{WRAPPER}} .vl-title-style11.vp-block-header .vp-block-title span.vl-title, {{WRAPPER}} .vl-title-style12.vp-block-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'header_style' => ['vl-title-style3', 'vl-title-style7', 'vl-title-style8', 'vl-title-style9', 'vl-title-style10', 'vl-title-style11', 'vl-title-style12']
            ],
                ]
        );

        $this->add_control(
                'header_title_margin', [
            'label' => esc_html__('Margin', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'allowed_dimensions' => 'vertical',
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vp-block-header, {{WRAPPER}} .vl-block-header' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
            ],
            'default' => [
                'top' => '0',
                'right' => '',
                'bottom' => '30',
                'left' => '',
                'isLinked' => false,
            ]
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'category_style', [
            'label' => esc_html__('Category', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'category_normal_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-primary-cat',
                ]
        );

        $this->start_controls_tabs(
                'category_style_tabs'
        );

        $this->start_controls_tab(
                'category_normal_tab', [
            'label' => __('Normal', 'viral-pro'),
                ]
        );

        $this->add_control(
                'category_background_color', [
            'label' => esc_html__('Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-primary-cat' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'category_text_color', [
            'label' => esc_html__('Text Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-primary-cat' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'category_hover_tab', [
            'label' => __('Hover', 'viral-pro'),
                ]
        );

        $this->add_control(
                'category_background_hover_color', [
            'label' => esc_html__('Background Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-primary-cat:hover' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'category_text_hover_color', [
            'label' => esc_html__('Text Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-primary-cat:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'post_title_style', [
            'label' => esc_html__('Title', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => esc_html__('Title Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-post-title' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'title_hover_color', [
            'label' => esc_html__('Title Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-post-title:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-post-title',
                ]
        );

        $this->add_control(
                'title_margin', [
            'label' => esc_html__('Margin', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'allowed_dimensions' => 'vertical',
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} h3.vl-post-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'excerpt_style', [
            'label' => esc_html__('Excerpt', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'excerpt_color', [
            'label' => esc_html__('Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-excerpt' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'excerpt_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-excerpt',
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'post_metas', [
            'label' => esc_html__('Metas', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'post_metas_color', [
            'label' => esc_html__('Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-post-metas' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'post_metas_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-post-metas'
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'navigation_style', [
            'label' => esc_html__('Navigation', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->start_controls_tabs(
                'nav_style_tabs'
        );

        $this->start_controls_tab(
                'nav_normal_tab', [
            'label' => __('Normal', 'viral-pro'),
                ]
        );

        $this->add_control(
                'nav_normal_bg_color', [
            'label' => esc_html__('Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-carousel .owl-nav button' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'nav_icon_normal_color', [
            'label' => esc_html__('Icon Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-carousel .owl-nav button.owl-next' => 'color: {{VALUE}}',
                '{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'dot_bg_color', [
            'label' => esc_html__('Dots Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-carousel button.owl-dot' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'nav_hover_tab', [
            'label' => __('Hover', 'viral-pro'),
                ]
        );

        $this->add_control(
                'nav_hover_bg_color', [
            'label' => esc_html__('Background Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-carousel .owl-nav button:hover' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'nav_icon_hover_color', [
            'label' => esc_html__('Icon Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-carousel .owl-nav button.owl-next:hover' => 'color: {{VALUE}}',
                '{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'dot_bg_color_hover', [
            'label' => esc_html__('Dots Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-carousel button.owl-dot:hover' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $image_size = $settings['post_image_size'];

        $params = array(
            'autoplay' => $settings['autoplay'] == 'yes' ? true : false,
            'pause' => (int) $settings['pause_duration']['size'] * 1000,
            'items' => (int) $settings['no_of_slides']['size'],
            'items_tablet' => (int) isset($settings['no_of_slides_tablet']['size']) ? $settings['no_of_slides_tablet']['size'] : 2,
            'items_mobile' => (int) isset($settings['no_of_slides_mobile']['size']) ? $settings['no_of_slides_mobile']['size'] : 1,
            'margin' => (int) $settings['slides_margin']['size'],
            'margin_tablet' => (int) isset($settings['slides_margin_tablet']['size']) ? $settings['slides_margin_tablet']['size'] : 30,
            'margin_mobile' => (int) isset($settings['slides_margin_mobile']['size']) ? $settings['slides_margin_mobile']['size'] : 30,
            'stagepadding' => (int) $settings['slides_stagepadding']['size'],
            'stagepadding_tablet' => (int) isset($settings['slides_stagepadding_tablet']['size']) ? $settings['slides_stagepadding_tablet']['size'] : 0,
            'stagepadding_mobile' => (int) isset($settings['slides_stagepadding_mobile']['size']) ? $settings['slides_stagepadding_mobile']['size'] : 0,
            'nav' => $settings['nav'] == 'yes' ? true : false,
            'dots' => $settings['dots'] == 'yes' ? true : false
        );
        $params = json_encode($params);
        ?>
        <div class="vl-carousel-block style4 <?php echo esc_attr($settings['image_hover_style']); ?>">

            <?php $this->render_header(); ?>

            <?php
            $args = $this->query_args();
            $query = new \WP_Query($args);
            if ($query->have_posts()) {
                ?>
                <div class="vl-carousel-wrap vl-ele-carousel-wrap">
                    <div class="owl-carousel" data-params='<?php echo $params; ?>'>
                        <?php
                        while ($query->have_posts()): $query->the_post();
                            if (has_post_thumbnail()) {
                                ?>
                                <div class="vl-carousel-item">
                                    <div class="vl-post-thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="vl-thumb-container">
                                                <?php
                                                viral_pro_elements_featured_image($image_size, false);
                                                ?>
                                            </div>
                                        </a>
                                        <?php
                                        if ($settings['post_category']) {
                                            viral_pro_elements_primary_category();
                                        }
                                        ?>
                                    </div>

                                    <h3 class="vl-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php $this->get_post_meta(); ?>

                                    <?php $this->get_post_excerpt(); ?>

                                </div>
                                <?php
                            }
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

    /** Render Header */
    protected function render_header() {
        $settings = $this->get_settings();
        $header_class = array(
            'vp-no-filter',
            $settings['header_style'] == 'vl-title-default' ? 'vl-block-header' : 'vp-block-header',
            $settings['header_style']
        );
        $class = $settings['header_style'] == 'vl-title-default' ? 'vl-block-title' : 'vp-block-title';

        $link_open = $link_close = "";
        $target = $settings['header_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['header_link']['nofollow'] ? ' rel="nofollow"' : '';

        if ($settings['header_link']['url']) {
            $link_open = '<a href="' . $settings['header_link']['url'] . '"' . $target . $nofollow . '>';
            $link_close = '</a>';
        }

        if ($settings['header_title']) {
            ?>
            <div class="<?php echo esc_attr(implode(' ', $header_class)); ?>">
                <h2 class="<?php echo esc_attr($class); ?>">
                    <?php
                    echo $link_open;
                    echo '<span class="vl-title">';
                    echo $settings['header_title'];
                    echo '</span>';
                    echo $link_close;
                    ?>
                </h2>
            </div>
            <?php
        }
    }

    /** Get Post Excerpt */
    protected function get_post_excerpt() {
        $settings = $this->get_settings_for_display();
        $excerpt_length = $settings['post_excerpt_length'];
        if ($excerpt_length) {
            ?>
            <div class="vl-excerpt"><?php echo viral_pro_elements_custom_excerpt($excerpt_length); ?></div>
            <?php
        }
    }

    /** Query Args */
    protected function query_args() {
        $settings = $this->get_settings();

        $post_type = $args['post_type'] = $settings['posts_post_type'];
        $args['orderby'] = $settings['posts_orderby'];
        $args['order'] = $settings['posts_order'];
        $args['ignore_sticky_posts'] = 1;
        $args['post_status'] = 'publish';
        $args['offset'] = $settings['posts_offset'];
        $args['posts_per_page'] = $settings['post_count']['size'];
        $args['post__not_in'] = $post_type == 'post' ? $settings['posts_exclude_posts'] : [];

        $args['tax_query'] = [];

        $taxonomies = get_object_taxonomies($post_type, 'objects');

        foreach ($taxonomies as $object) {
            $setting_key = 'posts_' . $object->name . '_ids';

            if (!empty($settings[$setting_key])) {
                $args['tax_query'][] = [
                    'taxonomy' => $object->name,
                    'field' => 'term_id',
                    'terms' => $settings[$setting_key],
                ];
            }
        }

        return $args;
    }

    /** Get Post Metas */
    protected function get_post_meta() {
        $settings = $this->get_settings_for_display();
        $post_author = $settings['post_author'];
        $post_date = $settings['post_date'];
        $post_comment = $settings['post_comment'];

        if ($post_author == 'yes' || $post_date == 'yes' || $post_comment == 'yes') {
            ?>
            <div class="vl-post-metas">
                <?php
                if ($post_author == 'yes') {
                    viral_pro_elements_author_name();
                }

                if ($post_date == 'yes') {
                    $date_format = $settings['date_format'];

                    if ($date_format == 'relative_format') {
                        viral_pro_elements_time_ago();
                    } else if ($date_format == 'default') {
                        viral_pro_elements_post_date();
                    } else if ($date_format == 'custom') {
                        $format = $settings['custom_date_format'];
                        viral_pro_elements_post_date($format);
                    }
                }

                if ($post_comment == 'yes') {
                    viral_pro_elements_comment_count();
                }
                ?>
            </div>
            <?php
        }
    }

}
