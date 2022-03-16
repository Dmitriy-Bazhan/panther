<?php

namespace App\Http\Repositories;

use App\Models\PrivateChat;
use App\Models\User;

class ChatRepository
{
    public function saveMessageNurseToClient($nurse_id, $client_id = null, $privateMessage = null, $user_name){
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

    public function getNursePrivateChats(){
        $chats = PrivateChat::where('nurse_user_id', auth()->id())->get()->groupBy('client_user_id');
        $clients = User::whereIn('id', $chats->keys()->toArray())->get()->groupBy('id');
        return ['chats' => $chats, 'clients' => $clients];
    }

    public function getClientPrivateChats(){
        $chats = PrivateChat::where('client_user_id', auth()->id())->get()->groupBy('nurse_user_id');
        return $chats;
    }

     public function getClientPrivateChatsWithNurse($nurse_id){
         $chat = PrivateChat::where('client_user_id', auth()->id())->where('nurse_user_id', $nurse_id)->get();
         return $chat;
     }
}
