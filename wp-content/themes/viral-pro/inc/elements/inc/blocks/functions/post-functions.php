<?php

use ViralPro\Blocks\Viral_Pro_Blocks_Manager;

add_action('wp_ajax_vp_load_posts_block', 'vp_load_posts_block_callback');
add_action('wp_ajax_nopriv_vp_load_posts_block', 'vp_load_posts_block_callback');

function vp_load_posts_block_callback() {
    check_ajax_referer('vp-block-nonce', '_ajax_nonce-vp-block');
    $ajax_parameters = array(
        'query' => '', // original block atts
        'currentPage' => '', // the current page of the block
        'blockId' => '', // block uid
        'blockType' => '', // the type of the block / block class
        'filterTerm' => '', // the id for this specific filter type. The filter type is in the query
        'filterTaxonomy' => '', // the id for this specific filter type. The filter type is in the query.
        'settings' => array()
    );
    if (!empty($_POST['blockId'])) {
        $ajax_parameters['blockId'] = $_POST['blockId'];
    }

    if (!empty($_POST['query'])) {
        $ajax_parameters['query'] = $_POST['query']; //current block args
    }

    if (!empty($_POST['settings'])) {
        $ajax_parameters['settings'] = $_POST['settings']; //current block args
    }

    if (!empty($_POST['blockType'])) {
        $ajax_parameters['blockType'] = $_POST['blockType'];
    }

    if (!empty($_POST['currentPage'])) {
        $ajax_parameters['currentPage'] = intval($_POST['currentPage']);
    }

    //read the id for this specific filter type
    if (!empty($_POST['filterTerm'])) {
        //this removes the block offset for blocks pull down filter items
        //..it excepts the "All" filter tab which will load posts with the set offset
        if (!empty($ajax_parameters['query']['offset'])) {
            $ajax_parameters['query']['offset'] = 0;
        }
        $ajax_parameters['filterTerm'] = $_POST['filterTerm']; //the new id filter
    }

    if (!empty($_POST['filterTaxonomy'])) {
        $ajax_parameters['filterTaxonomy'] = $_POST['filterTaxonomy']; //the new id filter
    }

    if (!empty($ajax_parameters['query'])) {
        $query_params = vp_parse_posts_block_query($ajax_parameters);
    }

    $loop = new \WP_Query($query_params);

    $block = Viral_Pro_Blocks_Manager::get_instance($ajax_parameters['blockType']);

    $output = $block->inner($loop->posts, $ajax_parameters['settings']);

    //pagination
    $hidePrev = false;
    $hideNext = false;
    $remaining_posts = 0;

    if ($ajax_parameters['currentPage'] == 1) {
        $hidePrev = true; //hide link on page 1
    }
    if (!empty($ajax_parameters['filterTerm'])) {
        $max_num_pages = $loop->max_num_pages;
        $found_posts = $loop->found_posts;
    } else {
        // total and max pages factoring in the offset set by the user
        $offset = isset($ajax_parameters['query']['offset']) ? intval($ajax_parameters['query']['offset']) : 0;

        $found_posts = $loop->found_posts - $offset;
        $max_num_pages = ceil($found_posts / $query_params['posts_per_page']);
    }
    if ($ajax_parameters['currentPage'] >= $max_num_pages) {
        $hideNext = true; //hide link on last page
    } else {
        $remaining_posts = $found_posts - ($query_params['paged'] * $query_params['posts_per_page']);
    }
    $outputArray = array(
        'data' => $output,
        'blockId' => $ajax_parameters['blockId'],
        'filterTerm' => $ajax_parameters['filterTerm'],
        'filterTaxonomy' => $ajax_parameters['filterTaxonomy'],
        'paged' => $query_params['paged'],
        'maxpages' => $max_num_pages,
        'remaining' => $remaining_posts,
        'hidePrev' => $hidePrev,
        'hideNext' => $hideNext
    );
    echo json_encode($outputArray);
    wp_die();
}

function vp_parse_posts_block_query($params) {
    $q = $params['query'];
    $q['ignore_sticky_posts'] = filter_var($q['ignore_sticky_posts'], FILTER_VALIDATE_BOOLEAN);
    if (!empty($q['suppress_filters']))
        $q['suppress_filters'] = filter_var($q['suppress_filters'], FILTER_VALIDATE_BOOLEAN);
    if (!empty($q['cache_results']))
        $q['cache_results'] = filter_var($q['cache_results'], FILTER_VALIDATE_BOOLEAN);
    if (!empty($q['update_post_term_cache']))
        $q['update_post_term_cache'] = filter_var($q['update_post_term_cache'], FILTER_VALIDATE_BOOLEAN);
    if (!empty($q['lazy_load_term_meta']))
        $q['lazy_load_term_meta'] = filter_var($q['lazy_load_term_meta'], FILTER_VALIDATE_BOOLEAN);
    if (!empty($q['update_post_meta_cache']))
        $q['update_post_meta_cache'] = filter_var($q['update_post_meta_cache'], FILTER_VALIDATE_BOOLEAN);
    if (!empty($q['nopaging']))
        $q['nopaging'] = filter_var($q['nopaging'], FILTER_VALIDATE_BOOLEAN);
    if (!empty($q['no_found_rows']))
        $q['no_found_rows'] = filter_var($q['no_found_rows'], FILTER_VALIDATE_BOOLEAN);
    $q['posts_per_page'] = filter_var($q['posts_per_page'], FILTER_VALIDATE_INT);

    // go for the page requested by the user
    $q['paged'] = filter_var($params['currentPage'], FILTER_VALIDATE_INT);

    // Replace existing tax_query with filter term, if any
    if (!empty($params['filterTerm'])) {
        $q['tax_query'] = array(
            array(
                'field' => 'term_id',
                'taxonomy' => filter_var($params['filterTaxonomy'], FILTER_SANITIZE_STRING),
                'terms' => filter_var($params['filterTerm'], FILTER_VALIDATE_INT),
                'operator' => 'IN',
            )
        );
    }

    $offset = isset($q['offset']) ? intval($q['offset']) : 0;
    // Modified offset based on page number - paged offset
    $q['offset'] = $offset + (($q['paged'] - 1) * $q['posts_per_page']);
    return apply_filters('vp_posts_block_parsed_query_args', $q, $params);
}
