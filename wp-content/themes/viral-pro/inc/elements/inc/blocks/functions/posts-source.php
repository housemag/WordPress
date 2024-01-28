<?php

namespace ViralPro\Blocks;

class Viral_Pro_Posts_Source {

    public $post;
    public $post_ID;

    function __construct($post) {
        $this->post = $post;
        $this->post_ID = $post->ID;
    }

    function get_title() {
        return get_the_title($this->post_ID);
    }

    function get_category_list() {
        $output = '';
        $post_categories = viral_pro_get_post_primary_category($this->post_ID, 'category', true);
        if (!empty($post_categories)) {
            $output .= '<ul class="vl-post-categories">';
            $category_ids = $post_categories['all_categories'];
            foreach ($category_ids as $category_id) {
                $output .= '<li><a class="vl-category vl-category-' . esc_attr($category_id) . '" href="' . esc_url(get_category_link($category_id)) . '">' . esc_html(get_cat_name($category_id)) . '</a></li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }

    function get_primary_category($class = "vl-primary-cat-block") {
        $output = '';
        $post_categories = viral_pro_elements_get_primary_category($this->post_ID);
        if (!empty($post_categories)) {
            $category_obj = $post_categories['primary_category'];
            $category_link = get_category_link($category_obj->term_id);
            $output .= '<div class="' . esc_attr($class) . '">';
            $output .= '<a class="vl-primary-cat vl-category-' . esc_attr($category_obj->term_id) . '" href="' . esc_url($category_link) . '">' . esc_html($category_obj->name) . '</a>';
            $output .= '</div>';
        }
        return $output;
    }

    function get_permalink() {
        return get_the_permalink($this->post_ID);
    }

    function get_custom_excerpt($limit) {
        $output = '';
        if ($limit) {
            $content = $this->post->post_content;
            $content = strip_tags($content);
            $content = strip_shortcodes($content);
            $excerpt = mb_substr($content, 0, $limit);
            if (strlen($content) >= $limit) {
                $excerpt = $excerpt . '...';
            }
            $output .= $excerpt;
        }
        return $output;
    }

    function get_author_name() {
        $author_id = get_post_field('post_author', $this->post_ID);
        $author_name = get_the_author_meta('display_name', $author_id);
        echo '<span class="vl-posted-by"><i class="mdi mdi-account"></i>' . $author_name . '</span>';
    }

    function get_comment_count() {
        echo '<span class="vl-post-comment-count"><i class="mdi mdi-comment-outline"></i>' . get_comments_number($this->post_ID) . '</span>';
    }

    function get_post_date($format = '') {
        $format = !empty($format) ? $format : get_option('date_format');
        if ($format) {
            echo '<span class="vl-posted-on"><i class="mdi mdi-clock-time-four-outline"></i>' . get_the_date($format, $this->post_ID) . '</span>';
        } else {
            echo '<span class="vl-posted-on"><i class="mdi mdi-clock-time-four-outline"></i>' . get_the_date($format, $this->post_ID) . '</span>';
        }
    }

    function get_time_ago() {
        echo '<span class="vl-posted-on"><i class="mdi mdi-clock-time-four-outline"></i>' . human_time_diff(get_the_time('U', $this->post_ID), current_time('timestamp')) . ' ' . __('ago', 'viral-pro') . '</span>';
    }

    function get_featured_image($viral_pro_image_size = 'full', $default_lazy_load = true) {
        $output = '';
        $placeholder_image = get_theme_mod('viral_pro_placeholder_image');
        $lazy_load = get_theme_mod('viral_pro_lazy_load', false);
        $viral_pro_get_all_image_sizes = viral_pro_get_all_image_sizes();
        if ($viral_pro_image_size == 'full') {
            $image_url = get_template_directory_uri() . '/images/placeholder.jpg';
        } elseif ($viral_pro_image_size == 'large') {
            $image_url = get_template_directory_uri() . '/images/placeholder-1300x540.jpg';
        } elseif ($viral_pro_image_size == 'medium') {
            $image_url = get_template_directory_uri() . '/images/placeholder-500x500.jpg';
        } elseif ($viral_pro_image_size == 'thumbnail') {
            $image_url = get_template_directory_uri() . '/images/placeholder-150x150.jpg';
        } else {
            $image_width = $viral_pro_get_all_image_sizes[$viral_pro_image_size]['width'];
            $image_height = $viral_pro_get_all_image_sizes[$viral_pro_image_size]['height'];
            $image_url = get_template_directory_uri() . '/images/placeholder-' . $image_width . 'x' . $image_height . '.jpg';
        }

        if (has_post_thumbnail($this->post_ID)) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($this->post_ID), $viral_pro_image_size);
            $image_url = $image[0];
        } else {
            if ($placeholder_image) {
                $placeholder_image_id = attachment_url_to_postid($placeholder_image);
                $image = wp_get_attachment_image_src($placeholder_image_id, $viral_pro_image_size);
                $image_url = $image[0];
            }
        }

        if ($default_lazy_load && $lazy_load && !(\Elementor\Plugin::$instance->editor->is_edit_mode())) {
            $output .= '<img class="vl-lazy" alt="' . esc_attr(get_the_title($this->post_ID)) . '" src="' . esc_url(get_template_directory_uri()) . '/images/empty-image.png" data-src="' . esc_url($image_url) . '"/>';
        } else {
            $output .= '<img alt="' . esc_attr(get_the_title()) . '" src="' . esc_url($image_url) . '"/>';
        }
        return $output;
    }

}
