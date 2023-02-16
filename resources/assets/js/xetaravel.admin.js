import './bootstrap';
import './vue';
import Dismiss from './libs/dismiss.js'

export default {
    Dismiss
}

 // Scroll to Top
 let buttonBackToTop = document.getElementById('btn-back-to-top');
 console.log(buttonBackToTop)
 // When the user clicks on the button, scroll to the top of the document
 buttonBackToTop.addEventListener('click', function() {
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