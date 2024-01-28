<?php

namespace ViralPro\Blocks;

use \ViralPro\Blocks\Headers\Viral_Pro_Block_Header;

abstract class Viral_Pro_Posts_Block extends Viral_Pro_Block {

    protected $wp_query;
    protected $max_num_pages = 1;
    protected $found_posts = 0;
    protected $query_args = array();
    protected $header_query_args = array();

    public function init_block() {
        $this->query_args = $this->build_query_args($this->settings);
        $this->query_args = apply_filters('vp_block_' . $this->settings['block_id'] . '_query_args', $this->query_args, $this->settings);
        $this->wp_query = new \WP_Query($this->query_args);
        $this->setup_pagination_for_offset();
        $this->block_items = $this->wp_query->posts;

        /* For Header Filter */
        $block_filter_terms = $this->get_block_filter_terms();
        $block_header_args = array(
            'settings' => $this->settings,
            'block_filter_terms' => $block_filter_terms
        );
        $this->block_header = new Viral_Pro_Block_Header($block_header_args);
    }

    public function get_block_header() {
        return $this->block_header->get_block_header();
    }

    public function get_block_footer() {
        return $this->get_block_pagination();
    }

    // get atts
    protected function get_block_data_atts() {
        $output = '';
        $output .= " data-block-uid='" . $this->block_uid . "'";
        $output .= " data-action='vp_load_posts_block'";
        $output .= " data-query='" . wp_json_encode($this->query_args) . "'";
        $output .= " data-settings='" . wp_json_encode($this->get_settings_data_atts()) . "'";
        $output .= " data-total='" . $this->found_posts . "'";
        $output .= " data-current='1'";
        $output .= " data-maxpages='" . $this->max_num_pages . "'";

        return apply_filters('vp_block_data_attributes', $output, $this);
    }

    protected function get_settings_defaults() {
        return array(
            'class' => '',
            'block_type' => 'news_block_one',
            'filterable' => false,
            'current_filter_term' => '',
            'pagination' => 'none',
            'show_remaining' => true,
            'show_related_posts' => false,
            'current_post_id' => '',
        );
    }

    private function setup_pagination_for_offset() {
        $offset = isset($this->settings['posts_offset']) ? intval($this->settings['posts_offset']) : 0;
        if ($offset !== 0) {
            $this->found_posts = $this->wp_query->found_posts - $offset;
            $this->max_num_pages = ceil($this->found_posts / $this->query_args['posts_per_page']);
        } else {
            $this->found_posts = $this->wp_query->found_posts;
            $this->max_num_pages = $this->wp_query->max_num_pages;
        }
    }

    protected function get_block_filter_terms() {
        $block_filter_terms = array();
        // Check if any taxonomy filter has been applied
        list($chosen_terms, $taxonomies) = $this->get_chosen_terms($this->header_query_args);

        if ($this->settings['filterable']) {
            if (!empty($chosen_terms)) {
                $terms = $chosen_terms;
            }

            if (!empty($terms) && !is_wp_error($terms)) {
                $block_filter_terms = $terms;
            }
        }
        return apply_filters('vp_block_filter_terms', $block_filter_terms, $this);
    }

    public function get_block_pagination() {
        $pagination_type = $this->settings['pagination'];
        $load_more_text = $this->settings['load_more_text'] ? $this->settings['load_more_text'] : __('Load More', 'viral-pro');
        // no pagination required if option is not chosen by user or if all posts are already displayed
        if ($pagination_type == 'none' || $this->max_num_pages == 1)
            return;
        $output = '<div class="vp-pagination ' . 'vp-' . preg_replace('/_/', '-', $pagination_type) . '-nav">';
        switch ($pagination_type) {
            case 'next_prev':
                $output .= '<a class="vp-page-nav vp-disabled" href="#" data-page="prev"><i class="icofont-thin-left"></i></a>';
                $output .= '<a class="vp-page-nav" href="#" data-page="next"><i class="icofont-thin-right"></i></a>';
                break;

            case 'load_more':
                $output .= '<a href="#" class="vp-load-more vp-button">';
                $output .= esc_html($load_more_text);
                if ($this->settings['show_remaining'])
                    $output .= '<span class="vp-post-counter">' . (intval($this->found_posts) - $this->query_args['posts_per_page']) . '</span>';
                $output .= '<div class="vp-loading"></div>';
                $output .= '</a>';
                break;

            case 'infinite_scroll':
                $output .= '<a href="#" class="vp-load-more vp-infinite-scroll">';
                $output .= '<div class="vp-big-loading"></div>';
                $output .= '</a>';
                break;

            case 'paged':
                $page_links = array();
                $current = (get_query_var('paged')) ? get_query_var('paged') : 1;
                for ($n = 1; $n <= $this->max_num_pages; $n++) :
                    $page_links[] = '<a class="vp-page-nav vp-numbered' . ($n == $current ? ' vp-current-page' : '') . '" href="#" data-page="' . $n . '">' . number_format_i18n($n) . '</a>';
                endfor;
                $r = join("\n", $page_links);
                if (!empty($page_links)) {
                    $prev_link = '<a class="vp-page-nav' . ($current == 1 ? ' vp-disabled' : '') . '" href="#" data-page="prev"><i class="icofont-thin-left"></i></a>';
                    $next_link = '<a class="vp-page-nav' . ($current == $this->max_num_pages ? ' vp-disabled' : '') . '" href="#" data-page="next"><i class="icofont-thin-right"></i></a>';
                    $output .= $prev_link . "\n" . $r . "\n" . $next_link;
                }
                break;
        }

        $output .= '</div>';
        return apply_filters('vp_block_pagination', $output, $this);
    }

