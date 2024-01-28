<?php

namespace Viral_Pro_Elements\Modules\NewsModuleNine;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'he-news-module-nine';
    }

    public function get_widgets() {
        $widgets = [
            'NewsModuleNine',
        ];
        return $widgets;
    }

}
