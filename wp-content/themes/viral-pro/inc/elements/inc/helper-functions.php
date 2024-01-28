<?php

/**
 * Helper Functions
 */
/** Get All Authors */
// Custom Excerpt
if (!function_exists('viral_pro_elements_custom_excerpt')) {

    function viral_pro_elements_custom_excerpt($limit) {
        if ($limit) {
            $content = get_the_content();
            $content = strip_tags($content);
            $content = strip_shortcodes($content);
            $excerpt = mb_substr($content, 0, $limit);

            if (strlen($content) >= $limit) {
                $excerpt = $excerpt . '...';
            }

            echo $excerpt;
        }
    }

}

/** Get All Posts */
if (!function_exists('viral_pro_elements_get_posts')) {

    function viral_pro_elements_get_posts() {

        $post_list = get_posts(array(
            'post_type' => 'post',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
        ));

        $posts = array();

        if (!empty($post_list) && !is_wp_error($post_list)) {
            foreach ($post_list as $post) {
                $posts[$post->ID] = $post->post_title;
            }
        }

        return $posts;
    }

}

/* Hash Elements Viral Pro Functions */

if (!function_exists('viral_pro_elements_featured_image')) {

    function viral_pro_elements_featured_image($viral_pro_image_size = 'full', $default_lazy_load = true) {

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

        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), $viral_pro_image_size);
            $image_url = $image[0];
        } else {
            if ($placeholder_image) {
                $placeholder_image_id = attachment_url_to_postid($placeholder_image);
                $image = wp_get_attachment_image_src($placeholder_image_id, $viral_pro_image_size);
                $image_url = $image[0];
            }
        }

        if ($default_lazy_load && $lazy_load && !(\Elementor\Plugin::$instance->editor->is_edit_mode())) {
            echo '<img class="vl-lazy" alt="' . esc_attr(get_the_title()) . '" src="' . esc_url(get_template_directory_uri()) . '/images/empty-image.png" data-src="' . esc_url($image_url) . '"/>';
        } else {
            echo '<img alt="' . esc_attr(get_the_title()) . '" src="' . esc_url($image_url) . '"/>';
        }
    }

}

if (!function_exists('viral_pro_elements_get_category_list')) {

    function viral_pro_elements_get_category_list() {
        $post_categories = viral_pro_get_post_primary_category(get_the_ID(), 'category', true);

        if (!empty($post_categories)) {
            echo '<ul class="vl-post-categories">';
            $category_ids = $post_categories['all_categories'];
            foreach ($category_ids as $category_id) {
                echo '<li><a class="vl-category vl-category-' . esc_attr($category_id) . '" href="' . esc_url(get_category_link($category_id)) . '">' . esc_html(get_cat_name($category_id)) . '</a></li>';
            }
            echo '</ul>';
        }
    }

}

if (!function_exists('viral_pro_elements_primary_category')) {

    function viral_pro_elements_primary_category($class = "vl-primary-cat-block") {
        $post_categories = viral_pro_elements_get_primary_category(get_the_ID());

        if (!empty($post_categories)) {
            $category_obj = $post_categories['primary_category'];
            $category_link = get_category_link($category_obj->term_id);
            echo '<div class="' . esc_attr($class) . '">';
            echo '<a class="vl-primary-cat vl-category-' . esc_attr($category_obj->term_id) . '" href="' . esc_url($category_link) . '">' . esc_html($category_obj->name) . '</a>';
            echo '</div>';
        }
    }

}

if (!function_exists('viral_pro_elements_get_primary_category')) {

    function viral_pro_elements_get_primary_category($post_id, $term = 'category', $return_all_categories = false) {
        $return = array();

        if (class_exists('WPSEO_Primary_Term')) {
            // Show Primary category by Yoast if it is enabled & set
            $wpseo_primary_term = new WPSEO_Primary_Term($term, $post_id);
            $primary_term = get_term($wpseo_primary_term->get_primary_term());

            if (!is_wp_error($primary_term)) {
                $return['primary_category'] = $primary_term;
            }
        }

        if (empty($return['primary_category']) || $return_all_categories) {
            $categories_list = get_the_terms($post_id, $term);

            if (empty($return['primary_category']) && !empty($categories_list)) {
                $return['primary_category'] = $categories_list[0];  //get the first category
            }

            if ($return_all_categories) {
                $return['all_categories'] = array();

                if (!empty($categories_list)) {
                    foreach ($categories_list as &$category) {
                        $return['all_categories'][] = $category->term_id;
                    }
                }
            }
        }

        return $return;
    }

}

if (!function_exists('viral_pro_elements_author_name')) {

    function viral_pro_elements_author_name() {
        echo '<span class="vl-posted-by"><i class="mdi mdi-account"></i>' . get_the_author() . '</span>';
    }

}

if (!function_exists('viral_pro_elements_comment_count')) {

    function viral_pro_elements_comment_count() {
        echo '<span class="vl-post-comment-count"><i class="mdi mdi-comment-outline"></i>' . get_comments_number() . '</span>';
    }

}

if (!function_exists('viral_pro_elements_post_date')) {

    function viral_pro_elements_post_date($format = '') {
        if ($format) {
            echo '<span class="vl-posted-on"><i class="mdi mdi-clock-time-four-outline"></i>' . get_the_date($format) . '</span>';
        } else {
            echo '<span class="vl-posted-on"><i class="mdi mdi-clock-time-four-outline"></i>' . get_the_date() . '</span>';
        }
    }

}

if (!function_exists('viral_pro_elements_time_ago')) {

    function viral_pro_elements_time_ago() {
        echo '<span class="vl-posted-on"><i class="mdi mdi-clock-time-four-outline"></i>' . human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('ago', 'viral-pro') . '</span>';
    }

}


/** Get All Categories */
if (!function_exists('viral_pro_elements_get_categories')) {

    function viral_pro_elements_get_categories() {
        $cats = array();

        $terms = get_categories(array(
            'hide_empty' => true
        ));

        foreach ($terms as $term) {
            $cats[$term->term_id] = $term->name;
        }

        return $cats;
    }

}

/** Get All Tags */
if (!function_exists('viral_pro_elements_get_tags')) {

    function viral_pro_elements_get_tags() {
        $tags = array();

        $terms = get_tags(array(
            'hide_empty' => true
        ));

        foreach ($terms as $term) {
            $tags[$term->term_id] = $term->name;
        }

        return $tags;
    }

}