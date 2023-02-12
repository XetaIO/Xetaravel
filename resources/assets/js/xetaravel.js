import './bootstrap';
import './vue';
import Dismiss from './libs/dismiss.js';

export default {
    Dismiss
}

// Used to toggle the class h-full for drawer.
// Need height 100% for Waypoints framework to work.
const checkboxDrawer = document.getElementById('xetaravel-drawer');
checkboxDrawer.addEventListener('change', function() {
    let drawer = document.getElementsByClassName('drawer')[0];
    drawer.classList.toggle('h-full');
})


 // Scroll to Top
let buttonBackToTop = document.getElementById('btn-back-to-top');
// When the user clicks on the button, scroll to the top of the document
buttonBackToTop.addEventListener('click', function() {
    //document.body.scrollTop = 0;
    //document.documentElement.scrollTop = 0;
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
// When the user scrolls down 40px from the top of the document, show the button
window.onscroll = function () {
    if (document.body.scrollTop > 60 || document.documentElement.scrollTop > 60) {
        buttonBackToTop.style.display = 'block';
    } else {
        buttonBackToTop.style.display = 'none';
    }
};

// Blog comment delete button
const blogModalsDeleteComment = document.querySelectorAll('.deleteCommentModal');
blogModalsDeleteComment.forEach(function(blogModalDeleteComment) {
    blogModalDeleteComment.addEventListener('click', function(event) {
            const formModalDeleteComment = document.getElementById('deleteCommentModalForm');
            const actionUrl = event.target.dataset.action;

            formModalDeleteComment.action = actionUrl;
    });
});

// Discuss conversation post delete button
const discussModalsDeletePost = document.querySelectorAll('.deleteConversationPostModal');
discussModalsDeletePost.forEach(function(discussModalDeletePost) {
    discussModalDeletePost.addEventListener('click', function(event) {
            const formModalDeletePost = document.getElementById('deleteConversationPostModalForm');
            const actionUrl = event.target.dataset.action;

            formModalDeletePost.action = actionUrl;
    });
});

// Discuss conversation post Edit Button
const postEditButton = document.querySelectorAll('.postEditButton');
postEditButton.forEach(function (button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        let id = event.target.dataset.id;
        let route = event.target.dataset.route;

        axios.get(route)
            .then(function (response) {
                let post = document.getElementById('discuss-post-edit-' + id);

                if (response.data.error == true || post !== null) {
                    return;
                }

                let content = document.getElementById('post-' + id).getElementsByClassName('discuss-conversation-content')[0];
                let edit = document.getElementById('post-' + id).getElementsByClassName('discuss-conversation-edit')[0];

                content.classList.add('hidden');
                var scriptEl = document.createRange().createContextualFragment(response.data.form);
                edit.append(scriptEl);

                let editPostEditor = editormd("editPostEditor-" + id, {
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

// Discuss conversation post Reply Button
const postReplyButton = document.getElementsByClassName('postReplyButton');
Array.from(postReplyButton).forEach(function (button) {
    button.addEventListener('click', function (event) {

        let content = button.getAttribute("data-content");

        _commentEditor.setCursor({ line: 0, ch: 0 });
        _commentEditor.insertValue(content + '\n');

    }, false);
});

//const tsParticles = require("tsparticles-engine");
