<?php

namespace Viral_Pro_Elements\Modules\NewsModuleFour\Widgets;

use ViralPro\Blocks\Viral_Pro_Blocks_Manager;
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
class NewsModuleFour extends Widget_Base {

    /** Widget Name */
    public function get_name() {
        return 'he-news-module-four';
    }

    /** Widget Title */
    public function get_title() {
        return esc_html__('News Module 4', 'viral-pro');
    }

    /** Icon */
    public function get_icon() {
        return 'vp-news-module-four vp-elementor-icon';
    }

    /** Category */
    public function get_categories() {
        return ['viral-pro-elements'];
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

        $this->add_control(
                'filterable', [
            'label' => __('Enable Header Filter', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'viral-pro'),
            'label_off' => __('No', 'viral-pro'),
            'return_value' => 'yes',
            'separator' => 'before'
                ]
        );

        $this->add_control(
                'all_text', [
            'label' => __('All Text', 'viral-pro'),
            'description' => __('Leave blank to hide', 'viral-pro'),
            'default' => __('All', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'condition' => [
                'filterable' => 'yes',
            ],
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_top_block', [
            'label' => esc_html__('Top Block', 'viral-pro'),
                ]
        );

        $this->add_group_control(
                Group_Control_Image_Size::get_type(), [
            'name' => 'top_post_image',
            'exclude' => ['custom'],
            'include' => [],
            'default' => 'viral-pro-500x500',
                ]
        );

        $this->add_control(
                'top_post_thumb_height', [
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
                'size' => 60,
            ],
            'selectors' => [
                '{{WRAPPER}} .vl-fwnews-block-style4 .vl-post-item:nth-child(1) .vl-thumb-container,
                     {{WRAPPER}} .vl-fwnews-block-style4 .vl-post-item:nth-child(2) .vl-thumb-container' => 'padding-bottom: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control('top_excerpt_length', [
            'label' => esc_html__('Excerpt Length', 'viral-pro'),
            'description' => esc_html__('Enter 0 to hide excerpt', 'viral-pro'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'default' => 0
        ]);

        $this->add_control(
                'top_post_author', [
            'label' => esc_html__('Show Post Author', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'separator' => 'before',
            'default' => 'yes'
                ]
        );

        $this->add_control(
                'top_post_date', [
            'label' => esc_html__('Show Post Date', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes'
                ]
        );

        $this->add_control(
                'top_post_comment', [
            'label' => esc_html__('Show Post Comments', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes'
                ]
        );

        $this->add_control(
                'top_block_post_category', [
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
                'section_bottom_block', [
            'label' => esc_html__('Bottom Block', 'viral-pro'),
                ]
        );

        $this->add_control(
                'bottom_post_count', [
            'label' => esc_html__('No of Posts', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 4
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 4,
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Image_Size::get_type(), [
            'name' => 'bottom_post_image',
            'exclude' => ['custom'],
            'include' => [],
            'default' => 'viral-pro-500x500',
                ]
        );

        $this->add_control(
                'bottom_post_thumb_height', [
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
                '{{WRAPPER}} .vl-fwnews-block-style4 .vl-post-item:nth-child(n+3) .vl-thumb-container' => 'padding-bottom: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control('bottom_excerpt_length', [
            'label' => esc_html__('Excerpt Length', 'viral-pro'),
            'description' => esc_html__('Enter 0 to hide excerpt', 'viral-pro'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'default' => 0
        ]);

        $this->add_control(
                'bottom_post_author', [
            'label' => esc_html__('Show Post Author', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'separator' => 'before'
                ]
        );

        $this->add_control(
                'bottom_post_date', [
            'label' => esc_html__('Show Post Date', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
                ]
        );

        $this->add_control(
                'bottom_post_comment', [
            'label' => esc_html__('Show Post Comments', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
                ]
        );

        $this->add_control(
                'bottom_block_post_category', [
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
                'additional_settings', [
            'label' => esc_html__('Additional Settings', 'viral-pro'),
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
                '{{WRAPPER}} .vl-post-thumb' => 'border-radius: {{SIZE}}{{UNIT}};'
            ],
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

        $this->add_control(
                'content_align', [
            'label' => __('Content Alignment', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'default' => 'vl-align-center',
            'options' => [
                'vl-align-left' => __('Left', 'viral-pro'),
                'vl-align-center' => __('Center', 'viral-pro'),
                'vl-align-right' => __('Right', 'viral-pro'),
            ],
            'label_block' => true,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'filter_style', [
            'label' => esc_html__('Filter', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'filterable' => 'yes'
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'filter_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vp-block-filter'
                ]
        );

        $this->add_control(
                'filter_spacing', [
            'label' => esc_html__('Spacing(px)', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 25,
            ],
            'selectors' => [
                '{{WRAPPER}} .vp-block-filter ul.vp-block-filter-list li, {{WRAPPER}} .vp-block-filter-dropdown' => 'padding-left: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'filter_color', [
            'label' => esc_html__('Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-block-filter ul.vp-block-filter-list li a, {{WRAPPER}} .vp-block-filter-more' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'filter_active_color', [
            'label' => esc_html__('Color (Active)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-block-filter ul.vp-block-filter-list li.vp-active a' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'filter_dropdown_bg_color', [
            'label' => esc_html__('DropDown Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-block-filter .vp-block-filter-dropdown-list' => 'background: {{VALUE}}',
            ],
            'separator' => 'before'
                ]
        );

        $this->add_control(
                'filter_dropdown_border_color', [
            'label' => esc_html__('DropDown Border Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-block-filter .vp-block-filter-dropdown-list, {{WRAPPER}} .vp-block-filter .vp-block-filter-dropdown-list li' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'filter_dropdown_text_color', [
            'label' => esc_html__('DropDown Text Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-block-filter .vp-block-filter-dropdown-list li a' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'filter_dropdown_active_text_color', [
            'label' => esc_html__('DropDown Text Color(Active)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-block-filter .vp-block-filter-dropdown-list li.vp-active a' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'filter_dropdown_padding', [
            'label' => esc_html__('DropDown Menu Padding', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .vp-block-filter .vp-block-filter-dropdown-list li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
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
            'name' => 'category_typography',
            'label' => esc_html__('Category Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-primary-cat,
                           {{WRAPPER}} .vl-post-categories li a.vl-category',
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
                'category_bg_color', [
            'label' => esc_html__('Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-primary-cat,
                {{WRAPPER}} .vl-post-categories li a.vl-category' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'category_text_color', [
            'label' => esc_html__('Text Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-primary-cat,
                {{WRAPPER}} .vl-post-categories li a.vl-category' => 'color: {{VALUE}}',
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
                'category_bg_hover_color', [
            'label' => esc_html__('Background Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-primary-cat:hover,
                {{WRAPPER}} .vl-post-categories li a.vl-category:hover' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'category_text_hover_color', [
            'label' => esc_html__('Text Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-primary-cat:hover,
                {{WRAPPER}} .vl-post-categories li a.vl-category:hover' => 'color: {{VALUE}}',
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
                'post_title_color', [
            'label' => esc_html__('Title Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-post-title' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'post_title_hover_color', [
            'label' => esc_html__('Title Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-post-title:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->start_controls_tabs(
                'title_style_tabs'
        );

        $this->start_controls_tab(
                'top_post_title_tab', [
            'label' => __('Top Post', 'viral-pro'),
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'top_post_title_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-post-item:nth-child(1) h3.vl-post-title,
                            {{WRAPPER}} .vl-post-item:nth-child(2) h3.vl-post-title'
                ]
        );

        $this->add_control(
                'top_post_title_margin', [
            'label' => esc_html__('Margin', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'allowed_dimensions' => 'vertical',
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vl-post-item:nth-child(1) .vl-post-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                '{{WRAPPER}} .vl-post-item:nth-child(2) .vl-post-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'bottom_post_title_tab', [
            'label' => __('Bottom Post', 'viral-pro'),
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'bottom_post_title_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-post-item:nth-child(3) h3.vl-post-title,
                            {{WRAPPER}} .vl-post-item:nth-child(4) h3.vl-post-title,
                            {{WRAPPER}} .vl-post-item:nth-child(5) h3.vl-post-title,
                            {{WRAPPER}} .vl-post-item:nth-child(6) h3.vl-post-title',
                ]
        );

        $this->add_control(
                'bottom_post_title_margin', [
            'label' => esc_html__('Margin', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'allowed_dimensions' => 'vertical',
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vl-post-item:nth-child(3) .vl-post-title, 
                {{WRAPPER}} .vl-post-item:nth-child(4) .vl-post-title,
                {{WRAPPER}} .vl-post-item:nth-child(5) .vl-post-title,
                {{WRAPPER}} .vl-post-item:nth-child(6) .vl-post-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
                'section_pagination', [
            'label' => __('Pagination', 'viral-pro'),
                ]
        );

        $this->add_control(
                'pagination', [
            'type' => Controls_Manager::SELECT,
            'label' => __('Pagination Mode', 'viral-pro'),
            'options' => array(
                'none' => __('None', 'viral-pro'),
                'next_prev' => __('Next Prev', 'viral-pro'),
                'paged' => __('Paged', 'viral-pro'),
                'load_more' => __('Load More', 'viral-pro'),
                'infinite_scroll' => __('Load On Scroll', 'viral-pro'),
            ),
            'default' => 'none',
                ]
        );

        $this->add_control(
                'pagination_align', [
            'label' => esc_html__('Alignment', 'viral-pro'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'viral-pro'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'viral-pro'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'viral-pro'),
                    'icon' => 'eicon-text-align-right',
                ]
            ],
            'toggle' => false,
            'default' => 'center',
            'selectors_dictionary' => [
                'left' => 'flex-start',
                'center' => 'center',
                'right' => 'flex-end',
            ],
            'selectors' => [
                '{{WRAPPER}} .vp-pagination' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'pagination' => ['next_prev', 'paged', 'load_more'],
            ],
                ]
        );

        $this->add_control(
                'load_more_text', [
            'label' => __('Load More Text', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'condition' => [
                'pagination' => 'load_more',
            ],
                ]
        );


        $this->add_control(
                'show_remaining', [
            'label' => __('Display Count', 'viral-pro'),
            'description' => __('No. posts yet to be loaded with the load more button', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'viral-pro'),
            'label_off' => __('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'pagination' => 'load_more',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'pagination_style', [
            'label' => esc_html__('Pagination', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'pagination!' => 'none'
            ],
                ]
        );

        $this->add_control(
                'pagination_top_spacing', [
            'label' => esc_html__('Top Spacing(px)', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 40,
            ],
            'selectors' => [
                '{{WRAPPER}} .vp-pagination, {{WRAPPER}} .vp-pagination.vp-infinite-scroll-nav .vp-load-more, {{WRAPPER}} .vp-pagination.vp-load-more-nav .vp-load-more' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'pagination_button_size', [
            'label' => esc_html__('Button Size(px)', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 1
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 40,
            ],
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-page-nav' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'pagination' => ['next_prev', 'paged']
            ],
                ]
        );

        $this->add_control(
                'pagination_text_size', [
            'label' => esc_html__('Button Text/Icon Size(px)', 'viral-pro'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 1
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 14,
            ],
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-page-nav' => 'font-size: {{SIZE}}{{UNIT}}'
            ],
            'condition' => [
                'pagination' => ['next_prev', 'paged']
            ],
                ]
        );

        $this->add_control(
                'pagination_button_spacing', [
            'label' => esc_html__('Button Padding', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'pagination' => 'load_more'
            ],
                ]
        );

        $this->add_control(
                'pagination_button_radius', [
            'label' => esc_html__('Button Border Radius', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-load-more, {{WRAPPER}} .vp-pagination .vp-page-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'pagination' => ['next_prev', 'paged', 'load_more']
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'pagination_button_typography',
            'label' => esc_html__('Button Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vp-pagination .vp-load-more',
            'condition' => [
                'pagination' => 'load_more'
            ],
                ]
        );

        $this->start_controls_tabs(
                'pagination_tab'
        );

        $this->start_controls_tab(
                'pagination_normal', [
            'label' => __('Normal', 'viral-pro'),
                ]
        );

        $this->add_control(
                'pagination_button_bg_color', [
            'label' => esc_html__('Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-page-nav, {{WRAPPER}} .vp-pagination .vp-load-more' => 'background: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'pagination_button_border_color', [
            'label' => esc_html__('Border Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-page-nav, {{WRAPPER}} .vp-pagination .vp-load-more' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'pagination_button_icon_color', [
            'label' => esc_html__('Icon/Text Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-page-nav, {{WRAPPER}} .vp-pagination .vp-load-more' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'pagination_hover', [
            'label' => __('Hover/Active', 'viral-pro'),
                ]
        );

        $this->add_control(
                'pagination_button_bg_hover_color', [
            'label' => esc_html__('Background Color(Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-page-nav:hover, {{WRAPPER}} .vp-pagination .vp-load-more:hover, {{WRAPPER}} .vp-pagination .vp-page-nav.vp-current-page' => 'background: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'pagination_button_border_hover_color', [
            'label' => esc_html__('Border Color(Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-page-nav:hover, {{WRAPPER}} .vp-pagination .vp-load-more:hover, {{WRAPPER}} .vp-pagination .vp-page-nav.vp-current-page' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'pagination_button_icon_hover_color', [
            'label' => esc_html__('Icon/Text Color(Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-page-nav:hover, {{WRAPPER}} .vp-pagination .vp-load-more:hover, {{WRAPPER}} .vp-pagination .vp-page-nav.vp-current-page' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
                'pagination_count_bg_color', [
            'label' => esc_html__('Count Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-load-more span' => 'background: {{VALUE}}',
            ],
            'condition' => [
                'pagination' => 'load_more'
            ],
                ]
        );

        $this->add_control(
                'pagination_count_text_color', [
            'label' => esc_html__('Count Text Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-pagination .vp-load-more span' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'pagination' => 'load_more'
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'loader_style', [
            'label' => esc_html__('Loader', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'filter_loader_color', [
            'label' => esc_html__('Main Loader Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-loader-gif:after, {{WRAPPER}} .vp-loader-gif:before' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'pagination_loader_color', [
            'label' => esc_html__('Footer Loader Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vp-loading:after, {{WRAPPER}} .vp-loading:before, {{WRAPPER}} .vp-big-loading:after, {{WRAPPER}} .vp-big-loading:before' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                'pagination' => ['load_more', 'infinite_scroll']
            ]
                ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $settings['block_id'] = $this->get_id();
        $settings['posts_per_page'] = intval($settings['bottom_post_count']['size']) + 2;
        $settings['block_type'] = 'news_block_four';
        $block = Viral_Pro_Blocks_Manager::get_instance('news_block_four');
        $output = $block->render($settings);
        echo $output;
    }

}
