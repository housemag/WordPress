<?php

if (!defined('WP_LOAD_IMPORTERS')) {
    return;
}

/** Display verbose errors */
define('IMPORT_DEBUG', false);

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if (!class_exists('WP_Importer')) {
    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
    if (file_exists($class_wp_importer))
        require $class_wp_importer;
}

/** Functions missing in older WordPress versions. */
require_once dirname(__FILE__) . '/compat.php';

/** Viral_Pro_WXR_Parser class */
require_once dirname(__FILE__) . '/class-wxr-parser.php';

/** Viral_Pro_WXR_Parser_SimpleXML class */
require_once dirname(__FILE__) . '/class-wxr-parser-simplexml.php';

/** Viral_Pro_WXR_Parser_XML class */
require_once dirname(__FILE__) . '/class-wxr-parser-xml.php';

/** Viral_Pro_WXR_Parser_Regex class */
require_once dirname(__FILE__) . '/class-wxr-parser-regex.php';

/** WP_Import class */
require_once dirname(__FILE__) . '/class-wp-import.php';
