<?php

if (!function_exists('viral_pro_widget_list')) {

    function viral_pro_widget_list() {
        global $wp_registered_sidebars;
        $exclude = viral_pro_get_default_widgets();
        $exclude = array_merge($exclude, array('viral-pro-frontpage-right-sidebar', 'viral-pro-frontpage-left-sidebar'));
        $widget_list['none'] = esc_html__('-- Choose Widget --', 'viral-pro');
        if ($wp_registered_sidebars) {
            foreach ($wp_registered_sidebars as $wp_registered_sidebar) {
                if (!in_array($wp_registered_sidebar['id'], $exclude)) {
                    $widget_list[$wp_registered_sidebar['id']] = $wp_registered_sidebar['name'];
                }
            }
        }
        return $widget_list;
    }

}

if (!function_exists('viral_pro_cat')) {

    function viral_pro_cat() {
        $cat = array();
        $categories = get_categories(array('hide_empty' => 0));
        if ($categories) {
            foreach ($categories as $category) {
                $cat[$category->term_id] = $category->cat_name;
            }
        }
        return $cat;
    }

}

if (!function_exists('viral_pro_page_choice')) {

    function viral_pro_page_choice() {
        $page_choice = array();
        $pages = get_pages(array('hide_empty' => 0));
        if ($pages) {
            foreach ($pages as $pages_single) {
                $page_choice[$pages_single->ID] = $pages_single->post_title;
            }
        }
        return $page_choice;
    }

}

if (!function_exists('viral_pro_menu_choice')) {

    function viral_pro_menu_choice() {
        $menu_choice = array('none' => esc_html('-- Choose Menu --', 'viral-pro'));
        $menus = get_terms('nav_menu', array('hide_empty' => false));
        if ($menus) {
            foreach ($menus as $menus_single) {
                $menu_choice[$menus_single->slug] = $menus_single->name;
            }
        }
        return $menu_choice;
    }

}

if (!function_exists('viral_pro_icon_choices')) {

    function viral_pro_icon_choices() {
        echo '<div id="ht--icon-box" class="ht--icon-box">';
        echo '<div class="ht--icon-search">';
        echo '<select>';

        //See customizer-icon-manager.php file
        $icons = apply_filters('viral_pro_register_icon', array());

        if ($icons && is_array($icons)) {
            foreach ($icons as $icon) {
                if ($icon['name'] && $icon['label']) {
                    echo '<option value="' . esc_attr($icon['name']) . '">' . esc_html($icon['label']) . '</option>';
                }
            }
        }

        echo '</select>';
        echo '<input type="text" class="ht--icon-search-input" placeholder="' . esc_html__('Type to filter', 'viral-pro') . '" />';
        echo '</div>';

        if ($icons && is_array($icons)) {
            $active_class = ' active';
            foreach ($icons as $icon) {
                $icon_name = isset($icon['name']) && $icon['name'] ? $icon['name'] : '';
                $icon_prefix = isset($icon['prefix']) && $icon['prefix'] ? $icon['prefix'] : '';
                $icon_displayPrefix = isset($icon['displayPrefix']) && $icon['displayPrefix'] ? $icon['displayPrefix'] . ' ' : '';

                echo '<ul class="ht--icon-list ' . esc_attr($icon_name) . esc_attr($active_class) . '">';
                $icon_array = isset($icon['icons']) ? $icon['icons'] : '';
                if (is_array($icon_array)) {
                    foreach ($icon_array as $icon_id) {
                        echo '<li><i class="' . esc_attr($icon_displayPrefix) . esc_attr($icon_prefix) . esc_attr($icon_id) . '"></i></li>';
                    }
                }
                echo '</ul>';
                $active_class = '';
            }
        }

        echo '</div>';
    }

}

add_action('customize_controls_print_footer_scripts', 'viral_pro_icon_choices');

function viral_pro_order_sections() {
    if (isset($_POST['sections'])) {
        set_theme_mod('viral_pro_frontpage_sections', $_POST['sections']);
    }
    wp_die();
}

add_action('wp_ajax_viral_pro_order_sections', 'viral_pro_order_sections');

function viral_pro_frontpage_sections() {
    $defaults = array(
        'viral_pro_frontpage_ticker_section',
        'viral_pro_frontpage_slider1_section',
        'viral_pro_frontpage_slider2_section',
        'viral_pro_frontpage_featured_section',
        'viral_pro_frontpage_tile1_section',
        'viral_pro_frontpage_tile2_section',
        'viral_pro_frontpage_mininews_section',
        'viral_pro_frontpage_leftnews_section',
        'viral_pro_frontpage_rightnews_section',
        'viral_pro_frontpage_fwcarousel_section',
        'viral_pro_frontpage_carousel1_section',
        'viral_pro_frontpage_carousel2_section',
        'viral_pro_frontpage_threecol_section',
        'viral_pro_frontpage_fwnews1_section',
        'viral_pro_frontpage_fwnews2_section',
        'viral_pro_frontpage_video_section'
    );
    $sections = get_theme_mod('viral_pro_frontpage_sections', $defaults);
    return $sections;
}

