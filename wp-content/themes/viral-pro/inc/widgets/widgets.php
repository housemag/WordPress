<?php
/**
 *
 * @package Viral Pro
 */
//require_once get_template_directory() . '/inc/widgets/add-widget.php';

require_once get_template_directory() . '/inc/widgets/widget-fields.php';

$active_widgets = array_keys(of_get_option('enabled_widgets', viral_pro_custom_widget_list()));

if (is_array($active_widgets)) {
    foreach ($active_widgets as $widgets) {
        if (file_exists(get_template_directory() . '/inc/widgets/' . $widgets . '.php')) {
            require_once get_template_directory() . '/inc/widgets/' . $widgets . '.php';
        }
    }
}

function viral_pro_custom_widget_list() {
    return array(
        'widget-accordian' => esc_html__('Accordian', 'viral-pro'),
        'widget-banner-ads' => esc_html__('Banner Ads', 'viral-pro'),
        'widget-category' => esc_html__('Categories', 'viral-pro'),
        'widget-cta' => esc_html__('Call To Action', 'viral-pro'),
        'widget-contact-detail' => esc_html__('Contact Detail', 'viral-pro'),
        'widget-contact-info' => esc_html__('Contact Info', 'viral-pro'),
        'widget-countdown' => esc_html__('Count Down', 'viral-pro'),
        'widget-counter' => esc_html__('Counter', 'viral-pro'),
        'widget-facebook-box' => esc_html__('Facebook Box', 'viral-pro'),
        'widget-flickr' => esc_html__('Flickr', 'viral-pro'),
        'widget-icon-text' => esc_html__('Icon Text', 'viral-pro'),
        'widget-image-box' => esc_html__('Image Text', 'viral-pro'),
        'widget-image-category' => esc_html__('Image Category', 'viral-pro'),
        'widget-latest-posts' => esc_html__('Latest Posts', 'viral-pro'),
        'widget-post-carousel-category' => esc_html__('Post Carousel by Category', 'viral-pro'),
        'widget-post-carousel' => esc_html__('Post Carousel', 'viral-pro'),
        'widget-post-list-category' => esc_html__('Post Listing by Category', 'viral-pro'),
        'widget-post-list' => esc_html__('Post Listing', 'viral-pro'),
        'widget-post-tab' => esc_html__('Post Tab', 'viral-pro'),
        'widget-post-timeline' => esc_html__('Post Timeline', 'viral-pro'),
        'widget-profile' => esc_html__('Profile', 'viral-pro'),
        'widget-progressbar' => esc_html__('Progress Bar', 'viral-pro'),
        'widget-social-icons' => esc_html__('Social Icons', 'viral-pro')
    );
}

function viral_pro_category_list() {
    $viral_pro_categories = get_categories(array('hide_empty' => 0));
    $viral_pro_cat = array();
    if ($viral_pro_categories) {
        foreach ($viral_pro_categories as $viral_pro_category) {
            $viral_pro_cat[$viral_pro_category->term_id] = $viral_pro_category->cat_name;
        }
    }

    return $viral_pro_cat;
}

/**
 * Enqueue Style and Script for widgets
 */
function viral_pro_admin_scripts() {
    wp_enqueue_style('materialdesignicons', get_template_directory_uri() . '/css/materialdesignicons.css', array(), VIRAL_PRO_VER);
    wp_enqueue_style('essential-icon', get_template_directory_uri() . '/css/essential-icon.css', array(), VIRAL_PRO_VER);
    wp_enqueue_style('icofont', get_template_directory_uri() . '/css/icofont.css', array(), VIRAL_PRO_VER);
    wp_enqueue_style('eleganticons', get_template_directory_uri() . '/css/eleganticons.css', array(), VIRAL_PRO_VER);
    if (is_rtl()) {
        wp_enqueue_style('viral-pro-admin-style', get_template_directory_uri() . '/inc/widgets/css/widget-style.rtl.css', array('wp-color-picker'), VIRAL_PRO_VER);
    } else {
        wp_enqueue_style('viral-pro-admin-style', get_template_directory_uri() . '/inc/widgets/css/widget-style.css', array('wp-color-picker'), VIRAL_PRO_VER);
    }

    wp_enqueue_media();
    $is_widgets_block_editor = function_exists('wp_use_widgets_block_editor') && wp_use_widgets_block_editor() ? 'true' : 'false';
    wp_enqueue_script('viral-pro-widget-script', get_template_directory_uri() . '/inc/widgets/js/widget-script.js', array('jquery', 'wp-color-picker', 'jquery-ui-datepicker'), VIRAL_PRO_VER, true);
    wp_localize_script('viral-pro-widget-script', 'viral_pro_widget_options', array(
        'widgets_block_editor' => $is_widgets_block_editor,
    ));
}

add_action('admin_enqueue_scripts', 'viral_pro_admin_scripts', 100);

add_action('elementor/editor/before_enqueue_scripts', 'viral_pro_admin_scripts');


/* ADD EDITOR TO CUSTOMIZER */

function viral_pro_customizer_editor() {
    ?>
    <div id="ht-wp-editor-widget-container" style="display: none;">
        <a class="ht-wp-editor-widget-close" href="#" title="<?php esc_attr_e('Close', 'viral-pro'); ?>"><i class="icofont-close-squared-alt"></i></a>
        <div class="editor">
            <?php
            $settings = array('textarea_rows' => 55, 'editor_height' => 260);
            wp_editor('', 'wpeditorwidget', $settings);
            ?>
            <p><a href="#" class="ht-wp-editor-widget-update-close button button-primary"><?php _e('Save and Close', 'viral-pro'); ?></a></p>
        </div>
    </div>
    <div id="ht-wp-editor-widget-backdrop" style="display: none;"></div>
    <?php
}

// END output_wp_editor_widget_html*/

add_action('widgets_admin_page', 'viral_pro_customizer_editor', 100);
add_action('customize_controls_print_footer_scripts', 'viral_pro_customizer_editor');
add_action('elementor/editor/before_enqueue_scripts', 'viral_pro_customizer_editor');

//SiteOrigin Builder
if (function_exists('siteorigin_panels_render')) {
    add_action('admin_print_scripts-post.php', 'viral_pro_customizer_editor', 100);
    add_action('admin_print_scripts-post-new.php', 'viral_pro_customizer_editor', 100);
}

//Beaver Builder
if (class_exists('FLBuilder')) {
    if (isset($_GET['fl_builder'])) {
        add_action('viral_pro_after_footer', 'viral_pro_customizer_editor', 100);
    }
}

/* Add Filters for the Customizer wp_editor */
add_filter('wp_editor_widget_content', 'wptexturize');
add_filter('wp_editor_widget_content', 'convert_smilies');
add_filter('wp_editor_widget_content', 'convert_chars');
add_filter('wp_editor_widget_content', 'wpautop');
add_filter('wp_editor_widget_content', 'shortcode_unautop');
add_filter('wp_editor_widget_content', 'do_shortcode', 11);
