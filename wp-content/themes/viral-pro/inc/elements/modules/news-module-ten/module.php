<?php

namespace Viral_Pro_Elements\Modules\NewsModuleTen;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'he-news-module-ten';
    }

    public function get_widgets() {
        $widgets = [
            'NewsModuleTen',
        ];
        return $widgets;
    }

}
