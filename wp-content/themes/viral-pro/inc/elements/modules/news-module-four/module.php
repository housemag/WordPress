<?php

namespace Viral_Pro_Elements\Modules\NewsModuleFour;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'he-news-module-four';
    }

    public function get_widgets() {
        $widgets = [
            'NewsModuleFour',
        ];
        return $widgets;
    }

}
