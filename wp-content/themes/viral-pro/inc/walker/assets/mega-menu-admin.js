(function ($) {
    var viral_pro_megamenu = {

        recalcTimeout: false,

        // bind the click event to all elements with the class avia_uploader
        bind_click: function () {
            var megmenuActivator = '.field-megamenu select, #menu-to-edit';

            $(document).on('change', megmenuActivator, function () {
                var selectbox = $(this),
                        container = selectbox.parents('.menu-item:eq(0)');

                if (selectbox.val() == 'megamenu_full_width' || selectbox.val() == 'megamenu_auto_width') {
                    container.addClass('menu-item-mega-menu-active');
                } else {
                    container.removeClass('menu-item-mega-menu-active');
                }

                //check if anything in the dom needs to be changed to reflect the (de)activation of the mega menu
                viral_pro_megamenu.recalc();

            });
        },

        recalcInit: function () {
            $(document).on('mouseup', '.menu-item-bar', function (event, ui) {
                if (!$(event.target).is('a')) {
                    clearTimeout(viral_pro_megamenu.recalcTimeout);
                    viral_pro_megamenu.recalcTimeout = setTimeout(viral_pro_megamenu.recalc, 500);
                }
            });
        },

        recalc: function () {
            var menuItems = $('.menu-item', '#menu-to-edit');

            menuItems.each(function (i) {
                var item = $(this),
                        megaMenuCheckbox = $('.field-megamenu select', this);

                if (!item.is('.menu-item-depth-0')) {
                    var checkItem = menuItems.filter(':eq(' + (i - 1) + ')');
                    if (checkItem.is('.menu-item-mega-menu-active')) {
                        item.addClass('menu-item-mega-menu-active');
                    } else {
                        item.removeClass('menu-item-mega-menu-active');
                    }
                }

            });

        },

        set_icon: function () {
            var delay = (function () {
                var timer = 0;
                return function (callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            // Icon Control JS
            $("body").on("click", ".mm-icon-box-wrap .mm-icon-list li", function () {
                var icon_class = $(this).find("i").attr("class");
                $(this).closest(".mm-icon-box").find(".mm-icon-list li").removeClass("icon-active");
                $(this).addClass("icon-active");
                $(this).closest(".mm-icon-box").prev(".mm-selected-icon").children("i").attr("class", "").addClass(icon_class);
                $(this).closest(".mm-icon-panel").find("input").val(icon_class);
                $(this).closest(".mm-icon-box").slideUp();
            });

            $("body").on("click", ".mm-icon-box-wrap .mm-selected-icon", function () {
                $(this).next().slideToggle();
            });

            $("body").on("change", ".mm-icon-box-wrap .mm-icon-search select", function () {
                var selected = $(this).val();
                $(this).parent(".mm-icon-search").next('.mm-icon-panel').find(".mm-icon-list").hide().removeClass("active");
                $(this).parent(".mm-icon-search").next('.mm-icon-panel').find("." + selected).fadeIn().addClass("active");
                $(this).parent(".mm-icon-search").next('.mm-icon-panel').find(".mm-icon-list li").show();
                $(this).parent(".mm-icon-search").next('.mm-icon-panel').find(".mm-icon-search-input").val("");
            });

            $("body").on("click", ".mm-icon-remove-button", function () {
                $(this).closest(".mm-icon-box-wrap").find(".mm-selected-icon > i").removeClass();
                $(this).closest(".mm-icon-box-wrap").find(".mm-icon-panel input").val("");
                $(this).closest(".mm-icon-box-wrap").find(".mm-icon-list li").removeClass("icon-active");
                $(this).closest(".mm-icon-box").slideUp();
                return false;
            });

            $("body").on("keyup", ".mm-icon-box-wrap .mm-icon-search input", function (e) {
                var $input = $(this);
                var keyword = $input.val().toLowerCase();
                search_criteria = $input.closest(".mm-icon-box").find(".mm-icon-list.active i");
                delay(function () {
                    $(search_criteria).each(function () {
                        if ($(this).attr("class").indexOf(keyword) > -1) {
                            $(this).parent().show();
                        } else {
                            $(this).parent().hide();
                        }
                    });
                }, 500);
            });
        }

    };

    $(function () {
        viral_pro_megamenu.bind_click();
        viral_pro_megamenu.recalcInit();
        viral_pro_megamenu.recalc();
        viral_pro_megamenu.set_icon();
    });


})(jQuery);