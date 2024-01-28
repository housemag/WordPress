<?php

if (!defined('WPINC')) {
    die();
}

if (!class_exists('Viral_Pro_Elements')) {

    class Viral_Pro_Elements {

        private static $instance = null;

        public static function get_instance() {
            // If the single instance hasn't been set, set it now.
            if (self::$instance == null) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct() {

            // Check if Elementor installed and activated
            if (!did_action('elementor/loaded')) {
                return;
            }

            add_action('init', [$this, 'update_elementor_options']);

            require get_template_directory() . '/inc/elements/inc/widget-loader.php';
            require get_template_directory() . '/inc/elements/inc/sticky-column.php';
            require get_template_directory() . '/inc/elements/inc/ajax-select.php';
            require get_template_directory() . '/inc/elements/inc/blocks/blocks-init.php';
        }

        public function update_elementor_options() {
            $kit = Elementor\Plugin::$instance->kits_manager->get_active_kit();
            $options = get_option('viral-pro-options');

            if (!$kit->get_id()) {
                $created_default_kit = Elementor\Plugin::$instance->kits_manager->create_default();
                update_option('elementor_active_kit', $created_default_kit);
            }

            if (!isset($options['elementor_default_font_color']) || $options['elementor_default_font_color']) {
                if ('yes' !== get_option('elementor_disable_color_schemes')) {
                    update_option('elementor_disable_color_schemes', 'yes');
                }

                if ('yes' !== get_option('elementor_disable_typography_schemes')) {
                    update_option('elementor_disable_typography_schemes', 'yes');
                }

                if ('inactive' !== get_option('elementor_experiment-e_dom_optimization')) {
                    update_option('elementor_experiment-e_dom_optimization', 'inactive');
                }

                if ('1' !== get_option('elementor_unfiltered_files_upload')) {
                    update_option('elementor_unfiltered_files_upload', '1');
                }
            }
        }

    }

}

/**
 * Returns instanse of the plugin class.
 *
 * @since  1.0.0
 * @return object
 */
if (!function_exists('viral_pro_elements')) {

    function viral_pro_elements() {
        return Viral_Pro_Elements::get_instance();
    }

}

viral_pro_elements();
