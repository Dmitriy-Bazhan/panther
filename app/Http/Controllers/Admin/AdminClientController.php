<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Repositories\ClientRepository;
use App\Http\Resources\ClientResource;
use App\Models\User;
use Illuminate\Http\Request;

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
        $clients = ClientResource::collection($this->clientRepo->search())->response()->getData();
        return response()->json(['clients' => $clients]);
    }

    public function getClientChats($id)
    {
        $data = $this->chatRepo->getClientPrivateChats($id);
        return response()->json(['success' => true, 'chats' => $data['chats'], 'nurses' => $data['nurses'],
            'haveNewMessages' => $data['haveNewMessages']]);
    }

    public function banNurse($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['success' => false]);
        }

        User::where('id', $id)->update([
            'banned' => 'yes',
        ]);

        return response()->json(['success' => true]);
    }

    public function dismissBanNurse($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['success' => false]);
        }

        User::where('id', $id)->update([
            'banned' => 'no',
        ]);

        return response()->json(['success' => true]);
    }
}
