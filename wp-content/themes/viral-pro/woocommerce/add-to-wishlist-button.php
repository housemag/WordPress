<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */
if (!defined('YITH_WCWL')) {
    exit;
} // Exit if accessed directly

global $product;
?>

<a href="<?php echo esc_url(add_query_arg('add_to_wishlist', $product_id)) ?>" rel="nofollow" data-product-id="<?php echo $product_id ?>" data-product-type="<?php echo $product_type ?>" class="<?php echo $link_classes ?>" >
    <?php echo $icon ?>
    <?php echo $label ?>
</a>
<img src="<?php echo esc_url(get_template_directory_uri() . '/images/loading.gif') ?>" class="ajax-loading" alt="loading" width="32" height="32" style="visibility:hidden" />