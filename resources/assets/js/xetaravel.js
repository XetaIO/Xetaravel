require('./bootstrap');
require('./vue');

$(document).ready(function () {
    "use strict";

    $("body").tooltip({
        selector: "[data-toggle=tooltip]"
    });

    $("body").popover({
        selector: "[data-toggle=popover]"
    });

    /**
     * ScrollUp.
     */
    $.scrollUp({
        scrollName: "scrollUp",
        scrollDistance: 300,
        scrollFrom: "top",
        scrollSpeed: 1000,
        easingType: "easeInOutCubic",
        animation: "fade",
        animationInSpeed: 200,
        animationOutSpeed: 200,
        scrollText: '<i class="fa fa-chevron-up"></i>',
        scrollTitle: " ",
        scrollImg: 0,
        activeOverlay: 0,
        zIndex: 1001
    });

    /**
     * Navbar
     */
    var minWidth = 768,
        navbar = $('#change-navbar'),
        offset = navbar.offset(),
        width = window.innerWidth;

    if (navbar.length && width >= minWidth){
        $(document).scroll(function() {
            var scrollStart = $(this).scrollTop();
            if (scrollStart > (offset.top - 60)) {
                $('.navbar').attr('style', 'background-color: #fff !important; border-bottom: 4px solid #506a85;');
                $('.navbar-hello-text').removeClass('text-white').attr('style', 'color: #506a85 !important;');
                $('.navbar-brand').removeClass('text-white').attr('style', 'color: #506a85 !important;');
                $('.btn-header-register-login').removeClass('btn-outline-primary-inverse').addClass('btn-outline-primary');
            } else {
                $('.navbar').attr('style', 'background-color: transparent !important; border-bottom: none;');
                $('.navbar-hello-text').addClass('text-white').removeAttr('style');
                $('.navbar-brand').addClass('text-white').removeAttr('style');
                $('.btn-header-register-login').removeClass('btn-outline-primary').addClass('btn-outline-primary-inverse');
            }
        });
    }

    /**
     * User Profile
     */
    var minWidth = 992,
        sidebar = $('.sidebar-profile');

    if (sidebar.length && width >= minWidth) {
        var sidebarTop = sidebar.offset().top,
            bottom = $(".footer").outerHeight(!0);

        $(document).scroll(function() {
            var navbarHeight = $(".navbar").height() + 10,
                scrollStart = $(this).scrollTop();
            var top = sidebarTop - navbarHeight;

            if(scrollStart > top && !sidebar.hasClass('fixed')) {
                sidebar.addClass('fixed');
            }
            if (scrollStart < top && sidebar.hasClass('fixed')) {
                sidebar.removeClass('fixed');
            }
        });
    }
});

/*app = {

    init: function() {
        alert('test');
    }

};
module.exports = app;*/