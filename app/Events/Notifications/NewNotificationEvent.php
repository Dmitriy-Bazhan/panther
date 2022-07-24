<?php

namespace App\Events\Notifications;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $unread_notifications_count;
    private $target_user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($unread_notifications_count, $target_user_id)
    {
        $this->unread_notifications_count = $unread_notifications_count;
        $this->target_user_id = $target_user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notifications.' . $this->target_user_id);
    }

    public function broadcastWith()
    {
        return [
            'unread_notifications_count' => $this->unread_notifications_count,
        ];
    }
}
