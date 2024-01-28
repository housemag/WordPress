<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    die();
}

if (!class_exists('Viral_Pro_Demo_Importer')) {

    final class Viral_Pro_Demo_Importer {

        /**
         * A reference to an instance of this class.
         *
         * @since  1.0.0
         * @access private
         * @var    object
         */
        private static $instance = null;

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

        /** Plugin API * */
        public static function call_plugin_api($plugin) {
            include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            $call_api = plugins_api('plugin_information', array(
                'slug' => $plugin,
                'fields' => array(
                    'downloaded' => false,
                    'rating' => false,
                    'description' => false,
                    'short_description' => false,
                    'donate_link' => false,
                    'tags' => false,
                    'sections' => true,
                    'homepage' => true,
                    'added' => false,
                    'last_updated' => false,
                    'compatibility' => false,
                    'tested' => false,
                    'requires' => false,
                    'downloadlink' => false,
                    'icons' => true
            )));

            return $call_api;
        }

        /** Check if Plugin is active or not * */
        public static function plugin_active_status($file_path) {
            $status = 'install';
            $plugin_path = WP_PLUGIN_DIR . '/' . esc_attr($file_path);

            if (file_exists($plugin_path)) {
                $status = is_plugin_active($file_path) ? 'active' : 'inactive';
            }

            return $status;
        }

        /** Generate Url for the Plugin Button * */
        public static function generate_plugin_url($plugin) {
            $status = self::plugin_active_status($plugin);
            $url = 'javascript:void()';
            if ($status == 'install' && $source == 'remote') {
                $url = $plugin['location'];
            }
            return $url;
        }

        /** Generate Class for the Plugin Button * */
        public static function generate_plugin_class($plugin) {
            $status = self::plugin_active_status($plugin);
            switch ($status) {
                case 'install' :
                    $btn_class = 'install button button-primary';
                    break;

                case 'inactive' :
                    $btn_class = 'activate button button-primary';
                    break;

                case 'active' :
                    $btn_class = 'installed button';
                    break;
            }

            return $btn_class;
        }

        /** Generate Label for the Plugin Button * */
        public static function generate_plugin_label($plugin) {
            $status = self::plugin_active_status($plugin);
            switch ($status) {
                case 'install' :
                    $btn_label = esc_html__('Install', 'viral-pro');
                    break;

                case 'inactive' :
                    $btn_label = esc_html__('Activate', 'viral-pro');
                    break;

                case 'active' :
                    $btn_label = esc_html__('Installed', 'viral-pro');
                    break;
            }
            return $btn_label;
        }

    }

}

Viral_Pro_Demo_Importer::get_instance();
