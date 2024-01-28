<?php

namespace Viral_Pro_Elements;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use Viral_Pro_Elements\AjaxSelect_Control;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Group_Control_Query extends Group_Control_Base {

    protected static $fields;

    public static function get_type() {
        return 'viral-pro-elements-query';
    }

    protected function init_fields() {
        $fields = [];

        $fields['post_type'] = [
            'label' => esc_html__('Source', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
        ];

        return $fields;
    }

    protected function prepare_fields($fields) {

        $post_types = self::get_post_types();

        $fields['post_type']['options'] = $post_types;

        $fields['post_type']['default'] = 'post';

        $taxonomy_filter_args = [
            'show_in_nav_menus' => true
        ];

        $taxonomies = get_taxonomies($taxonomy_filter_args, 'objects');

        foreach ($taxonomies as $taxonomy => $object) {
            $options = array();

            $terms = get_terms($taxonomy);

            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name . ' (' . $term->count . ')';
            }

            $fields[$taxonomy . '_ids'] = [
                'label' => $object->label,
                'description' => __('Drag and Drop to Reorder', 'viral-pro'),
                'type' => Selectize_Control::Selectize,
                'label_block' => true,
                'multiple' => true,
                'options' => $options,
                'condition' => [
                    'post_type' => $object->object_type,
                ],
            ];
        }

        $fields['exclude_posts'] = [
            'label' => esc_html__('Exclude Posts', 'viral-pro'),
            'type' => AjaxSelect_Control::AJAXSELECT,
            'search' => 'viral_pro_get_posts_by_query',
            'render' => 'viral_pro_get_posts_title_by_id',
            'label_block' => true,
            'post_type' => 'post',
            'multiple' => true,
            'condition' => [
                'post_type' => 'post'
            ]
        ];

        $fields['orderby'] = [
            'label' => esc_html__('Order By', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'date' => esc_html__('Date', 'viral-pro'),
                'modified' => esc_html__('Last Modified Date', 'viral-pro'),
                'rand' => esc_html__('Rand', 'viral-pro'),
                'comment_count' => esc_html__('Comment Count', 'viral-pro'),
                'title' => esc_html__('Title', 'viral-pro'),
                'ID' => esc_html__('Post ID', 'viral-pro'),
                'author' => esc_html__('Post Author', 'viral-pro'),
            ],
            'default' => 'date',
        ];

        $fields['order'] = [
            'label' => esc_html__('Order', 'viral-pro'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'DESC' => esc_html__('Descending', 'viral-pro'),
                'ASC' => esc_html__('Ascending', 'viral-pro'),
            ],
            'default' => 'DESC',
        ];

        $fields['offset'] = [
            'label' => esc_html__('Offset', 'viral-pro'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'default' => '',
        ];

        return parent::prepare_fields($fields);
    }

    private static function get_post_types() {
        $post_type_args = [
            'show_in_nav_menus' => true,
        ];

        $_post_types = get_post_types($post_type_args, 'objects');

        $post_types = [];

        foreach ($_post_types as $post_type => $object) {
            $post_types[$post_type] = $object->label;
        }

        return $post_types;
    }

    protected function get_default_options() {
        return [
            'popover' => false,
        ];
    }

}
