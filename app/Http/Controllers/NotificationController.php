<?php

namespace App\Http\Controllers;

use App\Events\Notifications\NewNotificationEvent;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    static public function createNotification($target_user_id = null, $type = null, $content = null, $resource_id = 0)
    {
        if (is_null($target_user_id) || is_null($type) || is_null($content)) {
            Log::channel('app_logs')->error('NotificationController@createNotification Vars is null');
            return false;
        }

        if (!User::find($target_user_id)) {
            Log::channel('app_logs')->error('NotificationController@createNotification Target user not exists');
            return false;
        }

        $notification = Notification::create([
            'creator_user_id' => auth()->id(),
            'creator_entity' => auth()->user()->entity_type,
            'target_user_id' => $target_user_id,
            'type' => $type,
            'status' => 'unread',
            'resource_id' => $resource_id,
            'content' => self::handleContent($content),
        ]);

        if ($notification) {
            $unread_notifications_count = Notification::where('status', 'unread')->where('target_user_id', $target_user_id)->count();
            broadcast(new NewNotificationEvent($unread_notifications_count, $target_user_id));
            $success = true;
        } else {
            Log::channel('app_logs')->error('NotificationController@createNotification Notification not created');
            $success = false;
        }

        return $success;

    }

    public function setNotificationStatusRead()
    {
        $notification_id = request()->post('notification_id');
        if (is_null($notification_id)) {
            Log::channel('app_logs')->error('NotificationController@setNotificationStatusRead Notification id is null');
            return false;
        }

        $success = Notification::where('id', $notification_id)->update([
            'status' => 'read'
        ]);

        $target_user_id = Notification::where('id', $notification_id)->select('target_user_id')->first()->target_user_id;

        if ($success) {
            $unread_notifications_count = Notification::where('status', 'unread')->where('target_user_id', $target_user_id)->count();
            broadcast(new NewNotificationEvent($unread_notifications_count, $target_user_id));
            return true;
        } else {
            Log::channel('app_logs')->error('NotificationController@setNotificationStatusRead Notification not update');
            return false;
        }
    }

    public function setAllNotificationStatusRead()
    {
        $target_user_id = request()->post('target_user_id');
        if (is_null($target_user_id)) {
            Log::channel('app_logs')->error('NotificationController@setNotificationStatusRead Notification id is null');
            return false;
        }

        $success = Notification::where('target_user_id', $target_user_id)->update([
            'status' => 'read'
        ]);

        if ($success) {
            $unread_notifications_count = 0;
            broadcast(new NewNotificationEvent($unread_notifications_count, $target_user_id));
            return true;
        } else {
            Log::channel('app_logs')->error('NotificationController@setNotificationStatusRead Notification not update');
            return false;
        }
    }

    private function handleContent($content){

        return $content;
    }
}
