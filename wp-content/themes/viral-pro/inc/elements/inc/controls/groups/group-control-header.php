<?php

namespace Viral_Pro_Elements;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Group_Control_Header extends Group_Control_Base {

    protected static $fields;

    public static function get_type() {
        return 'viral-pro-elements-header';
    }

    protected function init_fields() {
        $fields = [];

        $fields['title'] = [
            'label' => __('Title', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true
        ];

        $fields['link'] = [
            'label' => __('Link', 'viral-pro'),
            'type' => Controls_Manager::URL,
            'show_external' => true,
            'default' => [
                'url' => '',
                'is_external' => false,
                'nofollow' => true,
            ],
        ];

        $fields['style'] = [
            'label' => __('Style', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'default' => 'vl-title-default',
            'options' => [
                'vl-title-default' => __('Default', 'viral-pro'),
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
        ];

        return $fields;
    }

    protected function get_default_options() {
        return [
            'popover' => false,
        ];
    }

}
