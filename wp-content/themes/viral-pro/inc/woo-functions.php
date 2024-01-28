<?php
/**
 *
 * @package Viral Pro
 */
if (!viral_pro_is_woocommerce_activated())
    return;

function viral_pro_woocommerce_remove_actions() {
    if (is_singular('product')) {
        $display_title = rwmb_meta('content_display_title');
        if (!$display_title) {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        }
    }
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
    remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
    remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
}

add_action('wp_head', 'viral_pro_woocommerce_remove_actions');

add_action('woocommerce_before_main_content', 'viral_pro_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'viral_pro_theme_wrapper_end', 10);
add_action('viral_pro_woocommerce_breadcrumb', 'viral_pro_woo_breadcrumb', 10);
add_action('viral_pro_woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
add_action('viral_pro_woocommerce_archive_description', 'woocommerce_product_archive_description', 10);

function viral_pro_theme_wrapper_start() {
    $viral_pro_show_title = get_theme_mod('viral_pro_show_title', true);

    if (is_archive()) {
        echo '<header class="ht-main-header">';
        echo '<div class="ht-container">';
        if ($viral_pro_show_title) {
            echo '<h1 class="ht-main-title">';
            woocommerce_page_title();
            echo '</h1>';
        }
        do_action('viral_pro_woocommerce_archive_description');
        do_action('viral_pro_woocommerce_breadcrumb');
        echo '</div>';
        echo '</header>';
    } else {
        $hide_titlebar = rwmb_meta('hide_titlebar');
        $sub_title = rwmb_meta('sub_title');
        $titlebar_background = rwmb_meta('titlebar_background');

        if (!$hide_titlebar) {
            echo '<header class="ht-main-header">';
            echo '<div class="ht-container">';
            if ($viral_pro_show_title) {
                the_title('<div class="ht-main-title">', '</div>');

                if ($sub_title) {
                    ?>
                    <div class="ht-sub-title"><?php echo wp_kses_post($sub_title); ?></div>
                    <?php
                }
            }
            do_action('viral_pro_woocommerce_breadcrumb');
            echo '</div>';
            echo '</header>';
        }
    }


    $container_class = array('ht-main-content', 'ht-clearfix');
    $content_width = '';

    if (is_singular('product')) {
        $content_width = rwmb_meta('content_width');
    }

    if (!$content_width || $content_width == 'container') {
        $container_class[] = 'ht-container';
    }
    echo '<div class="' . implode(' ', $container_class) . '">';
    echo '<div id="primary">';
}

function viral_pro_theme_wrapper_end() {
    echo '</div>';
    get_sidebar('shop');
    echo '</div>';
}

add_filter('woocommerce_show_page_title', '__return_false');

function viral_pro_woo_breadcrumb() {
    $viral_pro_breadcrumb = get_theme_mod('viral_pro_breadcrumb', true);
    if (!$viral_pro_breadcrumb) {
        return;
    }
    woocommerce_breadcrumb();
}

//Change number of related products on product page
add_filter('woocommerce_output_related_products_args', 'viral_pro_related_products_args');

function viral_pro_related_products_args($args) {
    $args['posts_per_page'] = 3; // 3 related products
    $args['columns'] = 3; // arranged in 3 columns
    return $args;
}

add_filter('woocommerce_product_description_heading', '__return_false');

add_filter('woocommerce_product_additional_information_heading', '__return_false');

add_filter('woocommerce_pagination_args', 'viral_pro_change_prev_text');

function viral_pro_change_prev_text($args) {
    $args['prev_text'] = '&lang;';
    $args['next_text'] = '&rang;';
    return $args;
}

if (!function_exists('viral_pro_cart_link')) {

    function viral_pro_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'viral-pro'); ?>">
            <i class="mdi mdi-cart"><span class="cart-count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span></i>
            <script>
                jQuery(function ($) {
                    $('.menu-item-ht-cart .woocommerce-mini-cart').mCustomScrollbar({
                        axis: "y",
                        scrollbarPosition: "outside"
                    });
                });
            </script>
        </a>
        <?php
    }

}

function viral_pro_cart_icon($items, $args) {
    $enable_cart = get_theme_mod('viral_pro_mh_show_cart', false);

    if ($enable_cart && $args->theme_location == 'primary') {
        ob_start();
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        echo '<li class="menu-item menu-item-ht-cart ' . esc_attr($class) . '">';
        viral_pro_cart_link();
        the_widget('WC_Widget_Cart', 'title=');
        echo '</li>';
        $items .= ob_get_clean();
    }
    return $items;
}

//add_filter('wp_nav_menu_items', 'viral_pro_cart_icon', 10, 2);

if (!function_exists('viral_pro_cart_link_fragment')) {

    function viral_pro_cart_link_fragment($fragments) {
        global $woocommerce;

        ob_start();
        viral_pro_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();
        return $fragments;
    }

}

