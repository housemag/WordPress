<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Viral Pro
 */
if (!function_exists('viral_pro_excerpt')) {

    function viral_pro_excerpt($content, $letter_count) {
        $new_content = strip_shortcodes($content);
        $new_content = strip_tags($new_content);
        $content = mb_substr($new_content, 0, $letter_count);

        if (($letter_count !== 0) && (strlen($new_content) > $letter_count)) {
            $content .= "...";
        }
        return $content;
    }

}

function viral_pro_comment($comment, $args, $depth) {
    extract($args, EXTR_SKIP);
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    $show_avatars = get_option('show_avatars');
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? 'parent' : '', $comment); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <?php if (0 != $args['avatar_size'] && $show_avatars) { ?>
            <div class="sp-comment-avatar">
                <?php echo get_avatar($comment, $args['avatar_size']); ?>
            </div>
        <?php } ?>

        <div class="sp-comment-content">
            <div class="comment-header">
                <div class="comment-author vcard">
                    <?php
                    echo sprintf('<b class="fn">%s</b>', viral_pro_get_comment_author_link());
                    echo " - ";
                    ?>
                    <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php
                            /* translators: 1: comment date, 2: comment time */
                            printf(__('%1$s', 'viral-pro'), get_comment_date('', $comment));
                            ?>
                        </time>
                    </a>
                </div>

                <?php
                comment_reply_link(array_merge($args, array(
                    'add_below' => 'div-comment',
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'before' => '<div class="reply">',
                    'after' => '</div>'
                )));
                ?>

                <!-- .comment-author -->

                <?php if ('0' == $comment->comment_approved) : ?>
                    <p class="comment-awaiting-moderation">
                        <?php _e('Your comment is awaiting moderation.', 'viral-pro'); ?>
                    </p>
                <?php endif; ?>

            </div>
            <!-- .comment-meta -->

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            <!-- .comment-content -->
            <?php edit_comment_link(__('Edit', 'viral-pro'), '<div class="edit-link">', '</div>'); ?>
        </div>
        <!-- .comment-metadata -->
    </article>
    <!-- .comment-body -->
    <?php
}

/* Convert hexdec color string to rgb(a) string */

function viral_pro_hex2rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

function viral_pro_color_brightness($hex, $percent) {
    // Work out if hash given
    $hash = '';
    if (stristr($hex, '#')) {
        $hex = str_replace('#', '', $hex);
        $hash = '#';
    }
    /// HEX TO RGB
    $rgb = array(hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
    //// CALCULATE
    for ($i = 0; $i < 3; $i++) {
        // See if brighter or darker
        if ($percent > 0) {
            // Lighter
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
        } else {
            // Darker
            $positivePercent = $percent - ($percent * 2);
            $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1 - $positivePercent));
        }
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    //// RBG to Hex
    $hex = '';
    for ($i = 0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if (strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
    }
    return $hash . $hex;
}

function viral_pro_css_strip_whitespace($css) {
    $replace = array(
        "#/\*.*?\*/#s" => "", // Strip C style comments.
        "#\s\s+#" => " ", // Strip excess whitespace.
    );
    $search = array_keys($replace);
    $css = preg_replace($search, $replace, $css);

    $replace = array(
        ": " => ":",
        "; " => ";",
        " {" => "{",
        " }" => "}",
        ", " => ",",
        "{ " => "{",
        ";}" => "}", // Strip optional semicolons.
        ",\n" => ",", // Don't wrap multiple selectors.
        "\n}" => "}", // Don't wrap closing braces.
        "} " => "}", // Put each rule on it's own line.
    );
    $search = array_keys($replace);
    $css = str_replace($search, $replace, $css);

    return trim($css);
}

function viral_pro_get_customizer_fonts() {
    $fonts = array(
        'body' => array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '15',
            'line_height' => '1.6',
            'color' => '#333333',
            'letter_spacing' => '0'
        ),
        'menu' => array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'uppercase',
            'text_decoration' => 'none',
            'font_size' => '14',
            'line_height' => '3',
            'letter_spacing' => '0'
        ),
        'title' => array(
            'font_family' => 'Default',
            'font_style' => '700',
            'text_transform' => 'uppercase',
            'text_decoration' => 'none',
            'font_size' => '32',
            'line_height' => '1.2',
            'letter_spacing' => '0',
            'color' => '#333333',
        ),
        'tagline' => array(
            'font_family' => 'Default',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '16',
            'line_height' => '1.2',
            'letter_spacing' => '0',
            'color' => '#333333',
        ),
        'page_title' => array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '40',
            'line_height' => '1.3',
            'color' => '#333333',
            'letter_spacing' => '0'
        ),
        'frontpage_title' => array(
            'font_family' => 'Roboto',
            'font_style' => '500',
            'text_transform' => 'capitalize',
            'text_decoration' => 'none',
            'font_size' => '16',
            'line_height' => '1.3',
            'letter_spacing' => '0'
        ),
        'frontpage_block_title' => array(
            'font_family' => 'Roboto',
            'font_style' => '700',
            'text_transform' => 'uppercase',
            'text_decoration' => 'none',
            'font_size' => '20',
            'line_height' => '1.1',
            'letter_spacing' => '0'
        ),
        'sidebar_title' => array(
            'font_family' => 'Roboto',
            'font_style' => '700',
            'text_transform' => 'uppercase',
            'text_decoration' => 'none',
            'font_size' => '18',
            'line_height' => '1.3',
            'color' => '#333333',
            'letter_spacing' => '0'
        )
    );

    $common_header_typography = get_theme_mod('common_header_typography', true);

    if (!$common_header_typography) {
        $fonts['h1'] = array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '38',
            'line_height' => '1.3',
            'letter_spacing' => '0'
        );
        $fonts['h2'] = array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '34',
            'line_height' => '1.3',
            'letter_spacing' => '0'
        );
        $fonts['h3'] = array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '30',
            'line_height' => '1.3',
            'letter_spacing' => '0'
        );
        $fonts['h4'] = array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '26',
            'line_height' => '1.3',
            'letter_spacing' => '0'
        );
        $fonts['h5'] = array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '22',
            'line_height' => '1.3',
            'letter_spacing' => '0'
        );
        $fonts['h6'] = array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'font_size' => '18',
            'line_height' => '1.3',
            'letter_spacing' => '0'
        );
    } else {
        $fonts['h'] = array(
            'font_family' => 'Roboto',
            'font_style' => '400',
            'text_transform' => 'none',
            'text_decoration' => 'none',
            'line_height' => '1.3',
            'letter_spacing' => '0'
        );
    }
    return $fonts;
}

