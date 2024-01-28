<?php
if (!class_exists('Viral_Pro_Recommended_Plugins')) {

    class Viral_Pro_Recommended_Plugins {

        /**
         * Recommended Plugins Array
         * @var     array
         * @access  public
         * @since   1.0.0
         */
        public $this_uri;
        public $this_dir;

        public function __construct() {

            // This uri & dir
            $this->this_uri = get_template_directory_uri() . '/inc/theme-panel/recommended-plugins/';
            $this->this_dir = get_template_directory() . '/inc/theme-panel/recommended-plugins/';

            /* Resigter Recommended Plugin Menu */
            add_action('admin_menu', array($this, 'register_menu'));

            /* Enqueue Styles & Scripts for Welcome Page */
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

            require_once $this->this_dir . 'plugin-installer.php';
        }

        public static function get_recommended_plugins() {
            $recommended_plugins = array(
                array(
                    'name' => 'Hash Form - Drag & Drop Form Builder',
                    'slug' => 'hash-form',
                    'required' => false,
                    'description' => esc_html__('Design, Embed, Connect: Your Ultimate Form Companion for WordPress.', 'viral-pro'),
                    'external_url' => 'https://wordpress.org/plugins/hash-form/',
                    'author_name' => 'HashThemes',
                    'author_url' => 'https://hashthemes.com/',
                    'icon' => 'https://ps.w.org/hash-form/assets/icon-256x256.gif'
                ),
                array(
                    'name' => 'Simple Floating Menu',
                    'slug' => 'simple-floating-menu',
                    'required' => false,
                    'description' => esc_html__('Simple Floating Menu adds a stylish designed menu in your website.', 'viral-pro'),
                    'external_url' => 'https://wordpress.org/plugins/simple-floating-menu/',
                    'author_name' => 'HashThemes',
                    'author_url' => 'https://hashthemes.com/',
                    'icon' => 'https://ps.w.org/simple-floating-menu/assets/icon-256x256.png'
                ),
                array(
                    'name' => 'Smart Block',
                    'slug' => 'smart-blocks',
                    'required' => false,
                    'description' => esc_html__('Collection of advanced blocks to be used with WordPress Gutenberg Pagebuilder', 'viral-pro'),
                    'external_url' => 'https://wordpress.org/plugins/smart-blocks/',
                    'author_name' => 'HashThemes',
                    'author_url' => 'https://hashthemes.com/',
                    'icon' => 'https://ps.w.org/smart-blocks/assets/icon-256x256.png'
                ),
                array(
                    'name' => 'Elementor',
                    'slug' => 'elementor',
                    'required' => false,
                    'description' => esc_html__('The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.', 'viral-pro'),
                    'external_url' => 'https://wordpress.org/plugins/elementor/',
                    'author_name' => 'Elementor',
                    'author_url' => 'https://elementor.com/',
                    'icon' => 'https://ps.w.org/elementor/assets/icon.svg'
                )
            );

            return $recommended_plugins;
        }

        public function register_menu() {
            add_submenu_page('viral-pro', esc_html__('Install Plugins', 'viral-pro'), esc_html__('Install Plugins', 'viral-pro'), 'manage_options', 'viral-pro-install-plugins', array($this, 'recommended_plugin_page'));
            global $submenu;
            $permalink = admin_url('customize.php');
            $submenu['viral-pro'][] = array(esc_html__('Customize', 'viral-pro'), 'manage_options', $permalink);
        }

        public function recommended_plugin_page() {
            $recommended_plugins = Viral_Pro_Recommended_Plugins::get_recommended_plugins();
            ?>
            <div class="wrap recommended-plugin-wrap">
                <h1><?php esc_html_e('Recommended Plugins', 'viral-pro'); ?></h1>
                <p><?php esc_html_e('To utilize the theme fully, please install all the Recommended Plugins. Please install it one by one.', 'viral-pro'); ?></p>

                <div class="recommended-plugins-list wp-clearfix">
                    <?php
                    foreach ($recommended_plugins as $plugin) {
                        $icon_url = $plugin['icon'];
                        $author = $plugin['author_name'];
                        $name = $plugin['name'];
                        $link = $plugin['external_url'];
                        $btn_class = Viral_Pro_Plugin_Installer::generate_plugin_class($plugin);
                        $label = Viral_Pro_Plugin_Installer::generate_plugin_label($plugin);
                        $status = Viral_Pro_Plugin_Installer::plugin_active_status($plugin);
                        $source = isset($plugin['source']) ? $plugin['source'] : '';
                        $path = isset($plugin['path']) ? $plugin['path'] : $plugin['slug'] . '/' . $plugin['slug'] . '.php';
                        ?>
                        <div class="recommended-plugin">
                            <?php
                            if ($status == 'active') {
                                ?>
                                <div class="item-ribbon active">
                                    <i class="dashicons dashicons-yes"></i>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="plugin-img-wrap">
                                <img src="<?php echo esc_url($icon_url); ?>" />
                                <div class="version-author-info">
                                    <span class="author"><?php printf(esc_html__('By %s', 'viral-pro'), $author); ?></span>
                                </div>
                            </div>
                            <div class="plugin-title-install wp-clearfix">
                                <span class="title" title="<?php echo esc_attr($name); ?>">
                                    <?php echo esc_html($name); ?>
                                </span>

                                <span class="plugin-action-btn plugin-btn-wrapper plugin-card-<?php echo esc_attr($plugin['slug']); ?>">
                                    <a
                                        class="<?php echo esc_attr($btn_class); ?>"
                                        data-source="<?php echo esc_attr($source); ?>"
                                        data-slug="<?php echo esc_attr($plugin['slug']); ?>"
                                        data-path="<?php echo esc_attr($path); ?>"
                                        href="javascript:void()">
                                            <?php echo esc_html($label); ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
            <?php
        }

        public function enqueue_scripts($hook) {
            if ('viral-pro-panel_page_viral-pro-install-plugins' == $hook) {
                if (is_rtl()) {
                    wp_enqueue_style('recommended-plugins', $this->this_uri . 'css/style.rtl.css', array(), VIRAL_PRO_VER);
                } else {
                    wp_enqueue_style('recommended-plugins', $this->this_uri . 'css/style.css', array(), VIRAL_PRO_VER);
                }
                wp_enqueue_style('plugin-install');
                wp_enqueue_script('plugin-install');
                wp_enqueue_script('updates');
            }
        }

    }

}

new Viral_Pro_Recommended_Plugins;

