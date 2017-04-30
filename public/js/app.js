$(document).ready(function() {
    "use strict";

    $("body").tooltip({
        selector: "[data-toggle=tooltip]"
    });

    $("body").popover({
        selector: "[data-toggle=popover]"
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
            } else {
                $('.navbar').attr('style', 'background-color: transparent !important; border-bottom: none;');
                $('.navbar-hello-text').addClass('text-white').removeAttr('style');
                $('.navbar-brand').addClass('text-white').removeAttr('style');
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
