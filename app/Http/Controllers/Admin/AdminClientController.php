<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Repositories\ClientRepository;
use App\Http\Resources\ClientResource;
use App\Models\PrivateChat;
use Illuminate\Support\Facades\Log;

class AdminClientController extends Controller
{
    protected $clientRepo;
    protected $chatRepo;

    public function __construct(ClientRepository $clientRepo, ChatRepository $chatRepo)
    {
        parent::__construct();
        $this->clientRepo = $clientRepo;
        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
//        $clients = ClientResource::collection($this->clientRepo->search(100))->response()->getData();
        $clients = ClientResource::collection($this->clientRepo->search())->response()->getData();
        return response()->json(['clients' => $clients]);
    }

    public function getClientChats($id)
    {
        $data = $this->chatRepo->getClientPrivateChats($id);
        return response()->json(['success' => true, 'chats' => $data['chats'], 'nurses' => $data['nurses'],
            'haveNewMessages' => $data['haveNewMessages']]);
    }

    public function adminRemoveMessage($id) {
        if(is_null($id) && !is_numeric($id)){
            Log::channel('app_logs')->error('AdminClientController@adminRemoveMessage comment id is not valid');
            return response()->json(['success' => false ]);
        }

        if(!$comment = PrivateChat::find($id)) {
            Log::channel('app_logs')->error('AdminClientController@adminRemoveMessage comment not exists');
            return response()->json(['success' => false ]);
        }

        $comment->message = 'Message is deleted admin';
        $comment->status = 'removed';

        if(!$comment->save()){
            Log::channel('app_logs')->error('AdminClientController@adminRemoveMessage comment not possible save');
            return response()->json(['success' => false ]);
        }

        return response()->json(['success' => true ]);
    }
}
