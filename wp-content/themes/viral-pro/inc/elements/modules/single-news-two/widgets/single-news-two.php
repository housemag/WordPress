<?php

namespace Viral_Pro_Elements\Modules\SingleNewsTwo\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Viral_Pro_Elements\Group_Control_Header;
use Viral_Pro_Elements\AjaxSelect_Control;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class Single_News_Two extends Widget_Base {

    /** Widget Name */
    public function get_name() {
        return 'vp-single-news-two';
    }

    /** Widget Title */
    public function get_title() {
        return esc_html__('Single News Two', 'viral-pro');
    }

    /** Icon */
    public function get_icon() {
        return 'vp-elementor-icon vp-single-news-two';
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

        $this->add_control(
                'filter_option', [
            'label' => esc_html__('Select Filter', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                'single-post' => esc_html__('By Post Title', 'viral-pro'),
                'categories' => esc_html__('By Categories', 'viral-pro'),
                'tags' => esc_html__('By Tags', 'viral-pro'),
            ),
            'default' => 'categories',
            'label_block' => true,
            'description' => esc_html__('Displays only one post', 'viral-pro')
                ]
        );

        $this->add_control(
                'post_id', [
            'label' => esc_html__('Select Post', 'viral-pro'),
            'type' => AjaxSelect_Control::AJAXSELECT,
            'search' => 'viral_pro_get_posts_by_query',
            'render' => 'viral_pro_get_posts_title_by_id',
            'label_block' => true,
            'post_type' => 'post',
            'condition' => [
                'filter_option' => 'single-post'
            ]
                ]
        );

        $this->add_control(
                'categories', [
            'label' => esc_html__('Select Categories', 'viral-pro'),
            'type' => Controls_Manager::SELECT2,
            'options' => viral_pro_elements_get_categories(),
            'label_block' => true,
            'multiple' => true,
            'condition' => [
                'filter_option' => 'categories'
            ],
            'description' => esc_html__('Displays latest post from the selected categories', 'viral-pro')
                ]
        );

        $this->add_control(
                'tags', [
            'label' => esc_html__('Select Tags', 'viral-pro'),
            'type' => Controls_Manager::SELECT2,
            'options' => viral_pro_elements_get_tags(),
            'multiple' => true,
            'label_block' => true,
            'condition' => [
                'filter_option' => 'tags'
            ],
            'description' => esc_html__('Displays latest post from the selected tags', 'viral-pro')
                ]
        );

        $this->add_control(
                'offset', [
            'label' => esc_html__('Offset', 'viral-pro'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 50,
            'condition' => [
                'filter_option' => ['categories', 'tags']
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_post_meta', [
            'label' => esc_html__('Post Meta', 'viral-pro'),
                ]
        );

        $this->add_control(
                'post_author', [
            'label' => esc_html__('Show Post Author', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes'
                ]
        );

        $this->add_control(
                'post_date', [
            'label' => esc_html__('Show Post Date', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes'
                ]
        );

        $this->add_control(
                'post_comment', [
            'label' => esc_html__('Show Post Comments', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes'
                ]
        );

        $this->add_control(
                'post_category', [
            'label' => esc_html__('Show Category', 'viral-pro'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'viral-pro'),
            'label_off' => esc_html__('No', 'viral-pro'),
            'return_value' => 'yes',
            'default' => 'yes',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_post_excerpt', [
            'label' => esc_html__('Post Excerpt', 'viral-pro'),
                ]
        );

        $this->add_control('excerpt_length', [
            'label' => esc_html__('Excerpt Length (in Letters)', 'viral-pro'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'default' => 0,
            'description' => esc_html__('Leave blank or enter 0 to hide the excerpt', 'viral-pro'),
        ]);

        $this->end_controls_section();

        $this->start_controls_section(
                'section_post_image', [
            'label' => esc_html__('Image Settings', 'viral-pro'),
                ]
        );

        $this->add_group_control(
                Group_Control_Image_Size::get_type(), [
            'name' => 'image',
            'exclude' => ['custom'],
            'include' => [],
            'default' => 'large',
                ]
        );

        $this->add_control(
                'image_height', [
            'label' => esc_html__('Image Height (%)', 'viral-pro'),
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
                'size' => 80,
            ],
            'selectors' => [
                '{{WRAPPER}} .vl-post-thumb .vl-thumb-container' => 'padding-bottom: {{SIZE}}{{UNIT}};',
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
                'content_alignment', [
            'label' => __('Content Alignment', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'default' => 'vl-align-left',
            'options' => [
                'vl-align-left' => __('Left', 'viral-pro'),
                'vl-align-center' => __('Center', 'viral-pro'),
                'vl-align-right' => __('Right', 'viral-pro'),
            ],
            'label_block' => true,
                ]
        );

        $this->add_control(
                'content_padding', [
            'label' => esc_html__('Content Padding', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vl-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'content_margin', [
            'label' => esc_html__('Content Margin', 'viral-pro'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .vl-post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'overlay_background_section', [
            'label' => esc_html__('Overlay Background', 'viral-pro'),
                ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(), [
            'name' => 'background',
            'label' => __('Overlay Background', 'viral-pro'),
            'types' => ['gradient'],
            'selector' => '{{WRAPPER}} .vl-post-content',
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
                'category_bg_color', [
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
                'category_bg_hover_color', [
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
                '{{WRAPPER}} .vl-post-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
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
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="vl-single-post <?php echo esc_attr($settings['image_hover_style']); ?>">

            <?php $this->render_header(); ?>

            <?php
            $args = $this->query_args();
            $post_query = new \WP_Query($args);

            if ($post_query->have_posts()) {
                ?>
                <div class="vl-single-post-two">
                    <?php
                    while ($post_query->have_posts()) {
                        $post_query->the_post();
                        $image_size = $settings['image_size'];
                        $excerpt_length = $settings['excerpt_length'];
                        ?>
                        <div class="vl-post-thumb">
                            <a href="<?php the_permalink(); ?>">
                                <div class="vl-thumb-container">
                                    <?php
                                    viral_pro_elements_featured_image($image_size);
                                    ?>
                                </div>
                                <div class="vl-post-content vl-gradient-overlay <?php echo $settings['content_alignment']; ?>">

                                    <h3 class="vl-post-title"><?php the_title(); ?></h3>

                                    <?php $this->get_post_meta(); ?>

                                    <?php
                                    if ($excerpt_length) {
                                        ?>
                                        <div class="vl-excerpt"><?php echo viral_pro_elements_custom_excerpt($excerpt_length); ?></div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </a>
                            <?php
                            if ($settings['post_category'] == 'yes')
                                viral_pro_elements_primary_category('vl-primary-cat-block');
                            ?>                           
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
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

    /** Query Args */
    protected function query_args() {
        $settings = $this->get_settings_for_display();

        $filter_option = $settings['filter_option'];
        if ($filter_option == 'single-post') {
            if (!empty($settings['post_id'])) {
                $args['p'] = $settings['post_id'];
            }
        } elseif ($filter_option == 'categories') {
            if (!empty($settings['categories'])) {
                $args['tax_query'][] = [
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $settings['categories'],
                ];
            }
        } elseif ($filter_option == 'tags') {
            if (!empty($settings['tags'])) {
                $args['tax_query'][] = [
                    'taxonomy' => 'post_tag',
                    'field' => 'term_id',
                    'terms' => $settings['tags'],
                ];
            }
        }

        if ($settings['offset']) {
            $args['offset'] = $settings['offset'];
        }

        $args['ignore_sticky_posts'] = 1;
        $args['post_status'] = 'publish';
        $args['posts_per_page'] = 1;

        return $args;
    }

}
