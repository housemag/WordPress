<?php
/**
 * Initial functions.
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class to manipulate menus.
 *
 */
class Viral_Pro_Nav_Walker {

    /**
     * Constructor.
     *
     * @access public
     */
    public function __construct() {
        add_action('init', array($this, 'add_custom_post_types'));

        // Edit menu walker
        add_filter('wp_edit_nav_menu_walker', array($this, 'edit_walker'), 100);

        // Add custom fields to menu
        add_filter('wp_setup_nav_menu_item', array($this, 'add_custom_fields_meta'));
        add_action('wp_nav_menu_item_custom_fields', array($this, 'add_custom_fields'), 10, 4);

        // Save menu custom fields
        add_action('wp_update_nav_menu_item', array($this, 'update_custom_nav_fields'), 10, 3);

        add_action('admin_enqueue_scripts', array($this, 'enqueue_script'));

        add_filter('nav_menu_item_title', array($this, 'add_custom_icon'), 10, 4);

        require get_template_directory() . '/inc/walker/menu-walker.php';
    }

    /**
     * Add custom menu style fields data to the menu.
     *
     * @access public
     * @param object $menu_item A single menu item.
     * @return object The menu item.
     */
    public function add_custom_fields_meta($menu_item) {
        $menu_item->megamenu = get_post_meta($menu_item->ID, '_menu_item_megamenu', true);
        $menu_item->megamenu_col = get_post_meta($menu_item->ID, '_menu_item_megamenu_col', true);
        $menu_item->megamenu_heading = get_post_meta($menu_item->ID, '_menu_item_megamenu_heading', true);
        $menu_item->megamenu_template = get_post_meta($menu_item->ID, '_menu_item_megamenu_template', true);
        $menu_item->megamenu_widgetarea = get_post_meta($menu_item->ID, '_menu_item_megamenu_widgetarea', true);
        $menu_item->category_post = get_post_meta($menu_item->ID, '_menu_item_category_post', true);
        $prev_menu_icon_val = get_post_meta($menu_item->ID, 'menu-icons', true);

        if (isset($prev_menu_icon_val) && $prev_menu_icon_val) {
            $menu_item->megamenu_icon = isset($prev_menu_icon_val['icon']) ? 'dashicons ' . $prev_menu_icon_val['icon'] : '';
            $menu_item->megamenu_hide_label = isset($prev_menu_icon_val['hide_label']) && $prev_menu_icon_val['hide_label'] ? 'yes' : 'no';
            $menu_item->megamenu_icon_position = isset($prev_menu_icon_val['position']) ? $prev_menu_icon_val['position'] : '';
            $menu_item->megamenu_icon_size = '';
        } else {
            $menu_item->megamenu_icon = get_post_meta($menu_item->ID, '_menu_item_megamenu_icon', true);
            $menu_item->megamenu_hide_label = get_post_meta($menu_item->ID, '_menu_item_megamenu_hide_label', true);
            $menu_item->megamenu_icon_position = get_post_meta($menu_item->ID, '_menu_item_megamenu_icon_position', true);
            $menu_item->megamenu_icon_size = get_post_meta($menu_item->ID, '_menu_item_megamenu_icon_size', true);
        }

        return $menu_item;
    }

