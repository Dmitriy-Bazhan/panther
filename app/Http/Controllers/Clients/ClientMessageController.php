<?php

namespace App\Http\Controllers\Clients;

use App\Events\PrivateChat\ClientNurseSentMessage;
use App\Events\PrivateChat\NurseHaveNewMessage;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientMessageController extends Controller
{
    protected $chatRepo;

    public function __construct(ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
        $data = $this->chatRepo->getClientLastPrivateChats();
        return response()->json(['success' => true, 'chats' => $data['chats'], 'nurses' => $data['nurses'],
            'haveNewMessages' => $data['haveNewMessages']]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $nurse_id = null;
        if (request()->filled('nurse_id') && is_numeric(request('nurse_id'))) {
            $nurse_id = request('nurse_id');
        }else{
            Log::channel('app_logs')->error('ClientMessageController@store Client Id not exists');
            return abort(409);
        }

        $privateMessage = null;
        if (request()->filled('privateMessage') && request('privateMessage') !== '') {
            $privateMessage = request('privateMessage');
        }

        if (count(request()->allFiles()) > 0) {
            $rules = [
                'file' => 'sometimes|file|mimes:jpeg,bmp,png'
            ];

            $validator = Validator::make($request->allFiles(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()]);
            }
        }

        if(is_null($privateMessage) && is_null(request()->file('file'))){
            return response()->json(['success' => false]);
        }

        $client_id = auth()->id();
        $user_name = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        if (!$result = $this->chatRepo->saveMessageClientToNurse($nurse_id, $client_id, $privateMessage, $user_name)) {
            //todo: cant save message client to burse
            return abort(409);
        }

        broadcast(new ClientNurseSentMessage($result));
        broadcast(new NurseHaveNewMessage($result))->toOthers();
        return response()->json(['success' => $result]);
    }

    public function getCurrentChat($nurse_id, $client_id){

        $messages = $this->chatRepo->getClientCurrentPrivateChat($nurse_id, $client_id);
        return response()->json(['success' => true, 'messages' => $messages]);
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

    public function markAsRead(){

        $nurse_id = null;
        if(request()->filled('nurse_id') && is_numeric(request('nurse_id'))){
            $nurse_id = request('nurse_id');
        }

        $client_id = null;
        if(request()->filled('client_id') && is_numeric(request('client_id')) && auth()->id() == request('client_id')){
            $client_id = request('client_id');
        }

        if(!$haveNewMessage = $this->chatRepo->markNursesMessageAsRead($nurse_id, $client_id)){
            //todo: log
            abort(409);
        }

        return response()->json(['success' => true, 'have_new_message' => $haveNewMessage]);
    }
}
