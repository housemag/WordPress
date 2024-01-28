<?php

if (!class_exists('Viral_Pro_Register_Customizer_Controls')) {

    class Viral_Pro_Register_Customizer_Controls {

        function __construct() {
            add_action('customize_register', array($this, 'register_customizer_settings'));
            add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_customizer_script'));
            add_action('customize_preview_init', array($this, 'enqueue_customize_preview_js'));
        }

        public function register_customizer_settings($wp_customize) {
            /** Theme Options */
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/maintenance.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/general-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/color-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/header-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/sidebar-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/home-sections.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/home-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/blog-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/footer-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/social-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/gdpr-settings.php';
            require VIRAL_PRO_CUSTOMIZER_PATH . 'customizer-panel/typography.php';

            $wp_customize->get_section('static_front_page')->priority = -1;

            $wp_customize->add_setting('viral_pro_enable_frontpage', array(
                'sanitize_callback' => 'viral_pro_sanitize_text',
                'default' => false,
            ));

            $wp_customize->add_control(new Viral_Pro_Toggle_Control($wp_customize, 'viral_pro_enable_frontpage', array(
                'section' => 'static_front_page',
                'label' => esc_html__('Enable FrontPage', 'viral-pro'),
                'description' => sprintf(esc_html__('Overwrites the homepage displays setting and shows the frontpage for Customizer %s', 'viral-pro'), '<a href="javascript:wp.customize.panel(\'viral_pro_front_page_panel\').focus()">' . esc_html__('Front Page Sections', 'viral-pro') . '</a>') . '<br/><br/>' . esc_html__('Do not enable this option if you want to use Elementor in home page.', 'viral-pro')
            )));

            /* ============IMPORTANT LINKS============ */
            $wp_customize->add_section('viral_pro_implink_section', array(
                'title' => esc_html__('Important Links', 'viral-pro'),
                'priority' => 1000
            ));

            $wp_customize->add_setting('viral_pro_imp_links', array(
                'sanitize_callback' => 'viral_pro_sanitize_text'
            ));

            $wp_customize->add_control(new Viral_Pro_Text_Info_Control($wp_customize, 'viral_pro_imp_links', array(
                'section' => 'viral_pro_implink_section',
                'description' => '<a class="viral-pro-implink" href="https://demo.hashthemes.com/viral-pro/" target="_blank">' . esc_html__('Live Demo', 'viral-pro') . '</a><a class="viral-pro-implink" href="https://hashthemes.com/support/forum/viral-pro/" target="_blank">' . esc_html__('Support Forum', 'viral-pro') . '</a><a class="viral-pro-implink" href="https://www.facebook.com/hashtheme/" target="_blank">' . esc_html__('Like Us in Facebook', 'viral-pro') . '</a>',
            )));

            $wp_customize->add_setting('viral_pro_rate_us', array(
                'sanitize_callback' => 'viral_pro_sanitize_text'
            ));

            $wp_customize->add_control(new Viral_Pro_Text_Info_Control($wp_customize, 'viral_pro_rate_us', array(
                'section' => 'viral_pro_implink_section',
                'description' => sprintf(esc_html__('Please do rate our theme if you liked it %s', 'viral-pro'), '<a class="viral-pro-implink" href="https://wordpress.org/support/theme/viral/reviews/?filter=5" target="_blank">Rate/Review</a>'),
            )));

            $wp_customize->add_setting('viral_pro_setup_instruction', array(
                'sanitize_callback' => 'viral_pro_sanitize_text'
            ));

            $wp_customize->add_control(new Viral_Pro_Text_Info_Control($wp_customize, 'viral_pro_setup_instruction', array(
                'section' => 'viral_pro_implink_section',
                'description' => __('<strong>Instruction - Setting up Home Page</strong><br/>1. Create a new
                            page (any title, like Home )<br/>
        2. In right column: Page Attributes -> Template: Home Page<br/>
        3. Click on Publish<br/>
        4. Go to Appearance-> Customize -> General settings -> Static Front Page<br/>
        5. Select - A static page<br/>
        6. In Front Page, select the page that you created in the step 1<br/>
        7. Save changes', 'viral-pro'),
            )));

            /** For Additional Hooks */
            do_action('viral_pro_new_options', $wp_customize);
        }

        public function enqueue_customizer_script() {
            wp_enqueue_script('viral-pro-customizer', VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/assets/customizer.js', array('jquery'), VIRAL_PRO_VER, true);
            if (is_rtl()) {
                wp_enqueue_style('viral-pro-customizer', VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/assets/customizer.rtl.css', array(), VIRAL_PRO_VER);
            } else {
                wp_enqueue_style('viral-pro-customizer', VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/assets/customizer.css', array(), VIRAL_PRO_VER);
            }
        }

        public function enqueue_customize_preview_js() {
            wp_enqueue_script('viral-pro-customizer-preview', VIRAL_PRO_CUSTOMIZER_URL . 'customizer-panel/assets/customizer-preview.js', array('customize-preview'), VIRAL_PRO_VER, true);
        }

    }

    new Viral_Pro_Register_Customizer_Controls();
}
