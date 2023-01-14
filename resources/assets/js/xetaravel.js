import './bootstrap';
import './vue';

jQuery(function() {
    "use strict";

    /**
     * Console
     */
    let consoleGreenTitle = 'color:#a3f5a3;background:#2f4052;font-weight:bold;';
    let consoleGreenMessage = "\n %c  %c HELLO ! %c  %c  Don't forget that this website is open-source ! https://github.com/XetaIO/Xetaravel  %c  \n\n";
    let consoleGreenWidth = 'padding:5px 0;';
    let consoleGreenColor = 'color:#fff;';
    let consoleGreenPrimaryBackground = 'background:#5ccc5c;';
    let consoleGreenCornerBackground = 'background:#a3f5a3;';

    console.log.apply(console, [
        consoleGreenMessage,
        consoleGreenPrimaryBackground + consoleGreenWidth,
        consoleGreenTitle + consoleGreenWidth,
        consoleGreenCornerBackground + consoleGreenWidth,
        consoleGreenColor + consoleGreenPrimaryBackground + consoleGreenWidth,
        consoleGreenCornerBackground + consoleGreenWidth
    ]);

    let consoleRedTitle = 'color:#e44;background:#2f4052;font-weight:bold;';
    let consoleRedMessage = "\n %c  %c ATTENTION %c  %c  DONT RUN ANY SCRIPT HERE ! IT WILL HAVE FULL ACCESS TO YOUR BROWSER AND YOUR ACCOUNT ! https://en.wikipedia.org/wiki/Self-XSS  %c  \n\n";
    let consoleRedWidth = 'padding:5px 0;';
    let consoleRedColor = 'color:#fff;';
    let consoleRedPrimaryBackground = 'background:#c22;';
    let consoleRedCornerBackground = 'background:#e44;';

    console.log.apply(console, [
        consoleRedMessage,
        consoleRedPrimaryBackground + consoleRedWidth,
        consoleRedTitle + consoleRedWidth,
        consoleRedCornerBackground + consoleRedWidth,
        consoleRedColor + consoleRedPrimaryBackground + consoleRedWidth,
        consoleRedCornerBackground + consoleRedWidth
    ]);

    /**
     * Bootstrap
     */
    $("body").tooltip({
        selector: "[data-toggle=tooltip]"
    });

    $('[data-toggle="popover"]').popover();

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
    var minWidth = 767,
        navbar = $('#change-navbar'),
        offset = navbar.offset(),
        width = window.innerWidth;

    if (navbar.length && width >= minWidth){
        $(document).scroll(function() {
            var scrollStart = $(this).scrollTop();
            if (scrollStart > (offset.top - 60)) {
                $('.navbar').attr('style', 'background-color: #FFFFFF  !important;');
                $('.navbar-hello-text').removeClass('text-white').attr('style', 'color: #506a85 !important;');
                $('.navbar-brand').removeClass('text-white').attr('style', 'color: #506a85 !important;');
                $('.btn-header-register-login').removeClass('btn-outline-primary-inverse').addClass('btn-outline-primary');
            } else {
                $('.navbar').attr('style', 'background-color: transparent !important;');
                $('.navbar-hello-text').addClass('text-white').removeAttr('style');
                $('.navbar-brand').addClass('text-white').removeAttr('style');
                $('.btn-header-register-login').removeClass('btn-outline-primary').addClass('btn-outline-primary-inverse');
            }
        });
    }


    /**
     * Discuss
     */
    $('#deletePostModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var route = button.data('form-action');

        var modal = $('#deletePostModal');
        modal.find('#deletePostForm').attr('action', route);
    });

    // Post Button
    var postReplyButton = document.getElementsByClassName('postReplyButton');
    Array.from(postReplyButton).forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            let content = button.getAttribute("data-content");

            _commentEditor.setCursor({ line: 0, ch: 0 });
            _commentEditor.insertValue(content + '\n');

        }, false);
    });

    var postEditButton = document.getElementsByClassName('postEditButton');
    Array.from(postEditButton).forEach(function (button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            let id = button.getAttribute("data-id");
            let route = button.getAttribute("data-route");

            axios.get(route)
                .then(function (response) {
                    let post = document.getElementById('disccuss-post-edit-' + id);

                    if (response.data.error == true || post !== null) {
                        return;
                    }

                    let content = $('#post-' + id + ' .discuss-conversation-content');
                    let edit = $('#post-' + id + ' .discuss-conversation-edit');

                    content.addClass('d-none');
                    edit.append(response.data.form);

                    var editPostEditor = editormd("editPostEditor-" + id, {
                        width: "100%",
                        height: 340,
                        markdown: response.data.markdown
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });

        }, false);
    });

    /**
     * Blog
     */
    $('#deleteCommentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var route = button.data('form-action');

        var modal = $('#deleteCommentModal');
        modal.find('#deleteCommentForm').attr('action', route);
    });

    /**
     * Sidebar
     */
    let sidebar = document.getElementById("sidebar");
    let sidebarTrigger = document.getElementById('sidebar-trigger');
    let sidebarOverlay = document.createElement('div');
    let closeSidebar = function () {
        sidebar.classList.remove('sidebar-opened');
        sidebar.classList.add('sidebar-closed');

        let parent = sidebarOverlay.parentNode;
        if (parent != null) {
            sidebarOverlay.parentNode.removeChild(sidebarOverlay);
        }
    };

    // User not connected, no sidebar.
    if (sidebarTrigger != null) {
        sidebarTrigger.addEventListener('click', function(event) {
            event.preventDefault();

            if (sidebar.classList.contains('sidebar-opened')) {
                closeSidebar();
            } else {
                sidebar.classList.remove('sidebar-closed');
                sidebar.classList.add('sidebar-opened');

                sidebarOverlay.classList.add('sidebar-overlay');
                sidebar.parentNode.appendChild(sidebarOverlay);

                sidebarOverlay.addEventListener('click', function() {
                    closeSidebar();
                    sidebarOverlay.removeEventListener('click', this);
                });
            }
        }, false);
    }
});

/*app = {

    init: function() {
        alert('test');
    }

};
module.exports = app;*/