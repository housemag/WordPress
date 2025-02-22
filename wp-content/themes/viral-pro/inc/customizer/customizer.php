<?php

/**
 * Viral Pro Theme Customizer
 *
 * @package Viral Pro
 */
define('VIRAL_PRO_CUSTOMIZER_URL', get_template_directory_uri() . '/inc/customizer/');
define('VIRAL_PRO_CUSTOMIZER_PATH', get_template_directory() . '/inc/customizer/');

require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-custom-controls.php';
require VIRAL_PRO_CUSTOMIZER_PATH . 'custom-controls/typography/typography.php';
require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-control-sanitization.php';
require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-functions.php';
require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-icon-manager.php';
require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/register-customizer-controls.php';
