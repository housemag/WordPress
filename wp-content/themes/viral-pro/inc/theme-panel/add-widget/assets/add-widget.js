jQuery(document).ready(function ($) {
    $('.ht-remove-widget').on('click', function (e) {
        e.preventDefault();
        var widget = $(this).attr('data-widget');
        var result = confirm("Are you sure you want to delete " + widget + " Widget?");

        if (result) {
            $.ajax({
                url: viral_pro_widget_params.ajaxurl,
                data: ({
                    'action': 'viral_pro_remove_widget_area',
                    'widget': widget,
                }),
                success: function (response) {
                    location.reload();
                }
            });
        }
    });

    setTimeout(function () {
        $('.ht-notice').fadeOut("slow");
    }, 3000);

});