add_filter('woocommerce_add_to_cart_fragments', 'viral_pro_cart_link_fragment');

/**
 * * Product Wishlist Button Function
 * */
if (class_exists('YITH_WCWL')) {

    /**
     * Wishlist Header Count Ajax Function
     * */
    if (!function_exists('viral_pro_wishlist')) {

        function viral_pro_wishlist() {
            if (function_exists('YITH_WCWL')) {
                $wishlist_url = YITH_WCWL()->get_wishlist_url();
                ?>
                <div class="top-wishlist">
                    <a href="<?php echo esc_url($wishlist_url); ?>" title="<?php esc_html_e('Wishlist', 'viral-pro'); ?>">
                        <div class="count">
                            <span class="badge bigcounter"><?php esc_html_e('Wishlist', 'viral-pro'); ?><?php echo " (" . yith_wcwl_count_products() . ") "; ?></span>
                        </div>
                    </a>
                </div>
                <?php
            }
        }

    }
    add_action('wp_ajax_yith_wcwl_update_single_product_list', 'viral_pro_wishlist');
}

/** Remove Default Quick View Button * */
if (class_exists('YITH_WCQV')) :
    remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend(), 'yith_add_quick_view_button'), 15);
endif;

// Check if compare button is enabled and enabled in yith settings
if (class_exists('YITH_Woocompare_Frontend') && get_option('yith_woocompare_compare_button_in_product_page') == 'yes') {
    global $yith_woocompare;
    if (!is_admin()) {
        remove_action('woocommerce_after_shop_loop_item', array($yith_woocompare->obj, 'add_compare_link'), 20);
        //remove_action('woocommerce_single_product_summary', array($yith_woocompare->obj, 'add_compare_link'), 35);
    }
}

if (!function_exists('viral_pro_woocommerce_product_buttons')) {

    function viral_pro_woocommerce_product_buttons() {
        ?>
        <div class="viral-pro-product-actions"> 
            <?php
            if (class_exists('YITH_WCWL')) :
                echo do_shortcode('
                    [yith_wcwl_add_to_wishlist 
                    browse_wishlist_text="<i class=\'icofont-heart-alt\'></i><span class=\'woo-button-tooltip\'>Browse</span>" 
                    label="<i class=\'icofont-heart-alt\'></i><span class=\'woo-button-tooltip\'>Wishlist</span>"
                    link_classes="add_to_wishlist single_add_to_wishlist"
                    ]');
            endif;

            if (class_exists('YITH_Woocompare_Frontend')) {
                ?>
                <div class="ht-compare">
                    <?php
                    echo do_shortcode('[yith_compare_button container="no" type="link"]<i class=\'icofont-random\'></i><span class=\'woo-button-tooltip\'>Compare</span>[/yith_compare_button]');
                    ?>
                </div>
                <?php
            }

            if (class_exists('YITH_WCQV')) :
                global $product;
                ?>
                <div class="ht-quick-view">
                    <a href="#" class="button yith-wcqv-button" data-product_id="<?php echo esc_attr($product->get_id()); ?>"><i class="icofont-search-1"></i><span class="woo-button-tooltip"><?php esc_html_e('Quick View', 'viral-pro') ?></span></a>
                </div>
            <?php endif;
            ?>
        </div>
        <?php
    }

}

add_action('woocommerce_before_shop_loop_item', 'viral_pro_product_image_wrap', 5);
add_action('woocommerce_after_shop_loop_item', 'viral_pro_woocommerce_product_buttons', 6);
add_action('woocommerce_after_shop_loop_item', 'viral_pro_product_title_wrap_close', 6);
add_action('woocommerce_after_shop_loop_item', 'viral_pro_product_title_wrap', 6);
add_action('woocommerce_after_shop_loop_item', 'viral_pro_woo_template_loop_product_title', 6);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6);
add_action('woocommerce_after_shop_loop_item', 'viral_pro_product_title_wrap_close', 6);

function viral_pro_woo_template_loop_product_title() {
    echo '<h2 class="woocommerce-loop-product__title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
}

function viral_pro_product_image_wrap() {
    echo '<div class="viral-pro-product-image-wrap">';
}

function viral_pro_product_title_wrap() {
    echo '<div class="viral-pro-product-title-wrap">';
}

function viral_pro_product_title_wrap_close() {
    echo '</div>';
}

add_filter('yith_quick_view_loader_gif', 'viral_pro_change_quickview_loader');

function viral_pro_change_quickview_loader($url) {
    return get_template_directory_uri() . '/images/loading.gif';
}

add_filter('yith_woocompare_main_script_localize_array', 'viral_pro_change_compare_loader');

function viral_pro_change_compare_loader($array) {
    $array['loader'] = get_template_directory_uri() . '/images/loading.gif';
    return $array;
}
