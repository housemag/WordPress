<?php
/**
 * @package Viral Pro
 */
$viral_pro_mh_menu_hover_style = get_theme_mod('viral_pro_mh_menu_hover_style', 'hover-style6');
$viral_pro_th_disable_mobile = get_theme_mod('viral_pro_th_disable_mobile', false);
$viral_pro_tagline_position = get_theme_mod('viral_pro_tagline_position', 'ht-tagline-inline-logo');
$viral_pro_mh_border = get_theme_mod('viral_pro_mh_border', 'ht-no-border');

$header_class = array('ht-site-header', 'ht-header-six', $viral_pro_mh_menu_hover_style, $viral_pro_tagline_position, $viral_pro_mh_border);

if ($viral_pro_th_disable_mobile) {
    $header_class[] = 'ht-topheader-mobile-disable';
}
?>

<header id="ht-masthead" class="<?php echo esc_attr(implode(' ', $header_class)); ?>" <?php echo viral_pro_get_schema_attribute('header'); ?>>
    <?php
    $viral_pro_top_header = get_theme_mod('viral_pro_top_header', 'on');
    if ($viral_pro_top_header == 'on') {
        ?>
        <div class="ht-top-header">
            <div class="ht-container">
                <?php do_action('viral_pro_top_header'); ?>
            </div>
        </div><!-- .ht-top-header -->
    <?php } ?>

    <div class="ht-header">
        <div class="ht-container">
            <div id="ht-site-branding" <?php echo viral_pro_get_schema_attribute('logo'); ?>>
                <?php viral_pro_header_logo(); ?>
            </div><!-- .site-branding -->
            <div class="ht-site-nav">
                <nav id="ht-site-navigation" class="ht-main-navigation" <?php echo viral_pro_get_schema_attribute('navigation'); ?>>
                    <?php viral_pro_main_navigation(); ?>
                </nav><!-- #ht-site-navigation -->
                <?php do_action('viral_pro_mobile_header'); ?>
            </div>
        </div>
    </div>
    <?php do_action('viral_pro_header_content') ?>
</header><!-- #ht-masthead -->