function viral_pro_get_section_position($key) {
    $sections = viral_pro_frontpage_sections();
    $position = array_search($key, $sections);
    $return = ( $position + 1 ) * 10;
    return $return;
}

function viral_pro_svg_seperator() {
    return array(
        'big-triangle-center' => esc_html__('Big Triangle Center', 'viral-pro'),
        'big-triangle-left' => esc_html__('Big Triangle Left', 'viral-pro'),
        'big-triangle-right' => esc_html__('Big Triangle Right', 'viral-pro'),
        'clouds' => esc_html__('Clouds', 'viral-pro'),
        'curve-center' => esc_html__('Curve Center', 'viral-pro'),
        'curve-repeater' => esc_html__('Curve Repeater', 'viral-pro'),
        'droplets' => esc_html__('Droplets', 'viral-pro'),
        'paper-cut' => esc_html__('Paint Brush', 'viral-pro'),
        'small-triangle-center' => esc_html__('Small Triangle Center', 'viral-pro'),
        'tilt-left' => esc_html__('Tilt Left', 'viral-pro'),
        'tilt-right' => esc_html__('Tilt Right', 'viral-pro'),
        'uniform-waves' => esc_html__('Uniform Waves', 'viral-pro'),
        'water-waves' => esc_html__('Water Waves', 'viral-pro'),
        'big-waves' => esc_html__('Big Waves', 'viral-pro'),
        'slanted-waves' => esc_html__('Slanted Waves', 'viral-pro'),
        'zigzag' => esc_html__('Zigzag', 'viral-pro'),
    );
}

function viral_pro_scroll_top_icons_array() {
    return array('arrow_up', 'arrow_carrot-up', 'arrow_carrot-2up', 'arrow_carrot-2up_alt2', 'arrow_carrot-up_alt2', 'arrow_triangle-up_alt2', 'arrow_up_alt', 'icofont-arrow-up', 'icofont-block-up', 'icofont-bubble-up', 'icofont-caret-up', 'icofont-circled-up', 'icofont-curved-up', 'icofont-dotted-up', 'icofont-hand-drawn-alt-up', 'icofont-hand-drawn-up', 'icofont-hand-up', 'icofont-line-block-up', 'icofont-long-arrow-up', 'icofont-rounded-up', 'icofont-scroll-bubble-up', 'icofont-scroll-double-up', 'icofont-scroll-long-up', 'icofont-scroll-up', 'icofont-simple-up', 'icofont-square-up', 'icofont-stylish-up', 'icofont-swoosh-up', 'icofont-thin-up', 'mdi-arrow-collapse-up', 'mdi-arrow-expand-up', 'mdi-arrow-up', 'mdi-arrow-up-bold', 'mdi-arrow-up-bold-box', 'mdi-arrow-up-bold-box-outline', 'mdi-arrow-up-bold-circle', 'mdi-arrow-up-bold-circle-outline', 'mdi-arrow-up-bold-hexagon-outline', 'mdi-arrow-up-bold-outline', 'mdi-arrow-up-box', 'mdi-arrow-up-circle', 'mdi-arrow-up-circle-outline', 'mdi-arrow-up-drop-circle', 'mdi-arrow-up-drop-circle-outline', 'mdi-arrow-up-thick', 'mdi-boom-gate-up', 'mdi-boom-gate-up-outline', 'mdi-chevron-double-up', 'mdi-chevron-triple-up', 'mdi-chevron-up', 'mdi-chevron-up-box', 'mdi-chevron-up-box-outline', 'mdi-chevron-up-circle-outline', 'mdi-clipboard-arrow-up-outline', 'mdi-elevator-up', 'mdi-format-text-rotation-up', 'mdi-gesture-swipe-up', 'mdi-hand-pointing-up', 'mdi-menu-up', 'mdi-menu-up-outline',);
}

function viral_pro_check_cfu() {
    if (class_exists('Hash_Custom_Font_Uploader')) {
        return false;
    } else {
        return true;
    }
}

function viral_pro_check_frontpage() {
    $show_on_front = get_option('show_on_front');
    $enable_frontpage = get_theme_mod('viral_pro_enable_frontpage', false);

    if ($enable_frontpage) {
        return false;
    }

    if ($show_on_front == 'page') {
        $page_on_front = get_option('page_on_front');
        if (get_page_template_slug($page_on_front) != 'templates/home-template.php') {
            return true;
        }
        return false;
    } else {
        return true;
    }
}
