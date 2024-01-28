(function ($, elementor) {
    "use strict";
    var Viral_Pro_Elements = {

        init: function () {

            var widgets = {
                'he-ticker-module.default': Viral_Pro_Elements.viralProTicker,
                'vp-slider-module-one.default': Viral_Pro_Elements.viralProSlider,
                'vp-slider-module-two.default': Viral_Pro_Elements.viralProSlider,
                'vp-slider-module-three.default': Viral_Pro_Elements.viralProSlider,
                'vp-slider-module-four.default': Viral_Pro_Elements.viralProSlider,
                'he-carousel-module-one.default': Viral_Pro_Elements.viralProCarousel,
                'vp-carousel-module-two.default': Viral_Pro_Elements.viralProCarousel,
                'vp-carousel-module-three.default': Viral_Pro_Elements.viralProCarousel,
                'vp-carousel-module-four.default': Viral_Pro_Elements.viralProCarousel,
                'vp-carousel-module-five.default': Viral_Pro_Elements.viralProCarousel,
                'vp-video-module.default': Viral_Pro_Elements.viralProVideo,
                'wp-widget-viral_pro_post_tab.default': Viral_Pro_Elements.viralProTab,
                'wp-widget-viral_pro_accordian.default': Viral_Pro_Elements.viralProAccordian,
                'wp-widget-viral_pro_counter.default': Viral_Pro_Elements.viralProCounter,
                'wp-widget-viral_pro_progressbar.default': Viral_Pro_Elements.viralProProgressbar,
                'wp-widget-viral_pro_post_carousel.default': Viral_Pro_Elements.viralProPostCarousel,
                'wp-widget-viral_pro_category_post_carousel.default': Viral_Pro_Elements.viralProPostCarousel,

            };

            $.each(widgets, function (widget, callback) {
                elementor.hooks.addAction('frontend/element_ready/' + widget, callback);
            });

            elementor.hooks.addAction('frontend/element_ready/column', Viral_Pro_Elements.elementorColumn);

        },

        viralProCarousel: function ($scope) {
            var $element = $scope.find('.vl-ele-carousel-wrap');
            if ($element.length > 0) {
                $element.each(function () {
                    var params = JSON.parse($(this).find('.owl-carousel').attr('data-params'));
                    $(this).find('.owl-carousel').owlCarousel({
                        rtl: JSON.parse(viral_pro_options.rtl),
                        loop: true,
                        autoplay: JSON.parse(params.autoplay),
                        autoplayTimeout: params.pause,
                        nav: JSON.parse(params.nav),
                        dots: JSON.parse(params.dots),
                        navText: ['<i class="mdi mdi-chevron-left"></i>', '<i class="mdi mdi-chevron-right"></i>'],
                        responsive: {
                            0: {
                                items: params.items_mobile,
                                margin: params.margin_mobile,
                                stagePadding: params.stagepadding_mobile
                            },
                            480: {
                                items: params.items_tablet,
                                margin: params.margin_tablet,
                                stagePadding: params.stagepadding_tablet
                            },
                            769: {
                                items: params.items,
                                margin: params.margin,
                                stagePadding: params.stagepadding
                            }
                        }
                    });
                });
            }
        },

        viralProSlider: function ($scope) {
            var $ele = $scope.find('.vl-ele-slider-wrap');
            var params = JSON.parse($ele.attr('data-params'));
            if ($ele.length > 0) {
                $ele.owlCarousel({
                    rtl: JSON.parse(viral_pro_options.rtl),
                    items: 1,
                    margin: 0,
                    loop: true,
                    mouseDrag: true,
                    autoplay: params.autoplay,
                    autoplayTimeout: params.pause,
                    nav: true,
                    dots: false,
                    navText: ['<i class="mdi mdi-chevron-left"></i>', '<i class="mdi mdi-chevron-right"></i>'],
                    responsive: {
                        0: {
                            margin: params.margin_mobile,
                            stagePadding: params.stagepadding_mobile
                        },
                        480: {
                            margin: params.margin_tablet,
                            stagePadding: params.stagepadding_tablet
                        },
                        769: {
                            margin: params.margin,
                            stagePadding: params.stagepadding
                        }
                    }
                });
            }
        },

        viralProTicker: function ($scope) {
            var $ele = $scope.find('.vl-ele-ticker');
            if ($ele.length > 0) {
                var ticker_parameters = $ele.find('.owl-carousel').attr('data-params');
                var ticker_params = JSON.parse(ticker_parameters);

                var ticker_obj = {
                    rtl: JSON.parse(viral_pro_options.rtl),
                    items: 1,
                    margin: 10,
                    loop: true,
                    mouseDrag: false,
                    autoplay: ticker_params.autoplay,
                    autoplayTimeout: parseInt(ticker_params.pause) * 1000,
                    nav: true,
                    dots: false,
                    navText: ['<i class="mdi mdi-chevron-left"></i>', '<i class="mdi mdi-chevron-right"></i>']
                }


                if (ticker_params.animation == 'top-bottom') {
                    ticker_obj.animateOut = 'slideOutDown';
                    ticker_obj.animateIn = 'slideInDown';
                } else if (ticker_params.animation == 'flip-top-bottom') {
                    ticker_obj.animateOut = 'slideOutDown';
                    ticker_obj.animateIn = 'flipInX';
                }

                $ele.find('.owl-carousel').owlCarousel(ticker_obj);
            }
        },

        viralProVideo: function ($scope) {
            var $ele = $scope.find('#vl-video-playlist');
            if ($ele.length > 0) {
                $(".vl-video-thumbnails").mCustomScrollbar({
                    axis: "y",
                    scrollbarPosition: "outside"
                });

                $(window).on('resize', function () {
                    setTimeout(Viral_Pro_Elements.viralPro_youtube_videoplaylist_class, 500);
                }).resize();
            }
        },

        viralPro_youtube_videoplaylist_class: function ($scope) {
            $('#vl-video-playlist').each(function () {
                var playlistWidth = $(this).outerWidth();
                if (playlistWidth < 788) {
                    $(this).addClass('shrink-playlist');
                } else if (playlistWidth > 789) {
                    $(this).removeClass('shrink-playlist');
                }
            });
        },

        viralProTab: function ($scope) {
            var $ele = $scope.find('.ht-post-tab');
            if ($ele.length > 0) {
                $ele.each(function (index) {
                    $(this).find('.ht-pt-header .ht-pt-tab:first').addClass('ht-pt-active');
                    $(this).find('.ht-pt-content-wrap .ht-pt-content:first').show();
                });

                $ele.find('.ht-pt-tab').on('click', function () {
                    var id = $(this).data('id');
                    $(this).closest('.ht-post-tab').find('.ht-pt-tab').removeClass('ht-pt-active');
                    $(this).addClass('ht-pt-active');

                    $(this).closest('.ht-post-tab').find('.ht-pt-content').hide();
                    $('#' + id).show();
                });
            }
        },

        viralProAccordian: function ($scope) {
            var $ele = $scope.find('.ht-accordion');
            if ($ele.length > 0) {
                $ele.each(function () {
                    if ($(this).hasClass('ht-single-open-accordian')) {
                        $(this).find('.ht-accordion-box').accordion({
                            'transitionSpeed': 400,
                            'singleOpen': true
                        });
                    } else if ($(this).hasClass('ht-all-open-accordian')) {
                        $(this).find('.ht-accordion-box').accordion({
                            'transitionSpeed': 400,
                            'singleOpen': false
                        });
                    }
                });
            }
        },
        viralProCounter: function ($scope) {
            var $ele = $scope.find('.ht-counter-widget');
            if ($ele.length > 0) {
                $ele.each(function (index) {
                    var $this = $(this);
                    $this.waypoint(function () {
                        var $odometer = $this.find('.odometer');
                        $odometer.html($odometer.data('count'));
                        this.destroy();
                    }, {
                        offset: '90%',
                    });
                });
            }
        },
        viralProProgressbar: function ($scope) {
            var $ele = $scope.find('.ht-progress-bar');
            if ($ele.length > 0) {
                $ele.each(function (index) {
                    var $this = $(this);
                    $this.waypoint(function () {
                        $this.find('.ht-progress-bar-length').animate({
                            width: $this.attr("data-width") + '%'
                        }, 1000, function () {
                            $this.find("span").animate({
                                opacity: 1
                            }, 500);
                        });
                        this.destroy();
                    }, {
                        offset: '90%',
                    });
                });
            }
        },
        viralProPostCarousel: function ($scope) {
            var $ele = $scope.find('.ht-post-carousel');
            if ($ele.length > 0) {
                $ele.each(function (index) {
                    $(this).owlCarousel({
                        rtl: JSON.parse(viral_pro_options.rtl),
                        items: 1,
                        loop: true,
                        mouseDrag: false,
                        nav: false,
                        dots: true,
                        autoplayTimeout: 6000,
                        autoplay: true,
                        smartSpeed: 600,
                        margin: 5
                    });
                });
            }
        },
        elementorColumn: function ($scope) {
            var editMode = Boolean(elementor.isEditMode());
            var enable_sticky = false;
            var adminbarHeight = 0;
            var topSpacing = 0;
            var bottomSpacing = 0;
            if ($('body').hasClass('admin-bar')) {
                adminbarHeight = 32;
            }
            if (editMode) {
                var $sticky = $scope.find('.vp-elementor-sticky-column');
                if ($sticky.length) {
                    enable_sticky = true;
                    if ($sticky.attr('data-top-spacing')) {
                        topSpacing = $sticky.attr('data-top-spacing');
                    }

                    if ($sticky.attr('data-bottom-spacing')) {
                        bottomSpacing = $sticky.attr('data-bottom-spacing');
                    }
                }
            } else {
                if ($scope.hasClass('vp-elementor-sticky-column')) {
                    enable_sticky = true;
                    if ($scope.attr('data-top-spacing')) {
                        topSpacing = $scope.attr('data-top-spacing');
                    }

                    if ($scope.attr('data-bottom-spacing')) {
                        bottomSpacing = $scope.attr('data-bottom-spacing');
                    }
                }
            }

            if (enable_sticky) {
                $scope.find('.elementor-column-wrap').addClass('theiaStickySidebar');
                $scope.css({display: 'block'});

                $scope.theiaStickySidebar({
                    additionalMarginTop: parseInt(topSpacing) + adminbarHeight,
                    additionalMarginBottom: parseInt(bottomSpacing)
                });
            }
        }
    };
    $(window).on('elementor/frontend/init', Viral_Pro_Elements.init);
}(jQuery, window.elementorFrontend));

