<?php

namespace ViralPro\Blocks\Headers;

class Viral_Pro_Block_Header {

    protected $block_header_args;

    function __construct($block_header_args) {
        $this->block_header_args = $block_header_args;
    }

    protected function get_block_title() {
        $link_open = $link_close = $output = "";
        $header_link = $this->get_setting('header_link');
        $header_title = $this->get_setting('header_title');
        $class = $this->get_setting('header_style') == 'vl-title-default' ? 'vl-block-title' : 'vp-block-title';
        $target = $header_link['is_external'] ? ' target="_blank"' : '';
        $nofollow = $header_link['nofollow'] ? ' rel="nofollow"' : '';

        if ($header_link['url']) {
            $link_open = '<a href="' . $header_link['url'] . '"' . $target . $nofollow . '>';
            $link_close = '</a>';
        }

        if (trim($header_title) !== '') {
            $output .= '<h2 class="' . $class . '">';
            $output .= $link_open;
            $output .= '<span class="vl-title">';
            $output .= $header_title;
            $output .= '</span>';
            $output .= $link_close;
            $output .= '</h2>';
        }
        return $output;
    }

    protected function get_block_taxonomy_filter() {
        if (!$this->get_setting('filterable'))
            return;

        $output = '';
        $block_filter_terms = $this->get_block_filter_terms();

        if (empty($block_filter_terms)) {
            return $output;
        }

        $output .= '<div class="vp-block-filter">';
        $output .= '<ul class="vp-block-filter-list">';

        $all_text = $this->get_setting('all_text');
        if (trim($all_text) != '') {
            $output .= '<li class="vp-block-filter-item vp-active"><a class="vp-block-filter-link" data-term-id="" data-taxonomy="" href="#">' . esc_html($all_text) . '</a>';
        }

        foreach ($block_filter_terms as $key => $block_filter_term) {
            $output .= '<li class="vp-block-filter-item ' . (($key == 0 && trim($all_text) == '') ? 'vp-active' : '') . '"><a class="vp-block-filter-link" data-term-id="' . $block_filter_term->term_id . '" data-taxonomy="' . $block_filter_term->taxonomy . '" href="#">' . $block_filter_term->name . '</a>';
        }

        $output .= '</ul>';
        $output .= '<div class="vp-block-filter-dropdown">';
        $output .= '<div class="vp-block-filter-more"><span>' . __('More', 'viral-pro') . '</span><i class="icofont-thin-down"></i></div>';
        $output .= '<div class="vp-block-filter-dropdown-list-wrap"><ul class="vp-block-filter-dropdown-list">';
        $output .= '</ul></div>';
        $output .= '</div><!-- .vp-block-filter-dropdown -->';
        $output .= '</div><!-- .vp-block-filter -->';
        return $output;
    }

    private function get_block_filter_terms() {
        if (!empty($this->block_header_args['block_filter_terms'])) {
            return $this->block_header_args['block_filter_terms'];
        }
    }

    private function get_setting($setting_name) {
        if (isset($this->block_header_args['settings'][$setting_name])) {
            return $this->block_header_args['settings'][$setting_name];
        }
    }

    public function get_block_header() {
        if ($this->get_setting('filterable') || trim($this->get_setting('header_title')) !== '') {
            $header_class = array(
                $this->get_setting('header_style') == 'vl-title-default' ? 'vl-block-header' : 'vp-block-header',
                $this->get_setting('header_style'),
                !$this->get_setting('filterable') ? 'vp-no-filter' : ''
            );
            $output = '<div class="' . implode(' ', $header_class) . '">';
            $output .= $this->get_block_title();
            $output .= $this->get_block_taxonomy_filter();
            $output .= '</div>';
            return apply_filters('vp_block_header_output', $output, $this);
        }
    }

}
