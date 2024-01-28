if (typeof (jQuery) != 'undefined') {
    var vpBlockObjColl;
    var vpBlockCache;
    var ViralPro_Block;
    var ViralPro_Grid_Helper;
    var vpBlocks;
    (function ($) {
        "use strict";
        vpBlockObjColl = [];
        vpBlockCache = {
            data: {},
            remove: function (blockSignature) {
                delete this.data[blockSignature];
            },
            exist: function (blockSignature) {
                return this.data.hasOwnProperty(blockSignature) && this.data[blockSignature] !== null;
            },
            get: function (blockSignature) {
                return this.data[blockSignature];
            },
            set: function (blockSignature, cachedData) {
                this.remove(blockSignature);
                this.data[blockSignature] = cachedData;
            }
        };

        //ViralPro_Block class - each ajax block uses a object of this class for requests
        ViralPro_Block = function (blockId) {
            var self = this;
            var $blockElem = $('#' + blockId).eq(0);
            self.blockId = blockId;
            self.action = $blockElem.data('action');
            self.query = $blockElem.data('query');
            self.items = $blockElem.data('items');
            self.settings = $blockElem.data('settings');
            self.blockType = self.settings['block_type'];
            self.currentPage = $blockElem.data('current');
            self.filterTaxonomy = $blockElem.data('filter-taxonomy');
            self.filterTerm = $blockElem.data('filter-term');
            self.maxPages = $blockElem.data('maxpages');

            var $filterItemColl = $blockElem.find('ul.vp-block-filter-list > li.vp-block-filter-item');

            self.filterWidths = [];
            // Preserve the filter widths for future use. Initially all filters are in the main list and visible until JS takes over
            $filterItemColl.each(function () {
                self.filterWidths.push($(this).outerWidth())
            });
            self._processNumberedPagination();
            self.organizeFilters();
        };

        ViralPro_Block.prototype = {
            action: '',
            blockId: '',
            blockType: '',
            query: '',
            items: [],
            settings: '',
            currentPage: 1,
            maxPages: 1,
            filterTerm: '', //current chosen filter term
            filterTaxonomy: '',
            userAction: 'next_prev', // load more or next prev action
            filterWidths: [],
            is_ajax_running: false,

            doAjaxBlockRequest: function (userAction) {
                var self = this;
                // first look in the cache
                var myCacheSignature = self._getObjectSignature();
                if (vpBlockCache.exist(myCacheSignature)) {
                    self._doAjaxBlockLoadingStart(true, userAction);
                    var cachedResponseObj = vpBlockCache.get(myCacheSignature);
                    self._doAjaxBlockProcessResponse(true, cachedResponseObj, userAction);
                    self._doAjaxBlockLoadingEnd(true, userAction);
                    return 'cache_hit';
                }

                self._doAjaxBlockLoadingStart(false, userAction);
                var displayItems = self._getItemsToDisplay();
                var requestData = {
                    'action': self.action,
                    'blockId': self.blockId,
                    'query': self.query,
                    'items': displayItems,
                    'settings': self.settings,
                    'blockType': self.blockType,
                    'currentPage': self.currentPage,
                    'maxpages': self.maxPages,
                    'filterTerm': self.filterTerm,
                    'filterTaxonomy': self.filterTaxonomy,
                    'userAction': userAction,
                    '_ajax_nonce-vp-block': vp_ajax_object.block_nonce
                };

                // We can also pass the url value separately from ajaxurl for front end AJAX implementations
                $.post(vp_ajax_object.ajax_url, requestData, function (response) {
                    vpBlockCache.set(myCacheSignature, response); // store for future retrieval
                    self._doAjaxBlockProcessResponse(false, response, userAction);
                    self._doAjaxBlockLoadingEnd(false, userAction);
                });
            },

            organizeFilters: function () {
                var self = this;
                var $blockElem = jQuery('#' + self.blockId);
                $blockElem.find('.vp-block-header, .vl-block-header').removeClass('vp-filter-ready');
                var $blockHeaderElem = $blockElem.find('.vp-block-header, .vl-block-header').eq(0);
                var availableWidth = self._getAvailableWidth($blockHeaderElem);
                self._resizeFilters($blockHeaderElem, availableWidth);
                $blockElem.find('.vp-block-header, .vl-block-header').addClass('vp-filter-ready');
            },

            handleFilterAction: function ($target) {
                var userAction = 'filter';
                var $blockElem = $target.closest('.vp-block');
                $blockElem.find('.vp-block-filter-item').removeClass('vp-active');
                $target.parent().addClass('vp-active');
                if (this.is_ajax_running === true)
                    return;

                var filterTerm = $target.attr('data-term-id');
                var filterTaxonomy = $target.attr('data-taxonomy');
                $blockElem.data('filter-term', filterTerm);
                $blockElem.data('filter-taxonomy', filterTaxonomy);

                this.filterTerm = filterTerm;
                this.filterTaxonomy = filterTaxonomy;
                this.currentPage = 1; // reset the current page
                this.doAjaxBlockRequest(userAction);
            },

            handlePageNavigation: function ($target) {
                var userAction = 'next';
                var $blockElem = $target.closest('.vp-block');
                var paged = $target.data('page');

                // Do not continue if already processing or if the page is currently being shown
                if ($target.is('.vp-current-page'))
                    return;

                if (this.is_ajax_running === true)
                    return;

                if (paged == 'prev') {
                    if (this.currentPage == 1)
                        return;
                    this.currentPage--;
                    userAction = 'prev';
                } else if (paged == 'next') {
                    if (this.currentPage >= this.maxpages)
                        return;
                    this.currentPage++;
                    userAction = 'next';
                } else {
                    this.currentPage = paged;
                    userAction = 'load_page';
                }

                this.doAjaxBlockRequest(userAction);
            },

            handleLoadMore: function ($target) {
                var $blockElem = $target.closest('.vp-block');

                // Do not continue if already processing or if the page is currently being shown
                if (this.currentPage >= this.maxpages)
                    return;

                if (this.is_ajax_running === true)
                    return;

                var userAction = 'load_more';
                this.currentPage++;
                this.doAjaxBlockRequest(userAction);
            },

            _doAjaxBlockLoadingStart: function (cacheHit, userAction) {
                var self = this;
                self.is_ajax_running = true;
                var $blockElem = jQuery('#' + self.blockId);

                $blockElem.addClass('vp-processing');
                var $blockElementInner = $('#' + self.blockId).find('.vp-block-inner');


                if (userAction == 'next' || userAction == 'prev' || userAction == 'filter' || userAction == 'load_page') {
                    $blockElem.addClass('vp-fetching');
                    if (cacheHit == false)
                        $blockElem.append('<div class="vp-loader-gif"><div></div></div>');
                    $blockElementInner.addClass('animated fadeOut');
                }
            },

            _doAjaxBlockLoadingEnd: function (cacheHit, userAction) {
                var self = this;
                self.is_ajax_running = false;
                var $blockElem = jQuery('#' + self.blockId);
                $blockElem.removeClass('vp-processing');
                $('.vp-loader-gif').remove();
                var $blockElementInner = $blockElem.find('.vp-block-inner');
                //$blockElementInner.imagesLoaded(function () {
                $blockElementInner.removeClass('animated fadeOut');
                switch (userAction) {
                    case 'load_more':
                        $blockElementInner.children('div').last().addClass("animated faster fadeInDownSmall");
                        break;
                    case 'next':
                    case 'load_page':
                    case 'prev':
                    case 'filter':
                        $blockElementInner.find('div:first').addClass('animated faster fadeInDownSmall');
                        $blockElementInner.find('div:first').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function (e) {
                            $blockElementInner.find('div:first').removeClass('animated faster fadeInDownSmall');
                        });
                        break;
                }

                // Leads to unwanted function calls if not turned off
                $blockElementInner.off('animationend webkitAnimationEnd oAnimationEnd');
                // });
                self._ensureBlockObjectsAreVisible($blockElem, userAction);
                $('img.vl-lazy').Lazy();
            },

            _doAjaxBlockProcessResponse: function (cacheHit, response, userAction) {
                var self = this;
                //read the server response
                var responseObj = $.parseJSON(response); //get the data object

                if (this.blockId !== responseObj.blockId)
                    return; // not mine

                var $blockElem = $('#' + this.blockId); // we know the response is for this block
                if ('load_more' === userAction) {
                    $(responseObj.data).appendTo($blockElem.find('.vp-block-inner'));
                } else {
                    $blockElem.removeClass('vp-fetching');
                    $blockElem.find('.vp-block-inner').html(responseObj.data); //in place
                }
                $blockElem.attr('data-current', responseObj.paged);
                $blockElem.attr('data-maxpages', responseObj.maxpages);
                $blockElem.find('.vp-pagination .vp-page-nav.vp-current-page').removeClass('vp-current-page');
                $blockElem.find('.vp-page-nav[data-page="' + parseInt(responseObj.paged) + '"]').addClass('vp-current-page');
                $blockElem.find('.vp-page-nav[data-page="next"]').removeClass('vp-disabled');
                $blockElem.find('.vp-page-nav[data-page="prev"]').removeClass('vp-disabled');

                //hide or show prev
                if (true === responseObj.hidePrev) {
                    $blockElem.find('.vp-page-nav[data-page="prev"]').addClass('vp-disabled');
                }

                //hide or show next
                if (true === responseObj.hideNext) {
                    $blockElem.find('.vp-page-nav[data-page="next"]').addClass('vp-disabled');
                }

                var maxpages = parseInt(responseObj.maxpages);

                // If the query is being filtered by a specific taxonomy term - the All option is not chosen
                if (responseObj.filterTerm.length) {
                    if (maxpages == 1) {
                        // Hide everything if no pagination is required
                        $blockElem.find('.vp-page-nav').hide();
                    } else {
                        // hide all pages which are irrelevant in filtered results
                        $blockElem.find('.vp-page-nav').each(function () {
                            var page = $(this).attr('data-page'); // can return next and prev too
                            if (page.match('prev|next')) {
                                $(this).show(); // could have been hidden with earlier filter if maxpages == 1
                            } else if (parseInt(page) > maxpages) {
                                $(this).hide();
                            } else {
                                $(this).show(); // display the same if hidden due to previous filter
                            }
                        });
                    }
                } else {
                    // display all navigation if it was hidden before during filtering
                    $blockElem.find('.vp-page-nav').show();
                }

                // Reorganize the pagination if there are too many pages to display navigation for
                this._processNumberedPagination();
                var remainingPosts = parseInt(responseObj.remaining);
                // Set remaining posts to be loaded and hide the button if we just loaded the last page
                if (self.settings['show_remaining'] && remainingPosts !== 0) {
                    $blockElem.find('.vp-pagination a.vp-load-more span').text(remainingPosts);
                }

                if (remainingPosts === 0) {
                    $blockElem.find('.vp-pagination a.vp-load-more').addClass('vp-disabled');
                } else {
                    $blockElem.find('.vp-pagination a.vp-load-more').removeClass('vp-disabled');
                }

            },

            _getObjectSignature: function () {
                var self = this;

                // create a block signature object without heavy footprint of settings and query fields
                var signatureObject = {
                    blockId: self.blockId,
                    blockType: self.blockType,
                    query: '',
                    settings: '',
                    currentPage: self.currentPage,
                    filterTerm: self.filterTerm,
                    filterTaxonomy: self.filterTaxonomy
                };
                var objectSignature = JSON.stringify(signatureObject);
                return objectSignature;
            },

            // Manage page number display so that it does not get too long with too many page numbers displayed
            _processNumberedPagination: function () {
                var self = this;
                var $blockElem = jQuery('#' + self.blockId);
                var maxpages = parseInt($blockElem.attr('data-maxpages'));
                var currentPage = parseInt($blockElem.attr('data-current'));
                // Remove all existing dotted navigation elements
                $blockElem.find('.vp-page-nav.vp-dotted').remove();

                // proceed only if there are too many pages to display navigation for
                if (maxpages > 5) {
                    var beenHiding = false;
                    $blockElem.find('.vp-page-nav.vp-numbered').each(function () {
                        var page = $(this).attr('data-page'); // can return next and prev too
                        var pageNum = parseInt(page);

                        // Deal with only those pages between 1 and maxpages
                        if (pageNum > 1 && pageNum <= maxpages) {
                            var $navElement = $(this);
                            if (pageNum == currentPage || (pageNum == currentPage - 1) || (pageNum == currentPage + 1) || (pageNum == currentPage + 2)) {
                                if (beenHiding)
                                    $('<a class="vp-page-nav vp-dotted" href="#" data-page="">...</a>').insertBefore($navElement);
                                $navElement.show();
                                beenHiding = false;
                            } else if (pageNum == maxpages) {
                                if (beenHiding)
                                    $('<a class="vp-page-nav vp-dotted" href="#" data-page="">...</a>').insertBefore($navElement);
                                beenHiding = false; // redundant for now
                            } else {
                                $navElement.hide();
                                beenHiding = true;
                            }
                        }
                    });
                }
            },

            _getAvailableWidth: function ($blockHeaderElem) {
                var headerWidth = $blockHeaderElem.width();
                // Keep about 100px for more dropdown indicator
                var availableWidth = headerWidth - 200;
                var titleWidth = 0;
                if ($blockHeaderElem.find('.vp-block-title, .vl-block-title').length) {
                    titleWidth = $blockHeaderElem.find('.vp-block-title, .vl-block-title').eq(0).width();
                }

                if (availableWidth > titleWidth)
                    availableWidth = availableWidth - titleWidth;
                else
                    availableWidth = 0;
                return availableWidth;
            },

            _resizeFilters: function ($blockHeaderElem, availableWidth) {
                var self = this;
                var spaceRequired = 0;
                var $mainListElem = $blockHeaderElem.find('ul.vp-block-filter-list');
                // Do not proceed if there is no main list as is the case with few header styles
                if ($mainListElem.length == 0)
                    return;
                var $mainListElem = $mainListElem.eq(0);
                var $dropdownListElem = $blockHeaderElem.find('ul.vp-block-filter-dropdown-list').eq(0);
                var $mainListFilterColl = $mainListElem.find('li.vp-block-filter-item');
                var $dropdownListFilterColl = $dropdownListElem.find('li.vp-block-filter-item');
                var filterIndex = 0;
                var dropdownModified = false;
                $mainListFilterColl.each(function () {
                    var $filter = $(this);
                    spaceRequired = spaceRequired + self.filterWidths[filterIndex];
                    if (spaceRequired >= availableWidth) {
                        self._moveFilterToDropdownList($filter, $dropdownListElem);
                        dropdownModified = true;
                    }
                    filterIndex++;
                });

                $dropdownListFilterColl.each(function () {
                    var $filter = $(this);
                    /* If dropdown was modified earlier, we need to rearrange the list to maintain initial ordering of filters by
                     adding the elements back to the list.
                     Also no question of adding to main list if dropdownlist was modified earlier due to lack of space. */
                    if (dropdownModified) {
                        self._moveFilterToDropdownList($filter, $dropdownListElem);
                    } else {
                        // takes into consideration the space required for existing items as calculated in previous loop
                        spaceRequired = spaceRequired + self.filterWidths[filterIndex];
                        // move if enough space is available
                        if (spaceRequired < availableWidth) {
                            self._moveFilterToMainList($filter, $mainListElem);
                        }
                    }
                    filterIndex++;
                });
                self._toggleMoreDropdownList($blockHeaderElem, $dropdownListElem);

            },

            _moveFilterToDropdownList: function ($filter, $dropdownFilterList) {
                $filter.detach();
                $dropdownFilterList.append($filter);
            },

            _moveFilterToMainList: function ($filter, $mainFilterList) {
                $filter.detach();
                $mainFilterList.append($filter);
            },

            _toggleMoreDropdownList: function ($blockHeaderElem, $dropdownListElem) {
                var moreFilter = $blockHeaderElem.find('.vp-block-filter-dropdown').eq(0);
                if ($dropdownListElem.find('li.vp-block-filter-item').length == 0)
                    moreFilter.hide();
                else
                    moreFilter.show();
                setTimeout(function () {
                    moreFilter.closest('.vp-block-header, .vl-block-header').addClass('vp-filter-ready');
                }, 1000);
            },

            // Restore focus to the top of the block to make new elements visible
            _ensureBlockObjectsAreVisible: function ($blockElem, userAction) {
                if (userAction.match(/^(next|prev|load_page)$/)) {
                    var viewportTop = $(window).scrollTop();
                    var blockElemTop = $blockElem.offset().top;

                    // If top of block element is hidden above viewport when pagination in invoked,
                    // bring it back down and make it visible in viewport about 50 pixels from top
                    if (blockElemTop < viewportTop) {
                        $('html,body').animate({scrollTop: blockElemTop - 60}, 800);
                    }
                }
            },

            _getItemsToDisplay: function () {
                var self = this;
                return self.items;
            }
        };


        vpBlocks = {
            getBlockObjById: function (blockId) {
                var blockIndex = this._getBlockIndex(blockId);
                if (blockIndex !== -1)
                    return vpBlockObjColl[blockIndex];
                var blockObj = new ViralPro_Block(blockId);
                vpBlockObjColl.push(blockObj); // add to the array for instant retrieval later
                return blockObj;
            },

            _getBlockIndex: function (blockId) {
                var blockIndex = -1;
                $.each(vpBlockObjColl, function (index, vpBlock) {
                    if (vpBlock.blockId === blockId) {
                        blockIndex = index;
                        return false; // breaks out of $.each only
                    }
                });
                return blockIndex;
            },
        };  //end vpBlocks

        /* -------------------------------------- END Block Implementation ----------------- */

        ViralPro_Grid_Helper = function ($scope) {
            this._$grid = $scope.find('.vp-block').eq(0);
        };

        ViralPro_Grid_Helper.prototype = {
            _$grid: null,
            loadMoreOnScroll: function () {
                var $waypoint = null;
                var self = this;
                self._$grid.find('.vp-pagination a.vp-load-more').not('.vp-disabled').each(function () {
                    var load_more_button = $(this);
                    $waypoint = self._$grid.ViralProWaypoint(function (direction) {
                        load_more_button.click();
                        this.destroy();
                    }, {
                        offset: 'bottom-in-view'
                    });
                });
                return $waypoint;
            },

            setupInfiniteScroll: function () {
                var self = this;
                var $waypoint = self.loadMoreOnScroll();
                var innerBlockElem = self._$grid.find('.vp-block-inner')[0];
                var observer = new MutationObserver(function (mutations) {
                    var hasUpdates = false;
                    for (var index = 0; index < mutations.length; index++) {
                        var mutation = mutations[index];
                        if (mutation.type === 'childList' && mutation.addedNodes.length) {
                            hasUpdates = true;

                            break;
                        }
                    }
                    if (hasUpdates) {
                        // Before scheduling another scroll handler through waypoint, destroy existing unfired waypoint
                        // this occurs when user clicks on the filters without clicking the load more button
                        if ($waypoint)
                            $waypoint[0].destroy();
                        $waypoint = self.loadMoreOnScroll();
                    }
                });

                // Observe block for any modifications to the DOM
                observer.observe(innerBlockElem, {
                    attributes: false,
                    childList: true,
                    characterData: false,
                    subtree: true
                });
            },
        };

        /* ----------------------- END Grid Helper --------------------------- */

    }(jQuery));

}