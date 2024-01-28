<?php

namespace Viral_Pro_Elements\Modules\TickerModule\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Viral_Pro_Elements\Group_Control_Query;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class TickerModule extends Widget_Base {

    /** Widget Name */
    public function get_name() {
        return 'he-ticker-module';
    }

    /** Widget Title */
    public function get_title() {
        return esc_html__('Ticker Module', 'viral-pro');
    }

    /** Icon */
    public function get_icon() {
        return 'vp-ticker-module vp-elementor-icon';
    }

    /** Category */
    public function get_categories() {
        return ['viral-pro-elements'];
    }

    /** Controls */
    protected function register_controls() {

        $this->start_controls_section(
                'ticker', [
            'label' => esc_html__('Ticker Block', 'viral-pro'),
                ]
        );

        $this->add_control(
                'ticker_title', [
            'label' => __('Title', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Latest Posts', 'viral-pro'),
            'placeholder' => __('Type your title here', 'viral-pro'),
            'label_block' => true
                ]
        );

        $this->add_control(
                'ticker_icon', [
            'label' => __('Icon', 'viral-pro'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'icon_target',
                'library' => 'solid',
            ],
                ]
        );

        $this->add_control(
                'ticker_animation_style', [
            'label' => __('Animation Style', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'multiple' => true,
            'options' => [
                'left-right' => __('Slide Left to Right', 'viral-pro'),
                'top-bottom' => __('Slide Top to Bottom', 'viral-pro'),
                'flip-top-bottom' => __('Flip Top to Bottom', 'viral-pro'),
            ],
            'default' => 'flip-top-bottom',
            'label_block' => true
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
                'ticker_pause_duration', [
            'label' => esc_html__('Ticker Pause Duration', 'viral-pro'),
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
                'size' => 5,
            ],
            'condition' => [
                'autoplay' => 'yes'
            ]
                ]
        );

        $this->add_control(
                'ticker_style', [
            'label' => __('Style', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'multiple' => true,
            'options' => [
                'style1' => __('Style 1', 'viral-pro'),
                'style2' => __('Style 2', 'viral-pro'),
                'style3' => __('Style 3', 'viral-pro'),
                'style4' => __('Style 4', 'viral-pro'),
            ],
            'default' => 'style1',
            'label_block' => true,
            'separator' => 'before'
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
                'ticker_post_count', [
            'label' => __('No of Posts', 'viral-pro'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'default' => 5,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'ticker_title_style', [
            'label' => esc_html__('Title', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'ticker_title_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-ticker .vl-ticker-title'
                ]
        );

        $this->add_control(
                'ticker_title_bg_color', [
            'label' => esc_html__('Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-ticker .vl-ticker-title' => 'background-color: {{VALUE}}',
                '{{WRAPPER}} .vl-ticker.style1 .vl-ticker-title:after' => 'border-color: transparent transparent transparent {{VALUE}}',
                '{{WRAPPER}} .vl-ticker.style4 .vl-ticker-title:after' => 'border-color: {{VALUE}} transparent transparent {{VALUE}}'
            ],
                ]
        );

        $this->add_control(
                'ticker_title_color', [
            'label' => esc_html__('Text Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-ticker .vl-ticker-title' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'ticker_content_style', [
            'label' => esc_html__('Content', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'ticker_content_typography',
            'label' => esc_html__('Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-ticker .vl-post-title'
                ]
        );

        $this->add_control(
                'ticker_content_bg_color', [
            'label' => esc_html__('Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-ticker' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'ticker_content_color', [
            'label' => esc_html__('Text Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-ticker .vl-post-title a' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'ticker_content_border_color', [
            'label' => esc_html__('Border Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'ticker_style' => 'style3'
            ],
            'selectors' => [
                '{{WRAPPER}} .vl-ticker.style3' => 'border-color: {{VALUE}}',
            ],
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
                '{{WRAPPER}} .vl-ticker.style1 .owl-carousel .owl-nav button, {{WRAPPER}} .vl-ticker.style4 .owl-carousel .owl-nav button' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'ticker_style' => ['style1', 'style4']
            ]
                ]
        );

        $this->add_control(
                'nav_normal_border_color', [
            'label' => esc_html__('Border Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-ticker.style2 .owl-carousel .owl-nav button, {{WRAPPER}} .vl-ticker.style3 .owl-carousel .owl-nav button' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                'ticker_style' => ['style2', 'style3']
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
                '{{WRAPPER}} .vl-ticker.style1 .owl-carousel .owl-nav button:hover, {{WRAPPER}} .vl-ticker.style4 .owl-carousel .owl-nav button:hover' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'ticker_style' => ['style1', 'style4']
            ],
                ]
        );

        $this->add_control(
                'nav_hover_border_color', [
            'label' => esc_html__('Border Color (Hover)', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'ticker_style' => ['style2', 'style3']
            ],
            'selectors' => [
                '{{WRAPPER}} .vl-ticker.style2 .owl-carousel .owl-nav button:hover, {{WRAPPER}} .vl-ticker.style3 .owl-carousel .owl-nav button:hover' => 'border-color: {{VALUE}}',
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

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $ticker_icon = $settings['ticker_icon']['value'];
        $ticker_animation = $settings['ticker_animation_style'];
        $ticker_pause = $settings['ticker_pause_duration']['size'];
        $ticker_style = $settings['ticker_style'];

        $parameters = array(
            'animation' => $ticker_animation,
            'pause' => intval($ticker_pause),
            'autoplay' => $settings['autoplay'] == 'yes' ? true : false,
        );

        $parameters_json = json_encode($parameters);


        $args = $this->query_args();
        $query = new \WP_Query($args);
        if ($query->have_posts()):
            ?>
            <div class="vl-ticker vl-ele-ticker <?php echo esc_attr($ticker_style); ?>">
                <span class="vl-ticker-title">
                    <i class="<?php echo esc_attr($ticker_icon) ?>"></i>
                    <?php
                    $ticker_title = isset($settings['ticker_title']) ? $settings['ticker_title'] : null;
                    if ($ticker_title) {
                        echo esc_html($ticker_title);
                    }
                    ?>
                </span>
                <div class="owl-carousel" data-params='<?php echo esc_attr($parameters_json); ?>'>
                    <?php
                    while ($query->have_posts()): $query->the_post();
                        echo '<h3 class="vl-post-title"><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h3>';
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php
        endif;
        ?>
        <?php
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
        $args['posts_per_page'] = $settings['ticker_post_count'];
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

}
