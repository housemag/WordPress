<?php

namespace Viral_Pro_Elements\Modules\NewsModuleSix;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'he-news-module-six';
    }

    public function get_widgets() {
        $widgets = [
            'NewsModuleSix',
        ];
        return $widgets;
    }

}