    /**
     * Add custom megamenu fields data to the menu.
     *
     * @access public
     * @param object $menu_item A single menu item.
     * @return object The menu item.
     */
    public function add_custom_fields($id, $item, $depth, $args) {
        ?>
        <?php if ($item->object == 'category') { ?>
            <p class="field-category-post description description-wide">
                <label for="edit-menu-item-category-post-<?php echo esc_attr($item->ID); ?>">
                    <input type="checkbox" id="edit-menu-item-category-post-<?php echo esc_attr($item->ID); ?>" class="edit-menu-item-category-post" value="category_post" name="menu-item-category_post[<?php echo esc_attr($item->ID); ?>]"<?php checked($item->category_post, 'category_post'); ?> />
                    <?php esc_html_e('Display Latest Posts', 'viral-pro'); ?>
                </label>
            </p>
        <?php } ?>

        <p class="field-megamenu description description-wide">
            <label for="edit-menu-item-megamenu-<?php echo esc_attr($item->ID); ?>">
                <?php esc_html_e('Mega Menu', 'viral-pro'); ?><br/>
                <select id="edit-menu-item-megamenu-<?php echo esc_attr($item->ID); ?>" class="widefat edit-menu-item-megamenu" name="menu-item-megamenu[<?php echo esc_attr($item->ID); ?>]"<?php checked($item->megamenu, 'viral-pro'); ?>>
                    <option value="normal" <?php selected($item->megamenu, 'normal') ?>><?php esc_html_e('Disable', 'viral-pro'); ?></option>
                    <option value="megamenu_full_width" <?php selected($item->megamenu, 'megamenu_full_width') ?>><?php esc_html_e('Megamenu - Full Width', 'viral-pro'); ?></option>
                    <option value="megamenu_auto_width" <?php selected($item->megamenu, 'megamenu_auto_width') ?>><?php esc_html_e('Megamenu - Auto Width', 'viral-pro'); ?></option>
                </select>
            </label>
        </p>

        <p class="field-megamenu-columns description description-wide">
            <label for="edit-menu-item-megamenu-col-<?php echo esc_attr($item->ID); ?>">
                <?php esc_html_e('Mega Menu Columns (from 1 to 6)', 'viral-pro'); ?><br />
                <select id="edit-menu-item-megamenu-col-<?php echo esc_attr($item->ID); ?>" class="widefat edit-menu-item-custom" name="menu-item-megamenu_col[<?php echo esc_attr($item->ID); ?>]">
                    <option value="1" <?php selected($item->megamenu_col, 1) ?>><?php esc_html_e('1', 'viral-pro'); ?></option>
                    <option value="2" <?php selected($item->megamenu_col, 2) ?>><?php esc_html_e('2', 'viral-pro'); ?></option>
                    <option value="3" <?php selected($item->megamenu_col, 3) ?>><?php esc_html_e('3', 'viral-pro'); ?></option>
                    <option value="4" <?php selected($item->megamenu_col, 4) ?>><?php esc_html_e('4', 'viral-pro'); ?></option>
                    <option value="5" <?php selected($item->megamenu_col, 5) ?>><?php esc_html_e('5', 'viral-pro'); ?></option>
                    <option value="6" <?php selected($item->megamenu_col, 6) ?>><?php esc_html_e('6', 'viral-pro'); ?></option>
                </select>
            </label>
        </p>      

        <p class="field-megamenu-heading description description-wide">
            <label for="edit-menu-item-megamenu-heading-<?php echo esc_attr($item->ID); ?>">
                <?php esc_html_e('Is Heading?', 'viral-pro'); ?>
                <select id="edit-menu-item-megamenu-heading-<?php echo esc_attr($item->ID); ?>" class="widefat edit-menu-item-custom" name="menu-item-megamenu_heading[<?php echo esc_attr($item->ID); ?>]">
                    <option value="no" <?php selected($item->megamenu_heading, 'no') ?>><?php esc_html_e('No', 'viral-pro'); ?></option>
                    <option value="yes" <?php selected($item->megamenu_heading, 'yes') ?>><?php esc_html_e('Yes', 'viral-pro'); ?></option>
                    <option value="hide" <?php selected($item->megamenu_heading, 'hide') ?>><?php esc_html_e('Hide', 'viral-pro'); ?></option>
                </select>
            </label>
        </p>

        <p class="field-megamenu-template description description-thin">
            <label for="edit-menu-item-megamenu-template-<?php echo esc_attr($item->ID); ?>">
                <?php esc_html_e('Mega Menu Template', 'viral-pro'); ?>
                <select id="edit-menu-item-megamenu-template-<?php echo esc_attr($item->ID); ?>" class="widefat edit-menu-item-custom" name="menu-item-megamenu_template[<?php echo esc_attr($item->ID); ?>]">
                    <option value="0"><?php esc_html_e('Select Template', 'viral-pro'); ?></option>
                    <?php
                    $templates_list = get_posts(array('post_type' => 'ht-megamenu', 'numberposts' => -1, 'post_status' => 'publish'));
                    if (!empty($templates_list)) {
                        foreach ($templates_list as $template) {
                            $templates[$template->ID] = $template->post_title;
                            ?>
                            <option value="<?php echo esc_attr($template->ID); ?>" <?php selected($item->megamenu_template, $template->ID); ?>><?php echo esc_html($template->post_title); ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </label>
        </p>

        <p class="field-megamenu-widgetarea description description-thin">
            <label for="edit-menu-item-megamenu-widgetarea-<?php echo esc_attr($item->ID); ?>">
                <?php esc_html_e('Mega Menu Widget Area', 'viral-pro'); ?>
                <select id="edit-menu-item-megamenu-widgetarea-<?php echo esc_attr($item->ID); ?>" class="widefat edit-menu-item-custom" name="menu-item-megamenu_widgetarea[<?php echo esc_attr($item->ID); ?>]">
                    <option value="0"><?php esc_html_e('Select Widget Area', 'viral-pro'); ?></option>
                    <?php
                    global $wp_registered_sidebars;
                    if (!empty($wp_registered_sidebars) && is_array($wp_registered_sidebars)) :
                        foreach ($wp_registered_sidebars as $sidebar) :
                            ?>
                            <option value="<?php echo esc_attr($sidebar['id']); ?>" <?php selected($item->megamenu_widgetarea, $sidebar['id']); ?>><?php echo esc_html($sidebar['name']); ?>
                            </option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </label>
        </p>

        <div class="field-megamenu-icon description description-wide">
            <label for="edit-menu-item-megamenu-icon-<?php echo esc_attr($item->ID); ?>">
                <?php
                esc_html_e('Select Icon', 'viral-pro');
                $new_value = $item->megamenu_icon;
                ?>
                <div class="mm-icon-box-wrap">
                    <div class="mm-selected-icon">
                        <i class="<?php echo esc_attr($new_value); ?>"></i>
                        <span><i class="total-down-icon"></i></span>
                    </div>
                    <div class="mm-icon-box">
                        <div class="mm-icon-search">
                            <select>
                                <?php
                                if (apply_filters('viral_pro_show_dash_icon', true)) {
                                    echo '<option value="mm-dash-icon-list">' . esc_html__('Dash Icon', 'viral-pro') . '</option>';
                                }

                                if (apply_filters('viral_pro_show_ico_font', true)) {
                                    echo '<option value="mm-icofont-list">' . esc_html__('Ico Font', 'viral-pro') . '</option>';
                                }

                                if (apply_filters('viral_pro_show_material_icon', true)) {
                                    echo '<option value="mm-material-icon-list">' . esc_html__('Material Icon', 'viral-pro') . '</option>';
                                }

                                if (apply_filters('viral_pro_show_elegant_icon', true)) {
                                    echo '<option value="mm-elegant-icon-list">' . esc_html__('Elegant Icon', 'viral-pro') . '</option>';
                                }
                                ?>

                            </select>
                            <input type="text" class="mm-icon-search-input" placeholder="<?php echo esc_html__('Type to filter', 'meta-store'); ?>" />
                            <button class="mm-icon-remove-button"><?php echo esc_html__('Remove', 'viral-pro') ?></button>
                        </div>

                        <div class="mm-icon-panel">
                            <?php
                            if (apply_filters('viral_pro_show_dash_icon', true)) {
                                echo '<ul class="mm-icon-list mm-dash-icon-list tp-clearfix active">';
                                $viral_pro_dash_icon_array = viral_pro_dash_icon_array();
                                foreach ($viral_pro_dash_icon_array as $viral_pro_dash_icon) {
                                    echo '<li><i class="dashicons dashicons-' . esc_attr($viral_pro_dash_icon) . '"></i></li>';
                                }
                                echo '</ul>';
                            }

                            if (apply_filters('viral_pro_show_ico_font', true)) {
                                echo '<ul class="mm-icon-list mm-icofont-list tp-clearfix">';
                                $viral_pro_icofont_icon_array = viral_pro_icofont_icon_array();
                                foreach ($viral_pro_icofont_icon_array as $viral_pro_icofont_icon) {
                                    echo '<li><i class="icofont-' . esc_attr($viral_pro_icofont_icon) . '"></i></li>';
                                }
                                echo '</ul>';
                            }

                            if (apply_filters('viral_pro_show_material_icon', true)) {
                                echo '<ul class="mm-icon-list mm-material-icon-list tp-clearfix">';
                                $viral_pro_materialdesignicons_icon_array = viral_pro_materialdesignicons_array();
                                foreach ($viral_pro_materialdesignicons_icon_array as $viral_pro_materialdesignicons_icon) {
                                    echo '<li><i class="mdi-' . esc_attr($viral_pro_materialdesignicons_icon) . '"></i></li>';
                                }
                                echo '</ul>';
                            }

                            if (apply_filters('viral_pro_show_elegant_icon', true)) {
                                echo '<ul class="mm-icon-list mm-elegant-icon-list tp-clearfix">';
                                $viral_pro_eleganticons_array = viral_pro_eleganticons_array();
                                foreach ($viral_pro_eleganticons_array as $viral_pro_elegant_icon) {
                                    echo '<li><i class="' . esc_attr($viral_pro_elegant_icon) . '"></i></li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                            <input type="hidden" value="<?php echo $item->megamenu_icon; ?>" id="edit-menu-item-megamenu-icon-<?php echo esc_attr($item->ID); ?>" name="menu-item-megamenu_icon[<?php echo esc_attr($item->ID); ?>]" />
                        </div>

                        <div class="mm-icon-bottom-panel">
                            <label class="field-megamenu-hide-label" for="edit-menu-item-megamenu-hide-label-<?php echo esc_attr($item->ID); ?>">
                                <?php echo esc_html__('Hide Label', 'viral-pro'); ?>
                                <select id="edit-menu-item-megamenu-hide-label-<?php echo esc_attr($item->ID); ?>" class="widefat edit-menu-item-custom" name="menu-item-megamenu_hide_label[<?php echo esc_attr($item->ID); ?>]">
                                    <option value="no"<?php echo selected($item->megamenu_hide_label, 'no'); ?>><?php echo esc_html_e('No', 'viral-pro'); ?></option>
                                    <option value="yes"<?php echo selected($item->megamenu_hide_label, 'yes'); ?>><?php echo esc_html_e('Yes', 'viral-pro'); ?></option>
                                </select>
                            </label>


                            <label class="field-megamenu-icon-position" for="edit-menu-item-megamenu-icon-position-<?php echo esc_attr($item->ID); ?>">
                                <?php echo esc_html__('Icon Position', 'viral-pro'); ?>
                                <select id="edit-menu-item-megamenu-icon-position-<?php echo esc_attr($item->ID); ?>" class="widefat edit-menu-item-custom" name="menu-item-megamenu_icon_position[<?php echo esc_attr($item->ID); ?>]">
                                    <option value="before"<?php echo selected($item->megamenu_icon_position, 'before'); ?>><?php echo esc_html_e('Before', 'viral-pro'); ?></option>
                                    <option value="after"<?php echo selected($item->megamenu_icon_position, 'after'); ?>><?php echo esc_html_e('After', 'viral-pro'); ?></option>
                                </select>
                            </label>

                            <label class="field-megamenu-icon-size" for="edit-menu-item-megamenu-icon-size-<?php echo esc_attr($item->ID); ?>">
                                <?php echo esc_html__('Icon Size', 'viral-pro'); ?>
                                <input id="edit-menu-item-megamenu-icon-size-<?php echo esc_attr($item->ID); ?>" class="widefat edit-menu-item-custom" name="menu-item-megamenu_icon_size[<?php echo esc_attr($item->ID); ?>]" type="number" value="<?php echo $item->megamenu_icon_size; ?>"> px
                            </label>
                        </div>
                    </div>
                </div>

            </label>
        </div>
        <?php
    }

    /**
     * Add the custom menu style fields menu item data to fields in database.
     *
     * @access public
     * @param string|int $menu_id         The menu ID.
     * @param string|int $menu_item_db_id The menu ID from the db.
     * @param array      $args            The arguments array.
     * @return void
     */
    public function update_custom_nav_fields($menu_id, $menu_item_db_id, $args) {

        $check = array('megamenu_template', 'category_post', 'megamenu', 'megamenu_col', 'megamenu_heading', 'megamenu_widgetarea', 'megamenu_icon', 'megamenu_hide_label', 'megamenu_icon_position', 'megamenu_icon_size');

        foreach ($check as $key) {
            if (!isset($_POST['menu-item-' . $key][$menu_item_db_id])) {
                $_POST['menu-item-' . $key][$menu_item_db_id] = '';
            }

            $value = sanitize_text_field(wp_unslash($_POST['menu-item-' . $key][$menu_item_db_id]));
            update_post_meta($menu_item_db_id, '_menu_item_' . $key, $value);
        }

        $prev_menu_icon_val = get_post_meta($menu_item_db_id, 'menu-icons', true);
        if (isset($prev_menu_icon_val) && $prev_menu_icon_val) {
            delete_post_meta($menu_item_db_id, 'menu-icons');
        }
    }

    /**
     * Function to replace normal edit nav walker.
     *
     * @return string Class name of new navwalker
     */
    public function edit_walker() {
        require_once get_template_directory() . '/inc/walker/class-walker-edit-viral-pro.php';
        return 'Walker_Nav_Menu_Edit_Viral_Pro';
    }

    public function enqueue_script() {
        if (is_rtl()) {
            wp_enqueue_style('viral-pro-mega-menu-admin-style', get_template_directory_uri() . '/inc/walker/assets/mega-menu-admin.rtl.css', array(), VIRAL_PRO_VER);
        } else {
            wp_enqueue_style('viral-pro-mega-menu-admin-style', get_template_directory_uri() . '/inc/walker/assets/mega-menu-admin.css', array(), VIRAL_PRO_VER);
        }
        wp_enqueue_script('viral-pro-mega-menu-admin-script', get_template_directory_uri() . '/inc/walker/assets/mega-menu-admin.js', array('jquery', 'jquery-ui-sortable'), VIRAL_PRO_VER, true);
    }

    public function add_custom_icon($title, $item, $args, $depth) {
        $prev_menu_icon_val = get_post_meta($item->ID, 'menu-icons', true);
        if (isset($prev_menu_icon_val) && $prev_menu_icon_val) {
            $megamenu_icon = isset($prev_menu_icon_val['icon']) ? 'dashicons ' . $prev_menu_icon_val['icon'] : '';
            $megamenu_hide_label = isset($prev_menu_icon_val['hide_label']) && $prev_menu_icon_val['hide_label'] ? 'yes' : 'no';
            $megamenu_icon_position = isset($prev_menu_icon_val['position']) ? $prev_menu_icon_val['position'] : '';
            $megamenu_icon_size = '';
        } else {
            $megamenu_icon = get_post_meta($item->ID, '_menu_item_megamenu_icon', true);
            $megamenu_hide_label = get_post_meta($item->ID, '_menu_item_megamenu_hide_label', true);
            $megamenu_icon_position = get_post_meta($item->ID, '_menu_item_megamenu_icon_position', true);
            $megamenu_icon_size = get_post_meta($item->ID, '_menu_item_megamenu_icon_size', true);
        }

        if ($megamenu_icon) {
            $icon_class = array(
                'mm-font-icon-' . $megamenu_icon_position,
                $megamenu_icon,
                $megamenu_hide_label == 'yes' ? 'mm-no-title' : ''
            );

            $style = '';

            if ($megamenu_icon_size) {
                $style = ' style="font-size:' . $megamenu_icon_size . 'px"';
            }

            $megamenu_icon = '<span' . $style . ' class="' . implode(' ', $icon_class) . '"></span>';

            if ($megamenu_hide_label == 'yes') {
                $title = '';
            }

            if ($megamenu_icon_position == 'after') {
                $title = $title . $megamenu_icon;
            } elseif ($megamenu_icon_position == 'before') {
                $title = $megamenu_icon . $title;
            }
        }

        return '<span class="mm-menu-title">' . $title . '</span>';
    }

    public function add_custom_post_types() {
        $labels = array(
            'name' => _x('Mega Menus', 'post type general name', 'viral-pro'),
            'singular_name' => _x('Mega Menu', 'post type singular name', 'viral-pro'),
            'menu_name' => _x('Mega Menus', 'admin menu', 'viral-pro'),
            'name_admin_bar' => _x('Mega Menu', 'add new on admin bar', 'viral-pro'),
            'add_new' => _x('Add New', 'Mega Menu', 'viral-pro'),
            'add_new_item' => __('Add New Mega Menu', 'viral-pro'),
            'new_item' => __('New Mega Menu', 'viral-pro'),
            'edit_item' => __('Edit Mega Menu', 'viral-pro'),
            'view_item' => __('View Mega Menu', 'viral-pro'),
            'all_items' => __('All Mega Menus', 'viral-pro'),
            'search_items' => __('Search Mega Menus', 'viral-pro'),
            'parent_item_colon' => __('Parent Mega Menus:', 'viral-pro'),
            'not_found' => __('No Mega Menu found.', 'viral-pro'),
            'not_found_in_trash' => __('No Mega Menu found in Trash.', 'viral-pro')
        );

        $args = array(
            'labels' => $labels,
            'description' => __('Show Mega Menu Items', 'viral-pro'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'ht-mega-menu'),
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-schedule',
            'supports' => array('title', 'editor'),
            'show_in_rest' => true,
            'show_in_nav_menus' => false
        );

        register_post_type('ht-megamenu', $args);
    }

}

new Viral_Pro_Nav_Walker();
