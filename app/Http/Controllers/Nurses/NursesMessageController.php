<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use Illuminate\Http\Request;

class NursesMessageController extends Controller
{
    protected $chatRepo;

    public function __construct(ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
        $chats = $this->chatRepo->getNursePrivateChats();

        return response()->json(['success' => true, 'chats' => $chats]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
