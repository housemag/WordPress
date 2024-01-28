<?php
/**
 * The header for our theme.
 *
 * @package Viral Pro
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <?php wp_head(); ?>
    </head>

    <body id="ht-body" <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <?php
        do_action('viral_pro_before_page');
        ?>
        <div id="ht-page">
            <?php
            if (is_singular(array('post', 'page', 'product', 'portfolio'))) {
                $hide_header = rwmb_meta('hide_header');
            } else {
                $hide_header = '';
            }

            if (!$hide_header) {
                do_action('viral_pro_header');
            }
            ?>
            <div id="ht-content" class="ht-site-content ht-clearfix">
                <?php
                if (is_active_sidebar('viral-pro-below-menu')) {
                    ?>
                    <div class="header-widget-area">
                        <div class="ht-container">
                            <?php dynamic_sidebar('viral-pro-below-menu'); ?>
                        </div>
                    </div>
                    <?php
                }
                ?>