function viral_pro_parallax_background($section_name = '') {
    $bg_type = get_theme_mod("viral_pro_{$section_name}_bg_type");
    $bg_image = get_theme_mod("viral_pro_{$section_name}_bg_image_url");
    $bg_video = get_theme_mod("viral_pro_{$section_name}_bg_video", '6O9Nd1RSZSY');
    $parallax_mode = '';

    if ($bg_type == "image-bg" && !empty($bg_image)) {
        $parallax_effect = get_theme_mod("viral_pro_{$section_name}_parallax_effect");
        if ($parallax_effect == 'parallax') {
            $parallax_mode = 'data-stellar-background-ratio="0.5"';
        } elseif ($parallax_effect == 'scroll') {
            $parallax_mode = 'data-motion="true"';
        }
    } elseif ($bg_type == "video-bg" && !empty($bg_video)) {
        $parallax_mode = 'data-property="{videoURL:\'' . $bg_video . '\', mobileFallbackImage:\'https://img.youtube.com/vi/' . $bg_video . '/maxresdefault.jpg\'}"';
    }

    return $parallax_mode;
}

if (!function_exists('viral_pro_is_woocommerce_activated')) {

    function viral_pro_is_woocommerce_activated() {
        if (class_exists('woocommerce')) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('attachment_url_to_postid')) {

    function attachment_url_to_postid($attachment_src) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$attachment_src'";
        $id = $wpdb->get_var($query);
        return $id;
    }

}

function viral_pro_get_image_sizes() {

    foreach (get_intermediate_image_sizes() as $_size) {
        if (in_array($_size, array('thumbnail', 'medium', 'large'))) {
            $default_sizes[$_size] = 'Image Size - ' . get_option("{$_size}_size_w") . 'x' . get_option("{$_size}_size_h") . ' (' . ucfirst($_size) . ')';
        }
    }

    $sizes = array(
        'full' => __('Full Size', 'viral-pro'),
        'viral-pro-1300x540' => __('Image Size - 1300x540', 'viral-pro'),
        'viral-pro-800x500' => __('Image Size - 800x500', 'viral-pro'),
        'viral-pro-700x700' => __('Image Size - 700x700', 'viral-pro'),
        'viral-pro-650x500' => __('Image Size - 650x500', 'viral-pro'),
        'viral-pro-500x500' => __('Image Size - 500x500', 'viral-pro'),
        'viral-pro-500x600' => __('Image Size - 500x600', 'viral-pro'),
        'viral-pro-360x240' => __('Image Size - 360x240', 'viral-pro'),
        'viral-pro-150x150' => __('Image Size - 150x150', 'viral-pro')
    );

    $all_sizes = array_merge($sizes, $default_sizes);

    return $all_sizes;
}

