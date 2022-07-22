import Echo from 'laravel-echo';

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
