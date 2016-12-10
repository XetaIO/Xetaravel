$(document).ready(function() {
    "use strict";

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
            if(scrollStart > offset.top) {
                $(".navbar").attr('style', 'background-color: #9A54B1 !important; border-bottom: 4px solid rgba(0,0,0,0.3);');
            } else {
                $('.navbar').attr('style', 'background-color: transparent !important; border-bottom: none;');
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

//# sourceMappingURL=app.js.map
