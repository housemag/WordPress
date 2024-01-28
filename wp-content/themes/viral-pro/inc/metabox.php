<?php

/**
 *
 * @package Viral Pro
 */
function viral_pro_post_metabox($meta_boxes) {
    $prefix = 'viral_pro_';
    $image_url = get_template_directory_uri() . '/inc/customizer/customizer-panel/images/';

    $meta_boxes[] = array(
        'id' => 'viral_pro_post_setting',
        'title' => esc_html__('Page Setting', 'viral-pro'),
        'post_types' => array('page', 'product'),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'tabs' => array(
            'general-setting' => array(
                'label' => esc_html__('General Setting', 'viral-pro'),
                'icon' => 'dashicons-admin-generic'
            ),
            'titlebar-setting' => array(
                'label' => esc_html__('Title Bar Setting', 'viral-pro'),
                'icon' => 'dashicons-editor-kitchensink'
            ),
            'content-setting' => array(
                'label' => esc_html__('Content Setting', 'viral-pro'),
                'icon' => 'dashicons-admin-page'
            ),
            'sidebar-setting' => array(
                'label' => esc_html__('Sidebar Setting', 'viral-pro'),
                'icon' => 'dashicons-welcome-widgets-menus'
            )
        ),
        'tab_style' => 'left',
        'tab_wrapper' => true,
        'fields' => array(
            array(
                'name' => esc_html__('Hide Header', 'viral-pro'),
                'id' => 'hide_header',
                'type' => 'switch',
                'style' => 'square',
                'on_label' => esc_html__('Yes', 'viral-pro'),
                'off_label' => esc_html__('No', 'viral-pro'),
                'std' => 0,
                'columns' => 6,
                'tab' => 'general-setting'
            ),
            array(
                'name' => esc_html__('Hide Footer', 'viral-pro'),
                'id' => 'hide_footer',
                'type' => 'switch',
                'style' => 'square',
                'on_label' => esc_html__('Yes', 'viral-pro'),
                'off_label' => esc_html__('No', 'viral-pro'),
                'std' => 0,
                'columns' => 6,
                'tab' => 'general-setting'
            ),
            array(
                'name' => esc_html__('Disable Space Below Header', 'viral-pro'),
                'id' => 'disable_space_below_header',
                'type' => 'switch',
                'style' => 'square',
                'on_label' => esc_html__('Yes', 'viral-pro'),
                'off_label' => esc_html__('No', 'viral-pro'),
                'std' => 0,
                'columns' => 6,
                'tab' => 'general-setting'
            ),
            array(
                'name' => esc_html__('Disable Space Above Footer', 'viral-pro'),
                'id' => 'disable_space_above_footer',
                'type' => 'switch',
                'style' => 'square',
                'on_label' => esc_html__('Yes', 'viral-pro'),
                'off_label' => esc_html__('No', 'viral-pro'),
                'std' => 0,
                'columns' => 6,
                'tab' => 'general-setting'
            ),
            array(
                'name' => esc_html__('Page Background Options', 'viral-pro'),
                'type' => 'group',
                'class' => 'background-group',
                'id' => 'page_background',
                'tab' => 'general-setting',
                'fields' => array(
                    array(
                        'id' => 'page_bg_color',
                        'type' => 'color'
                    ),
                    array(
                        'id' => 'page_bg_image',
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1,
                        'max_status' => false
                    ),
                    array(
                        'placeholder' => esc_html__('Background Repeat', 'viral-pro'),
                        'id' => 'page_bg_repeat',
                        'type' => 'select_advanced',
                        'options' => array(
                            'no-repeat' => esc_html__('No Repeat', 'viral-pro'),
                            'repeat' => esc_html__('Repeat All', 'viral-pro'),
                            'repeat-x' => esc_html__('Repeat Horizontally', 'viral-pro'),
                            'repeat-y' => esc_html__('Repeat Vertically', 'viral-pro')
                        ),
                        'js_options' => array(
                            'width' > '500px',
                            'allowClear' => false
                        ),
                        'hidden' => array('page_bg_image', 0),
                        'columns' => 6
                    ),
                    array(
                        'placeholder' => esc_html__('Background Size', 'viral-pro'),
                        'id' => 'page_bg_size',
                        'type' => 'select_advanced',
                        'options' => array(
                            'auto' => esc_html__('Auto', 'viral-pro'),
                            'cover' => esc_html__('Cover', 'viral-pro'),
                            'contain' => esc_html__('Contain', 'viral-pro')
                        ),
                        'js_options' => array(
                            'width' > '500px',
                            'allowClear' => false
                        ),
                        'hidden' => array('page_bg_image', 0),
                        'columns' => 6
                    ),
                    array(
                        'placeholder' => esc_html__('Background Attachment', 'viral-pro'),
                        'id' => 'page_bg_attachment',
                        'type' => 'select_advanced',
                        'options' => array(
                            'scroll' => esc_html__('Scroll', 'viral-pro'),
                            'fixed' => esc_html__('Fixed', 'viral-pro')
                        ),
                        'js_options' => array(
                            'width' > '500px',
                            'allowClear' => false
                        ),
                        'hidden' => array('page_bg_image', 0),
                        'columns' => 6
                    ),
                    array(
                        'placeholder' => esc_html__('Background Position', 'viral-pro'),
                        'id' => 'page_bg_position',
                        'type' => 'select_advanced',
                        'options' => array(
                            'left top' => esc_html__('Left Top', 'viral-pro'),
                            'left center' => esc_html__('Left Center', 'viral-pro'),
                            'left bottom' => esc_html__('Left Bottom', 'viral-pro'),
                            'center top' => esc_html__('Center Top', 'viral-pro'),
                            'center center' => esc_html__('Center Center', 'viral-pro'),
                            'center bottom' => esc_html__('Center Bottom', 'viral-pro'),
                            'right top' => esc_html__('Right Top', 'viral-pro'),
                            'right center' => esc_html__('Right Center', 'viral-pro'),
                            'right bottom' => esc_html__('Right Bottom', 'viral-pro')
                        ),
                        'js_options' => array(
                            'width' > '500px',
                            'allowClear' => false
                        ),
                        'hidden' => array('page_bg_image', 0),
                        'columns' => 6
                    )
                )
            ),
            array(
                'name' => esc_html__('Page Text Color', 'viral-pro'),
                'id' => 'page_text_color',
                'type' => 'color',
                'tab' => 'general-setting'
            ),
            array(
                'name' => esc_html__('Hide Titlebar', 'viral-pro'),
                'id' => 'hide_titlebar',
                'type' => 'switch',
                'style' => 'square',
                'on_label' => esc_html__('Yes', 'viral-pro'),
                'off_label' => esc_html__('No', 'viral-pro'),
                'std' => 0,
                'tab' => 'titlebar-setting'
            ),
            array(
                'name' => esc_html__('Sub Title', 'viral-pro'),
                'id' => 'sub_title',
                'type' => 'text',
                'tab' => 'titlebar-setting',
                'attributes' => array(
                    'class' => 'widefat'
                )
            ),
            array(
                'name' => esc_html__('Display Featured Image in Content', 'viral-pro'),
                'id' => 'content_display_featured_image',
                'type' => 'switch',
                'style' => 'square',
                'on_label' => esc_html__('Yes', 'viral-pro'),
                'off_label' => esc_html__('No', 'viral-pro'),
                'std' => 0,
                'tab' => 'content-setting'
            ),
            array(
                'name' => esc_html__('Content Width', 'viral-pro'),
                'id' => 'content_width',
                'type' => 'radio',
                'options' => array(
                    'container' => esc_html__('Inside Container', 'viral-pro'),
                    'full-width' => esc_html__('Full Width', 'viral-pro')
                ),
                'inline' => true,
                'std' => 'container',
                'tab' => 'content-setting'
            ),
            array(
                'id' => 'sidebar_layout',
                'type' => 'image_select',
                'name' => esc_html__('Sidebar Layout', 'viral-pro'),
                'options' => array(
                    'default-sidebar' => $image_url . 'sidebar-layouts/default.png',
                    'right-sidebar' => $image_url . 'sidebar-layouts/right-sidebar.png',
                    'left-sidebar' => $image_url . 'sidebar-layouts/left-sidebar.png',
                    'no-sidebar' => $image_url . 'sidebar-layouts/no-sidebar.png',
                    'no-sidebar-narrow' => $image_url . 'sidebar-layouts/no-sidebar-narrow.png'
                ),
                'std' => 'default-sidebar',
                'tab' => 'sidebar-setting'
            ),
            array(
                'name' => esc_html__('Left Sidebar', 'viral-pro'),
                'id' => 'left_sidebar',
                'type' => 'sidebar',
                'field_type' => 'select_advanced',
                'placeholder' => esc_html__('Select a sidebar', 'viral-pro'),
                'columns' => 6,
                'tab' => 'sidebar-setting'
            ),
            array(
                'name' => esc_html__('Right Sidebar', 'viral-pro'),
                'id' => 'right_sidebar',
                'type' => 'sidebar',
                'field_type' => 'select_advanced',
                'placeholder' => esc_html__('Select a sidebar', 'viral-pro'),
                'columns' => 6,
                'tab' => 'sidebar-setting'
            )
        )
    );

    $meta_boxes[] = array(
        'id' => 'viral_pro_post_setting',
        'title' => esc_html__('Post Setting', 'viral-pro'),
        'post_types' => array('post'),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'tabs' => array(
            'layout-setting' => array(
                'label' => esc_html__('Layout Settings', 'viral-pro'),
                'icon' => 'dashicons-editor-kitchensink'
            ),
            'general-setting' => array(
                'label' => esc_html__('General Settings', 'viral-pro'),
                'icon' => 'dashicons-admin-generic'
            ),
            'gallery' => array(
                'label' => esc_html__('Post Gallery', 'viral-pro'),
                'icon' => 'dashicons-admin-generic'
            ),
            'link' => array(
                'label' => esc_html__('Post Link', 'viral-pro'),
                'icon' => 'dashicons-admin-generic'
            ),
            'quote' => array(
                'label' => esc_html__('Post Quote', 'viral-pro'),
                'icon' => 'dashicons-admin-generic'
            ),
            'video' => array(
                'label' => esc_html__('Post Video', 'viral-pro'),
                'icon' => 'dashicons-admin-generic'
            ),
            'audio' => array(
                'label' => esc_html__('Post Audio', 'viral-pro'),
                'icon' => 'dashicons-admin-generic'
            )
        ),
        'tab_style' => 'left',
        'tab_wrapper' => true,
        'fields' => array(
            array(
                'name' => esc_html__('Sub Title', 'viral-pro'),
                'id' => 'sub_title',
                'type' => 'text',
                'tab' => 'layout-setting',
                'attributes' => array(
                    'class' => 'widefat'
                )
            ),
            array(
                'id' => 'post_layout',
                'type' => 'image_select',
                'name' => esc_html__('Post Layout', 'viral-pro'),
                'options' => array(
                    'default' => $image_url . 'sidebar-layouts/default.png',
                    'layout1' => $image_url . 'single-layouts/layout1.png',
                    'layout2' => $image_url . 'single-layouts/layout2.png',
                    'layout3' => $image_url . 'single-layouts/layout3.png',
                    'layout4' => $image_url . 'single-layouts/layout4.png',
                    'layout5' => $image_url . 'single-layouts/layout5.png',
                    'layout6' => $image_url . 'single-layouts/layout6.png',
                    'layout7' => $image_url . 'single-layouts/layout7.png'
                ),
                'std' => 'default',
                'tab' => 'layout-setting'
            ),
            array(
                'id' => 'sidebar_layout',
                'type' => 'image_select',
                'name' => esc_html__('Sidebar Position', 'viral-pro'),
                'options' => array(
                    'default-sidebar' => $image_url . 'sidebar-layouts/default.png',
                    'right-sidebar' => $image_url . 'sidebar-layouts/right-sidebar.png',
                    'left-sidebar' => $image_url . 'sidebar-layouts/left-sidebar.png',
                    'no-sidebar' => $image_url . 'sidebar-layouts/no-sidebar.png',
                    'no-sidebar-narrow' => $image_url . 'sidebar-layouts/no-sidebar-narrow.png'
                ),
                'std' => 'default-sidebar',
                'tab' => 'layout-setting'
            ),
            array(
                'name' => esc_html__('Left Sidebar', 'viral-pro'),
                'desc' => esc_html__('Replaces Default Sidebar', 'viral-pro'),
                'id' => 'left_sidebar',
                'type' => 'sidebar',
                'field_type' => 'select_advanced',
                'placeholder' => esc_html__('Select a sidebar', 'viral-pro'),
                'columns' => 6,
                'tab' => 'layout-setting'
            ),
            array(
                'name' => esc_html__('Right Sidebar', 'viral-pro'),
                'desc' => esc_html__('Replaces Default Sidebar', 'viral-pro'),
                'id' => 'right_sidebar',
                'type' => 'sidebar',
                'field_type' => 'select_advanced',
                'placeholder' => esc_html__('Select a sidebar', 'viral-pro'),
                'columns' => 6,
                'tab' => 'layout-setting'
            ),
            array(
                'name' => esc_html__('Hide Header', 'viral-pro'),
                'id' => 'hide_header',
                'type' => 'switch',
                'style' => 'square',
                'on_label' => esc_html__('Yes', 'viral-pro'),
                'off_label' => esc_html__('No', 'viral-pro'),
                'std' => 0,
                'columns' => 6,
                'tab' => 'general-setting'
            ),
            array(
                'name' => esc_html__('Hide Footer', 'viral-pro'),
                'id' => 'hide_footer',
                'type' => 'switch',
                'style' => 'square',
                'on_label' => esc_html__('Yes', 'viral-pro'),
                'off_label' => esc_html__('No', 'viral-pro'),
                'std' => 0,
                'columns' => 6,
                'tab' => 'general-setting'
            ),
            array(
                'name' => esc_html__('Page Background Options', 'viral-pro'),
                'type' => 'group',
                'class' => 'background-group',
                'id' => 'page_background',
                'tab' => 'general-setting',
                'fields' => array(
                    array(
                        'id' => 'page_bg_color',
                        'type' => 'color'
                    ),
                    array(
                        'id' => 'page_bg_image',
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1,
                        'max_status' => false
                    ),
                    array(
                        'placeholder' => esc_html__('Background Repeat', 'viral-pro'),
                        'id' => 'page_bg_repeat',
                        'type' => 'select_advanced',
                        'options' => array(
                            'no-repeat' => esc_html__('No Repeat', 'viral-pro'),
                            'repeat' => esc_html__('Repeat All', 'viral-pro'),
                            'repeat-x' => esc_html__('Repeat Horizontally', 'viral-pro'),
                            'repeat-y' => esc_html__('Repeat Vertically', 'viral-pro')
                        ),
                        'js_options' => array(
                            'width' > '500px',
                            'allowClear' => false
                        ),
                        'hidden' => array('page_bg_image', 0),
                        'columns' => 6
                    ),
                    array(
                        'placeholder' => esc_html__('Background Size', 'viral-pro'),
                        'id' => 'page_bg_size',
                        'type' => 'select_advanced',
                        'options' => array(
                            'auto' => esc_html__('Auto', 'viral-pro'),
                            'cover' => esc_html__('Cover', 'viral-pro'),
                            'contain' => esc_html__('Contain', 'viral-pro')
                        ),
                        'js_options' => array(
                            'width' > '500px',
                            'allowClear' => false
                        ),
                        'hidden' => array('page_bg_image', 0),
                        'columns' => 6
                    ),
                    array(
                        'placeholder' => esc_html__('Background Attachment', 'viral-pro'),
                        'id' => 'page_bg_attachment',
                        'type' => 'select_advanced',
                        'options' => array(
                            'scroll' => esc_html__('Scroll', 'viral-pro'),
                            'fixed' => esc_html__('Fixed', 'viral-pro')
                        ),
                        'js_options' => array(
                            'width' > '500px',
                            'allowClear' => false
                        ),
                        'hidden' => array('page_bg_image', 0),
                        'columns' => 6
                    ),
                    array(
                        'placeholder' => esc_html__('Background Position', 'viral-pro'),
                        'id' => 'page_bg_position',
                        'type' => 'select_advanced',
                        'options' => array(
                            'left top' => esc_html__('Left Top', 'viral-pro'),
                            'left center' => esc_html__('Left Center', 'viral-pro'),
                            'left bottom' => esc_html__('Left Bottom', 'viral-pro'),
                            'center top' => esc_html__('Center Top', 'viral-pro'),
                            'center center' => esc_html__('Center Center', 'viral-pro'),
                            'center bottom' => esc_html__('Center Bottom', 'viral-pro'),
                            'right top' => esc_html__('Right Top', 'viral-pro'),
                            'right center' => esc_html__('Right Center', 'viral-pro'),
                            'right bottom' => esc_html__('Right Bottom', 'viral-pro')
                        ),
                        'js_options' => array(
                            'width' > '500px',
                            'allowClear' => false
                        ),
                        'hidden' => array('page_bg_image', 0),
                        'columns' => 6
                    )
                )
            ),
            array(
                'name' => esc_html__('Page Text Color', 'viral-pro'),
                'id' => 'page_text_color',
                'type' => 'color',
                'tab' => 'general-setting'
            ),
            array(
                'id' => 'post_gallery_image',
                'name' => esc_html__('Post Gallery Images', 'viral-pro'),
                'type' => 'image_advanced',
                'force_delete' => false,
                'max_file_uploads' => 30,
                'max_status' => 'false',
                'image_size' => 'thumbnail',
                'tab' => 'gallery'
            ),
            array(
                'name' => esc_html__('Link', 'viral-pro'),
                'id' => 'post_link',
                'type' => 'text',
                'tab' => 'link',
                'attributes' => array(
                    'class' => 'widefat'
                )
            ),
            array(
                'name' => esc_html__('Title', 'viral-pro'),
                'id' => 'post_link_title',
                'type' => 'text',
                'tab' => 'link',
                'attributes' => array(
                    'class' => 'widefat'
                )
            ),
            array(
                'name' => esc_html__('Upload Image', 'viral-pro'),
                'type' => 'single_image',
                'id' => 'post_link_image',
                'tab' => 'link'
            ),
            array(
                'name' => esc_html__('Quote Text', 'viral-pro'),
                'id' => 'post_quote',
                'type' => 'textarea',
                'tab' => 'quote',
                'attributes' => array(
                    'class' => 'widefat'
                )
            ),
            array(
                'name' => esc_html__('Quote Author', 'viral-pro'),
                'id' => 'post_quote_author',
                'type' => 'text',
                'tab' => 'quote',
                'attributes' => array(
                    'class' => 'widefat'
                )
            ),
            array(
                'name' => esc_html__('Quote Image', 'viral-pro'),
                'type' => 'single_image',
                'id' => 'post_quote_image',
                'tab' => 'quote'
            ),
            array(
                'name' => esc_html__('Video Url', 'viral-pro'),
                'id' => 'post_video',
                'type' => 'oembed',
                'tab' => 'video',
                'attributes' => array(
                    'class' => 'widefat'
                )
            ),
            array(
                'name' => esc_html__('Audio Url', 'viral-pro'),
                'id' => 'post_audio',
                'type' => 'text',
                'tab' => 'audio',
                'attributes' => array(
                    'class' => 'widefat'
                )
            ),
        )
    );


    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', 'viral_pro_post_metabox');

add_filter('rwmb_outside_conditions', function( $conditions ) {
    $conditions['.rwmb-tab-gallery'] = array(
        'visible' => array('post_format', 'gallery'),
    );
    $conditions['.rwmb-tab-link'] = array(
        'visible' => array('post_format', 'link'),
    );
    $conditions['.rwmb-tab-quote'] = array(
        'visible' => array('post_format', 'quote'),
    );
    $conditions['.rwmb-tab-video'] = array(
        'visible' => array('post_format', 'video'),
    );
    $conditions['.rwmb-tab-audio'] = array(
        'visible' => array('post_format', 'audio'),
    );
    return $conditions;
});
