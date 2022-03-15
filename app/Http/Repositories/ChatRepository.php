<?php


namespace App\Http\Repositories;


use App\Models\PrivateChat;

class ChatRepository
{
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

        return $chats;
    }
}
