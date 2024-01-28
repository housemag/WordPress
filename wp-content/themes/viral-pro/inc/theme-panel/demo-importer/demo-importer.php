<?php
if (!defined('ABSPATH'))
    exit;

if (!class_exists('Viral_Pro_Importer')) {

    class Viral_Pro_Importer {

        public $this_uri;
        public $this_dir;
        public $configFile;
        public $uploads_dir;
        public $plugin_install_count;
        public $plugin_active_count;
        public $ajax_response = array();

        /*
         * Constructor
         */

        public function __construct() {

            // This uri & dir
            $this->this_uri = get_template_directory_uri() . '/inc/theme-panel/demo-importer/';
            $this->this_dir = get_template_directory() . '/inc/theme-panel/demo-importer/';

            $this->uploads_dir = wp_get_upload_dir();

            $this->plugin_install_count = 0;
            $this->plugin_active_count = 0;

            // Include necesarry files
            $this->configFile = include $this->this_dir . 'import_config.php';

            require_once $this->this_dir . 'classes/class-demo-importer.php';
            require_once $this->this_dir . 'classes/class-customizer-importer.php';
            require_once $this->this_dir . 'classes/class-widget-importer.php';

            // WP-Admin Menu
            add_action('admin_menu', array($this, 'add_menu'));

            // Add necesary backend JS
            add_action('admin_enqueue_scripts', array($this, 'load_backends'));

            // Actions for the ajax call
            add_action('wp_ajax_viral_pro_install_demo', array($this, 'install_demo_process'));
            add_action('wp_ajax_viral_pro_install_plugin', array($this, 'install_plugin_process'));
            add_action('wp_ajax_viral_pro_activate_plugin', array($this, 'activate_plugin_process'));
            add_action('wp_ajax_viral_pro_download_files', array($this, 'download_files_process'));
            add_action('wp_ajax_viral_pro_import_xml', array($this, 'import_xml_process'));
            add_action('wp_ajax_viral_pro_customizer_import', array($this, 'import_customizer_process'));
            add_action('wp_ajax_viral_pro_menu_import', array($this, 'import_menu_process'));
            add_action('wp_ajax_viral_pro_theme_option', array($this, 'import_theme_option_process'));
            add_action('wp_ajax_viral_pro_importing_widget', array($this, 'import_widget_process'));
            add_action('wp_ajax_viral_pro_import_hashform', array($this, 'import_hashform_process'));
            add_action('wp_ajax_viral_pro_import_revslider', array($this, 'import_revslider_process'));
        }

        /*
         * WP-ADMIN Menu for importer
         */

        function add_menu() {
            add_submenu_page('viral-pro', 'OneClick Demo Install', 'Demo Importer', 'manage_options', 'viral-pro-demo-importer', array($this, 'display_demos'));
        }

        /*
         *  Display the available demos
         */

        function display_demos() {
            ?>
            <div class="wrap viral-pro-demo-importer-wrap">
                <h2><?php echo esc_html__('Viral Pro OneClick Demo Importer', 'viral-pro'); ?></h2>

                <?php
                if (is_array($this->configFile) && !is_null($this->configFile) && !empty($this->configFile)) {
                    $tags = $pagebuilders = array();
                    foreach ($this->configFile as $demo_slug => $demo_pack) {
                        if (isset($demo_pack['tags']) && is_array($demo_pack['tags'])) {
                            foreach ($demo_pack['tags'] as $key => $tag) {
                                $tags[$key] = $tag;
                            }
                        }
                    }

                    foreach ($this->configFile as $demo_slug => $demo_pack) {
                        if (isset($demo_pack['pagebuilder']) && is_array($demo_pack['pagebuilder'])) {
                            foreach ($demo_pack['pagebuilder'] as $key => $pagebuilder) {
                                $pagebuilders[$key] = $pagebuilder;
                            }
                        }
                    }

                    asort($tags);
                    asort($pagebuilders);

                    if (!empty($tags) || !empty($pagebuilders)) {
                        ?>
                        <div class="viral-pro-tab-filter wp-clearfix">
                            <?php
                            if (!empty($tags)) {
                                ?>
                                <div class="viral-pro-tab-group viral-pro-tag-group" data-filter-group="tag">
                                    <div class="viral-pro-tab" data-filter="*">
                                        <?php esc_html_e('All', 'viral-pro'); ?>
                                    </div>
                                    <?php
                                    foreach ($tags as $key => $value) {
                                        ?>
                                        <div class="viral-pro-tab" data-filter=".<?php echo esc_attr($key); ?>">
                                            <?php echo esc_html($value); ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }

                            if (!empty($pagebuilders)) {
                                ?>
                                <div class="viral-pro-tab-group viral-pro-pagebuilder-group" data-filter-group="pagebuilder">
                                    <div class="viral-pro-tab" data-filter="*">
                                        <?php esc_html_e('All', 'viral-pro'); ?>
                                    </div>
                                    <?php
                                    foreach ($pagebuilders as $key => $value) {
                                        ?>
                                        <div class="viral-pro-tab" data-filter=".<?php echo esc_attr($key); ?>">
                                            <?php echo esc_html($value); ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php }
                            ?>
                        </div>
                    <?php } ?>

                    <div class="viral-pro-demo-box-wrap wp-clearfix">
                        <?php
                        // Loop through Demos
                        foreach ($this->configFile as $demo_slug => $demo_pack) {
                            $tags = $pagebuilders = $class = '';
                            if (isset($demo_pack['tags'])) {
                                $tags = implode(' ', array_keys($demo_pack['tags']));
                            }

                            if (isset($demo_pack['pagebuilder'])) {
                                $pagebuilders = implode(' ', array_keys($demo_pack['pagebuilder']));
                            }

                            $classes = $tags . ' ' . $pagebuilders;
                            ?>
                            <div id="<?php echo esc_attr($demo_slug); ?>" class="viral-pro-demo-box <?php echo esc_attr($classes); ?>">
                                <img src="<?php echo esc_url($demo_pack['image']); ?> ">

                                <div class="viral-pro-demo-actions">
                                    <h4><?php echo esc_html($demo_pack['name']); ?></h4>

                                    <div class="viral-pro-demo-buttons">
                                        <a href="<?php echo esc_url($demo_pack['preview_url']); ?>" target="_blank" class="button">
                                            <?php echo esc_html__('Preview', 'viral-pro'); ?>
                                        </a> 

                                        <a href="#viral-pro-modal-<?php echo esc_attr($demo_slug) ?>" class="viral-pro-modal-button button button-primary">
                                            <?php echo esc_html__('Install', 'viral-pro') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                <?php } else {
                    ?>
                    <div class="viral-pro-demo-wrap">
                        <?php esc_html_e("It looks like the config file for the demos is missing or conatins errors!. Demo install can\'t go futher!", 'viral-pro'); ?>  
                    </div>
                <?php }
                ?>

                <?php
                /* Demo Modals */
                if (is_array($this->configFile) && !is_null($this->configFile)) {
                    foreach ($this->configFile as $demo_slug => $demo_pack) {
                        ?>
                        <div id="viral-pro-modal-<?php echo esc_attr($demo_slug) ?>" class="viral-pro-modal" style="display: none;">

                            <div class="viral-pro-modal-header">
                                <h2><?php printf(esc_html('Import %s Demo', 'viral-pro'), esc_html($demo_pack['name'])); ?></h2>
                                <div class="viral-pro-modal-back"><span class="dashicons dashicons-no-alt"></span></div>
                            </div>

                            <div class="viral-pro-modal-wrap">
                                <p><?php echo sprintf(esc_html__('We recommend you backup your website content before attempting to import the demo so that you can recover your website if something goes wrong. You can use %s plugin for it.', 'viral-pro'), '<a href="https://wordpress.org/plugins/all-in-one-wp-migration/" target="_blank">' . esc_html__('All in one migration', 'viral-pro') . '</a>'); ?></p>

                                <p><?php echo esc_html__('This process will install all the required plugins, import contents and setup customizer and theme options.', 'viral-pro'); ?></p>

                                <div class="viral-pro-modal-recommended-plugins">
                                    <h4><?php esc_html_e('Required Plugins', 'viral-pro') ?></h4>
                                    <p><?php esc_html_e('For your website to look exactly like the demo,the import process will install and activate the following plugin if they are not installed or activated.', 'viral-pro') ?></p>
                                    <?php
                                    $plugins = isset($demo_pack['plugins']) ? $demo_pack['plugins'] : '';

                                    if (is_array($plugins)) {
                                        ?>
                                        <ul class="viral-pro-plugin-status">
                                            <?php
                                            foreach ($plugins as $plugin) {
                                                $name = isset($plugin['name']) ? $plugin['name'] : '';
                                                $status = Viral_Pro_Demo_Importer::plugin_active_status($plugin['file_path']);
                                                if ($status == 'active') {
                                                    $plugin_class = '<span class="dashicons dashicons-yes-alt"></span>';
                                                } else if ($status == 'inactive') {
                                                    $plugin_class = '<span class="dashicons dashicons-warning"></span>';
                                                } else {
                                                    $plugin_class = '<span class="dashicons dashicons-dismiss"></span>';
                                                }
                                                ?>
                                                <li class="viral-pro-<?php echo esc_attr($status); ?>">
                                                    <?php
                                                    echo $plugin_class . ' ' . esc_html($name) . ' - <i>' . $this->get_plugin_status($status) . '</i>';
                                                    ?>
                                                </li>
                                            <?php }
                                            ?>
                                        </ul>
                                        <?php
                                    } else {
                                        ?>
                                        <ul>
                                            <li><?php esc_html_e('No Required Plugins Found.', 'viral-pro'); ?></li>
                                        </ul>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="viral-pro-exclude-image-checkbox">
                                    <h4><?php esc_html_e('Exclude Images', 'viral-pro') ?></h4>
                                    <p><?php esc_html_e('Check this option if importing demo fails multiple times. Excluding image will make the demo import process quick.', 'viral-pro') ?></p>
                                    <label>
                                        <input id="checkbox-exclude-image-<?php echo esc_attr($demo_slug); ?>" type="checkbox" value='1'/>
                                        <?php echo esc_html('Yes, Exclude Images', 'viral-pro'); ?>
                                    </label>
                                </div>

                                <div class="viral-pro-reset-checkbox">
                                    <h4><?php esc_html_e('Reset Website', 'viral-pro') ?></h4>
                                    <p><?php esc_html_e('Reseting the website will delete all your post, pages, custom post types, categories, taxonomies, images and all other customizer and theme option settings.', 'viral-pro') ?></p>
                                    <p><?php esc_html_e('It is always recommended to reset the database for a complete demo import.', 'viral-pro') ?></p>
                                    <label>
                                        <input id="checkbox-reset-<?php echo esc_attr($demo_slug); ?>" type="checkbox" value='1' checked="checked"/>
                                        <?php echo esc_html('Reset Website - Check this box only if you are sure to reset the website.', 'viral-pro'); ?>
                                    </label>
                                </div>

                                <p><strong><?php echo sprintf(esc_html__('IMPORTANT!! Please make sure that there is not any red indication in the %s page for the demo import to work properly.', 'viral-pro'), '<a href="' . admin_url('/admin.php?page=viral-pro-system-status') . '" target="_blank">' . esc_html__('System Status', 'viral-pro') . '</a>'); ?></strong></p>

                                <a href="javascript:void(0)" data-demo-slug="<?php echo esc_attr($demo_slug) ?>" class="button button-primary viral-pro-import-demo"><?php esc_html_e('Import Demo', 'viral-pro'); ?></a>
                                <a href="javascript:void(0)" class="button viral-pro-modal-cancel"><?php esc_html_e('Cancel', 'viral-pro'); ?></a>
                            </div>

                        </div>
                        <?php
                    }
                }
                ?>
                <div id="viral-pro-import-progress" style="display: none">
                    <h2 class="viral-pro-import-progress-header"><?php echo esc_html__('Demo Import Progress', 'viral-pro'); ?></h2>

                    <div class="viral-pro-import-progress-wrap">
                        <div class="viral-pro-import-loader">
                            <div class="viral-pro-loader-content">
                                <div class="viral-pro-loader-content-inside">
                                    <div class="viral-pro-loader-rotater"></div>
                                    <div class="viral-pro-loader-line-point"></div>
                                </div>
                            </div>
                        </div>
                        <div class="viral-pro-import-progress-message"></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /*
         *  Do the install on ajax call
         */

        function install_demo_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';
            $excludeImages = isset($_POST['excludeImages']) ? sanitize_text_field($_POST['excludeImages']) : '';

            if (isset($_POST['reset']) && $_POST['reset'] == 'true') {
                $this->database_reset();
                $this->ajax_response['complete_message'] = esc_html__('Database reset complete', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['excludeImages'] = $excludeImages;
            $this->ajax_response['next_step'] = 'viral_pro_install_plugin';
            $this->ajax_response['next_step_message'] = esc_html__('Installing required plugins', 'viral-pro');
            $this->send_ajax_response();
        }

        function install_plugin_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';
            $excludeImages = isset($_POST['excludeImages']) ? sanitize_text_field($_POST['excludeImages']) : '';

            // Install Required Plugins
            $this->install_plugins($demo_slug);

            $plugin_install_count = $this->plugin_install_count;

            if ($plugin_install_count > 0) {
                $this->ajax_response['complete_message'] = esc_html__('All the required plugins installed', 'viral-pro');
            } else {
                $this->ajax_response['complete_message'] = esc_html__('No plugin required to install', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['excludeImages'] = $excludeImages;
            $this->ajax_response['next_step'] = 'viral_pro_activate_plugin';
            $this->ajax_response['next_step_message'] = esc_html__('Activating required plugins', 'viral-pro');
            $this->send_ajax_response();
        }

        function activate_plugin_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';
            $excludeImages = isset($_POST['excludeImages']) ? sanitize_text_field($_POST['excludeImages']) : '';

            // Activate Required Plugins
            $this->activate_plugins($demo_slug);

            $plugin_active_count = $this->plugin_active_count;

            if ($plugin_active_count > 0) {
                $this->ajax_response['complete_message'] = esc_html__('All the required plugins activated', 'viral-pro');
            } else {
                $this->ajax_response['complete_message'] = esc_html__('No plugin required to activate', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['excludeImages'] = $excludeImages;
            $this->ajax_response['next_step'] = 'viral_pro_download_files';
            $this->ajax_response['next_step_message'] = esc_html__('Downloading demo files', 'viral-pro');
            $this->send_ajax_response();
        }

        function download_files_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';
            $excludeImages = isset($_POST['excludeImages']) ? sanitize_text_field($_POST['excludeImages']) : '';

            $downloads = $this->download_files($this->configFile[$demo_slug]['external_url']);
            if ($downloads) {
                $this->ajax_response['complete_message'] = esc_html__('All demo files downloaded', 'viral-pro');
                $this->ajax_response['next_step'] = 'viral_pro_import_xml';
                $this->ajax_response['next_step_message'] = esc_html__('Importing posts, pages and medias. It may take a bit longer time', 'viral-pro');
            } else {
                $this->ajax_response['error'] = true;
                $this->ajax_response['error_message'] = esc_html__('Demo import process failed. Demo files can not be downloaded', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['excludeImages'] = $excludeImages;
            $this->send_ajax_response();
        }

        function import_xml_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';
            $excludeImages = isset($_POST['excludeImages']) ? sanitize_text_field($_POST['excludeImages']) : '';

            // Import XML content
            $xml_filepath = $this->demo_upload_dir($demo_slug) . '/content.xml';

            if (file_exists($xml_filepath)) {
                $this->importDemoContent($xml_filepath, $excludeImages);
                $this->ajax_response['complete_message'] = esc_html__('All content imported', 'viral-pro');
                $this->ajax_response['next_step'] = 'viral_pro_customizer_import';
                $this->ajax_response['next_step_message'] = esc_html__('Importing customizer settings', 'viral-pro');
            } else {
                $this->ajax_response['error'] = true;
                $this->ajax_response['error_message'] = esc_html__('Demo import process failed. No content file found', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['excludeImages'] = $excludeImages;
            $this->send_ajax_response();
        }

        function import_customizer_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';
            $excludeImages = isset($_POST['excludeImages']) ? sanitize_text_field($_POST['excludeImages']) : '';

            $customizer_filepath = $this->demo_upload_dir($demo_slug) . '/customizer.dat';

            if (file_exists($customizer_filepath)) {
                ob_start();
                Viral_Pro_Customizer_Importer::import($customizer_filepath, $excludeImages);
                ob_end_clean();
                $this->ajax_response['complete_message'] = esc_html__('Customizer settings imported', 'viral-pro');
            } else {
                $this->ajax_response['complete_message'] = esc_html__('No customizer settings found', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['next_step'] = 'viral_pro_menu_import';
            $this->ajax_response['next_step_message'] = esc_html__('Setting menus', 'viral-pro');
            $this->send_ajax_response();
        }

        function import_menu_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';

            $menu_array = isset($this->configFile[$demo_slug]['menu_array']) ? $this->configFile[$demo_slug]['menu_array'] : '';
            // Set menu
            if ($menu_array) {
                $this->setMenu($menu_array);
                $this->ajax_response['complete_message'] = esc_html__('Menus saved', 'viral-pro');
            } else {
                $this->ajax_response['complete_message'] = esc_html__('No menus saved', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['next_step'] = 'viral_pro_theme_option';
            $this->ajax_response['next_step_message'] = esc_html__('Importing theme option settings', 'viral-pro');
            $this->send_ajax_response();
        }

        function import_theme_option_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';

            $options_array = isset($this->configFile[$demo_slug]['options_array']) ? $this->configFile[$demo_slug]['options_array'] : '';

            if (isset($options_array) && is_array($options_array)) {
                foreach ($options_array as $theme_option) {
                    $option_filepath = $this->demo_upload_dir($demo_slug) . '/' . $theme_option . '.json';

                    if (file_exists($option_filepath)) {
                        $data = file_get_contents($option_filepath);

                        if ($data) {
                            update_option($theme_option, json_decode($data, true));
                        }
                    }
                }
                $this->ajax_response['complete_message'] = esc_html__('Theme options settings imported', 'viral-pro');
            } else {
                $this->ajax_response['complete_message'] = esc_html__('No theme options found', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['next_step'] = 'viral_pro_importing_widget';
            $this->ajax_response['next_step_message'] = esc_html__('Importing widgets', 'viral-pro');
            $this->send_ajax_response();
        }

        function import_widget_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';

            $widget_filepath = $this->demo_upload_dir($demo_slug) . '/widget.wie';

            if (file_exists($widget_filepath)) {
                ob_start();
                Viral_Pro_Widget_Importer::import($widget_filepath);
                ob_end_clean();
                $this->ajax_response['complete_message'] = esc_html__('Widgets imported', 'viral-pro');
            } else {
                $this->ajax_response['complete_message'] = esc_html__('No widgets found', 'viral-pro');
            }

            $sliderFile = $this->demo_upload_dir($demo_slug) . '/revslider.zip';

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['next_step'] = 'viral_pro_import_hashform';
            $this->ajax_response['next_step_message'] = esc_html__('Importing Forms', 'viral-pro');
            $this->send_ajax_response();
        }

        function import_hashform_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';

            $hash_forms = isset($this->configFile[$demo_slug]['hash_forms']) ? $this->configFile[$demo_slug]['hash_forms'] : '';

            if (isset($hash_forms) && is_array($hash_forms)) {
                foreach ($hash_forms as $hash_form) {
                    $filepath = $this->demo_upload_dir($demo_slug) . '/' . $hash_form . '.json';

                    if (file_exists($filepath)) {
                        if (class_exists('HashFormBuilder')) {
                            hashform_create_table();

                            $imdat = json_decode(file_get_contents($filepath), true);
                            $options = $imdat['options'];

                            $form = array(
                                'name' => esc_html($options['title']),
                                'description' => esc_html($options['description']),
                                'options' => $options,
                                'status' => $imdat['status'],
                                'settings' => $imdat['settings'],
                                'styles' => $imdat['styles'],
                                'created_at' => current_time('mysql'),
                            );

                            $form_id = HashFormBuilder::create($form);

                            foreach ($imdat['field'] as $field) {
                                HashFormFields::create_row(array(
                                    'name' => $field['name'],
                                    'description' => $field['description'],
                                    'type' => $field['type'],
                                    'default_value' => $field['default_value'],
                                    'options' => $field['options'],
                                    'field_order' => $field['field_order'],
                                    'form_id' => absint($form_id),
                                    'required' => $field['required'],
                                    'field_options' => $field['field_options']
                                ));
                            }
                        } else {
                            $this->ajax_response['complete_message'] = esc_html__('Hash Form plugin not installed', 'viral-pro');
                        }
                    }
                }
                $this->ajax_response['complete_message'] = esc_html__('Forms imported', 'viral-pro');
            } else {
                $this->ajax_response['complete_message'] = esc_html__('No Form files found', 'viral-pro');
            }

            $sliderFile = $this->demo_upload_dir($demo_slug) . '/revslider.zip';

            if (file_exists($sliderFile)) {
                $this->ajax_response['next_step'] = 'viral_pro_import_revslider';
                $this->ajax_response['next_step_message'] = esc_html__('Importing Revolution slider', 'viral-pro');
            } else {
                $this->ajax_response['next_step'] = '';
                $this->ajax_response['next_step_message'] = '';
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->send_ajax_response();
        }

        function import_revslider_process() {
            if (!current_user_can('manage_options')) {
                return;
            }
            check_ajax_referer('demo-importer-ajax', 'security');

            $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';

            // Get the zip file path
            $sliderFile = $this->demo_upload_dir($demo_slug) . '/revslider.zip';

            if (file_exists($sliderFile)) {
                if (class_exists('RevSlider')) {
                    $slider = new RevSlider();
                    $slider->importSliderFromPost(true, true, $sliderFile);
                    $this->ajax_response['complete_message'] = esc_html__('Revolution slider installed', 'viral-pro');
                } else {
                    $this->ajax_response['complete_message'] = esc_html__('Revolution slider plugin not installed', 'viral-pro');
                }
            } else {
                $this->ajax_response['complete_message'] = esc_html__('No Revolution slider found', 'viral-pro');
            }

            $this->ajax_response['demo'] = $demo_slug;
            $this->ajax_response['next_step'] = '';
            $this->ajax_response['next_step_message'] = '';
            $this->send_ajax_response();
        }

        public function download_files($external_url) {
            // Make sure we have the dependency.
            if (!function_exists('WP_Filesystem')) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }

            /**
             * Initialize WordPress' file system handler.
             *
             * @var WP_Filesystem_Base $wp_filesystem
             */
            WP_Filesystem();
            global $wp_filesystem;

            $result = true;

            if (!($wp_filesystem->exists($this->demo_upload_dir()))) {
                $result = $wp_filesystem->mkdir($this->demo_upload_dir());
            }

            // Abort the request if the local uploads directory couldn't be created.
            if (!$result) {
                return false;
            } else {
                $demo_pack = $this->demo_upload_dir() . 'demo-pack.zip';

                $file = wp_remote_retrieve_body(wp_remote_get($external_url, array(
                    'timeout' => 60,
                )));

                $wp_filesystem->put_contents($demo_pack, $file);
                unzip_file($demo_pack, $this->demo_upload_dir());
                $wp_filesystem->delete($demo_pack);
                return true;
            }
        }

        /*
         * Reset the database, if the case
         */

        function database_reset() {
            global $wpdb;
            $core_tables = array('commentmeta', 'comments', 'links', 'postmeta', 'posts', 'term_relationships', 'term_taxonomy', 'termmeta', 'terms');
            $exclude_core_tables = array('options', 'usermeta', 'users');
            $core_tables = array_map(function ($tbl) {
                global $wpdb;
                return $wpdb->prefix . $tbl;
            }, $core_tables);
            $exclude_core_tables = array_map(function ($tbl) {
                global $wpdb;
                return $wpdb->prefix . $tbl;
            }, $exclude_core_tables);
            $custom_tables = array();

            $table_status = $wpdb->get_results('SHOW TABLE STATUS');
            if (is_array($table_status)) {
                foreach ($table_status as $index => $table) {
                    if (0 !== stripos($table->Name, $wpdb->prefix)) {
                        continue;
                    }
                    if (empty($table->Engine)) {
                        continue;
                    }

                    if (false === in_array($table->Name, $core_tables) && false === in_array($table->Name, $exclude_core_tables)) {
                        $custom_tables[] = $table->Name;
                    }
                }
            }
            $custom_tables = array_merge($core_tables, $custom_tables);

            foreach ($custom_tables as $tbl) {
                $wpdb->query('SET foreign_key_checks = 0');
                $wpdb->query('TRUNCATE TABLE ' . $tbl);
            }

            // Delete Widgets
            global $wp_registered_widget_controls;

            $widget_controls = $wp_registered_widget_controls;

            $available_widgets = array();

            foreach ($widget_controls as $widget) {
                if (!empty($widget['id_base']) && !isset($available_widgets[$widget['id_base']])) {
                    $available_widgets[] = $widget['id_base'];
                }
            }

            update_option('sidebars_widgets', array('wp_inactive_widgets' => array()));
            foreach ($available_widgets as $widget_data) {
                update_option('widget_' . $widget_data, array());
            }

            // Delete Thememods
            $theme_slug = get_option('stylesheet');
            $mods = get_option("theme_mods_$theme_slug");
            if (false !== $mods) {
                delete_option("theme_mods_$theme_slug");
            }

            //Clear "uploads" folder
            $this->clear_uploads($this->uploads_dir['basedir']);
        }

        /**
         * Clear "uploads" folder
         * @param string $dir
         * @return bool
         */
        private function clear_uploads($dir) {
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                ( is_dir("$dir/$file") ) ? $this->clear_uploads("$dir/$file") : unlink("$dir/$file");
            }

            return ( $dir != $this->uploads_dir['basedir'] ) ? rmdir($dir) : true;
        }

        /*
         * Set the menu on theme location
         */

        function setMenu($menuArray) {

            if (!$menuArray) {
                return;
            }

            $locations = get_theme_mod('nav_menu_locations');

            foreach ($menuArray as $menuId => $menuname) {
                $menu_exists = wp_get_nav_menu_object($menuname);

                if (!$menu_exists) {
                    $term_id_of_menu = wp_create_nav_menu($menuname);
                } else {
                    $term_id_of_menu = $menu_exists->term_id;
                }

                $locations[$menuId] = $term_id_of_menu;
            }

            set_theme_mod('nav_menu_locations', $locations);
        }

        /*
         * Import demo XML content
         */

        function importDemoContent($xml_filepath, $excludeImages) {

            if (!defined('WP_LOAD_IMPORTERS'))
                define('WP_LOAD_IMPORTERS', true);

            if (!class_exists('Viral_Pro_Import')) {
                $class_wp_importer = $this->this_dir . "wordpress-importer/wordpress-importer.php";
                if (file_exists($class_wp_importer)) {
                    require_once $class_wp_importer;
                }
            }

            // Import demo content from XML
            if (class_exists('Viral_Pro_Import')) {
                $demo_slug = isset($_POST['demo']) ? sanitize_text_field($_POST['demo']) : '';
                $excludeImages = $excludeImages == 'true' ? false : true;
                $home_slug = isset($this->configFile[$demo_slug]['home_slug']) ? $this->configFile[$demo_slug]['home_slug'] : '';
                $blog_slug = isset($this->configFile[$demo_slug]['blog_slug']) ? $this->configFile[$demo_slug]['blog_slug'] : '';
                $element_kit_slug = isset($this->configFile[$demo_slug]['element_kit_slug']) ? $this->configFile[$demo_slug]['element_kit_slug'] : '';

                if (file_exists($xml_filepath)) {
                    $wp_import = new Viral_Pro_Import();
                    $wp_import->fetch_attachments = $excludeImages;
                    // Capture the output.
                    ob_start();
                    $wp_import->import($xml_filepath);
                    // Clean the output.
                    ob_end_clean();
                    // Import DONE
                    // set homepage as front page
                    if ($home_slug) {
                        $page = get_page_by_path($home_slug);
                        if ($page) {
                            update_option('show_on_front', 'page');
                            update_option('page_on_front', $page->ID);
                        } else {
                            $page = get_page_by_title('Home');
                            if ($page) {
                                update_option('show_on_front', 'page');
                                update_option('page_on_front', $page->ID);
                            }
                        }
                    }

                    if ($blog_slug) {
                        $blog = get_page_by_path($blog_slug);
                        if ($blog) {
                            update_option('show_on_front', 'page');
                            update_option('page_for_posts', $blog->ID);
                        }
                    }

                    if (!$home_slug && !$blog_slug) {
                        update_option('show_on_front', 'posts');
                    }

                    if ($element_kit_slug) {
                        $elementor_kit = get_page_by_path($element_kit_slug, OBJECT, 'elementor_library');
                        if ($elementor_kit) {
                            update_option('elementor_active_kit', $elementor_kit->ID);
                        }
                    }
                }
            }
        }

        function demo_upload_dir($path = '') {
            $upload_dir = $this->uploads_dir['basedir'] . '/demo-pack/' . $path;
            return $upload_dir;
        }

        function install_plugins($slug) {
            $demo = $this->configFile[$slug];

            $plugins = $demo['plugins'];

            foreach ($plugins as $plugin_slug => $plugin) {
                $name = isset($plugin['name']) ? $plugin['name'] : '';
                $source = isset($plugin['source']) ? $plugin['source'] : '';
                $file_path = isset($plugin['file_path']) ? $plugin['file_path'] : '';
                $location = isset($plugin['location']) ? $plugin['location'] : '';

                if ($source == 'wordpress') {
                    $this->plugin_installer_callback($file_path, $plugin_slug);
                } else {
                    $this->plugin_offline_installer_callback($file_path, $location);
                }
            }
        }

        function activate_plugins($slug) {
            $demo = $this->configFile[$slug];

            $plugins = $demo['plugins'];

            foreach ($plugins as $plugin_slug => $plugin) {
                $name = isset($plugin['name']) ? $plugin['name'] : '';
                $file_path = isset($plugin['file_path']) ? $plugin['file_path'] : '';
                $plugin_status = $this->plugin_status($file_path);

                if ($plugin_status == 'inactive') {
                    $this->activate_plugin($file_path);
                    $this->plugin_active_count++;
                }
            }
        }

        public function plugin_installer_callback($path, $slug) {
            $plugin_status = $this->plugin_status($path);

            if ($plugin_status == 'install') {
                // Include required libs for installation
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
                require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

                // Get Plugin Info
                $api = $this->call_plugin_api($slug);

                $skin = new WP_Ajax_Upgrader_Skin();
                $upgrader = new Plugin_Upgrader($skin);
                $upgrader->install($api->download_link);

                $this->activate_plugin($file_path);

                $this->plugin_install_count++;
            }
        }

        public function plugin_offline_installer_callback($path, $external_url) {

            $plugin_status = $this->plugin_status($path);

            if ($plugin_status == 'install') {
                // Make sure we have the dependency.
                if (!function_exists('WP_Filesystem')) {
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                }

                /**
                 * Initialize WordPress' file system handler.
                 *
                 * @var WP_Filesystem_Base $wp_filesystem
                 */
                WP_Filesystem();
                global $wp_filesystem;

                $plugin = $this->demo_upload_dir() . 'plugin.zip';

                $file = wp_remote_retrieve_body(wp_remote_get($external_url, array(
                    'timeout' => 60,
                )));

                $wp_filesystem->mkdir($this->demo_upload_dir());

                $wp_filesystem->put_contents($plugin, $file);

                unzip_file($plugin, WP_PLUGIN_DIR);

                $plugin_file = WP_PLUGIN_DIR . '/' . esc_html($path);

                $wp_filesystem->delete($plugin);

                $this->activate_plugin($file_path);

                $this->plugin_install_count++;
            }
        }

        /* Plugin API */

        public function call_plugin_api($slug) {
            include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            $call_api = plugins_api('plugin_information', array(
                'slug' => $slug,
                'fields' => array(
                    'downloaded' => false,
                    'rating' => false,
                    'description' => false,
                    'short_description' => false,
                    'donate_link' => false,
                    'tags' => false,
                    'sections' => false,
                    'homepage' => false,
                    'added' => false,
                    'last_updated' => false,
                    'compatibility' => false,
                    'tested' => false,
                    'requires' => false,
                    'downloadlink' => true,
                    'icons' => false
            )));

            return $call_api;
        }

        public function activate_plugin($file_path) {
            if ($file_path) {
                $activate = activate_plugin($file_path, '', false, true);
            }
        }

        /* Check if plugin is active or not */

        public function plugin_status($file_path) {
            $status = 'install';

            $plugin_path = WP_PLUGIN_DIR . '/' . $file_path;

            if (file_exists($plugin_path)) {
                $status = is_plugin_active($file_path) ? 'active' : 'inactive';
            }
            return $status;
        }

        public function get_plugin_status($status) {
            switch ($status) {
                case 'install':
                    $plugin_status = esc_html__('Not Installed', 'viral-pro');
                    break;

                case 'active':
                    $plugin_status = esc_html__('Installed and Active', 'viral-pro');
                    break;

                case 'inactive':
                    $plugin_status = esc_html__('Installed but Not Active', 'viral-pro');
                    break;
            }
            return $plugin_status;
        }

        public function send_ajax_response() {
            $json = wp_json_encode($this->ajax_response);
            echo $json;
            die();
        }

        /*
          Register necessary backend js
         */

        function load_backends() {
            $data = array(
                'nonce' => wp_create_nonce('demo-importer-ajax'),
                'prepare_importing' => esc_html__('Preparing to import demo', 'viral-pro'),
                'reset_database' => esc_html__('Reseting database', 'viral-pro'),
                'no_reset_database' => esc_html__('Database was not reset', 'viral-pro'),
                'import_error' => sprintf(esc_html__('There was an error in importing demo. Please make sure that your server has all the recommended settings %s. If there is not red indication in the System Staus page then please reload the page and try again.', 'viral-pro'), '<a target="_blank" href="' . admin_url('/admin.php?page=viral-pro-system-status') . '">' . esc_html__('here', 'viral-pro') . '</a>'),
                'import_success' => '<h2>' . esc_html__('All done. Have fun!', 'viral-pro') . '</h2><p>' . esc_html__('Your website has been successfully setup.', 'viral-pro') . '</p><a class="button" target="_blank" href="' . esc_url(home_url('/')) . '">' . esc_html__('View your Website', 'viral-pro') . '</a><a class="button" href="' . esc_url(admin_url('/admin.php?page=viral-pro-demo-importer')) . '">' . esc_html__('Go Back', 'viral-pro') . '</a>'
            );

            wp_enqueue_script('isotope-pkgd', $this->this_uri . 'assets/isotope.pkgd.js', array('jquery'), VIRAL_PRO_VER, true);
            wp_enqueue_script('viral-pro-demo-ajax', $this->this_uri . 'assets/demo-importer-ajax.js', array('jquery', 'imagesloaded'), VIRAL_PRO_VER, true);
            wp_localize_script('viral-pro-demo-ajax', 'viral_pro_ajax_data', $data);
            if (is_rtl()) {
                wp_enqueue_style('viral-pro-demo-style', $this->this_uri . 'assets/demo-importer-style.rtl.css', array(), VIRAL_PRO_VER);
            } else {
                wp_enqueue_style('viral-pro-demo-style', $this->this_uri . 'assets/demo-importer-style.css', array(), VIRAL_PRO_VER);
            }
        }

    }

}
new Viral_Pro_Importer;
