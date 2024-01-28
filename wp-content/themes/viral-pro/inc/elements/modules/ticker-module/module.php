<?php

namespace Viral_Pro_Elements\Modules\TickerModule;

use Viral_Pro_Elements\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'he-ticker-module';
    }

    public function get_widgets() {
        $widgets = [
            'TickerModule',
        ];
        return $widgets;
    }

}
