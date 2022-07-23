<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Repositories\ClientRepository;
use App\Http\Resources\ClientResource;
use App\Models\PrivateChat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function getClients()
    {
        $search = request()->get('search');
        request()->merge([
            'search' => $search
        ]);

        $clients = ClientResource::collection($this->clientRepo->search())->response()->getData();
        return response()->json(['clients' => $clients]);
    }

    public function addNewClient(){

        $client = json_decode(request()->post('client'), true);

        $rules = [
            'description' => 'required',
            'email' => 'required|email',
            'first_name' => 'required',
            'gender' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'zip_code' => 'required',
            'age' => 'required|numeric|min:18|max:200',
        ];

        $validator = Validator::make($client, $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

        if (count(request()->allFiles()) > 0) {
            $rules = [
                'file' => 'sometimes|file|mimes:jpeg,bmp,png'
            ];

            $validator = Validator::make(request()->allFiles(), $rules);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if (!$this->clientRepo->addNewClient($client)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        return response()->json(['success' => true]);
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
