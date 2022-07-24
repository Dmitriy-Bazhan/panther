<?php

namespace App\Http\Controllers;

use App\Events\Notifications\NewNotificationEvent;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications($user_id)
    {

        if (!User::find($user_id)) {
            return response()->json(['success' => false]);
        }

        if (auth()->id() == $user_id || auth()->user()->is_admin) {
            $notifications = Notification::where('status', 'unread')->where('target_user_id', auth()->id())->get();
            return NotificationResource::collection($notifications);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'You don`t have permissions',
            ]);
        }
    }

    static public function createNotification($target_user_id = null, $type = null, $content = null)
    {
        $notification = Notification::create([
            'creator_user_id' => auth()->id(),
            'creator_entity' => auth()->user()->entity,
            'target_user_id' => $target_user_id,
            'type' => $type,
            'status' => 'unread',
            'content' => $content,
        ]);

        if($notification){
            $unread_notifications_count = Notification::where('status', 'unread')->where('target_user_id', $target_user_id)->count();
            broadcast(new NewNotificationEvent($unread_notifications_count, $target_user_id));
            $success = true;
        }else{
            $success = false;
        }

        return $success;

    }
}
