import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import AutoAnimate from '@marcreichel/alpine-auto-animate';

// Load Alpine plugins
Alpine.plugin(AutoAnimate);
//Start Livewire
Livewire.start();

// Scroll to Top
let buttonBackToTop = document.getElementById('btn-back-to-top');
//let drawer = document.getElementsByClassName('drawer-content')[0];
// When the user clicks on the button, scroll to the top of the document
buttonBackToTop.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// When the user scrolls down 60px from the top of the document, show the button
window.onscroll = function () {
    if (document.body.scrollTop > 60 || document.documentElement.scrollTop > 60) {
        buttonBackToTop.style.display = 'block';
    } else {
        buttonBackToTop.style.display = 'none';
    }
};
