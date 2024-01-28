<?php

namespace Viral_Pro_Elements\Modules\TitleModule\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class TitleModule extends Widget_Base {

    /** Widget Name */
    public function get_name() {
        return 'vp-title-module';
    }

    /** Widget Title */
    public function get_title() {
        return esc_html__('Title Bar Module', 'viral-pro');
    }

    /** Icon */
    public function get_icon() {
        return 'vp-title-module vp-elementor-icon';
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

        $this->add_control('header_title', [
            'label' => __('Title', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => esc_html__('Title', 'viral-pro')
        ]);

        $this->add_control('header_link', [
            'label' => __('Link', 'viral-pro'),
            'type' => Controls_Manager::URL,
            'show_external' => true,
            'default' => [
                'url' => '',
                'is_external' => false,
                'nofollow' => true,
            ],
        ]);

        $this->add_control('header_style', [
            'label' => __('Style', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'label_block' => true,
            'default' => 'vl-title-style2',
            'options' => [
                'vl-title-style1' => __('Style 1', 'viral-pro'),
                'vl-title-style2' => __('Style 2', 'viral-pro'),
                'vl-title-style3' => __('Style 3', 'viral-pro'),
                'vl-title-style4' => __('Style 4', 'viral-pro'),
                'vl-title-style5' => __('Style 5', 'viral-pro'),
                'vl-title-style6' => __('Style 6', 'viral-pro'),
                'vl-title-style7' => __('Style 7', 'viral-pro'),
                'vl-title-style8' => __('Style 8', 'viral-pro'),
                'vl-title-style9' => __('Style 9', 'viral-pro'),
                'vl-title-style10' => __('Style 10', 'viral-pro'),
                'vl-title-style11' => __('Style 11', 'viral-pro'),
                'vl-title-style12' => __('Style 12', 'viral-pro'),
            ],
        ]);

        $this->add_control(
                'header_description', [
            'label' => __('Description', 'viral-pro'),
            'type' => Controls_Manager::TEXTAREA,
            'rows' => 5,
            'default' => __('Type your description here', 'viral-pro'),
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
                '{{WRAPPER}} .vp-block-header' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
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
                'description', [
            'label' => esc_html__('Description', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-title-description',
                ]
        );

        $this->add_control(
                'description_color', [
            'label' => esc_html__('Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-title-description' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'description_margin', [
            'label' => esc_html__('Margin', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'allowed_dimensions' => 'vertical',
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vl-title-description' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
            ],
                ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {

        $settings = $this->get_settings();
        $class = $settings['header_style'] == 'vl-title-default' ? 'vl-block-title' : 'vp-block-title';
        $has_desc = isset($settings['header_description']) && !empty($settings['header_description']) ? 'vl-has-desc' : '';
        $this->add_render_attribute('header_attr', 'class', [
            esc_attr($class),
            esc_attr($has_desc)
                ]
        );

        $link_open = $link_close = "";
        $target = $settings['header_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['header_link']['nofollow'] ? ' rel="nofollow"' : '';

        if ($settings['header_link']['url']) {
            $link_open = '<a href="' . $settings['header_link']['url'] . '"' . $target . $nofollow . '>';
            $link_close = '</a>';
        }
        ?>
        <div class="vl-title-module">
            <?php
            if ($settings['header_title']) {
                ?>
                <div class="vp-block-header <?php echo esc_attr($settings['header_style']); ?>">
                    <h2 <?php echo $this->get_render_attribute_string('header_attr'); ?>>
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

            if (isset($settings['header_description']) && !empty($settings['header_description'])) {
                echo '<div class="vl-title-description">' . $settings['header_description'] . '</div>';
            }
            ?>
        </div>
        <?php
    }

}
