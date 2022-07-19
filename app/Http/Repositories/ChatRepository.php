<?php

namespace App\Http\Repositories;

use App\Models\Chat;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\PrivateChat;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class ChatRepository
{
    public function saveMessageNurseToClient($nurse_id, $client_id = null, $privateMessage = null, $user_name)
    {
        if (is_null($client_id)) {
            //todo: log
            return abort(409);
        }

        $have_file = 'no';
        $original_file = null;
        $thumbnail_file = null;

        if (count(request()->allFiles()) > 0) {
            $result = $this->savePrivateChatFile();
            $have_file = 'yes';
            $original_file = $result['original_file'];
            $thumbnail_file = $result['thumbnail_file'];
        }

        $success = PrivateChat::create([
            'client_user_id' => $client_id,
            'nurse_user_id' => $nurse_id,
            'message' => is_null($privateMessage) ? '' : $privateMessage,
            'user_name' => $user_name,
            'nurse_sent' => 'yes',
            'have_file' => $have_file,
            'original_file' => $original_file,
            'thumbnail_file' => $thumbnail_file,
        ]);

        $this->checkOrCreateChat($client_id, $nurse_id);

        if ($success) {
            return $success;
        }
        return false;
    }

    public function saveMessageClientToNurse($nurse_id = null, $client_id, $privateMessage = null, $user_name)
    {
        if (is_null($nurse_id)) {
            //todo: log
            return abort(409);
        }

        $have_file = 'no';
        $original_file = null;
        $thumbnail_file = null;

        if (count(request()->allFiles()) > 0) {
            $result = $this->savePrivateChatFile();
            $have_file = 'yes';
            $original_file = $result['original_file'];
            $thumbnail_file = $result['thumbnail_file'];
        }

        $success = PrivateChat::create([
            'client_user_id' => $client_id,
            'nurse_user_id' => $nurse_id,
            'message' => $privateMessage,
            'user_name' => $user_name,
            'client_sent' => 'yes',
            'have_file' => $have_file,
            'original_file' => $original_file,
            'thumbnail_file' => $thumbnail_file,
        ]);

        $this->checkOrCreateChat($client_id, $nurse_id);

        if ($success) {
            return $success;
        }
        return false;
    }

    public function getNursePrivateChats($id = null)
    {
        if (is_null($id)) {
            $nurseId = auth()->id();
        } else {
            $nurseId = $id;
        }
        $chats = PrivateChat::where('nurse_user_id', $nurseId)
            ->where('client_sent', 'yes')
            ->orderByDesc('created_at')
            ->get()->groupBy('client_user_id');

        $haveNewMessages = [];
        $clientsIds = PrivateChat::where('nurse_user_id', $nurseId)->select('client_user_id')->get()->groupBy('client_user_id');
        $clients = User::whereIn('id', $clientsIds->keys())->without('prefs')->get()->groupBy('id');

        return ['chats' => $chats, 'clients' => $clients, 'haveNewMessages' => $haveNewMessages];
    }

    public function getNurseCurrentPrivateChat($nurse_id = null, $client_id = null)
    {
        $messages = PrivateChat::where('nurse_user_id', $nurse_id)
            ->where('client_user_id', $client_id)
            ->orderByDesc('created_at')
            ->get();

        return $messages;
    }

    public function getNurseLastPrivateChats($id = null)
    {
        if (is_null($id)) {
            $nurseId = auth()->id();
        } else {
            $nurseId = $id;
        }

        $clientsIds = PrivateChat::where('nurse_user_id', $nurseId)->select('client_user_id')->get()->groupBy('client_user_id');
        $clients = User::whereIn('id', $clientsIds->keys())->without('prefs')->get()->groupBy('id');

        $haveNewMessages = [];
        $chats = [];
        foreach ($clients as $key => $chat) {
            $clients[$key]['count'] = PrivateChat::where('nurse_user_id', $nurseId)
                ->where('client_sent', 'yes')
                ->where('client_user_id', $key)
                ->where('status', 'unread')->count();
            $clients[$key]['last_message'] = PrivateChat::where('nurse_user_id', $nurseId)
                ->where('client_user_id', $key)
                ->where('client_sent', 'yes')
                ->where('status', 'unread')->orderByDesc('created_at')->first();
            $clients[$key]['chat'] = Chat::where('client_user_id', $key)
                ->where('nurse_user_id', $nurseId)->first();

            if ($clients[$key]['count'] > 0) {
                $haveNewMessages[$key] = $key;
            }

        }

        return ['chats' => $chats, 'clients' => $clients, 'haveNewMessages' => $haveNewMessages];
    }

    public function getClientPrivateChats($id = null)
    {
        if (is_null($id)) {
            $clientId = auth()->id();
        } else {
            $clientId = $id;
        }

        $chats = PrivateChat::where('client_user_id', $clientId)->orderByDesc('created_at')->get()->groupBy('nurse_user_id');
        $nurses = User::whereIn('id', $chats->keys()->toArray())->get()->groupBy('id');
        $haveNewMessages = [];
        foreach ($chats as $key => $chat) {
            if ($chat->where('status', 'unread')->where('nurse_sent', 'yes')->first()) {
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

    public function getNursePrivateChatsWithClients($client_id)
    {
        $chat = PrivateChat::where('nurse_user_id', auth()->id())->where('client_user_id', $client_id)->get();
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
        if ($success) {
            $haveNewMessage = PrivateChat::where('client_user_id', $client_id)
                ->where('status', 'unread')
                ->whereNotNull('nurse_sent')
                ->first() !== null ? 'no' : 'yes';
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
        if ($success) {
            $haveNewMessage = PrivateChat::where('nurse_user_id', $client_id)
                ->where('status', 'unread')
                ->whereNotNull('client_sent')
                ->first() !== null ? 'no' : 'yes';
        }

        return $haveNewMessage;
    }

    public function savePrivateChatFile()
    {
        $file = request()->file('file');
        $original_name = $file->getClientOriginalName();
        $file_name = auth()->id() . '_' . Str::random(10) . '_' . $original_name;
        $thumbnail_name = 'thumbnail_' . $file_name;
        $directory_name = 'user_' . auth()->id() . '/private_chats';
        $original_file = Storage::disk('public')->putFileAs($directory_name, $file, $file_name);
        $thumbnail_file = Storage::disk('public')->putFileAs($directory_name, $file, $thumbnail_name);

        //make thumbnail or avatar
        $img = Image::make('storage/' . $thumbnail_file)->resize(40, 40, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save();

        return [
            'original_file' => $original_file,
            'thumbnail_file' => $thumbnail_file,
        ];

    }

    public function checkOrCreateChat($client_id, $nurse_id)
    {

        if (!Chat::where('client_user_id', $client_id)->where('nurse_user_id', $nurse_id)->first()) {
            Chat::create([
                'client_user_id' => $client_id,
                'nurse_user_id' => $nurse_id,
            ]);
        }
    }

    public function removeChatAndAllThatRelationWithHim(Chat $chat)
    {
        $client_user_id = $chat->client_user_id;
        $nurse_user_id = $chat->nurse_user_id;
        $success = true;

        if (!Chat::where('id', $chat->id)->delete()) {
            Log::error('ChatRepository@removeChatAndAllThatRelationWithHim can\'t remove chat');
            $success = false;
        }

        $messages = PrivateChat::where('client_user_id', $client_user_id)
            ->where('nurse_user_id', $nurse_user_id)->get();

        $result = PrivateChat::where('client_user_id', $client_user_id)
            ->where('nurse_user_id', $nurse_user_id)->delete();

        if (!$result) {
            Log::error('ChatRepository@removeChatAndAllThatRelationWithHim can\'t remove messages from private_chats table');
            $success = false;
        }

        foreach ($messages as $message) {
            Storage::disk('public')->delete($message->original_file);
            Storage::disk('public')->delete($message->thumbnail_file);
        }

        return $success;
    }
}
