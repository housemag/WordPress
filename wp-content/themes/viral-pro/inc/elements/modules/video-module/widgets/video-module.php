<?php

namespace Viral_Pro_Elements\Modules\VideoModule\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class VideoModule extends Widget_Base {

    /** Widget Name */
    public function get_name() {
        return 'vp-video-module';
    }

    /** Widget Title */
    public function get_title() {
        return esc_html__('Video Module', 'viral-pro');
    }

    /** Icon */
    public function get_icon() {
        return 'vp-video-module vp-elementor-icon';
    }

    /** Category */
    public function get_categories() {
        return ['viral-pro-elements'];
    }

    public function get_script_depends() {
        return ['youtube-api'];
    }

    /** Controls */
    protected function register_controls() {

        $this->start_controls_section(
                'video', [
            'label' => esc_html__('Videos', 'viral-pro'),
                ]
        );

        $this->add_control(
                'video_notice', [
            'label' => __('NOTICE: THE VIDEO MODULE CAN BE USED ONLY ONCE PER PAGE. THE VIDEO MAY NOT DISPLAY IN EDITING MODE BUT WILL DISPLAY IN LIVE PAGE.', 'viral-pro'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
                ]
        );

        $this->add_control(
                'youtube_api_key', [
            'label' => __('Youtube API Key', 'viral-pro'),
            'description' => sprintf(esc_html__('Create own API key. %s. The Video Module will work without API key as well. The API key is only required to generate the title and time automatically.', 'viral-pro'), '<a target="_blank" href="https://hashthemes.com/how-to-create-a-youtube-api-key/">' . esc_html__('Guide on creating Youtube API Key', 'viral-pro') . '</a>'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true
                ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
                'video_title', [
            'label' => __('Title', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
                ]
        );

        $repeater->add_control(
                'video_id', [
            'label' => __('Video ID', 'viral-pro'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
                ]
        );

        $this->add_control(
                'video_block', [
            'label' => __('Videos', 'viral-pro'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'video_title' => __('Video #1', 'viral-pro'),
                    'video_id' => __('wRzoewOkafk', 'viral-pro'),
                ],
                [
                    'video_title' => __('Video #2', 'viral-pro'),
                    'video_id' => __('G1I3psDbD94', 'viral-pro'),
                ],
                [
                    'video_title' => __('Video #3', 'viral-pro'),
                    'video_id' => __('eJxrbXO65uY', 'viral-pro'),
                ],
                [
                    'video_title' => __('Video #4', 'viral-pro'),
                    'video_id' => __('XtTL1UVikzI', 'viral-pro'),
                ],
                [
                    'video_title' => __('Video #5', 'viral-pro'),
                    'video_id' => __('y8bv1Uskw1w', 'viral-pro'),
                ],
            ],
            'title_field' => '{{{ video_title }}}',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'play_list_style', [
            'label' => esc_html__('Play List', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'play_list_bg_color', [
            'label' => esc_html__('Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .video-thumbs' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_html__('Title Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-video-list .vl-post-title',
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => esc_html__('Title Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-video-list .vl-post-title' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'time_typography',
            'label' => esc_html__('Time Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .vl-video-list .video-list-duration',
                ]
        );

        $this->add_control(
                'time_color', [
            'label' => esc_html__('Time Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-video-list .video-list-duration' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'play_list_hover_bg_color', [
            'label' => esc_html__('Play List Background Color on Hover', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-video-list:hover' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'play_list_active_bg_color', [
            'label' => esc_html__('Active Play List Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .vl-video-list.video-active' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'scrollbar_bg_color', [
            'label' => esc_html__('Scroll Bar Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, {{WRAPPER}} .mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'control_style', [
            'label' => esc_html__('Controls', 'viral-pro'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'control_bar_bg_color', [
            'label' => esc_html__('Control Bar Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .video-controls' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'track_typography',
            'label' => esc_html__('Track Typography', 'viral-pro'),
            'selector' => '{{WRAPPER}} .video-track',
                ]
        );

        $this->add_control(
                'track_color', [
            'label' => esc_html__('Track Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .video-track' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'control_bg_color', [
            'label' => esc_html__('Control Background Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .video-control-holder' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'control_color', [
            'label' => esc_html__('Controls Color', 'viral-pro'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .video-control-holder i' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $videos = array();

        $video_blocks = $settings['video_block'];
        foreach ($video_blocks as $video_block) {
            $videos[] = trim($video_block['video_id']);
        }

        $new_videos = $videos;

        //array_shift($new_videos);

        $video_list = implode(',', $new_videos);
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
                        $youtube_api = $settings['youtube_api_key'];
                        $video_title = $video_duration = "";
                        $i = 0;
                        if (trim($youtube_api)) {
                            foreach ($video_blocks as $key => $video_block) {
                                $video = $video_block['video_id'];
                                $video_api = wp_remote_get('https://www.googleapis.com/youtube/v3/videos?id=' . $video . '&key=' . $youtube_api . '&part=snippet,contentDetails', array('sslverify' => false));
                                $video_api_array = json_decode(wp_remote_retrieve_body($video_api), true);

                                if (is_array($video_api_array) && !empty($video_api_array['items'])) {
                                    $snippet = $video_api_array['items'][0]['snippet'];
                                    $video_title = !empty($video_block['video_title']) ? $video_block['video_title'] : $snippet['title'];
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
                            foreach ($video_blocks as $key => $video_block) {
                                $video = $video_block['video_id'];
                                $video_title = isset($video_block['video_title']) ? $video_block['video_title'] : '';
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
    }

}
