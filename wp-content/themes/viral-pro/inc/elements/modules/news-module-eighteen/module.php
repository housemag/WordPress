<?php

namespace Viral_Pro_Elements\Modules\NewsModuleEighteen;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-news-module-eighteen';
    }

    public function get_widgets() {
        $widgets = [
            'NewsModuleEighteen',
        ];
        return $widgets;
    }

}
