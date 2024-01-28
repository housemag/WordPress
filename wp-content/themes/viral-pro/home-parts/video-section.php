<?php

/**
 * @package Viral
 */
function viral_pro_frontpage_video_section() {
    $disable_section = get_theme_mod('viral_pro_frontpage_video_section_disable', 'off');
    $overwrite = get_theme_mod('viral_pro_video_overwrite_block_title_color', false);
    $class = $overwrite ? 'ht-overwrite-color' : '';

    if ($disable_section == 'on' || viral_pro_is_amp()) {
        return;
    }
    ?>
    <section id="ht-video-section" class="ht-section ht-video-section <?php echo esc_attr($class); ?>" <?php echo viral_pro_parallax_background('video'); ?>>
        <div class="ht-section-wrap">
            <?php viral_pro_add_top_seperator('video'); ?>
            <div class="ht-container ht-video-container">
                <?php viral_pro_frontpage_video_content(); ?>
            </div>
            <?php viral_pro_add_bottom_seperator('video'); ?>
        </div>
    </section>
    <?php
}

function viral_pro_frontpage_video_content() {

    $video_blocks = get_theme_mod('viral_pro_frontpage_video_blocks', json_encode(array(
        array(
            'id' => 'wRzoewOkafk',
            'title' => '',
            'enable' => 'on'
        ),
        array(
            'id' => 'G1I3psDbD94',
            'title' => '',
            'enable' => 'on'
        ),
        array(
            'id' => 'eJxrbXO65uY',
            'title' => '',
            'enable' => 'on'
        ),
        array(
            'id' => 'XtTL1UVikzI',
            'title' => '',
            'enable' => 'on'
        ),
        array(
            'id' => 'y8bv1Uskw1w',
            'title' => '',
            'enable' => 'on'
        )
    )));

    if (!$video_blocks) {
        return;
    }

    wp_enqueue_script('youtube-api');
    $videos = array();

    $video_blocks = json_decode($video_blocks);
    foreach ($video_blocks as $video_block) {
        if ($video_block->enable == 'on') {
            $videos[] = trim($video_block->id);
        }
    }

    $new_videos = $videos;

    //array_shift($new_videos);

    $video_list = implode(',', $new_videos);

    viral_pro_frontpage_add_top_widget('video');
    ?>

    <div id="vl-video-playlist">

        <div class="vl-video-holder clearfix"> 
            <div class="big-video">
                <div class="big-video-inner">
                    <div id="vl-video-placeholder"></div>
                </div>
            </div>

            <div class="video-thumbs">
                <div class="video-controls">

                    <div class="video-track">
                        <div class="video-current-playlist">
                            <?php _e('Fetching Video Title..', 'viral-pro') ?>
                        </div>

                        <div class="video-duration-time">
                            <span class="video-current-time">0:00</span>
                            /
                            <span class="video-duration"><?php esc_html_e('Loading..', 'viral-pro') ?></span>		
                        </div>
                    </div>

                    <div class="video-control-holder">
                        <div class="video-play-pause stopped"><i class="mdi mdi-play"></i></div>
                        <div class="video-prev"><i class="mdi mdi-skip-previous"></i></div>
                        <div class="video-next"><i class="mdi mdi-skip-next" aria-hidden="true"></i></div>
                    </div>

                </div>

                <div class="vl-video-thumbnails">
                    <?php
                    $youtube_api = get_theme_mod('viral_pro_youtube_api');
                    $video_title = $video_duration = "";
                    $i = 0;

                    if (trim($youtube_api)) {
                        foreach ($video_blocks as $video_block) {
                            $video = $video_block->id;
                            $video_api = wp_remote_get('https://www.googleapis.com/youtube/v3/videos?id=' . $video . '&key=' . $youtube_api . '&part=snippet,contentDetails', array('sslverify' => false));
                            $video_api_array = json_decode(wp_remote_retrieve_body($video_api), true);

                            //var_dump($video_api_array);
                            if (is_array($video_api_array) && !empty($video_api_array['items'])) {
                                $snippet = $video_api_array['items'][0]['snippet'];
                                $video_title = !empty($video_block->title) ? $video_block->title : $snippet['title'];
                                $video_duration = $video_api_array['items'][0]['contentDetails']['duration'];
                                ?>
                                <div class="vl-video-list ht-clearfix" data-index="<?php echo $i; ?>" data-video-id="<?php echo $video; ?>"> 
                                    <img alt="<?php echo esc_attr($video_title); ?>" src="https://img.youtube.com/vi/<?php echo esc_attr($video); ?>/default.jpg">

                                    <div class="video-title-duration">
                                        <h3 class="vl-post-title"><?php echo esc_html($video_title); ?></h3>
                                        <div class="video-list-duration"><?php echo viral_pro_youtube_duration($video_duration) ?></div>
                                    </div>
                                </div>
                                <?php
                            }
                            $i++;
                        }
                    } else {
                        foreach ($video_blocks as $video_block) {
                            $video = $video_block->id;
                            $video_title = isset($video_block->title) ? $video_block->title : '';
                            ?>
                            <div class = "vl-video-list ht-clearfix" data-index = "<?php echo $i; ?>" data-video-id = "<?php echo $video; ?>">
                                <img alt = "<?php echo esc_attr($video_title); ?>" src = "https://img.youtube.com/vi/<?php echo esc_attr($video); ?>/default.jpg">

                                <div class = "video-title-duration">
                                    <h3 class = "vl-post-title"><?php echo esc_html($video_title); ?></h3>
                                    <div class="video-list-duration"></div>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <script>
            var player;
            var time_update_interval;

            function onYouTubeIframeAPIReady() {
                player = new YT.Player('vl-video-placeholder', {
                    videoId: '<?php echo $videos[0] ?>',
                    playerVars: {
                        color: 'white',
                        playlist: '<?php echo $video_list ?>',
                    },
                    events: {
                        onReady: initialize,
                        onStateChange: onPlayerStateChange
                    }
                });

            }

            function initialize() {

                // Update the controls on load
                updateTimerDisplay();

                jQuery('.video-current-playlist').text(jQuery('.vl-video-list:first').text());
                jQuery('.vl-video-list:first').addClass('video-active')

                // Clear any old interval.
                clearInterval(time_update_interval);

                // Start interval to update elapsed time display and
                // the elapsed part of the progress bar every second.
                time_update_interval = setInterval(function () {
                    updateTimerDisplay();
                }, 1000);

            }

            // This function is called by initialize()
            function updateTimerDisplay() {
                // Update current time text display.
                jQuery('.video-current-time').text(formatTime(player.getCurrentTime()));
                jQuery('.video-duration').text(formatTime(player.getDuration()));
            }

            function formatTime(time) {
                time = Math.round(time);
                var minutes = Math.floor(time / 60),
                        seconds = time - minutes * 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                return minutes + ":" + seconds;
            }

            function onPlayerStateChange(event) {
                updateButtonStatus(event.data);
            }

            function updateButtonStatus(playerStatus) {
                if (playerStatus == -1) {
                    jQuery('.video-play-pause').removeClass('playing').addClass('stopped'); // unstarted
                    var currentIndex = player.getPlaylistIndex();

                    var currentElement = jQuery('.vl-video-list').map(function () {
                        if (currentIndex == jQuery(this).attr('data-index')) {
                            return this;
                        }
                    });

                    var videoTitle = currentElement.find('.vl-post-title').text();

                    currentElement.siblings().removeClass('video-active');
                    currentElement.addClass('video-active');

                    jQuery('.video-current-playlist').text(videoTitle);

                    player.setLoop(true);

                } else if (playerStatus == 0) {
                    jQuery('.video-play-pause').removeClass('playing').addClass('stopped'); // ended
                } else if (playerStatus == 1) {
                    jQuery('.video-play-pause').removeClass('stopped').addClass('playing'); // playing
                } else if (playerStatus == 2) {
                    jQuery('.video-play-pause').removeClass('playing').addClass('stopped'); // paused
                } else if (playerStatus == 3) {
                    jQuery('.video-play-pause').removeClass('playing').addClass('stopped'); // buffering
                } else if (playerStatus == 5) {
                    // video cued
                }
            }

            jQuery(function ($) {
                $('body').on('click', '.video-play-pause.stopped', function () {
                    player.playVideo();
                    $(this).removeClass('stopped').addClass('playing');
                });

                $('body').on('click', '.video-play-pause.playing', function () {
                    player.pauseVideo();
                    $(this).removeClass('playing').addClass('stopped');
                });

                $('.video-next').on('click', function () {
                    player.nextVideo();
                });

                $('.video-prev').on('click', function () {
                    player.previousVideo()
                });

                $('.vl-video-list').on('click', function () {
                    var videoIndex = $(this).attr('data-index');
                    player.playVideoAt(videoIndex);
                    player.setLoop(true);
                });
            });
        </script>
    </div>
    <?php
    viral_pro_frontpage_add_bottom_widget('video');
}
