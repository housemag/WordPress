<?php

function viral_pro_elementor_widget_list() {
    $enabled_elementor_widgets = array(
        'news-module-one' => esc_html('News Module One', 'viral-pro'),
        'news-module-two' => esc_html('News Module Two', 'viral-pro'),
        'news-module-three' => esc_html('News Module Three', 'viral-pro'),
        'news-module-four' => esc_html('News Module Four', 'viral-pro'),
        'news-module-five' => esc_html('News Module Five', 'viral-pro'),
        'news-module-six' => esc_html('News Module Six', 'viral-pro'),
        'news-module-seven' => esc_html('News Module Seven', 'viral-pro'),
        'news-module-eight' => esc_html('News Module Eight', 'viral-pro'),
        'news-module-nine' => esc_html('News Module Nine', 'viral-pro'),
        'news-module-ten' => esc_html('News Module Ten', 'viral-pro'),
        'news-module-eleven' => esc_html('News Module Eleven', 'viral-pro'),
        'news-module-twelve' => esc_html('News Module Twelve', 'viral-pro'),
        'news-module-thirteen' => esc_html('News Module Thirteen', 'viral-pro'),
        'news-module-fourteen' => esc_html('News Module Fourteen', 'viral-pro'),
        'news-module-fifteen' => esc_html('News Module Fifteen', 'viral-pro'),
        'news-module-sixteen' => esc_html('News Module Sixteen', 'viral-pro'),
        'news-module-seventeen' => esc_html('News Module Seventeen', 'viral-pro'),
        'news-module-eighteen' => esc_html('News Module Eighteen', 'viral-pro'),
        'news-module-nineteen' => esc_html('News Module Nineteen', 'viral-pro'),
        'news-module-twenty' => esc_html('News Module Twenty', 'viral-pro'),
        'news-module-twentyone' => esc_html('News Module Twenty One', 'viral-pro'),
        'news-module-twentytwo' => esc_html('News Module Twenty Two', 'viral-pro'),
        'news-module-twentythree' => esc_html('News Module Twenty Three', 'viral-pro'),
        'news-module-twentyfour' => esc_html('News Module Twenty Four', 'viral-pro'),
        'single-news-one' => esc_html('Single News One', 'viral-pro'),
        'single-news-two' => esc_html('Single New Two', 'viral-pro'),
        'slider-module-one' => esc_html('Slider Moudle One', 'viral-pro'),
        'slider-module-two' => esc_html('Slider Moudle Two', 'viral-pro'),
        'slider-module-three' => esc_html('Slider Moudle Three', 'viral-pro'),
        'slider-module-four' => esc_html('Slider Moudle Four', 'viral-pro'),
        'carousel-module-one' => esc_html('Carousel Module One', 'viral-pro'),
        'carousel-module-two' => esc_html('Carousel Module Two', 'viral-pro'),
        'carousel-module-three' => esc_html('Carousel Module Three', 'viral-pro'),
        'carousel-module-four' => esc_html('Carousel Module Four', 'viral-pro'),
        'carousel-module-five' => esc_html('Carousel Module Five', 'viral-pro'),
        'tile-module-one' => esc_html('Tile Module One', 'viral-pro'),
        'tile-module-two' => esc_html('Tile Module Two', 'viral-pro'),
        'tile-module-three' => esc_html('Tile Module Three', 'viral-pro'),
        'tile-module-four' => esc_html('Tile Module Four', 'viral-pro'),
        'tile-module-five' => esc_html('Tile Module Five', 'viral-pro'),
        'tile-module-six' => esc_html('Tile Module Six', 'viral-pro'),
        'tile-module-seven' => esc_html('Tile Module Seven', 'viral-pro'),
        'tile-module-eight' => esc_html('Tile Module Eight', 'viral-pro'),
        'featured-module' => esc_html('Featured Module', 'viral-pro'),
        'video-module' => esc_html('Video Module', 'viral-pro'),
        'title-module' => esc_html('Title Module', 'viral-pro'),
        'ticker-module' => esc_html('Ticker Module', 'viral-pro')
    );
    return $enabled_elementor_widgets;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */
function optionsframework_options() {

    $widget_list = viral_pro_custom_widget_list();
    $elementor_widget_list = viral_pro_elementor_widget_list();
    $std_widget_list = $std_elementor_widget_list = array();

    foreach ($widget_list as $key => $widget) {
        $std_widget_list[$key] = '1';
    }

    foreach ($elementor_widget_list as $key => $widget) {
        $std_elementor_widget_list[$key] = '1';
    }

    $options = array();

    $options[] = array(
        'name' => __('Customizer Settings', 'viral-pro'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Maintenance Mode Panel', 'viral-pro'),
        'label' => __('Enable/Disable', 'viral-pro'),
        'desc' => sprintf(__('If you are not using %s then disabling can increase the loading speed of customizer panel.', 'viral-pro'), '<a target="_blank" href="' . admin_url('customize.php?autofocus[section]=viral_pro_maintenance_section') . '">' . __('Maintenance Screen', 'viral-pro') . '</a>'),
        'id' => 'customizer_maintenance_mode',
        'std' => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'type' => 'break'
    );

    $options[] = array(
        'name' => __('GDPR Settings Panel', 'viral-pro'),
        'label' => __('Enable/Disable', 'viral-pro'),
        'desc' => sprintf(__('If you are not using %s then disabling can increase the loading speed of customizer panel.', 'viral-pro'), '<a target="_blank" href="' . admin_url('customize.php?autofocus[section]=viral_pro_gdpr_section') . '">' . __('GDPR Option', 'viral-pro') . '</a>'),
        'id' => 'customizer_gdpr_settings',
        'std' => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'type' => 'break'
    );

    $options[] = array(
        'name' => __('Disable Home Page Settings Panel', 'viral-pro'),
        'label' => __('Enable/Disable', 'viral-pro'),
        'desc' => sprintf(__('If you are using page builder instead of %s then disabling can increase the loading speed of customizer panel.', 'viral-pro'), '<a target="_blank" href="' . admin_url('customize.php?autofocus[panel]=viral_pro_front_page_panel') . '">' . __('Customizer Home Page Sections', 'viral-pro') . '</a>'),
        'id' => 'customizer_home_settings',
        'std' => '1',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('Widget Settings', 'viral-pro'),
        'type' => 'heading'
    );

    $options[] = array(
        'name' => __('Widgets', 'viral-pro'),
        'desc' => sprintf(__('Enable/Disable the Widgets. This widgets will show in %1$s.', 'viral-pro'), '<a target="_blank" href="' . admin_url('/widgets.php') . '">' . __('Widget Page', 'viral-pro') . '</a>'),
        'id' => 'enabled_widgets',
        'std' => $std_widget_list,
        'type' => 'multicheck',
        'class' => 'three-col-multicheck',
        'options' => $widget_list
    );

    $options[] = array(
        'name' => __('Elementor Widget Settings', 'viral-pro'),
        'type' => 'heading'
    );

    $options[] = array(
        'name' => __('Overwrite Elementor Settings', 'viral-pro'),
        'desc' => sprintf(__('Forcefully overwrite some settings in the elementor %s.(Disable Default Colors / Disable Default Fonts / Enable Unfiltered File Uploads / Optimized DOM Output)', 'viral-pro'), '<a target="_blank" href="' . admin_url('/admin.php?page=elementor') . '">Setting Page</a>'),
        'id' => 'elementor_default_font_color',
        'std' => true,
        'type' => 'checkbox',
        'label' => __('Yes/No', 'viral-pro'),
    );

    $options[] = array(
        'name' => __('Available Elementor Widgets', 'viral-pro'),
        'desc' => __('List of widgets that will be available when editing the page with Elementor.', 'viral-pro'),
        'id' => 'enabled_elementor_widgets',
        'std' => $std_elementor_widget_list,
        'type' => 'multicheck',
        'class' => 'three-col-multicheck',
        'options' => viral_pro_elementor_widget_list()
    );

    $options[] = array(
        'type' => 'break'
    );

    $options[] = array(
        'name' => __('NOTE', 'viral-pro'),
        'desc' => sprintf(__('These settings will work only if you have installed and activated the %1$s Plugin. You can install Elementor Plugin %2$s.', 'viral-pro'), '<a target="_blank" href="https://wordpress.org/plugins/elementor/">Elementor</a>', '<a href="' . admin_url('/admin.php?page=viral-pro-install-plugins') . '">' . __('here', 'viral-pro') . '</a>'),
        'type' => 'info',
        'class' => 'boxed-note'
    );

    return $options;
}
