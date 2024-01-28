<?php

namespace Viral_Pro_Elements\Modules\FeaturedModule\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class FeaturedModule extends Widget_Base {

    /** Widget Name */
    public function get_name() {
        return 'vp-featured-module';
    }

    /** Widget Title */
    public function get_title() {
        return esc_html__('Featured Image Module', 'viral-pro');
    }

    /** Icon */
    public function get_icon() {
        return 'vp-featured-module vp-elementor-icon';
    }

    /** Category */
    public function get_categories() {
        return ['viral-pro-elements'];
    }

    /** Controls */
    protected function register_controls() {

        $this->start_controls_section(
                'section_featured_block', [
            'label' => esc_html__('Content', 'viral-pro'),
                ]
        );

        $this->add_control(
                'image', [
            'label' => __('Choose Image', 'viral-pro'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
                ]
        );

        $this->add_control('title', [
            'label' => __('Title', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
        ]);

        $this->add_control('link', [
            'label' => __('Link', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'separator' => 'after'
        ]);

        $this->add_group_control(
                Group_Control_Image_Size::get_type(), [
            'name' => 'image_size',
            'exclude' => ['custom'],
            'include' => [],
            'default' => 'viral-pro-650x500',
                ]
        );

        $this->add_control(
                'thumb_height', [
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
                'size' => 100,
            ],
            'selectors' => [
                '{{WRAPPER}} .vl-thumb-container' => 'padding-bottom: {{SIZE}}{{UNIT}}',
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
                '{{WRAPPER}} .vl-post-thumb' => 'border-radius: {{SIZE}}{{UNIT}};'
            ],
                ]
        );

        $this->add_control(
                'featured_layout', [
            'label' => __('Layout Style', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1', 'viral-pro'),
                'style2' => __('Style 2', 'viral-pro'),
            ],
            'label_block' => true,
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
                'title_style', [
            'label' => esc_html__('Title', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_html__('Title Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .ht-featured-block span',
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => esc_html__('Title Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ht-featured-block span' => 'color: {{VALUE}}',
            ]
                ]
        );

        $this->add_control(
                'title_bg_color', [
            'label' => esc_html__('Title Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ht-featured-block span' => 'background-color: {{VALUE}}',
            ]
                ]
        );

        $this->add_control(
                'border_color', [
            'label' => esc_html__('Border Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ht-featured-block>a:after' => 'border-color: {{VALUE}}',
            ]
                ]
        );

        $this->add_control(
                'title_padding', [
            'label' => esc_html__('Title Padding', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .ht-featured-block span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
                ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $featured_style = $settings['featured_layout'];

        $class = array(
            'ht-featured-block-wrap',
            esc_attr($featured_style),
            esc_attr($settings['image_hover_style'])
        );
        ?>
        <div class="<?php echo implode(' ', $class) ?>">

            <div class="ht-featured-block vl-post-thumb">
                <?php
                echo '<a href="' . esc_url($settings['link']) . '">';
                echo '<div class="vl-thumb-container">';
                echo Group_Control_Image_Size::get_attachment_image_html($settings, 'image_size', 'image');
                echo '</div>';

                if (!empty($settings['title'])) {
                    ?> 
                    <span><?php echo esc_html($settings['title']); ?></span>
                    <?php
                }

                echo '</a>';
                ?>
            </div>

        </div>
        <?php
    }

}
