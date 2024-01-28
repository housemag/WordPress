<?php

namespace Viral_Pro_Elements\Modules\TileModuleEight;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-tile-module-eight';
    }

    public function get_widgets() {
        $widgets = [
            'TileModuleEight',
        ];
        return $widgets;
    }

}
