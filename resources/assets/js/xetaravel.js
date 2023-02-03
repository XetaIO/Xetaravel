import './bootstrap';
import './vue';
import Dismiss from './libs/dismiss.js';

export default {
    Dismiss
}

const blogModalsDeleteComment = document.querySelectorAll('.deleteCommentModal');

blogModalsDeleteComment.forEach(function(blogModalDeleteComment) {
    blogModalDeleteComment.addEventListener('click', () => {
            const formModalDeleteComment = document.getElementById('deleteCommentModalForm');
            const actionUrl = this.dataset.action;

            formModalDeleteComment.action = actionUrl;
    });
})

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
