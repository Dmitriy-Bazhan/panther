<?php

namespace App\Events\PrivateChat;

use App\Models\PrivateChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientNurseSentMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('client-between-nurse.' . $this->result->nurse_user_id . '.' .$this->result->client_user_id);
    }

    public function broadcastWith()
    {
        return [
            'result' => $this->result,
            'nurse_count_unread_message' => PrivateChat::where('nurse_user_id', $this->result->nurse_user_id)->where('status', 'unread')->count(),
            'client_count_unread_message' => PrivateChat::where('client_user_id', $this->result->client_user_id)->where('status', 'unread')->count(),
        ];
    }
}
