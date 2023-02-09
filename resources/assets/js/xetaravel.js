import './bootstrap';
import './vue';
import Dismiss from './libs/dismiss.js';

export default {
    Dismiss
}

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
         event.preventDefault();

         let content = button.getAttribute("data-content");

         _commentEditor.setCursor({ line: 0, ch: 0 });
         _commentEditor.insertValue(content + '\n');

     }, false);
 });

/*document.addEventListener("DOMContentLoaded", () => {
    var codes = document.getElementsByClassName('hljs');
    const codesArray = Array.from(codes);

    codes.forEach(code => {
        console.log(code);
        code.classList.add('dark:bg-base-300 dark:text-slate-300');
    });
});*/

/*var codes = document.getElementsByClassName('hljs');

codes.forEach(code => {
    console.log(code);
    code.classList.add('dark:bg-base-300 dark:text-slate-300');
});*/

//const tsParticles = require("tsparticles-engine");
