<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Viral Pro
 */
if (!function_exists('viral_pro_posted_on')) {

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function viral_pro_posted_on() {

        $viral_pro_single_author = get_theme_mod('viral_pro_single_author', true);
        $viral_pro_single_date = get_theme_mod('viral_pro_single_date', true);
        $viral_pro_single_comment_count = get_theme_mod('viral_pro_single_comment_count', true);
        $viral_pro_single_views = get_theme_mod('viral_pro_single_views', true);
        $viral_pro_single_reading_time = get_theme_mod('viral_pro_single_reading_time', true);
        $viral_pro_is_updated_date = get_theme_mod('viral_pro_display_date_option', 'posted') == 'updated' ? true : false;

        if ($viral_pro_single_author) {
            $avatar = get_avatar(get_the_author_meta('ID'), 32);
            $author = $avatar . '<span class="author vcard">' . esc_html(get_the_author()) . '</span>';

            echo '<span class="entry-author"> ' . $author . '</span>';
        }

        if ($viral_pro_single_date) {
            $ago_format = get_theme_mod('viral_pro_display_time_ago', false);

            $get_the_modified_date = get_the_modified_date();
            $get_the_date = $viral_pro_is_updated_date ? $get_the_modified_date : get_the_date();

            if ($ago_format) {
                $get_the_modified_date = sprintf(_x('%s ago', '%s = human-readable time difference', 'viral-pro'), human_time_diff(get_the_modified_date('U'), current_time('timestamp')));
                $get_the_date = $viral_pro_is_updated_date ? $get_the_modified_date : sprintf(_x('%s ago', '%s = human-readable time difference', 'viral-pro'), human_time_diff(get_the_time('U'), current_time('timestamp')));
            }

            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

            if ((get_the_time('U') !== get_the_modified_time('U') && !$viral_pro_is_updated_date)) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $time_string = sprintf(
                    $time_string, esc_attr(($viral_pro_is_updated_date ? get_the_modified_date(DATE_W3C) : get_the_date(DATE_W3C))), esc_html($get_the_date), esc_attr(get_the_modified_date(DATE_W3C)), esc_html($get_the_modified_date)
            );

            echo '<span class="entry-post-date"><i class="mdi mdi-clock-time-four-outline"></i>' . $time_string . '</span>';
        }

        if ($viral_pro_single_comment_count) {
            $comment_count = get_comments_number(); // get_comments_number returns only a numeric value

            if (comments_open()) {
                if ($comment_count == 0) {
                    $comments = __('0 Comments', 'viral-pro');
                } elseif ($comment_count > 1) {
                    $comments = $comment_count . __(' Comments', 'viral-pro');
                } else {
                    $comments = __('1 Comment', 'viral-pro');
                }
                $comment_link = $comments;
            } else {
                $comment_link = "";
            }

            echo '<span class="entry-comment"><i class="mdi mdi-comment-outline"></i>' . $comment_link . '</span>';
        }

        if ($viral_pro_single_views) {
            echo '<span class="entry-views"><i class="mdi mdi-eye-outline"></i>' . viral_pro_get_post_view() . '</span>';
        }

        if ($viral_pro_single_reading_time) {
            echo '<span class="entry-read-time"><i class="mdi mdi-book-open"></i>' . viral_pro_calculate_reading_time() . '</span>';
        }
    }

}

