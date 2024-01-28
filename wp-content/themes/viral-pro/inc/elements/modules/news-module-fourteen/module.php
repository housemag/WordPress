<?php

namespace Viral_Pro_Elements\Modules\NewsModuleFourteen;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-news-module-fourteen';
    }

    public function get_widgets() {
        $widgets = [
            'NewsModuleFourteen',
        ];
        return $widgets;
    }

}
