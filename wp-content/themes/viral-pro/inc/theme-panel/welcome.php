<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    die();
}

if (!class_exists('Viral_Pro_Welcome')) {

    class Viral_Pro_Welcome {

        /**
         * Theme Name
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        private $theme_name;

        /**
         * Theme Version
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        private $theme_version;

        /**
         * Theme Version
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public static $dir;

        /**
         * Theme Version
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public static $uri;

        public function __construct() {
            $theme = wp_get_theme();
            $this->theme_name = $theme->Name;
            $this->theme_version = $theme->Version;
            self::$dir = get_template_directory() . '/inc/theme-panel/';
            self::$uri = get_template_directory_uri() . '/inc/theme-panel/';

            /* Theme Activation Notice */
            add_action('load-themes.php', array($this, 'activation_admin_notice'));

            /* Create a Welcome Page */
            add_action('admin_menu', array($this, 'register_menu'));

            /* Enqueue Styles & Scripts for Welcome Page */
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

            $this->load_files();
        }

        /**
         * Initiator
         *
         * @since 1.0.0
         * @return object
         */
        public function load_files() {
            require self::$dir . 'theme-options/theme-options.php';
            require self::$dir . 'recommended-plugins/recommended-plugins.php';
            require self::$dir . 'demo-importer/demo-importer.php';
            require self::$dir . 'system-status/system-status.php';
            require self::$dir . 'add-widget/add-widget.php';
        }

        /** Welcome Message Notification on Theme Activation * */
        public function activation_admin_notice() {
            global $pagenow;

            if (is_admin() && ('themes.php' == $pagenow) && (isset($_GET['activated']))) {
                add_action('admin_notices', array($this, 'welcome_notice'));
            }
        }

        public function welcome_notice() {
            ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php
                    printf('%1$s %2$s %3$s <a href="%4$s">%5$s</a> %6$s', esc_html__('Welcome! Thank you for choosing', 'viral-pro'), esc_html($this->theme_name), esc_html__('Please make sure you visit our', 'viral-pro'), esc_url(admin_url('admin.php?page=viral-pro')), esc_html__('Welcome Page', 'viral-pro'), esc_html__('to get started with Viral Pro.', 'viral-pro'));
                    ?>
                </p>
                <p><a class="button" href="<?php echo esc_url(admin_url('admin.php?page=viral-pro')) ?>"><?php esc_html_e('Lets Get Started', 'viral-pro'); ?></a></p>
            </div>
            <?php
        }

        /** Enqueue Necessary Styles and Scripts for the Welcome Page * */
        public function enqueue_scripts() {
            if (is_rtl()) {
                wp_enqueue_style('welcome-screen', self::$uri . 'css/welcome.rtl.css', array(), VIRAL_PRO_VER);
            } else {
                wp_enqueue_style('welcome-screen', self::$uri . 'css/welcome.css', array(), VIRAL_PRO_VER);
            }
        }

        /** Register Menu for Welcome Page * */
        public function register_menu() {
            add_menu_page(esc_html__('Welcome', 'viral-pro'), esc_html__('Viral Pro Panel', 'viral-pro'), 'manage_options', 'viral-pro', array($this, 'viral_pro_welcome'), '', 2);
            add_submenu_page('viral-pro', esc_html__('Welcome', 'viral-pro'), esc_html__('Welcome', 'viral-pro'), 'manage_options', 'viral-pro', array($this, 'viral_pro_welcome'));
        }

        public function viral_pro_welcome() {
            $theme = wp_get_theme();
            ?>
            <div class="wrap viral-pro-welcome-wrap wp-clearfix">
                <h1></h1>
                <div class="viral-pro-welcome-content">

                    <div class="viral-pro-welcome-intro">
                        <h3><?php printf(esc_html__('Welcome to %s', 'viral-pro'), $theme->Name); ?> <span class="theme-version">v<?php echo esc_html($theme->Version); ?></span></h3>
                        <p><?php printf(esc_html__('Welcome and thank you for installing %s. We have worked very hard to release a great product and fully commited to making your experience perfect.', 'viral-pro'), $theme->Name); ?></p>

                        <p><?php printf(esc_html__('If this is your first experience with %s, we recommend you visiting the following pages', 'viral-pro'), $theme->Name); ?></p>

                        <ul class="viral-pro-quick-links wp-clearfix">
                            <li><a href="<?php echo admin_url('/admin.php?page=viral-pro-install-plugins') ?>"><?php echo esc_html('Installing Recommended Plugins', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/admin.php?page=viral-pro-demo-importer') ?>"><?php echo esc_html('Importing Demos', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php') ?>"><?php echo esc_html('Setting Customizer Panel', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/admin.php?page=viral-pro-options') ?>"><?php echo esc_html('Setting Theme Option Panel', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/admin.php?page=viral-pro-system-status') ?>"><?php echo esc_html('System Status', 'viral-pro') ?></a></li>
                            <li><a href="https://www.templatemonster.com/wordpress-themes/viral-pro-news-amp-magazine-wordpress-theme-230399.html#tab-comments" target="_blank"><?php echo esc_html('Support Forum', 'viral-pro') ?></a></li>
                        </ul>
                    </div>

                    <div class="viral-pro-welcome-customizer-links">
                        <h4><?php echo esc_html('Quick Links - Customizer Settings') ?></h4>
                        <ul>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=title_tagline') ?>"><?php echo esc_html('Upoad Logo - Add logo, title, tagline and favicon', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=viral_pro_preloader_options_section') ?>"><?php echo esc_html('Add Preloader - Show beautiful animated preloader untill your website loads', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[panel]=viral_pro_typography_panel') ?>"><?php echo esc_html('Customize Fonts - Set typography family, style, weight, size, line height and color', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=colors') ?>"><?php echo esc_html('Theme Color - Set the primary color and content text colors of the theme', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=viral_pro_main_header_options') ?>"><?php echo esc_html('Header Layouts - Change the header layout from 6 styles', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[panel]=viral_pro_header_settings_panel') ?>"><?php echo esc_html('Header Options - Set top header and main header content, style and colors', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[panel]=viral_pro_front_page_panel') ?>"><?php echo esc_html('Home Sections Settings - Enable/Disable, configure various predefined home page sections', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=viral_pro_blog_options_section') ?>"><?php echo esc_html('Blog Page Settings - Choose from different blog styles and configure other blog settings', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=viral_pro_footer_section') ?>"><?php echo esc_html('Footer Settings - Choose footer layout, column and colors', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=viral_pro_layout_options_section') ?>"><?php echo esc_html('Sidebar layouts - Choose sidebar layouts for page, post and archive pages', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=viral_pro_maintenance_section') ?>"><?php echo esc_html('Maintenance Screen - Display Comming Soon or Maintenace page untill your website is not ready', 'viral-pro') ?></a></li>
                            <li><a href="<?php echo admin_url('/customize.php?autofocus[section]=viral_pro_gdpr_section') ?>"><?php echo esc_html('GDPR Settings - Allows you to inform users that your site uses cookies and to comply with the EU cookie law GDPR regulations', 'viral-pro') ?></a></li>
                        </ul>
                    </div>
                </div>


                <div class="viral-pro-welcome-sidebar">

                    <div class="viral-pro-support-box">
                        <h5><span class="dashicons dashicons-download"></span><?php echo esc_html('One Click Demo Import', 'viral-pro'); ?></h5>
                        <div class="viral-pro-support-content">
                            <p><?php echo esc_html('Viral Pro allows you to easily create unique looking sites with just one click. Click on the button below to go to the demo importer page and import the desired demo.', 'viral-pro'); ?></p>
                            <a class="button button-primary" href="<?php echo admin_url('/admin.php?page=viral-pro-demo-importer'); ?>"><?php echo esc_html('Import Demo', 'viral-pro') ?></a>
                        </div>
                    </div>

                    <div class="viral-pro-support-box">
                        <h5><span class="dashicons dashicons-welcome-write-blog"></span><?php echo esc_html('Documentation', 'viral-pro'); ?></h5>
                        <div class="viral-pro-support-content">
                            <p><?php echo sprintf(esc_html('Please check our full documentation for detailed information on how to use the theme. You need to be %s to our website with your purchase account to access the documentation.', 'viral-pro'), '<a href="https://hashthemes.com/login/" target="_blank">logged in</a>'); ?></p>
                            <a class="button button-primary" href="https://hashthemes.com/documentation/viral-pro-documentation/" target="_blank"><?php echo esc_html('View Documentation', 'viral-pro') ?></a>
                        </div>
                    </div>

                    <div class="viral-pro-support-box">
                        <h5><span class="dashicons dashicons-book"></span><?php echo esc_html('Knowledge Base (Articles)', 'viral-pro'); ?></h5>
                        <div class="viral-pro-support-content">
                            <p><?php echo esc_html('You can find additional information that are not in the documentation. It can be from general topics to specific aspects of the WordPress and themes.', 'viral-pro'); ?></p>
                            <a class="button button-primary" href="https://hashthemes.com/articles/" target="_blank"><?php echo esc_html('View Articles', 'viral-pro') ?></a>
                        </div>
                    </div>

                    <div class="viral-pro-support-box">
                        <h5><span class="dashicons dashicons-sos"></span><?php echo esc_html('Support Forums', 'viral-pro'); ?></h5>
                        <div class="viral-pro-support-content">
                            <p><?php echo sprintf(esc_html('Through the forums we offer top notch support. Before asking a questions it\'s highly recommended to search on forums, but if you can\'t find the solution feel free to create a new topic.', 'viral-pro')); ?></p>
                            <a class="button button-primary" href="https://www.templatemonster.com/wordpress-themes/viral-pro-news-amp-magazine-wordpress-theme-230399.html#tab-comments" target="_blank"><?php echo esc_html('Visit Support Forum', 'viral-pro') ?></a>
                        </div>
                    </div>

                </div>
            </div><!-- .wrap -->
            <?php
        }

    }

}

if (!function_exists('viral_pro_welcome')) {

    function viral_pro_welcome() {
        return new Viral_Pro_Welcome;
    }

}

viral_pro_welcome();
