<?php

/**
 * Viral Pro functions and definitions
 *
 * @package Viral Pro
 */
if (!defined('VIRAL_PRO_VER')) {
    $viral_plus_get_theme = wp_get_theme();
    $viral_plus_version = $viral_plus_get_theme->Version;
    define('VIRAL_PRO_VER', $viral_plus_version);
}

define('VIRAL_PRO_ELEMENTOR_ACTIVE', class_exists('Elementor\Plugin'));
define('VIRAL_PRO_BEAVER_BUILDER_ACTIVE', class_exists('FLBuilder'));
define('VIRAL_PRO_SITEORIGIN_ACTIVE', class_exists('SiteOrigin_Panels'));

if (!function_exists('viral_pro_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function viral_pro_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Viral Pro, use a find and replace
         * to change 'viral-pro' to the name of your theme in all the template files
         */
        load_theme_textdomain('viral-pro', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        add_image_size('viral-pro-1300x540', 1300, 540, true);
        add_image_size('viral-pro-800x500', 800, 500, true);
        add_image_size('viral-pro-700x700', 700, 700, true);
        add_image_size('viral-pro-650x500', 650, 500, true);
        add_image_size('viral-pro-500x500', 500, 500, true);
        add_image_size('viral-pro-500x600', 500, 600, true);
        add_image_size('viral-pro-360x240', 360, 240, true);
        add_image_size('viral-pro-150x150', 150, 150, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'viral-pro'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
        ));

        add_theme_support('post-formats', array('gallery', 'link', 'quote', 'video', 'audio'));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('viral_pro_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        add_theme_support('custom-logo', array(
            'height' => 62,
            'width' => 300,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('.ht-site-title', '.ht-site-description'),
        ));

        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        // Add support editor style.
        add_theme_support('editor-styles');

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');

        // Add support for full and wide align images.
        add_theme_support('align-wide');

        add_theme_support('custom-line-height');

        add_theme_support('custom-spacing');

        add_theme_support('custom-units');

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/editor-style.css'));

        // Add theme support for AMP.
        add_theme_support('amp');
    }

endif; // viral_pro_setup
add_action('after_setup_theme', 'viral_pro_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function viral_pro_content_width() {
    $GLOBALS['content_width'] = apply_filters('viral_pro_content_width', 640);
}

add_action('after_setup_theme', 'viral_pro_content_width', 0);

/**
 * Enables the Excerpt meta box in Page edit screen.
 */
function viral_pro_add_excerpt_support_for_pages() {
    add_post_type_support('page', 'excerpt');
}

