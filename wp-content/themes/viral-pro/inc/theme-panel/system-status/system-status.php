<?php

if (!defined('WPINC')) {
    die;
}

define('SYSTEM_STATUS_DIRECTORY', trailingslashit(str_replace('\\', '/', dirname(__FILE__))));
define('SYSTEM_STATUS_DIRECTORY_URI', site_url(str_replace(trailingslashit(str_replace('\\', '/', ABSPATH)), '', SYSTEM_STATUS_DIRECTORY)));

require SYSTEM_STATUS_DIRECTORY . 'class/class-admin-system-status.php';
require SYSTEM_STATUS_DIRECTORY . 'class/class-admin-system-status-report.php';
require SYSTEM_STATUS_DIRECTORY . 'class/class-admin-tgm-plugin.php';

function viral_pro_system_report_scripts() {
    if (is_rtl()) {
        wp_enqueue_style('system-status-style', SYSTEM_STATUS_DIRECTORY_URI . 'assets/system-status.rtl.css', array(), VIRAL_PRO_VER);
    } else {
        wp_enqueue_style('system-status-style', SYSTEM_STATUS_DIRECTORY_URI . 'assets/system-status.css', array(), VIRAL_PRO_VER);
    }
}

add_action('admin_enqueue_scripts', 'viral_pro_system_report_scripts');

function viral_pro_register_system_status_page() {
    add_submenu_page('viral-pro', esc_html__('System Status', 'viral-pro'), esc_html__('System Status', 'viral-pro'), 'manage_options', 'viral-pro-system-status', 'viral_pro_system_status_callback');
}

add_action('admin_menu', 'viral_pro_register_system_status_page');

/**
 * Display callback for the submenu page.
 */
function viral_pro_system_status_callback() {
    require SYSTEM_STATUS_DIRECTORY . 'system-status-template.php';
}

if (!function_exists('viral_pro_admin_system_status')) {

    function viral_pro_admin_system_status() {
        return Viral_Pro_System_Status::obtain();
    }

}


if (!function_exists('viral_pro_admin_system_status_report')) {

    function viral_pro_admin_system_status_report() {
        return Viral_Pro_System_Status_Report::obtain();
    }

}


if (!function_exists('viral_pro_admin_export_system_status_report_download')) {
    add_action('admin_menu', 'viral_pro_admin_export_system_status_report_download', 20);

    function viral_pro_admin_export_system_status_report_download() {
        if (isset($_POST['viral-pro-system-status-report-download']) && ( true === viral_pro_bool($_POST['viral-pro-system-status-report-download']) )) {
            check_admin_referer('viral-pro-system-status-report-download');

            // Initialize the System Status Report handler.
            $system_status_report = viral_pro_admin_system_status_report();

            // Export a full report in JSON format.
            $system_status_report->export_json_report();
        }
    }

}


if (!function_exists('viral_pro_bool')) {

    function viral_pro_bool($value = false) {

        if (is_string($value)) {

            if ($value && ( 'false' !== strtolower($value) )) {
                return true;
            } else {
                return false;
            }
        } else {

            return ( $value ? true : false );
        }
    }

}


if (!function_exists('viral_pro_uasort_plugins')) {

    function viral_pro_uasort_plugins($a, $b) {
        return strcmp($a['name'], $b['name']);
    }

}