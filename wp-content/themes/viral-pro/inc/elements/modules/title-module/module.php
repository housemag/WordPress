<?php

namespace Viral_Pro_Elements\Modules\TitleModule;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'vp-title-module';
    }

    public function get_widgets() {
        $widgets = [
            'TitleModule',
        ];
        return $widgets;
    }

}
