<?php

namespace ViralPro\Blocks;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('VIRAL_PRO_Blocks_Init')):

    class VIRAL_PRO_Blocks_Init {

        public function __construct() {
            $this->setup_constants();
            $this->includes();

            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_frontend_scripts']);
        }

        private function setup_constants() {
            define('VIRAL_PRO_BLOCKS_PATH', get_template_directory() . '/inc/elements/inc/blocks/');
            define('VIRAL_PRO_BLOCKS_URL', get_template_directory_uri() . '/inc/elements/inc/blocks/');
        }

        private function includes() {
            require_once VIRAL_PRO_BLOCKS_PATH . 'blocks-manager.php';
            require_once VIRAL_PRO_BLOCKS_PATH . 'block.php';
            require_once VIRAL_PRO_BLOCKS_PATH . 'block-posts.php';
            require_once VIRAL_PRO_BLOCKS_PATH . 'block-header.php';

            /* Source */
            require_once VIRAL_PRO_BLOCKS_PATH . 'functions/posts-source.php';

            /* Block Functions */
            require_once VIRAL_PRO_BLOCKS_PATH . 'functions/post-functions.php';
        }

        /**
         * Enqueue Frontend Scripts
         */
        public function enqueue_frontend_scripts() {
            $is_rtl = (is_rtl()) ? 'true' : 'false';
            wp_enqueue_script('viralpro-ajax-block', VIRAL_PRO_BLOCKS_URL . 'assets/vp-ajax-block.min.js', array('jquery'), VIRAL_PRO_VER, true);
            wp_enqueue_script('viralpro-block', VIRAL_PRO_BLOCKS_URL . 'assets/vp-block.js', array('jquery'), VIRAL_PRO_VER, true);
            wp_enqueue_script('viralpro-jquery-waypoint', VIRAL_PRO_BLOCKS_URL . 'assets/jquery.waypoints.js', array('jquery'), VIRAL_PRO_VER, true);
            $ajax_params = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'block_nonce' => wp_create_nonce('vp-block-nonce')
            );
            wp_localize_script('viralpro-ajax-block', 'vp_ajax_object', $ajax_params);
        }

    }

    endif;

new VIRAL_PRO_Blocks_Init();
