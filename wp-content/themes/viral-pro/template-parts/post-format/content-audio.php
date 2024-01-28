<?php

$media = rwmb_meta('post_audio');
$media_sites = array('soundcloud', 'mixcloud', 'reverbnation', 'spotify');
$check = false;
global $wp_embed;

if ($media) {
    foreach ($media_sites as $site) {
        if (strpos($media, $site)) {
            $check = true;
        }
    }

    echo '<div class="single-entry-audio">';
    if ($check) {
        echo '<div class="single-video-container">' . $wp_embed->run_shortcode("[embed]" . $media . "[/embed]") . '</div>';
    } else {
        echo do_shortcode('[audio src="' . $media . '" loop="off" autoplay="0" preload="none"]');
    }
    echo '</div>';
}
