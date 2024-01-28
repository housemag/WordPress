<?php

namespace Viral_Pro_Elements;

use \Elementor\Base_Data_Control;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class AjaxSelect_Control extends Base_Data_Control {

    const AJAXSELECT = 'viral-pro-ajax-select';

    /**
     * Set control type.
     */
    public function get_type() {
        return self::AJAXSELECT;
    }

    /**
     * Set default settings
     */
    protected function get_default_settings() {
        return [
            'label_block' => true,
            'multiple' => false,
            'taxonomy' => false,
            'post_type' => false,
            'options' => [],
            'callback' => '',
        ];
    }

    /**
     * Enqueue control scripts and styles.
     */
    public function enqueue() {
        wp_enqueue_script('ajaxselect2-editor', get_template_directory_uri() . '/inc/elements/assets/js/ajaxselect2-editor.js', array(), VIRAL_PRO_VER);
    }

    /**
     * Render select2 control output in the editor.
     */
    public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <label for="<?php echo esc_attr($control_uid); ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
                <select id="<?php echo esc_attr($control_uid); ?>" class="elementor-select2" type="select2" {{ multiple }} data-setting="{{ data.name }}" data-post-type="{{ data.post_type }}" data-taxonomy="{{ data.taxonomy }}" data-placeholder="<?php echo esc_attr__('Search', 'viral-pro'); ?>">
                        <# _.each( data.options, function( option_title, option_value ) {
                        var value = data.controlValue;
                        if ( typeof value == 'string' ) {
                        var selected = ( option_value === value ) ? 'selected' : '';
                        } else if ( null !== value ) {
                        var value = _.values( value );
                        var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
                        }
                        #>
                        <option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
                    <# } ); #>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }

}
