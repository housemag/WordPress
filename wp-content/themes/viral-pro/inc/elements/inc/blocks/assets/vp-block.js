(function ($) {
    var WidgetVPPostsBlockHandler = function ($scope, $) {
        var $blockElem = $scope.find('.vp-block');
        if ($blockElem.find('.vp-module').length === 0) {
            return; // no items to display or load and hence don't continue
        }
        var $blockElemInner = $blockElem.find('.vp-block-inner');
        var currentBlockObj = vpBlocks.getBlockObjById($blockElem.data('block-uid'));

        /* ----------- Reorganize Filters when device width changes -------------- */

        /* https://stackoverflow.com/questions/24460808/efficient-way-of-using-window-resize-or-other-method-to-fire-jquery-functions */
        var vpResizeTimeout;
        $(window).resize(function () {
            if (!!vpResizeTimeout) {
                clearTimeout(vpResizeTimeout);
            }
            vpResizeTimeout = setTimeout(function () {
                currentBlockObj.organizeFilters();
            }, 200);
        });

        /* -------------- Taxonomy Filter --------------- */
        $scope.find('.vp-block-filter .vp-block-filter-item a').on('click', function (e) {
            e.preventDefault();
            if (!$(this).parent().hasClass('vp-active')) {
                currentBlockObj.handleFilterAction($(this));
            }
            return false;
        });
        var pagination = currentBlockObj.settings['pagination'];

        /* ------------------- Pagination ---------------------- */
        $scope.find('.vp-pagination a.vp-page-nav').on('click', function (e) {
            e.preventDefault();
            currentBlockObj.handlePageNavigation($(this));
        });

        /*---------------- Load More Button --------------------- */
        $scope.find('.vp-pagination a.vp-load-more').on('click', function (e) {
            e.preventDefault();
            currentBlockObj.handleLoadMore($(this));
        });

        /*---------------- Load On Scroll --------------------- */
        if (pagination == 'infinite_scroll') {
            var helper = new ViralPro_Grid_Helper($scope);
            helper.setupInfiniteScroll();
        }
    };

    // Make sure you run this code under Elementor..
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-one.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-two.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-three.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-four.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-five.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-six.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-seven.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-eight.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-nine.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-ten.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-eleven.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-twelve.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-thirteen.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-fourteen.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-news-module-fifteen.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-sixteen.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-seventeen.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-eighteen.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-nineteen.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-twenty.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-twentyone.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-twentytwo.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-twentythree.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-news-module-twentyfour.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-tile-module-one.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-tile-module-two.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/he-tile-module-three.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-tile-module-four.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-tile-module-five.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-tile-module-six.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-tile-module-seven.default', WidgetVPPostsBlockHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/vp-tile-module-eight.default', WidgetVPPostsBlockHandler);
    });
})(jQuery);