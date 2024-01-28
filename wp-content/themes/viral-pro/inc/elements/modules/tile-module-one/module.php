<?php

namespace Viral_Pro_Elements\Modules\TileModuleOne;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-tile-module-one';
    }

    public function get_widgets() {
        $widgets = [
            'TileModuleOne',
        ];
        return $widgets;
    }

}