function viral_pro_get_default_widgets() {
    return array('viral-pro-right-sidebar', 'viral-pro-left-sidebar', 'viral-pro-shop-right-sidebar', 'viral-pro-shop-left-sidebar', 'viral-pro-header-widget', 'viral-pro-offcanvas-sidebar', 'viral-pro-top-footer', 'viral-pro-footer1', 'viral-pro-footer2', 'viral-pro-footer3', 'viral-pro-footer4', 'viral-pro-footer5', 'viral-pro-footer6', 'viral-pro-bottom-footer', 'viral-pro-below-menu', 'viral-pro-single-post-before-article', 'viral-pro-single-post-after-article');
}

if (!function_exists('viral_pro_youtube_duration')) {

    function viral_pro_youtube_duration($duration) {
        preg_match_all('/(\d+)/', $duration, $parts);

        //Put in zeros if we have less than 3 numbers.
        if (count($parts[0]) == 1) {
            array_unshift($parts[0], "0", "0");
        } elseif (count($parts[0]) == 2) {
            array_unshift($parts[0], "0");
        }

        $sec_init = $parts[0][2];
        $seconds = $sec_init % 60;
        $seconds = str_pad($seconds, 2, "0", STR_PAD_LEFT);
        $seconds_overflow = floor($sec_init / 60);

        $min_init = $parts[0][1] + $seconds_overflow;
        $minutes = ( $min_init ) % 60;
        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
        $minutes_overflow = floor(( $min_init ) / 60);

        $hours = $parts[0][0] + $minutes_overflow;

        if ($hours != 0) {
            return $hours . ':' . $minutes . ':' . $seconds;
        } else {
            return $minutes . ':' . $seconds;
        }
    }

}

function viral_pro_get_post_view() {
    $count = get_post_meta(get_the_ID(), 'post_views_count', true);
    return $count;
}

function viral_pro_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta($post_id, $key, true);
    $count++;
    update_post_meta($post_id, $key, $count);
}

function viral_pro_check_active_footer() {
    $viral_pro_footer_col = get_theme_mod('viral_pro_footer_col', 'col-3-1-1-1');
    $viral_pro_footer_array = explode('-', $viral_pro_footer_col);
    $count = count($viral_pro_footer_array);
    $footer_col = $count - 2;
    $status = false;

    for ($i = 1; $i <= $footer_col; $i++) {
        if (is_active_sidebar('viral-pro-footer' . $i)) {
            $status = true;
        }
    }

    return $status;
}

/*
  function viral_pro_posts_column_views( $columns ) {
  $columns['post_views'] = 'Views';
  return $columns;
  }
  function viral_pro_posts_custom_column_views( $column ) {
  if ( $column === 'post_views') {
  echo viral_pro_get_post_view();
  }
  }
  add_filter( 'manage_posts_columns', 'viral_pro_posts_column_views' );
  add_action( 'manage_posts_custom_column', 'viral_pro_posts_custom_column_views' );
 */

if (!function_exists('viral_pro_calculate_reading_time')) {

    function viral_pro_calculate_reading_time() {
        $wpm = apply_filters('viral_pro_filter_wpm', 250);
        $include_shortcodes = true;
        $exclude_images = false;

        $tmpContent = get_post_field('post_content', get_the_ID());
        $number_of_images = substr_count(strtolower($tmpContent), '<img ');
        if (!$include_shortcodes) {
            $tmpContent = strip_shortcodes($tmpContent);
        }
        $tmpContent = strip_tags($tmpContent);
        $wordCount = str_word_count($tmpContent);

        if (!$exclude_images) {
            $additional_words_for_images = viral_pro_calculate_images($number_of_images, $wpm);
            $wordCount += $additional_words_for_images;
        }

        $readingTime = ceil($wordCount / $wpm);

        // If the reading time is 0 then return it as < 1 instead of 0.
        if ($readingTime < 1) {
            $readingTime = esc_html__('< 1 Min Read', 'viral-pro');
        } elseif ($readingTime == 1) {
            $readingTime = esc_html__('1 Min Read', 'viral-pro');
        } else {
            $readingTime = $readingTime . ' ' . esc_html__('Mins Read', 'viral-pro');
        }

        return $readingTime;
    }

}

if (!function_exists('viral_pro_calculate_images')) {

    function viral_pro_calculate_images($total_images, $wpm) {
        $additional_time = 0;
        // For the first image add 12 seconds, second image add 11, ..., for image 10+ add 3 seconds
        for ($i = 1; $i <= $total_images; $i++) {
            if ($i >= 10) {
                $additional_time += 3 * (int) $wpm / 60;
            } else {
                $additional_time += (12 - ($i - 1) ) * (int) $wpm / 60;
            }
        }

        return $additional_time;
    }

}

