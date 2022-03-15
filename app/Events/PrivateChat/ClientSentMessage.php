<?php

namespace App\Events\PrivateChat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientSentMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $privateMessage;
    public $nurse_id;
    public $client_id;
    public $user_name;
    public $created_at;

    public function __construct($nurse_id, $client_id, $privateMessage, $user_name, $created_at)
    {
        $this->nurse_id = $nurse_id;
        $this->privateMessage = $privateMessage;
        $this->client_id = $client_id;
        $this->user_name = $user_name;
        $this->created_at = $created_at;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('client-between-nurse.' . $this->nurse_id . '.' . $this->client_id);
    }

    public function broadcastWith()
    {
        return [
            'privateMessage' => $this->privateMessage,
            'nurse_id' => $this->nurse_id,
            'client_id' => $this->client_id,
            'user_name' => $this->user_name,
            'created_at' => $this->created_at,
        ];
    }
}
