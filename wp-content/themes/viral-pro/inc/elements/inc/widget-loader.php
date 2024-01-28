<?php

namespace Viral_Pro_Elements;

use Elementor\Group_Control_Base;

if (!defined('ABSPATH'))
    exit();

class Viral_Pro_Widget_Loader {

    private static $instance = null;
    public static $dir;
    public static $uri;

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function __construct() {
        self::$dir = get_template_directory() . '/inc/elements/';
        self::$uri = get_template_directory_uri() . '/inc/elements/';

        spl_autoload_register([$this, 'autoload']);

        $this->includes();
        // Elementor hooks
        $this->add_actions();
    }

    public function autoload($class) {
        if (0 !== strpos($class, __NAMESPACE__)) {
            return;
        }

        $has_class_alias = isset($this->classes_aliases[$class]);

        // Backward Compatibility: Save old class name for set an alias after the new class is loaded
        if ($has_class_alias) {
            $class_alias_name = $this->classes_aliases[$class];
            $class_to_load = $class_alias_name;
        } else {
            $class_to_load = $class;
        }

        if (!class_exists($class_to_load)) {

            $filename = strtolower(
                    preg_replace(
                            ['/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/'], ['', '$1-$2', '-', DIRECTORY_SEPARATOR], $class_to_load
                    )
            );

            $filename = self::$dir . $filename . '.php';

            if (is_readable($filename)) {
                include( $filename );
            }
        }

        if ($has_class_alias) {
            class_alias($class_alias_name, $class);
        }
    }

    private function includes() {
        require self::$dir . 'inc/module-manager.php';
        require self::$dir . 'inc/helper-functions.php';
    }

    public function add_actions() {
        add_action('elementor/init', [$this, 'add_elementor_widget_categories']);

        // Fires after Elementor controls are registered.
        add_action('elementor/controls/register', [$this, 'register_controls']);

        //FrontEnd Scripts
        add_action('elementor/frontend/before_register_scripts', [$this, 'register_frontend_scripts']);
        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_frontend_scripts']);

        //FrontEnd Styles
        add_action('elementor/frontend/before_register_styles', [$this, 'register_frontend_styles']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_frontend_styles']);

        //Editor Scripts
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueue_editor_scripts']);

        //Editor Style
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_styles']);

        //Fires after Elementor preview styles are enqueued.
        add_action('elementor/preview/enqueue_styles', [$this, 'enqueue_preview_styles']);
    }

    function add_elementor_widget_categories() {

        $groups = array(
            'viral-pro-elements' => esc_html__('News Modules', 'viral-pro'),
            'viral-pro-tile-elements' => esc_html__('Tile Modules', 'viral-pro'),
            'viral-pro-carousel-elements' => esc_html__('Carousel Modules', 'viral-pro'),
            'viral-pro-slider-elements' => esc_html__('Slider Modules', 'viral-pro')
        );

        foreach ($groups as $key => $value) {
            \Elementor\Plugin::$instance->elements_manager->add_category($key, ['title' => $value], 1);
        }
    }

    function register_controls($controls_manager) {
        require_once self::$dir . 'inc/controls/groups/group-control-query.php';
        require_once self::$dir . 'inc/controls/groups/group-control-header.php';
        require_once self::$dir . 'inc/controls/class-selectize-control.php';
        require_once self::$dir . 'inc/controls/class-ajaxselect-control.php';

        // Register Group
        $controls_manager->add_group_control('viral-pro-elements-query', new Group_Control_Query());
        $controls_manager->add_group_control('viral-pro-elements-header', new Group_Control_Header());
        $controls_manager->register(new Selectize_Control());
        $controls_manager->register(new AjaxSelect_Control());
    }

    /**
     * Register Frontend Scripts
     */
    public function register_frontend_scripts() {
        
    }

    /**
     * Enqueue Frontend Scripts
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_script('viral-pro-elements-frontend-script', self::$uri . 'assets/js/frontend.js', array('jquery'), VIRAL_PRO_VER, true);
    }

    /**
     * Register Frontend Styles
     */
    public function register_frontend_styles() {
        
    }

    /**
     * Enqueue Frontend Styles
     */
    public function enqueue_frontend_styles() {
        if (is_rtl()) {
            wp_enqueue_style('viral-pro-elements-frontend-style', self::$uri . 'assets/css/frontend.rtl.css', array(), VIRAL_PRO_VER);
        } else {
            wp_enqueue_style('viral-pro-elements-frontend-style', self::$uri . 'assets/css/frontend.css', array(), VIRAL_PRO_VER);
        }
    }

    /**
     * Enqueue Editor Scripts
     */
    public function enqueue_editor_scripts() {
        wp_enqueue_script('viral-pro-elements-editor', self::$uri . 'assets/js/editor.js', array('jquery'), VIRAL_PRO_VER, true);
        wp_localize_script('viral-pro-elements-editor', 'viral_pro_elementor_params', array('is_elementor_pro_installed' => $this->is_elementor_pro_installed()));
    }

    /**
     * Enqueue Editor Styles
     */
    public function enqueue_editor_styles() {
        wp_enqueue_style('viral-pro-elements-editor-style', self::$uri . 'assets/css/editor-styles.css', array(), VIRAL_PRO_VER);
    }

    /**
     * Preview Styles
     */
    public function enqueue_preview_styles() {
        
    }

    /**
     * Check if theme has elementor Pro installed
     *
     * @return boolean
     */
    public function is_elementor_pro_installed() {
        return function_exists('elementor_pro_load_plugin') ? 'yes' : 'no';
    }

}

if (!function_exists('viral_pro_widget_loader')) {

    /**
     * Returns an instance of the plugin class.
     * @since  1.0.0
     * @return object
     */
    function viral_pro_widget_loader() {
        return Viral_Pro_Widget_Loader::get_instance();
    }

}
viral_pro_widget_loader();