if (!function_exists('viral_pro_social_share')) {

    function viral_pro_social_share() {
        global $post;

        $post_url = get_permalink();

        // Get current page title
        $post_title = str_replace(' ', '%20', get_the_title());

        // Get Post Thumbnail for pinterest
        if (has_post_thumbnail($post->ID)) {
            $post_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
            $thumb = $post_thumbnail[0];
        } else {
            $thumb = '';
        }

        // Construct sharing URL
        $twitterURL = 'https://twitter.com/intent/tweet?text=' . $post_title . '&amp;url=' . $post_url;
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
        $pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $post_url . '&amp;media=' . $thumb . '&amp;description=' . $post_title;
        $linkedinURL = 'https://linkedin.com/shareArticle?mini=true&amp;url=' . $post_url . '&amp;title=' . $post_title;
        $redditURL = 'http://www.reddit.com/submit?url=' . $post_url . '&amp;title=' . $post_title;
        $mailURL = 'mailto:?Subject=' . $post_title . '&amp;Body=' . $post_url;

        $content = '<div class="viral-pro-share-buttons">';
        $content .= '<a class="facebook-share" target="_blank" href="' . $facebookURL . '" target="_blank"><i class="social_facebook_circle"></i><span class="screen-reader-text">' . esc_html__('Facebook', 'viral-pro') . '</span></a>';
        $content .= '<a class="twitter-share" target="_blank" href="' . $twitterURL . '" target="_blank"><i class="vp-twitter-x-circ"></i><span class="screen-reader-text">' . esc_html__('Twitter', 'viral-pro') . '</span></a>';
        $content .= '<a class="linkedin-share" target="_blank" href="' . $linkedinURL . '" target="_blank"><i class="social_linkedin_circle"></i><span class="screen-reader-text">' . esc_html__('LinkedIn', 'viral-pro') . '</span></a>';
        $content .= '<a class="pinterest-share" target="_blank" href="' . $pinterestURL . '" target="_blank"><i class="social_pinterest_circle"></i><span class="screen-reader-text">' . esc_html__('Pinterest', 'viral-pro') . '</span></a>';
        $content .= '<a class="reddit-share" target="_blank" href="' . $redditURL . '" target="_blank"><i class="mdi mdi-reddit"></i><span class="screen-reader-text">' . esc_html__('Stumbleupon', 'viral-pro') . '</span></a>';
        $content .= '<a class="email-share" target="_blank" href="' . $mailURL . '"><i class="icon_mail"></i><span class="screen-reader-text">' . esc_html__('Email', 'viral-pro') . '</span></a>';
        $content .= '</div>';

        echo $content;
    }

}

if (!function_exists('viral_pro_post_author')) {

    function viral_pro_post_author() {
        echo '<span class="vl-posted-by" ' . viral_pro_get_schema_attribute('author_name') . '><i class="mdi mdi-account"></i>' . esc_html(get_the_author()) . '</span>';
    }

}


if (!function_exists('viral_pro_post_date')) {

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function viral_pro_post_date() {
        $viral_pro_is_updated_date = get_theme_mod('viral_pro_display_date_option', 'posted') == 'updated' ? true : false;
        $ago_format = get_theme_mod('viral_pro_display_time_ago', false);
        $time_string = $viral_pro_is_updated_date ? get_the_modified_date() : get_the_date();

        if ($ago_format) {
            $time_string = sprintf(_x('%s ago', '%s = human-readable time difference', 'viral-pro'), human_time_diff(($viral_pro_is_updated_date ? get_the_modified_time('U') : get_the_time('U')), current_time('timestamp')));
        }

        echo '<span class="vl-posted-on" ' . viral_pro_get_schema_attribute('publish_date') . '><i class="mdi mdi-clock-time-four-outline"></i>' . $time_string . '</span>'; // WPCS: XSS OK.
    }

}

if (!function_exists('viral_pro_post_primary_category')) {

    function viral_pro_post_primary_category($class = "vl-primary-cat-block") {
        $post_categories = viral_pro_get_post_primary_category(get_the_ID());

        if (!empty($post_categories)) {
            $category_obj = $post_categories['primary_category'];
            $category_link = get_category_link($category_obj->term_id);
            echo '<div class="' . esc_attr($class) . '">';
            echo '<a class="vl-primary-cat vl-category-' . esc_attr($category_obj->term_id) . '" href="' . esc_url($category_link) . '">' . esc_html($category_obj->name) . '</a>';
            echo '</div>';
        }
    }

}

