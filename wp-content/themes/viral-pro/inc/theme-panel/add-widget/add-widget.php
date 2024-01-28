<?php
if (!class_exists('Viral_Pro_Add_Widget')) {

    class Viral_Pro_Add_Widget {

        private $this_uri;
        private $this_dir;
        private $message = '';
        private $message_class = '';

        public function __construct() {
            // This uri & dir
            $this->this_uri = get_template_directory_uri() . '/inc/theme-panel/add-widget/';
            $this->this_dir = get_template_directory() . '/inc/theme-panel/add-widget/';

            add_action('admin_menu', array($this, 'register_add_widget_page'));

            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

            // Save the widget area id options table
            add_action('admin_init', array($this, 'viral_pro_save_widgets'));

            // Delete Custom Widget Areas
            add_action('wp_ajax_viral_pro_remove_widget_area', array($this, 'viral_pro_remove_widget_area'));

            // Registering Dynamic Sidebars
            add_action('widgets_init', array($this, 'viral_pro_register_dynamic_sidebars'));
        }

        function viral_pro_save_widgets() {
            if ($_POST) {
                if (!isset($_POST['ht-add-widget-input']) || !isset($_POST['ht-sidebar-nonce']) || !wp_verify_nonce($_POST['ht-sidebar-nonce'], 'viral_pro_create_widget_area_nonce')) {
                    $this->message = esc_html('Something is wrong. Widget not saved.', 'viral-prp');
                    $this->message_class = 'ht-error';
                    return;
                }

                if (isset($_POST['ht-add-widget-input']) && !empty(trim($_POST['ht-add-widget-input']))) {
                    $new_widget = wp_strip_all_tags($_POST['ht-add-widget-input']);

                    if (get_theme_mod('viral_pro_widget_areas')) {
                        $allwidgets = get_theme_mod('viral_pro_widget_areas');
                    } else {
                        $allwidgets = array();
                    }

                    if (in_array(sanitize_key($new_widget), $allwidgets)) {
                        $this->message = esc_html('Widget already exists. Please enter another name.', 'viral-pro');
                        $this->message_class = 'ht-error';
                        return;
                    }

                    $allwidgets[sanitize_text_field($new_widget)] = sanitize_key($new_widget);

                    array_unique(array_filter($allwidgets));

                    set_theme_mod('viral_pro_widget_areas', $allwidgets);

                    $this->message = esc_html('Widget saved successfully.', 'viral-pro');
                    $this->message_class = 'ht-success';
                } else {
                    $this->message = esc_html('Enter the name of the widget.', 'viral-pro');
                    $this->message_class = 'ht-error';
                }
            }
        }

        /**
         *
         * Adding Widget Form Interface in widget page
         * 
         * */
        function register_add_widget_page() {
            add_submenu_page('viral-pro', esc_html__('Add Widget Area', 'viral-pro'), esc_html__('Add Widget Area', 'viral-pro'), 'manage_options', 'viral-pro-add-widgets', array($this, 'viral_pro_add_widget_callback'));
        }

        function viral_pro_add_widget_callback() {
            /**
             *
             * Creates a area accepting widget ID
             */
            $nonce = wp_create_nonce('viral_pro_create_widget_area_nonce');
            ?>
            <div id="ht-add-widget" class="ht-widgets-holder">

                <?php
                if ($this->message) {
                    echo '<div class="ht-notice ' . esc_attr($this->message_class) . '">' . esc_html($this->message) . '</div>';
                }
                ?>

                <div class="ht-add-custom-widgets">
                    <h3><?php esc_html_e('Create New Widget Area', 'viral-pro'); ?></h3>
                    <form action="" method="post">
                        <input type="hidden" name="ht-sidebar-nonce" value="<?php echo esc_attr($nonce); ?>" />
                        <input id="ht-add-widget-input" name="ht-add-widget-input" type="text" class="regular-text" placeholder="<?php esc_attr_e('Name of Widget', 'viral-pro'); ?>" />
                        <input class="button button-primary" type="submit" value="<?php esc_attr_e('Create Widget Area', 'viral-pro'); ?>" />
                    </form>
                </div>

                <div class="ht-remove-custom-widgets">
                    <?php
                    /** Registering Dynamic Sidebars * */
                    $viral_pro_widgets = get_theme_mod('viral_pro_widget_areas');

                    if (!empty($viral_pro_widgets)) {
                        $viral_pro_widgets = array_filter($viral_pro_widgets);
                        ?>
                        <h3 class="ht-widget-toggle"><?php esc_attr_e('Remove Custom Widgets', 'viral-pro'); ?></h3>
                        <ol class="ht-custom-widgets" style="">
                            <?php
                            foreach ($viral_pro_widgets as $title => $id) {
                                ?>
                                <li>
                                    <span><?php echo esc_html($title); ?></span>
                                    <a class="ht-remove-widget" href="#" data-widget="<?php echo esc_attr($title); ?>"><i class="icofont-trash"></i></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ol>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }

        function viral_pro_remove_widget_area() {
            $viral_pro_widgets = get_theme_mod('viral_pro_widget_areas');

            $widget = isset($_REQUEST['widget']) ? $_REQUEST['widget'] : '';
            unset($viral_pro_widgets[$widget]);

            set_theme_mod('viral_pro_widget_areas', $viral_pro_widgets);

            die();
        }

        function viral_pro_register_dynamic_sidebars() {
            $viral_pro_widgets = get_theme_mod('viral_pro_widget_areas');

            if (!empty($viral_pro_widgets)) {
                $viral_pro_widgets = array_filter($viral_pro_widgets);
                foreach ($viral_pro_widgets as $title => $id) {
                    register_sidebar(array(
                        'name' => $title,
                        'id' => $id,
                        'description' => esc_html__('Add widgets here.', 'viral-pro'),
                        'before_widget' => '<div id="%1$s" class="widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h4 class="widget-title">',
                        'after_title' => '</h4>',
                    ));
                }
            }
        }

        function enqueue_scripts() {
            if (is_rtl()) {
                wp_enqueue_style('viral-pro-add-widget', $this->this_uri . 'assets/add-widget.rtl.css', array(), VIRAL_PRO_VER);
            } else {
                wp_enqueue_style('viral-pro-add-widget', $this->this_uri . 'assets/add-widget.css', array(), VIRAL_PRO_VER);
            }

            wp_enqueue_script('viral-pro-add-widget', $this->this_uri . 'assets/add-widget.js', array('jquery'), VIRAL_PRO_VER, true);

            // Localize script
            wp_localize_script(
                    'viral-pro-add-widget', 'viral_pro_widget_params', array(
                'ajaxurl' => admin_url('admin-ajax.php')
                    )
            );
        }

    }

}

new Viral_Pro_Add_Widget();
