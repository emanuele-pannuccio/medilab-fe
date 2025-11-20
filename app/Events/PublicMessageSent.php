<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // importante

class PublicMessageSent implements ShouldBroadcastNow
{
    public function __construct(
        public string $message
    ) {}

    public function broadcastOn()
    {
        return new Channel('public-chat'); // stesso nome usato in Echo
    }

    public function broadcastAs()
    {
        return 'message.sent'; // quindi in Echo .message.sent
    }
}
