<?php

namespace Viral_Pro_Elements;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!function_exists('is_plugin_active')) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

final class Viral_Pro_Modules_Manager {

    public function __construct() {
        $this->require_files();
        $this->register_modules();
    }

    private function get_modules() {
        $modules = [
            'news-module-one',
            'news-module-two',
            'news-module-three',
            'news-module-four',
            'news-module-five',
            'news-module-six',
            'news-module-seven',
            'news-module-eight',
            'news-module-nine',
            'news-module-ten',
            'news-module-eleven',
            'news-module-twelve',
            'news-module-thirteen',
            'news-module-fourteen',
            'news-module-fifteen',
            'news-module-sixteen',
            'news-module-seventeen',
            'news-module-eighteen',
            'news-module-nineteen',
            'news-module-twenty',
            'news-module-twentyone',
            'news-module-twentytwo',
            'news-module-twentythree',
            'news-module-twentyfour',
            'single-news-one',
            'single-news-two',
            'slider-module-one',
            'slider-module-two',
            'slider-module-three',
            'slider-module-four',
            'carousel-module-one',
            'carousel-module-two',
            'carousel-module-three',
            'carousel-module-four',
            'carousel-module-five',
            'tile-module-one',
            'tile-module-two',
            'tile-module-three',
            'tile-module-four',
            'tile-module-five',
            'tile-module-six',
            'tile-module-seven',
            'tile-module-eight',
            'featured-module',
            'video-module',
            'title-module',
            'ticker-module'
        ];
        return $modules;
    }

    private function is_module_active($module_id) {
        $options = get_option('viral-pro-options');
        $active_widgets = $this->get_modules();

        if (isset($options['enabled_elementor_widgets'])) {
            $active_widgets = array_keys($options['enabled_elementor_widgets']);
        }

        if (in_array($module_id, $active_widgets)) {
            return true;
        }
    }

    private function require_files() {
        require get_template_directory() . '/inc/elements/base/module-base.php';
    }

    public function register_modules() {
        $modules = $this->get_modules();

        foreach ($modules as $module) {
            if (!$this->is_module_active($module)) {
                continue;
            }
            $class_name = str_replace('-', ' ', $module);
            $class_name = str_replace(' ', '', ucwords($class_name));
            $class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

            $class_name::instance();
        }
    }

}

if (!function_exists('viral_pro_elements_module_manager')) {

    /**
     * Returns an instance of the plugin class.
     * @since  1.0.0
     * @return object
     */
    function viral_pro_module_manager() {
        return new Viral_Pro_Modules_Manager();
    }

}
viral_pro_module_manager();