function viral_pro_pll_string_register_helper($theme_mod, $group) {
    if (!function_exists('pll_register_string')) {
        return;
    }

    $repeater_content = get_theme_mod($theme_mod);
    $repeater_content = json_decode($repeater_content);
    $include_fields = array('title', 'link');

    if (!empty($repeater_content)) {
        foreach ($repeater_content as $repeater_item) {
            foreach ($repeater_item as $field_name => $field_value) {
                if ($field_value !== 'undefined') {
                    if (in_array($field_name, $include_fields)) {
                        $name = str_replace('_', ' ', $field_name);
                        $name = ucwords($name);
                        pll_register_string($name, $field_value, $group, true);
                    }
                }
            }
        }
    }
}

function viral_pro_sections_register_strings() {
    $translatable_sections = array(
        'viral_pro_frontpage_leftnews_blocks' => __('News Module - Right Sidebar', 'viral-pro'),
        'viral_pro_frontpage_rightnews_blocks' => __('News Module - Left Sidebar', 'viral-pro'),
        'viral_pro_frontpage_carousel1_blocks' => __('Carousel Module One', 'viral-pro'),
        'viral_pro_frontpage_carousel2_blocks' => __('Carousel Module Two', 'viral-pro'),
        'viral_pro_frontpage_fwnews_blocks' => __('News Module - Full Width', 'viral-pro'),
        'viral_pro_frontpage_featured_blocks' => __('Featured Image Module', 'viral-pro')
    );
    foreach ($translatable_sections as $field_mods => $field_name) {
        viral_pro_pll_string_register_helper($field_mods, $field_name);
    }
}

if (function_exists('pll_register_string')) {
    add_action('after_setup_theme', 'viral_pro_sections_register_strings', 11);
}

/**
 * Filter to translate strings
 */
function viral_pro_translate_string($original_value, $domain) {
    if (is_customize_preview()) {
        $wpml_translation = $original_value;
    } else {
        $wpml_translation = apply_filters('wpml_translate_single_string', $original_value, $domain, $original_value);
        if ($wpml_translation === $original_value && function_exists('pll__')) {
            return pll__($original_value);
        }
    }
    return $wpml_translation;
}

add_filter('viral_pro_translate_string', 'viral_pro_translate_string', 10, 2);

function viral_pro_add_current_year() {
    return date("Y");
}

add_shortcode('display-year', 'viral_pro_add_current_year');

if (!function_exists('viral_pro_get_schema_attribute')) {

    function viral_pro_get_schema_attribute($place) {
        $schema_markup = get_theme_mod('viral_pro_schema_markup', false);
        if (!$schema_markup) {
            return '';
        }
        $attrs = "";
        switch ($place) {
            case 'single':
                $itemscope = 'itemscope';
                $itemtype = 'WebPage';
                break;
            case 'article':
                $itemscope = 'itemscope';
                $itemtype = 'Article';
                break;
            case 'blog':
                $itemscope = 'itemscope';
                $itemtype = 'Blog';
                break;
            case 'header':
                $itemscope = '';
                $itemtype = 'WPHeader';
                break;
            case 'logo':
                $itemscope = 'itemscope';
                $itemtype = 'Organization';
                break;
            case 'navigation':
                $itemscope = '';
                $itemtype = 'SiteNavigationElement';
                break;
            case 'breadcrumb':
                $itemscope = '';
                $itemtype = 'BreadcrumbList';
                break;
            case 'sidebar':
                $itemscope = 'itemscope';
                $itemtype = 'WPSideBar';
                break;
            case 'footer':
                $itemscope = 'itemscope';
                $itemtype = 'WPFooter';
                break;
            case 'author':
                $itemprop = 'author';
                $itemscope = '';
                $itemtype = 'Person';
                break;
            case 'breadcrumb_list':
                $itemscope = '';
                $itemtype = 'BreadcrumbList';
                break;
            case 'breadcrumb_item':
                $itemscope = '';
                $itemprop = 'itemListElement';
                $itemtype = 'ListItem';
                break;
            case 'author_name':
                $itemprop = 'name';
                break;
            case 'author_link':
                $itemprop = 'author';
                break;
            case 'author_url':
                $itemprop = 'url';
                break;
            case 'publish_date':
                $itemprop = 'datePublished';
                break;
            case 'modified_date':
                $itemprop = 'dateModified';
                break;
            default:
        }
        if (isset($itemprop)) {
            $attrs .= ' itemprop="' . $itemprop . '"';
        }
        if (isset($itemtype)) {
            $attrs .= ' itemtype="https://schema.org/' . $itemtype . '"';
        }
        if (isset($itemscope)) {
            $attrs .= ' itemscope="' . $itemscope . '"';
        }
        return apply_filters('viral_pro_schema_' . $place . '_attributes', $attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

}