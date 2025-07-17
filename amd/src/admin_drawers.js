define(['jquery'], function ($) {

    return {
        init: function () {

            $('#admin-hamburger').on('click', function () {
                $('body').addClass('admin-navigation-open');
                $('.admin-navigation').addClass('open');
            });

            $('.admin-sidebar-close').on('click', function () {
                $('body').removeClass('admin-navigation-open');
                $('.admin-navigation').removeClass('open');
            });

            $('.toggle').on('click keydown', function (e) {
                if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
                    $(this).parent().toggleClass('expanded');
                    e.preventDefault();
                }
            });
        }
    };
});
