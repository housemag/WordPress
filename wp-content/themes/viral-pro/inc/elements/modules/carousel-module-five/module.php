<?php

namespace Viral_Pro_Elements\Modules\CarouselModuleFive;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-carousel-module-five';
    }

    public function get_widgets() {
        $widgets = [
            'CarouselModuleFive',
        ];
        return $widgets;
    }

}
