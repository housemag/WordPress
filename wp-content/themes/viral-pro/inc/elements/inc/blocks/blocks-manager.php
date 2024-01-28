<?php

namespace ViralPro\Blocks;

class Viral_Pro_Blocks_Manager {

    static function get_instance($block_type) {
        if ($block_type) {
            /* Modules */
            require_once VIRAL_PRO_BLOCKS_PATH . 'modules/' . str_replace('_', '-', $block_type) . '.php';
            $block_class = '\ViralPro\Blocks\Modules\\' . self::get_class_name($block_type);
            if (class_exists($block_class)) {
                $new_instance = new $block_class();
                return $new_instance;
            }
        }
        return false;
    }

    static function get_class_name($template_id) {
        return 'Viral_Pro_' . ucwords($template_id, '_');
    }

}
