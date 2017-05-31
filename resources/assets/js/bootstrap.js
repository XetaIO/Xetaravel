//window._ = require('lodash');

/**
 * Sprintf function.
 */
var vsprintf = require("sprintf-js").vsprintf;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Xetaravel.csrfToken;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

/*import EchoLibrary from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new EchoLibrary({
    broadcaster: 'pusher',
    key: '73add875620699f38825',
    cluster: 'eu',
    encrypted: true,
    namespace: 'Xetaravel.Events'
});
Echo.channel('Xetaravel.User')
    .listen('UserUpdated', (e) => {
        console.log('Echo OK');
    })
    .listen('Xetaravel\\Events\\UserUpdated', (e) => {
        console.log('Echo OK2');
    })
    .listen('Xetaravel.Events.UserUpdated', (e) => {
        console.log('Echo OK3');
    });
*/
