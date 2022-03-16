<?php

namespace App\Events\PrivateChat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NurseHaveNewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nurse_id;

    public function __construct($nurse_id)
    {
        $this->nurse_id = $nurse_id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('nurse-have-new-message.' . $this->nurse_id);
    }
}