    protected function get_block_items_to_display() {
        // return all posts since the query itself returns a subset of results based on posts_per_page parameter
        return apply_filters('vp_post_grid_display_items', $this->block_items, $this->settings);
    }

    private function build_query_args($settings) {
        $query_args = $this->default_query_args($settings);
        if (!empty($settings['posts_post_type'])) {
            $post_type = $query_args['post_type'] = $settings['posts_post_type'];
            $taxonomies = get_object_taxonomies($post_type, 'objects');
            $query_args['tax_query'] = array();
            $query_args['tax_query']['relation'] = 'OR';
            foreach ($taxonomies as $object) {
                $setting_key = 'posts_' . $object->name . '_ids';

                if (!empty($settings[$setting_key])) {
                    if (!$settings['filterable'] || trim($settings['all_text']) != '') {
                        $this->header_query_args['tax_query'][] = $query_args['tax_query'][] = [
                            'taxonomy' => $object->name,
                            'field' => 'term_id',
                            'terms' => $settings[$setting_key],
                        ];
                    } else {
                        $query_args['tax_query'][] = [
                            'taxonomy' => $object->name,
                            'field' => 'term_id',
                            'terms' => $settings[$setting_key][0],
                        ];
                        $this->header_query_args['tax_query'][] = [
                            'taxonomy' => $object->name,
                            'field' => 'term_id',
                            'terms' => $settings[$setting_key],
                        ];
                    }
                }
            }
        }
        $query_args['post__not_in'] = $post_type == 'post' ? $settings['posts_exclude_posts'] : [];
        $query_args = apply_filters('vp_custom_query_args', $query_args, $settings);
        $query_args['paged'] = max(1, get_query_var('paged'), get_query_var('page'));
        return apply_filters('vp_posts_query_args', $query_args, $settings);
    }

    private function default_query_args($settings) {
        $query_args = [
            'orderby' => $settings['posts_orderby'],
            'order' => $settings['posts_order'],
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish',
        ];

        $query_args['posts_per_page'] = $settings['posts_per_page'];
        $query_args['offset'] = isset($settings['posts_offset']) ? intval($settings['posts_offset']) : 0;
        return apply_filters('vp_default_query_args', $query_args, $settings);
    }

    private function get_chosen_terms($query_args) {
        $chosen_terms = array();
        $taxonomies = array();
        if (!empty($query_args) && !empty($query_args['tax_query'])) {
            $term_queries = $query_args['tax_query'];
            foreach ($term_queries as $terms_query) {
                if (!is_array($terms_query))
                    continue;
                $field = $terms_query['field'];
                $taxonomy = $terms_query['taxonomy'];
                $terms = $terms_query['terms'];
                if (empty($taxonomy) || empty($terms))
                    continue;
                if (!in_array($taxonomy, $taxonomies))
                    $taxonomies[] = $taxonomy;

                if (is_array($terms)) {
                    foreach ($terms as $term) {
                        $chosen_terms[] = get_term_by($field, $term, $taxonomy);
                    }
                } else {
                    $chosen_terms[] = get_term_by($field, $terms, $taxonomy);
                }
            }
        }

        // Remove duplicates
        $taxonomies = array_unique($taxonomies);
        $return = array($chosen_terms, $taxonomies);
        return apply_filters('vp_chosen_taxonomy_terms', $return, $query_args);
    }

}
