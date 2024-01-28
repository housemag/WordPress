<?php

namespace Viral_Pro_Elements\Modules\CarouselModuleTwo;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-carousel-module-two';
    }

    public function get_widgets() {
        $widgets = [
            'CarouselModuleTwo',
        ];
        return $widgets;
    }

}
