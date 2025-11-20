import './bootstrap';



window.Echo
    .channel('public-chat')
    .listen('.message.sent', (e) => {
        console.log('Messaggio ricevuto:', e.message);
    });