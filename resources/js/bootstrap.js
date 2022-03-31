window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo =  new Echo({
    broadcaster: 'pusher',
    key: 1,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    auth: {
        headers: {
            Authorization: 'Bearer ' + document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    enabledTransports: ['ws', 'wss']
});

// window.Echo.connector.pusher.connection.bind('connecting', (payload) => {
//     console.log('connecting...');
// });
//
// window.Echo.connector.pusher.connection.bind('connected', (payload) => {
//     console.log('connected!', payload);
// });
//
// window.Echo.connector.pusher.connection.bind('unavailable', (payload) => {
//     console.log('unavailable', payload);
// });
//
// window.Echo.connector.pusher.connection.bind('failed', (payload) => {
//     console.log('Failed', payload);
// });
//
// window.Echo.connector.pusher.connection.bind('disconnected', (payload) => {
//     console.log('disconnected', payload);
// });
//
// window.Echo.connector.pusher.connection.bind('message', (payload) => {
//     console.log('message', payload);
// });

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
