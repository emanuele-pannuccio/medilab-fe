import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: "my-app-key",
    wsHost: "192.168.1.187",
    wsPort: 8080,
    forceTLS: ("http" ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
