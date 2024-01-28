<?php

$video = rwmb_meta('post_video');
$video_url = rwmb_get_value('post_video');

if ($video && $video_url != '') {
    echo '<div class="single-entry-video">';
    echo '<div class="single-video-container">' . $video . '</div>';
    echo '</div>';
}

