<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ChatRepository;
use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    protected $chatRepo;

    public function __construct(ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
    }

    public function setChatOnDeleteStatus()
    {
        $chat_id = request('chat_id');
        $result = Chat::where('id', $chat_id)->update([
            'status' => 'deleted',
            'delete_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
        ]);

        if (!$result) {
            Log::error('ChatController@setChatOnDeleteStatus some problems with update chat status');
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }

    public function setChatOnActiveStatus()
    {
        $chat_id = request('chat_id');
        $result = Chat::where('id', $chat_id)->update([
            'status' => 'active',
            'delete_date' => null,
        ]);

        if (!$result) {
            Log::error('ChatController@setChatOnActiveStatus some problems with update chat status');
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }

    public function removeChatAtAll()
    {
        $chat_id = request('chat_id');

        if (!$chat = Chat::find($chat_id)) {
            Log::error('ChatController@removeChatAtAll chat with this chat_id not exists');
            return response()->json(['success' => false]);
        }

        $success = $this->chatRepo->removeChatAndAllThatRelationWithHim($chat);

        return response()->json(['success' => $success]);
    }
}
