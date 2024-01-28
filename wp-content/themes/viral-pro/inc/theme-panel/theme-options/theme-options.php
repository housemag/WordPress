<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    die();
}

if (!class_exists('Viral_Pro_Theme_Options')) {

    class Viral_Pro_Theme_Options {

        /**
         * A reference to an instance of this class.
         *
         * @since  1.0.0
         * @access private
         * @var    object
         */
        private static $instance = null;

        /**
         * Theme Name
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public static $theme_name;

        /**
         * Theme Version
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public static $theme_version;

        /**
         * Theme Version
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public static $theme_dir;

        /**
         * Theme Version
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public static $theme_uri;

        public function __construct() {
            $theme = wp_get_theme();
            self::$theme_name = $theme->Name;
            self::$theme_version = $theme->Version;
            self::$theme_dir = get_template_directory() . '/inc/theme-panel/theme-options/';
            self::$theme_uri = get_template_directory_uri() . '/inc/theme-panel/theme-options/';

            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

            require_once self::$theme_dir . 'options-framework/options-framework.php';

            add_filter('optionsframework_menu', array($this, 'options_menu_params'));

            add_filter('options_framework_location', array($this, 'options_array_locations'));
        }

        /**
         * Initiator
         *
         * @since 1.0.0
         * @return object
         */
        public static function get_instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /** Enqueue Necessary Styles and Scripts for the Welcome Page * */
        public function enqueue_scripts() {
            wp_enqueue_style('viral-pro-theme-options', self::$theme_uri . 'css/theme-options.css', array(), VIRAL_PRO_VER);
            wp_enqueue_script('viral-pro-theme-options', self::$theme_uri . 'js/theme-options.js', array('jquery'), array(), VIRAL_PRO_VER, false);
        }

        public function options_menu_params($menu) {
            $menu['page_title'] = __('Theme Options', 'viral-pro');
            $menu['menu_title'] = __('Theme Options', 'viral-pro');
            $menu['menu_slug'] = 'viral-pro-options';
            $menu['parent_slug'] = 'viral-pro';

            return $menu;
        }

        public function options_array_locations() {
            return array('/inc/theme-panel/theme-options/options.php');
        }

    }

}

if (!function_exists('viral_pro_theme_options')) {

    /**
     * Returns instanse of the plugin class.
     *
     * @since  1.0.0
     * @return object
     */
    function viral_pro_theme_options() {
        return Viral_Pro_Theme_Options::get_instance();
    }

}

viral_pro_theme_options();