add_action('init', 'viral_pro_add_excerpt_support_for_pages');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function viral_pro_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Right Sidebar', 'viral-pro'),
        'id' => 'viral-pro-right-sidebar',
        'description' => __('Add widgets here to appear in your sidebar.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Left Sidebar', 'viral-pro'),
        'id' => 'viral-pro-left-sidebar',
        'description' => __('Add widgets here to appear in your sidebar.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Below Menu', 'viral-pro'),
        'id' => 'viral-pro-below-menu',
        'description' => __('Add widgets here to appear below menu.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Front Page Right Sidebar', 'viral-pro'),
        'id' => 'viral-pro-frontpage-right-sidebar',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Front Page Left Sidebar', 'viral-pro'),
        'id' => 'viral-pro-frontpage-left-sidebar',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    if (viral_pro_is_woocommerce_activated()) {
        register_sidebar(array(
            'name' => esc_html__('Shop Right Sidebar', 'viral-pro'),
            'id' => 'viral-pro-shop-right-sidebar',
            'description' => __('Add widgets here to appear in your sidebar of shop page.', 'viral-pro'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Shop Left Sidebar', 'viral-pro'),
            'id' => 'viral-pro-shop-left-sidebar',
            'description' => __('Add widgets here to appear in your sidebar of shop page.', 'viral-pro'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    }

    register_sidebar(array(
        'name' => esc_html__('Header Widget', 'viral-pro'),
        'id' => 'viral-pro-header-widget',
        'description' => __('Add widgets in the Header. Works with Header 4 and Header 5 Only', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('OffCanvas Sidebar', 'viral-pro'),
        'id' => 'viral-pro-offcanvas-sidebar',
        'description' => __('Add widgets here to appear in your OffCanvas Sidebar.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Top Footer', 'viral-pro'),
        'id' => 'viral-pro-top-footer',
        'description' => __('Add widgets here to appear in your Footer.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer One', 'viral-pro'),
        'id' => 'viral-pro-footer1',
        'description' => __('Add widgets here to appear in your Footer.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Two', 'viral-pro'),
        'id' => 'viral-pro-footer2',
        'description' => __('Add widgets here to appear in your Footer.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Three', 'viral-pro'),
        'id' => 'viral-pro-footer3',
        'description' => __('Add widgets here to appear in your Footer.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Four', 'viral-pro'),
        'id' => 'viral-pro-footer4',
        'description' => __('Add widgets here to appear in your Footer.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Five', 'viral-pro'),
        'id' => 'viral-pro-footer5',
        'description' => __('Add widgets here to appear in your Footer.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Six', 'viral-pro'),
        'id' => 'viral-pro-footer6',
        'description' => __('Add widgets here to appear in your Footer.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Bottom Footer', 'viral-pro'),
        'id' => 'viral-pro-bottom-footer',
        'description' => __('Add widgets here to appear in your Footer.', 'viral-pro'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Front Page Ads', 'viral-pro'),
        'id' => 'viral-pro-frontpage-ads',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Single Post - Before Article', 'viral-pro'),
        'description' => __('Add widgets here to appear in the post before the article', 'viral-pro'),
        'id' => 'viral-pro-single-post-before-article',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Single Post - After Article', 'viral-pro'),
        'description' => __('Add widgets here to appear in the post after the article', 'viral-pro'),
        'id' => 'viral-pro-single-post-after-article',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}

add_action('widgets_init', 'viral_pro_widgets_init');

if (!function_exists('viral_pro_fonts_url')) :

    /**
     * Register Google fonts for Viral Pro.
     *
     * @since Viral Pro 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function viral_pro_fonts_url() {
        $fonts_url = '';
        $fonts = $customizer_font_family = array();
        $subsets = 'latin,latin-ext';
        $all_fonts = viral_pro_all_fonts();
        $google_fonts = viral_pro_google_fonts();

        $customizer_fonts = array(
            'body_font_family' => 'Roboto',
            'menu_font_family' => 'Roboto',
            'title_font_family' => 'Default',
            'tagline_font_family' => 'Default',
            'page_title_font_family' => 'Roboto',
            'frontpage_title_font_family' => 'Roboto',
            'frontpage_block_title_font_family' => 'Roboto',
            'sidebar_title_font_family' => 'Roboto'
        );

        $common_header_typography = get_theme_mod('common_header_typography', true);

        if (!$common_header_typography) {
            $customizer_fonts['h1_font_family'] = 'Roboto';
            $customizer_fonts['h2_font_family'] = 'Roboto';
            $customizer_fonts['h3_font_family'] = 'Roboto';
            $customizer_fonts['h4_font_family'] = 'Roboto';
            $customizer_fonts['h5_font_family'] = 'Roboto';
            $customizer_fonts['h6_font_family'] = 'Roboto';
        } else {
            $customizer_fonts['h_font_family'] = 'Roboto';
        }

        $customizer_fonts = apply_filters('viral_pro_customizer_fonts', $customizer_fonts);

        foreach ($customizer_fonts as $key => $value) {
            $font = get_theme_mod($key, $value);
            if (array_key_exists($font, $google_fonts)) {
                $customizer_font_family[] = $font;
            }
        }

        if ($customizer_font_family) {
            $customizer_font_family = array_unique($customizer_font_family);
            foreach ($customizer_font_family as $font_family) {
                if (isset($all_fonts[$font_family]['variants'])) {
                    $variants_array = $all_fonts[$font_family]['variants'];
                    $variants_keys = array_keys($variants_array);
                    $variants = implode(',', $variants_keys);

                    $fonts[] = $font_family . ':' . str_replace('italic', 'i', $variants);
                }
            }

            if ($fonts) {
                $fonts_url = add_query_arg(array(
                    'family' => urlencode(implode('|', $fonts)),
                    'subset' => urlencode($subsets),
                    'display' => 'swap',
                        ), 'https://fonts.googleapis.com/css');
            }

            return $fonts_url;
        }
    }

endif;

/**
 * Enqueue scripts and styles.
 */
function viral_pro_scripts() {
    if (!viral_pro_is_amp()) {
        $customizer_gdpr_settings = of_get_option('customizer_gdpr_settings', '1');
        $is_customize_preview = (is_customize_preview()) ? 'true' : 'false';
        $is_rtl = (is_rtl()) ? 'true' : 'false';
        if ($customizer_gdpr_settings) {
            wp_enqueue_script('js-cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array('jquery'), VIRAL_PRO_VER, true);
        }

        wp_register_script('YTPlayer', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.min.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_register_script('youtube-api', '//youtube.com/iframe_api', array(), 'v3', false);
        wp_enqueue_script('jquery-nav', get_template_directory_uri() . '/js/jquery.nav.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('isotope-pkgd', get_template_directory_uri() . '/js/isotope.pkgd.js', array('jquery', 'imagesloaded'), VIRAL_PRO_VER, true);
        wp_enqueue_script('hoverintent', get_template_directory_uri() . '/js/hoverintent.js', array(), VIRAL_PRO_VER, true);
        wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('jquery-stellar', get_template_directory_uri() . '/js/jquery.stellar.js', array('imagesloaded'), VIRAL_PRO_VER, false);
        wp_enqueue_script('odometer', get_template_directory_uri() . '/js/odometer.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('waypoint', get_template_directory_uri() . '/js/waypoint.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('espy', get_template_directory_uri() . '/js/jquery.espy.min.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('motio', get_template_directory_uri() . '/js/motio.min.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('jquery-mcustomscrollbar', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('jquery-accordion', get_template_directory_uri() . '/js/jquery.accordion.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('photostream', get_template_directory_uri() . '/js/jquery.photostream.min.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('justifiedGallery', get_template_directory_uri() . '/js/jquery.justifiedGallery.min.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('countdown', get_template_directory_uri() . '/js/jquery.countdown.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('viral-pro-megamenu', get_template_directory_uri() . '/inc/walker/assets/megaMenu.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('headroom', get_template_directory_uri() . '/js/headroom.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('resizesensor', get_template_directory_uri() . '/js/ResizeSensor.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('jquery-lazy', get_template_directory_uri() . '/js/jquery.lazy.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_enqueue_script('viral-pro-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_localize_script('viral-pro-custom', 'viral_pro_options', array(
            'template_path' => get_template_directory_uri(),
            'rtl' => $is_rtl,
            'customize_preview' => $is_customize_preview,
            'customizer_gdpr_settings' => $customizer_gdpr_settings
        ));
        wp_localize_script('viral-pro-megamenu', 'viral_pro_megamenu', array(
            'rtl' => $is_rtl
        ));

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    if (viral_pro_is_amp()) {
        //wp_enqueue_style('viral-proicons', get_template_directory_uri() . '/css/viralproicons.css', array(), VIRAL_PRO_VER);
        wp_enqueue_style('viral-pro-amp-style', get_template_directory_uri() . '/style-amp.css', array('viral-pro-style'), VIRAL_PRO_VER);
    } else {
        wp_enqueue_style('viral-pro-loaders', get_template_directory_uri() . '/css/loaders.css', array(), VIRAL_PRO_VER);
        wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), VIRAL_PRO_VER);
        wp_enqueue_style('animate', get_template_directory_uri() . '/css/animate.css', array(), VIRAL_PRO_VER);
        wp_enqueue_style('slick', get_template_directory_uri() . '/css/slick.css', array(), VIRAL_PRO_VER);
        wp_enqueue_style('YTPlayer', get_template_directory_uri() . '/css/jquery.mb.YTPlayer.min.css', array(), VIRAL_PRO_VER);
        wp_enqueue_style('jquery-mcustomscrollbar', get_template_directory_uri() . '/css/jquery.mCustomScrollbar.css', array(), VIRAL_PRO_VER);
        wp_enqueue_style('justifiedGallery', get_template_directory_uri() . '/css/justifiedGallery.min.css', array(), VIRAL_PRO_VER);
    }

    wp_enqueue_style('viral-pro-style', get_stylesheet_uri(), array(), VIRAL_PRO_VER);
    wp_style_add_data('viral-pro-style', 'rtl', 'replace');

    wp_enqueue_style('eleganticons', get_template_directory_uri() . '/css/eleganticons.css', array(), VIRAL_PRO_VER);
    wp_enqueue_style('materialdesignicons', get_template_directory_uri() . '/css/materialdesignicons.css', array(), VIRAL_PRO_VER);
    wp_enqueue_style('icofont', get_template_directory_uri() . '/css/icofont.css', array(), VIRAL_PRO_VER);
    wp_enqueue_style('essential-icon', get_template_directory_uri() . '/css/essential-icon.css', array(), VIRAL_PRO_VER);
    wp_enqueue_style('vp-twittericon', get_template_directory_uri() . '/css/twittericon.css', array(), VIRAL_PRO_VER);
    wp_enqueue_style('dashicons');

    $fonts_url = viral_pro_fonts_url();
    $load_font_locally = get_theme_mod('viral_pro_load_google_font_locally', false);
    if ($fonts_url && ($load_font_locally == 'on')) {
        require_once get_theme_file_path('inc/wptt-webfont-loader.php');
        $fonts_url = wptt_get_webfont_url($fonts_url);
    }

    // Load Fonts if necessary.
    if ($fonts_url) {
        wp_enqueue_style('viral-pro-fonts', $fonts_url, array(), NULL);
    }

    if ('file' != get_theme_mod('viral_pro_style_option', 'head')) {
        wp_add_inline_style('viral-pro-style', viral_pro_dymanic_styles());
    } else {

        // We will probably need to load this file
        require_once( ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php' );

        global $wp_filesystem;
        $upload_dir = wp_upload_dir(); // Grab uploads folder array
        $dir = trailingslashit($upload_dir['basedir']) . 'viral-pro' . DIRECTORY_SEPARATOR; // Set storage directory path

        WP_Filesystem(); // Initial WP file system
        $wp_filesystem->mkdir($dir); // Make a new folder 'viral-pro' for storing our file if not created already.
        $wp_filesystem->put_contents($dir . 'custom-style.css', viral_pro_dymanic_styles(), 0644); // Store in the file.
        wp_enqueue_style('viral-pro-dynamic-style', trailingslashit($upload_dir['baseurl']) . 'viral-pro/custom-style.css', array(), NULL);
    }
}

add_action('wp_enqueue_scripts', 'viral_pro_scripts');

/**
 * Determine whether this is an AMP response.
 *
 * Note that this must only be called after the parse_query action.
 *
 * @link https://github.com/Automattic/amp-wp
 * @return bool Is AMP endpoint (and AMP plugin is active).
 */
function viral_pro_is_amp() {
    return function_exists('is_amp_endpoint') && is_amp_endpoint();
}

add_filter('template_include', 'viral_pro_frontpage_template', 9999);

function viral_pro_frontpage_template($template) {
    if (is_front_page()) {
        $enable_frontpage = get_theme_mod('viral_pro_enable_frontpage', false);
        if ($enable_frontpage) {
            $new_template = locate_template(array('templates/home-template.php'));
            if ('' != $new_template) {
                return $new_template;
            }
        }
    }
    return $template;
}

/**
 * BreadCrumb
 */
require get_template_directory() . '/inc/breadcrumbs.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * MetaBox additions.
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Icons Array
 */
require get_template_directory() . '/inc/font-icons.php';

/**
 * Theme Settings
 */
require get_template_directory() . '/inc/theme-panel/welcome.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Header Functions
 */
require get_template_directory() . '/inc/header/header-functions.php';

/**
 * Home Page Functions
 */
require get_template_directory() . '/inc/frontpage-hooks.php';

/**
 * Hooks
 */
require get_template_directory() . '/inc/theme-hooks.php';

/**
 * Woo Commerce Functions
 */
require get_template_directory() . '/inc/woo-functions.php';

/**
 * Elementor Elements
 */
require get_template_directory() . '/inc/elements/elements.php';

/**
 * AriColor
 */
require get_template_directory() . '/inc/aricolor.php';

/**
 * MetaBox
 */
require get_template_directory() . '/inc/assets/meta-box/meta-box.php';
require get_template_directory() . '/inc/assets/meta-box-columns/meta-box-columns.php';
require get_template_directory() . '/inc/assets/meta-box-tabs/meta-box-tabs.php';
require get_template_directory() . '/inc/assets/meta-box-conditional-logic/meta-box-conditional-logic.php';
require get_template_directory() . '/inc/assets/meta-box-group/meta-box-group.php';

/**
 * Menu Walker
 */
require get_template_directory() . '/inc/walker/init.php';

/**
 * Dynamic Styles additions
 */
require get_template_directory() . '/inc/style.php';

/**
 * Transfer old Settings
 */
require get_template_directory() . '/inc/viralmagtopro.php';