if (!function_exists('viral_pro_get_the_category_list')) {

    function viral_pro_get_the_category_list() {
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

if (!function_exists('viral_pro_get_post_primary_category')) {

    function viral_pro_get_post_primary_category($post_id, $term = 'category', $return_all_categories = false) {
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

if (!function_exists('viral_pro_get_all_image_sizes')) {

    function viral_pro_get_all_image_sizes() {
        global $_wp_additional_image_sizes;

        $sizes = array();

        foreach (get_intermediate_image_sizes() as $_size) {
            if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
                $sizes[$_size]['width'] = get_option("{$_size}_size_w");
                $sizes[$_size]['height'] = get_option("{$_size}_size_h");
                $sizes[$_size]['crop'] = (bool) get_option("{$_size}_crop");
            } elseif (isset($_wp_additional_image_sizes[$_size])) {
                $sizes[$_size] = array(
                    'width' => $_wp_additional_image_sizes[$_size]['width'],
                    'height' => $_wp_additional_image_sizes[$_size]['height'],
                    'crop' => $_wp_additional_image_sizes[$_size]['crop'],
                );
            }
        }

        return $sizes;
    }

}

if (!function_exists('viral_pro_post_featured_image')) {

    function viral_pro_post_featured_image($viral_pro_image_size = 'full', $default_lazy_load = true) {

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

        if ($default_lazy_load && $lazy_load && !viral_pro_is_amp()) {
            echo '<img class="vl-lazy" alt="' . esc_attr(get_the_title()) . '" src="' . esc_url(get_template_directory_uri()) . '/images/empty-image.png" data-src="' . esc_url($image_url) . '"/>';
        } else {
            echo '<img alt="' . esc_attr(get_the_title()) . '" src="' . esc_url($image_url) . '"/>';
        }
    }

}

/* Single Page Content Functions */

if (!function_exists('viral_pro_single_featured_image')) {

    function viral_pro_single_featured_image() {
        if (has_post_thumbnail()) {
            ?>
            <figure class="single-entry-figure">
                <?php
                $viral_pro_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'viral-pro-840x420');
                ?>
                <img src="<?php echo esc_url($viral_pro_image[0]); ?>" alt="<?php echo esc_attr(get_the_title()) ?>">
            </figure>
            <?php
        }
    }

}

if (!function_exists('viral_pro_single_post_meta')) {

    function viral_pro_single_post_meta() {
        $viral_pro_single_author = get_theme_mod('viral_pro_single_author', true);
        $viral_pro_single_date = get_theme_mod('viral_pro_single_date', true);
        $viral_pro_single_comment_count = get_theme_mod('viral_pro_single_comment_count', true);
        $viral_pro_single_views = get_theme_mod('viral_pro_single_views', true);
        $viral_pro_single_reading_time = get_theme_mod('viral_pro_single_reading_time', true);

        if ('post' === get_post_type() && ($viral_pro_single_author || $viral_pro_single_date || $viral_pro_single_comment_count || $viral_pro_single_views || $viral_pro_single_reading_time)) {
            ?>
            <div class="single-entry-meta">
                <?php viral_pro_posted_on(); ?>
            </div><!-- .entry-meta -->
            <?php
        }
    }

}


if (!function_exists('viral_pro_single_category')) {

    function viral_pro_single_category() {
        $viral_pro_single_categories = get_theme_mod('viral_pro_single_categories', true);

        if ($viral_pro_single_categories && 'post' === get_post_type()) {
            $categories_list = get_the_category_list(', ');
            if ($categories_list) {
                echo '<div class="single-entry-category">';
                echo $categories_list;
                echo '</div>';
            }
        }
    }

}

if (!function_exists('viral_pro_single_tag')) {

    function viral_pro_single_tag() {
        $viral_pro_single_tags = get_theme_mod('viral_pro_single_tags', true);

        if ($viral_pro_single_tags && 'post' === get_post_type()) {
            $tags_list = get_the_tag_list('', '');
            if ($tags_list) {
                echo '<div class="single-entry-tags">';
                echo $tags_list;
                echo '</div>';
            }
        }
    }

}

if (!function_exists('viral_pro_single_social_share')) {

    function viral_pro_single_social_share() {
        $viral_pro_single_social_share = get_theme_mod('viral_pro_single_social_share', 'sticky');

        if ($viral_pro_single_social_share == 'bottom' || $viral_pro_single_social_share == 'both') {
            ?>
            <div class="ht-social-share">
                <span><?php esc_html_e('Share', 'viral-pro'); ?></span>
                <?php viral_pro_social_share(); ?>
            </div>
            <?php
        }
    }

}

if (!function_exists('viral_pro_single_sticky_social_share')) {

    function viral_pro_single_sticky_social_share() {
        $viral_pro_single_social_share = get_theme_mod('viral_pro_single_social_share', 'sticky');

        if ($viral_pro_single_social_share == 'sticky' || $viral_pro_single_social_share == 'both') {
            ?>
            <div class="sticky-social-share">
                <div class="viral-pro-share-buttons-wrap">
                    <?php viral_pro_social_share(); ?>
                    <span><?php esc_html_e('Share', 'viral-pro'); ?></span>
                </div>
            </div>
            <?php
        }
    }

}

if (!function_exists('viral_pro_single_author_box')) {

    function viral_pro_single_author_box() {

        global $post;

        $viral_pro_single_author_box = get_theme_mod('viral_pro_single_author_box', true);

        if ($viral_pro_single_author_box && 'post' === get_post_type() && isset($post->post_author)) {
            // Get Author Data
            $author = get_the_author();
            $author_description = get_the_author_meta('description', $post->post_author);
            $author_url = get_author_posts_url($post->post_author);
            $author_avatar = get_avatar(get_the_author_meta('user_email', $post->post_author), apply_filters('wpex_author_bio_avatar_size', 100));

            // Only display if author has a description
            //if ($author_description) {
            ?>

            <div class="viral-pro-author-info">

                <?php if ($author_avatar) { ?>
                    <div class="viral-pro-author-avatar">
                        <a href="<?php echo esc_url($author_url); ?>" rel="author">
                            <?php echo $author_avatar; ?>
                        </a>
                    </div><!-- .author-avatar -->
                <?php } ?>

                <div class="viral-pro-author-description">
                    <h5><?php printf(esc_html__('By %s', 'viral-pro'), esc_html($author)); ?></h5>
                    <?php if ($author_description) { ?>
                        <p><?php echo wp_kses_post($author_description); ?></p>
                    <?php } ?>

                    <div class="viral-pro-author-icons">
                        <?php
                        $website_url = get_the_author_meta('url', $post->post_author);
                        if ($website_url && $website_url != '') {
                            echo '<a href="' . esc_url($website_url) . '"><i class="icon_house"></i></a>';
                        }

                        $facebook_profile = get_the_author_meta('facebook_profile', $post->post_author);
                        if ($facebook_profile && $facebook_profile != '') {
                            echo '<a href="' . esc_url($facebook_profile) . '"><i class="social_facebook_circle"></i></a>';
                        }

                        $twitter_profile = get_the_author_meta('twitter_profile', $post->post_author);
                        if ($twitter_profile && $twitter_profile != '') {
                            echo '<a href="' . esc_url($twitter_profile) . '"><i class="vp-twitter-x-circ"></i></a>';
                        }

                        $linkedin_profile = get_the_author_meta('linkedin_profile', $post->post_author);
                        if ($linkedin_profile && $linkedin_profile != '') {
                            echo '<a href="' . esc_url($linkedin_profile) . '"><i class="social_linkedin_circle"></i></a>';
                        }

                        $instagram_profile = get_the_author_meta('instagram_profile', $post->post_author);
                        if ($instagram_profile && $instagram_profile != '') {
                            echo '<a href="' . esc_url($instagram_profile) . '"><i class="social_instagram_circle"></i></a>';
                        }

                        $rss_url = get_the_author_meta('rss_url', $post->post_author);
                        if ($rss_url && $rss_url != '') {
                            echo '<a href="' . esc_url($rss_url) . '"><i class="social_rss_circle"></i></a>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            //}
        }
    }

}


if (!function_exists('viral_pro_single_pagination')) {

    function viral_pro_single_pagination() {
        $viral_pro_single_prev_next_post = get_theme_mod('viral_pro_single_prev_next_post', true);

        if ($viral_pro_single_prev_next_post) {
            ?>
            <nav class="navigation post-navigation" role="navigation">
                <div class="nav-links">
                    <div class="nav-previous ht-clearfix">
                        <?php
                        if ($prev_post = get_previous_post()) {
                            $prev_post_thumb = get_the_post_thumbnail($prev_post->ID, 'viral-pro-150x150');
                            previous_post_link('%link', $prev_post_thumb . '<span>' . __('Previous Post', 'viral-pro') . '</span>%title');
                        }
                        ?>
                    </div>

                    <div class="nav-next ht-clearfix">
                        <?php
                        if ($next_post = get_next_post()) {
                            $next_post_thumb = get_the_post_thumbnail($next_post->ID, 'viral-pro-150x150');
                            next_post_link('%link', $next_post_thumb . '<span>' . __('Next Post', 'viral-pro') . '</span>%title');
                        }
                        ?>
                    </div>
                </div>
            </nav>
            <?php
        }
    }

}

if (!function_exists('viral_pro_single_related_posts')) {

    function viral_pro_single_related_posts() {
        $viral_pro_single_related_posts = get_theme_mod('viral_pro_single_related_posts', true);
        $viral_pro_single_related_post_title = get_theme_mod('viral_pro_single_related_post_title', esc_html__('Related Posts', 'viral-pro'));
        $viral_pro_single_related_post_style = get_theme_mod('viral_pro_single_related_post_style', 'style1');
        $viral_pro_single_related_post_count = get_theme_mod('viral_pro_single_related_post_count', 3);
        if (viral_pro_is_amp()) {
            $image_size = 'viral-pro-500x500';
        } elseif ($viral_pro_single_related_post_style == 'style2') {
            $image_size = 'viral-pro-500x600';
        } else {
            $image_size = 'viral-pro-360x240';
        }

        if ($viral_pro_single_related_posts && is_singular('post')) {
            global $post;

            $categories = get_the_category($post->ID);

            if ($categories) {
                $category_ids = array();
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }

                $args = array(
                    'category__in' => $category_ids,
                    'post__not_in' => array($post->ID),
                    'posts_per_page' => absint($viral_pro_single_related_post_count),
                );

                $query = new WP_Query($args);

                if ($query->have_posts()):
                    echo '<div class="viral-pro-related-post ' . esc_attr($viral_pro_single_related_post_style) . '">';
                    if (!empty($viral_pro_single_related_post_title)) {
                        echo '<h4 class="related-post-title widget-title">' . esc_html($viral_pro_single_related_post_title) . '</h4>';
                    }
                    if ($viral_pro_single_related_post_style == 'style3') {
                        echo viral_pro_is_amp() ? '<ul class="viral-pro-related-post-wrap"><amp-base-carousel class="amp-slider viral-pro-related-post-wrap" layout="responsive" width="1" height="1" heights="(min-width: 900px) 31.33%,(min-width: 600px) 48%, 100%" visible-count="(min-width: 900px) 3,(min-width: 600px) 2, 1" auto-advance="true" auto-advance-interval="3000">' : '<ul class="viral-pro-related-post-wrap owl-carousel">';
                    } else {
                        echo '<ul class="viral-pro-related-post-wrap">';
                    }
                    while ($query->have_posts()): $query->the_post();
                        ?>
                        <li>
                            <div class="relatedthumb">
                                <a href="<?php the_permalink() ?>">
                                    <?php viral_pro_post_featured_image($image_size, false); ?>
                                </a>

                                <?php if ($viral_pro_single_related_post_style == 'style2') { ?>
                                    <div class="relatedtitle">
                                        <h3 class="vl-post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a></h3>
                                        <div class="vl-post-metas">
                                            <?php
                                            echo viral_pro_post_author();
                                            echo viral_pro_post_date();
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php
                            if ($viral_pro_single_related_post_style != 'style2') {
                                if (viral_pro_is_amp()) {
                                    ?>
                                    <div class="vl-post-content vl-gradient-overlay">
                                    <?php } ?>
                                    <div class="relatedtitle">
                                        <h3 class="vl-post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a></h3>
                                        <div class="vl-post-metas">
                                            <?php
                                            echo viral_pro_post_author();
                                            echo viral_pro_post_date();
                                            ?>
                                        </div>

                                        <?php
                                        if ($viral_pro_single_related_post_style == 'style4') {
                                            ?>
                                            <div class="related-excerpt">
                                                <?php echo viral_pro_excerpt(get_the_content(), 180); ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php if (viral_pro_is_amp()) { ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </li>
                        <?php
                    endwhile;
                    echo viral_pro_is_amp() ? '</amp-base-carousel></ul>' : '</ul>';
                    echo '</div>';
                endif;
                wp_reset_postdata();
            }
        }
    }

}

if (!function_exists('viral_pro_single_comment')) {

    function viral_pro_single_comment() {
        $viral_pro_single_comments = get_theme_mod('viral_pro_single_comments', true);
        // If comments are open or we have at least one comment, load up the comment template.
        if ($viral_pro_single_comments && (comments_open() || get_comments_number())) :
            comments_template();
        endif;
    }

}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function viral_pro_categorized_blog() {
    if (false === ( $all_the_cool_cats = get_transient('viral_pro_categories') )) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(array(
            'fields' => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number' => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('viral_pro_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so viral_pro_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so viral_pro_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in viral_pro_categorized_blog.
 */
function viral_pro_category_transient_flusher() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('viral_pro_categories');
}

add_action('edit_category', 'viral_pro_category_transient_flusher');
add_action('save_post', 'viral_pro_category_transient_flusher');


if (!function_exists('viral_pro_entry_author')) {

    function viral_pro_entry_author() {
        $author = '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '"><i class="mdi mdi-account"></i>' . esc_html(get_the_author()) . '</a></span>';
        echo '<span class="entry-author">' . $author . '</span>';
    }

}

if (!function_exists('viral_pro_entry_date')) {

    function viral_pro_entry_date() {
        $viral_pro_is_updated_date = get_theme_mod('viral_pro_blog_display_date_option', 'posted') == 'updated' ? true : false;
        $post_date = '<a href="' . esc_url(get_permalink()) . '"><i class="mdi mdi-clock-time-four-outline"></i>' . ($viral_pro_is_updated_date ? get_the_modified_date() : get_the_date()) . '</a>';
        echo '<span class="entry-date">' . $post_date . '</span>';
    }

}

if (!function_exists('viral_pro_entry_category')) {

    function viral_pro_entry_category() {
        $categories_list = get_the_category_list(', ');
        if ($categories_list && viral_pro_categorized_blog()) {
            echo '<span class="entry-categories">';
            echo '<i class="mdi mdi-folder"></i>' . $categories_list;
            echo '</span>';
        }
    }

}

if (!function_exists('viral_pro_entry_tag')) {

    function viral_pro_entry_tag() {
        $tags_list = get_the_tag_list('<i class="mdi mdi-bookmark"></i>', ', ');
        if ($tags_list && viral_pro_categorized_blog()) {
            echo '<span class="entry-tags">';
            echo $tags_list;
            echo '</span>';
        }
    }

}

if (!function_exists('viral_pro_comment_link')) {

    function viral_pro_comment_link() {
        $comment_count = get_comments_number(); // get_comments_number returns only a numeric value
        $comment_link = "";

        if (comments_open()) {
            if ($comment_count == 0) {
                $comments = __('0 Comments', 'viral-pro');
            } elseif ($comment_count > 1) {
                $comments = $comment_count . __(' Comments', 'viral-pro');
            } else {
                $comments = __('1 Comment', 'viral-pro');
            }
            $comment_link .= '<span class="entry-comment">';
            $comment_link .= '<a class="comment-link" href="' . get_comments_link() . '"><i class="mdi mdi-comment"></i>' . $comments . '</a>';
            $comment_link .= '</span>';
        }

        return $comment_link;
    }

}


if (!function_exists('viral_pro_get_comment_author_link')) {

    function viral_pro_get_comment_author_link() {
        global $comment;
        if ($comment->user_id == '0') {
            $url = '#';
        } else {
            $url = get_author_posts_url($comment->user_id);
        }

        return "<a href=\"" . esc_url($url) . "\">" . get_comment_author() . "</a>";
    }

}

/**
 * Adds amp support for search toggle.
 */
function viral_pro_amp_search_toggle() {
    if (viral_pro_is_amp()) {
        return 'on="tap:htSearchWrapper.toggleClass(class=\'ht-search-triggered\')"';
    }
}

/**
 * Adds amp support for search toggle.
 */
function viral_pro_amp_search_is_toggled() {
    if (viral_pro_is_amp()) {
        return 'on="tap:htSearchWrapper.toggleClass(class=\'ht-search-triggered\', force=false)"';
    }
}

/**
 * Adds amp support for offcanvas nav toggle.
 */
function viral_pro_amp_offcanvas_nav_toggle() {
    if (viral_pro_is_amp()) {
        return 'on="tap:ht-body.toggleClass(class=\'ht-offcanvas-opened\')"';
    }
}

/**
 * Adds amp support for offcanvas nav toggle.
 */
function viral_pro_amp_offcanvas_nav_is_toggled() {
    if (viral_pro_is_amp()) {
        return 'on="tap:ht-body.toggleClass(class=\'ht-offcanvas-opened\', force=false)"';
    }
}

/**
 * Adds amp support for offcanvas nav toggle.
 */
function viral_pro_amp_responsive_menu_nav_toggle() {
    if (viral_pro_is_amp()) {
        return 'on="tap:ht-responsive-menu.toggleClass(class=\'active\')"';
    }
}

/**
 * Adds amp support for accordian toggle.
 */
function viral_pro_amp_accordian_toggle($id) {
    if (viral_pro_is_amp()) {
        return 'on="tap:' . esc_attr($id) . '.toggleClass(class=\'open\')"';
    }
}
