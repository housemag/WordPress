<?php
$viral_pro_maintenance_date = get_theme_mod('viral_pro_maintenance_date');
$date = str_replace('/', '-', $viral_pro_maintenance_date);
$utcdate = date("D, d M Y H:i:s T", strtotime($date));
header("HTTP/1.1 503 Service Unavailable");
header("Retry-After: $utcdate");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <?php
        wp_head();
        $viral_pro_maintenance_background_color = get_theme_mod('viral_pro_maintenance_background_color', '#000000');
        $viral_pro_maintenance_bg_type = get_theme_mod('viral_pro_maintenance_bg_type', 'banner');
        $viral_pro_maintenance_layout = get_theme_mod('viral_pro_maintenance_layout', 'maintenance-style1');
        ?>
    </head>
    <body class="<?php echo esc_attr($viral_pro_maintenance_bg_type) . ' ' . esc_attr($viral_pro_maintenance_layout); ?>" style="background-color:<?php echo esc_attr($viral_pro_maintenance_background_color) ?>">
        <?php
        $viral_pro_maintenance_logo = get_theme_mod('viral_pro_maintenance_logo');
        $viral_pro_maintenance_title = get_theme_mod('viral_pro_maintenance_title', esc_html__('WEBSITE UNDER MAINTENANCE', 'viral-pro'));
        $viral_pro_maintenance_text = get_theme_mod('viral_pro_maintenance_text', esc_html__('We are coming soon with new changes. Stay Tuned!', 'viral-pro'));
        $viral_pro_maintenance_shortcode = get_theme_mod('viral_pro_maintenance_shortcode');
        $viral_pro_maintenance_banner_image = get_theme_mod('viral_pro_maintenance_banner_image', get_template_directory_uri() . '/images/bg.jpg');
        $viral_pro_maintenance_banner_image_repeat = get_theme_mod('viral_pro_maintenance_banner_image_repeat', 'no-repeat');
        $viral_pro_maintenance_banner_image_size = get_theme_mod('viral_pro_maintenance_banner_image_size', 'cover');
        $viral_pro_maintenance_banner_image_position = get_theme_mod('viral_pro_maintenance_banner_image_position', 'center-center');
        $viral_pro_maintenance_banner_image_position = str_replace('-', ' ', $viral_pro_maintenance_banner_image_position);
        $viral_pro_maintenance_banner_image_attach = get_theme_mod('viral_pro_maintenance_banner_image_attach', 'fixed');
        $viral_pro_maintenance_slider_shortcode = get_theme_mod('viral_pro_maintenance_slider_shortcode');
        $viral_pro_maintenance_sliders = get_theme_mod('viral_pro_maintenance_sliders');
        $viral_pro_maintenance_slider_pause = get_theme_mod('viral_pro_maintenance_slider_pause', 5);
        $viral_pro_maintenance_video = get_theme_mod('viral_pro_maintenance_video', 'yNAsk4Zw2p0');

        $viral_pro_maintenance_bg_overlay_color = get_theme_mod('viral_pro_maintenance_bg_overlay_color', 'rgba(255,255,255,0)');
        $viral_pro_maintenance_title_color = get_theme_mod('viral_pro_maintenance_title_color', '#FFFFFF');
        $viral_pro_maintenance_text_color = get_theme_mod('viral_pro_maintenance_text_color', '#FFFFFF');
        $viral_pro_maintenance_counter_color = get_theme_mod('viral_pro_maintenance_counter_color', '#FFFFFF');
        $viral_pro_maintenance_social_icon_color = get_theme_mod('viral_pro_maintenance_social_icon_color', '#FFFFFF');
        ?>

        <div class="ht-maintenance-bg">
            <?php
            if ($viral_pro_maintenance_bg_type == 'revolution' && !empty($viral_pro_maintenance_slider_shortcode)) {
                echo do_shortcode($viral_pro_maintenance_slider_shortcode);
            } elseif ($viral_pro_maintenance_bg_type == 'banner' && !empty($viral_pro_maintenance_banner_image)) {
                ?>
                <div class="ht-maintenance-banner" style="background-image:url(<?php echo esc_url($viral_pro_maintenance_banner_image) ?>); background-repeat:<?php echo esc_attr($viral_pro_maintenance_banner_image_repeat) ?>; background-size:<?php echo esc_attr($viral_pro_maintenance_banner_image_size) ?>; background-position:<?php echo esc_attr($viral_pro_maintenance_banner_image_position) ?>; background-attachment:<?php echo esc_attr($viral_pro_maintenance_banner_image_attach) ?>"></div>
                <?php
            } elseif ($viral_pro_maintenance_bg_type == 'video' && !empty($viral_pro_maintenance_video)) {
                $video_attr = 'data-property="{videoURL:\'' . $viral_pro_maintenance_video . '\', mobileFallbackImage:\'https://img.youtube.com/vi/' . $viral_pro_maintenance_video . '/maxresdefault.jpg\'}"';
                wp_enqueue_script('YTPlayer');
                ?>
                <div class="ht-maintenance-video" <?php echo $video_attr; ?>></div>
                <?php
            } elseif ($viral_pro_maintenance_bg_type == 'slider' && !empty($viral_pro_maintenance_sliders)) {
                ?>
                <div class="ht-maintenance-slider owl-carousel" data-timeout="<?php echo $viral_pro_maintenance_slider_pause * 1000; ?>">
                    <?php
                    $sliders = json_decode($viral_pro_maintenance_sliders);

                    foreach ($sliders as $slider) {
                        $image = $slider->image;
                        if ($image) {
                            $slide_bg_css = "style=background-image:url(" . esc_url($image) . ")";
                            ?>
                            <div class="ht-maintenance-slide" <?php echo esc_attr($slide_bg_css) ?>></div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <div id="ht-maintenance-page">
            <div class="ht-maintenance-page animated fadeInUp">
                <header>
                    <?php
                    if (!empty($viral_pro_maintenance_logo)) {
                        ?>
                        <div class="ht-maintenance-logo">
                            <img src="<?php echo esc_url($viral_pro_maintenance_logo) ?>" alt="Logo">
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if (!empty($viral_pro_maintenance_title)) {
                        ?>
                        <h1>
                            <?php echo esc_html($viral_pro_maintenance_title) ?>
                        </h1>
                        <?php
                    }
                    ?>

                    <?php echo wp_kses_post($viral_pro_maintenance_text); ?>
                </header>

                <?php if ($viral_pro_maintenance_date) { ?>
                    <div class="ht-maintenance-countdown"></div>
                    <script>
                        jQuery(function ($) {
                            $('.ht-maintenance-countdown').countdown('<?php echo $viral_pro_maintenance_date; ?>', function (event) {
                                var $this = $(this).html(event.strftime(''
                                        + '<div class="ht-count-label"><span>%D</span><label><?php echo __('Days', 'viral-pro'); ?></label></div>'
                                        + '<div class="ht-count-label"><span>%H</span><label><?php echo __('Hours', 'viral-pro'); ?></label></div>'
                                        + '<div class="ht-count-label"><span>%M</span><label><?php echo __('Minutes', 'viral-pro'); ?></label></div>'
                                        + '<div class="ht-count-label"><span>%S</span><label><?php echo __('Seconds', 'viral-pro'); ?></label></div>'));
                            });
                        });
                    </script>
                <?php } ?>

                <?php if ($viral_pro_maintenance_shortcode) {
                    ?>
                    <div class="ht-maintenance-shortcode">
                        <?php echo do_shortcode($viral_pro_maintenance_shortcode); ?>
                    </div>
                <?php } ?>

                <footer>
                    <div class="ht-maintenance-social">
                        <?php
                        do_action('viral_pro_social_icons');
                        ?>
                    </div>
                </footer>
            </div>
        </div>
        <style type="text/css">
            .ht-maintenance-bg:after{
                background-color: <?php echo $viral_pro_maintenance_bg_overlay_color; ?>
            }
            #ht-maintenance-page{
                color: <?php echo $viral_pro_maintenance_text_color; ?>
            }
            #ht-maintenance-page h1,
            #ht-maintenance-page h2,
            #ht-maintenance-page h3,
            #ht-maintenance-page h4,
            #ht-maintenance-page h5,
            #ht-maintenance-page h6{
                color: <?php echo $viral_pro_maintenance_title_color; ?>
            }

            #ht-maintenance-page .ht-maintenance-countdown *{
                color: <?php echo $viral_pro_maintenance_counter_color; ?>
            }

            #ht-maintenance-page .ht-maintenance-social *{
                color: <?php echo $viral_pro_maintenance_social_icon_color; ?>
            }
        </style>
        <?php
        wp_footer();
        ?>
    </body>
</html>