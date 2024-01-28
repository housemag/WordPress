<?php

namespace Viral_Pro_Elements\Modules\SliderModuleFour;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-slider-module-four';
    }

    public function get_widgets() {
        $widgets = [
            'SliderModuleFour',
        ];
        return $widgets;
    }

}
