<?php

namespace Viral_Pro_Elements\Modules\NewsModuleFifteen;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-news-module-fifteen';
    }

    public function get_widgets() {
        $widgets = [
            'NewsModuleFifteen',
        ];
        return $widgets;
    }

}
