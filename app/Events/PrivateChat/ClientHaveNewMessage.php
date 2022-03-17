<?php

namespace App\Events\PrivateChat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientHaveNewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('client-have-new-message.' . $this->result['client_user_id']);
    }

    public function broadcastWith()
    {
        return [
            'result' => $this->result,
        ];
    }
}
