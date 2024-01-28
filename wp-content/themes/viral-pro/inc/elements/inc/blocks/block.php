<?php

namespace ViralPro\Blocks;

abstract class Viral_Pro_Block {

    protected $block_uid;
    protected $block_header;
    protected $block_items;
    public $settings = array();

    /* Force override  */

    abstract function get_block_header();

    abstract function inner($block_items, $settings);

    abstract function get_block_footer();

    abstract function init_block();

    /* Force override  */

    protected abstract function get_block_class();

    protected abstract function get_settings_defaults();

    protected abstract function get_settings_data_atts();

    protected abstract function get_block_data_atts();

    protected abstract function get_block_items_to_display();

    public function init($settings) {
        $this->block_items = array();
        //$defaults = $this->get_settings_defaults();
        $this->settings = $settings; //wp_parse_args($settings, $defaults);
        $this->block_uid = 'vp-block-uid-' . uniqid();
        $this->init_block();
    }

    public function render($settings) {
        try {
            $this->init($settings);
            $display_items = $this->get_block_items_to_display();

            $output = '<div id="' . $this->block_uid . '" class="' . $this->get_block_classes() . '" ' . $this->get_block_data_atts() . '>';
            $output .= $this->get_block_header();

            // add container class to enable column styling
            $output .= '<div class="vp-block-inner">';
            $output .= $this->inner($display_items, $this->settings);
            $output .= '</div><!-- .block-inner -->';

            $output .= $this->get_block_footer();
            $output .= '</div><!-- .block -->';
        } catch (\Exception $e) {
            // show error message if thrown
            $output = $e->getMessage();
        }
        return apply_filters('vp_output', $output, $this);
    }

    protected function get_block_classes($classes_array = array()) {
        $block_classes = array();

        // add block wrap
        $block_classes[] = 'vp-block';

        // add block id for styling
        $block_classes[] = $this->get_block_class();

        $block_classes[] = $this->settings['image_hover_style'];

        //marge the additional classes received from blocks code
        if (!empty($classes_array)) {
            $block_classes = array_merge(
                    $block_classes, $classes_array
            );
        }

        //remove duplicates
        $block_classes = array_unique($block_classes);

        return implode(' ', $block_classes);
    }

}
