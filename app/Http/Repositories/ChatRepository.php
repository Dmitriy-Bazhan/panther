<?php

namespace App\Http\Repositories;

use App\Models\PrivateChat;
use App\Models\User;

class ChatRepository
{
    public function saveMessageNurseToClient($nurse_id, $client_id = null, $privateMessage = null, $user_name)
    {
        if (is_null($client_id) || is_null($privateMessage)) {
            //todo: log
            return abort(409);
        }

        $success = PrivateChat::create([
            'client_user_id' => $client_id,
            'nurse_user_id' => $nurse_id,
            'message' => $privateMessage,
            'user_name' => $user_name,
            'nurse_sent' => 'yes',
        ]);

        if ($success) {
            return $success;
        }
        return false;
    }

    public function saveMessageClientToNurse($nurse_id = null, $client_id, $privateMessage = null, $user_name)
    {
        if (is_null($nurse_id) || is_null($privateMessage)) {
            //todo: log
            return abort(409);
        }

        $success = PrivateChat::create([
            'client_user_id' => $client_id,
            'nurse_user_id' => $nurse_id,
            'message' => $privateMessage,
            'user_name' => $user_name,
            'client_sent' => 'yes',
        ]);

        if ($success) {
            return $success;
        }
        return false;
    }

    public function getNursePrivateChats()
    {
        $chats = PrivateChat::where('nurse_user_id', auth()->id())->orderByDesc('created_at')->get()->groupBy('client_user_id');
        $clients = User::whereIn('id', $chats->keys()->toArray())->get()->groupBy('id');
        $haveNewMessages = [];
        foreach ($chats as $key => $chat) {
            if ($chat->where('status' , 'unread')->where('client_sent', 'yes')->first()) {
                $haveNewMessages[$key] = $key;
                continue;
            }
        }


        return ['chats' => $chats, 'clients' => $clients, 'haveNewMessages' => $haveNewMessages];
    }

    public function getClientPrivateChats()
    {
        $chats = PrivateChat::where('client_user_id', auth()->id())->orderByDesc('created_at')->get()->groupBy('nurse_user_id');
        $nurses = User::whereIn('id', $chats->keys()->toArray())->get()->groupBy('id');
        $haveNewMessages = [];
        foreach ($chats as $key => $chat) {
            if ($chat->where('status' , 'unread')->where('nurse_sent', 'yes')->first()) {
                $haveNewMessages[$key] = $key;
                continue;
            }
        }
        return ['chats' => $chats, 'nurses' => $nurses, 'haveNewMessages' => $haveNewMessages];
    }

    public function getClientPrivateChatsWithNurse($nurse_id)
    {
        $chat = PrivateChat::where('client_user_id', auth()->id())->where('nurse_user_id', $nurse_id)->get();
        return $chat;
    }

    public function markNursesMessageAsRead($nurse_id, $client_id)
    {
        if (is_null($nurse_id) || is_null($client_id)) {
            //todo: log
            abort(409);
        }

        $success = PrivateChat::where('nurse_user_id', $nurse_id)
            ->where('client_user_id', $client_id)
            ->where('nurse_sent', 'yes')
            ->update([
                'status' => 'read'
            ]);

        $haveNewMessage = 'yes';
        if($success){
           $haveNewMessage = PrivateChat::where('client_user_id', $client_id)
                ->where('status', 'unread')
                ->whereNotNull('nurse_sent')
                ->first() !== null ? 'no' : 'yes' ;
        }

        return $haveNewMessage;
    }

    public function markClientMessageAsRead($nurse_id, $client_id)
    {
        if (is_null($nurse_id) || is_null($client_id)) {
            //todo: log
            abort(409);
        }

        $success = PrivateChat::where('nurse_user_id', $nurse_id)
            ->where('client_user_id', $client_id)
            ->where('client_sent', 'yes')
            ->update([
                'status' => 'read'
            ]);

        $haveNewMessage = 'yes';
        if($success){
            $haveNewMessage = PrivateChat::where('nurse_user_id', $client_id)
                ->where('status', 'unread')
                ->whereNotNull('client_sent')
                ->first() !== null ? 'no' : 'yes' ;
        }

        return $haveNewMessage;
    }
}
