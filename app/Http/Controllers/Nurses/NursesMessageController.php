<?php

namespace App\Http\Controllers\Nurses;

use App\Events\PrivateChat\ClientHaveNewMessage;
use App\Events\PrivateChat\ClientNurseSentMessage;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        $data = $this->chatRepo->getNurseLastPrivateChats();
        return response()->json(['success' => true, 'chats' => $data['chats'], 'clients' => $data['clients']
            , 'haveNewMessages' => $data['haveNewMessages']]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $client_id = null;
        if (request()->filled('client_id') && is_numeric(request('client_id'))) {
            $client_id = request('client_id');
        }else{
            Log::error('NursesMessageController@store Client Id not exists');
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

        $nurse_id = auth()->id();
        $user_name = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        if (!$result = $this->chatRepo->saveMessageNurseToClient($nurse_id, $client_id, $privateMessage, $user_name)) {
            //todo: cant save message client to burse
            return abort(409);
        }
        broadcast(new ClientNurseSentMessage($result));
        broadcast(new ClientHaveNewMessage($result))->toOthers();
        return response()->json(['success' => true]);
    }

    public function getCurrentChat($nurse_id, $client_id){

        $messages = $this->chatRepo->getNurseCurrentPrivateChat($nurse_id, $client_id);
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

        $client_id = null;
        if(request()->filled('client_id') && is_numeric(request('client_id'))){
            $client_id = request('client_id');
        }

        $nurse_id = null;
        if(request()->filled('nurse_id') && is_numeric(request('nurse_id')) && auth()->id() == request('nurse_id')){
            $nurse_id = request('nurse_id');
        }

        if(!$haveNewMessage = $this->chatRepo->markClientMessageAsRead($nurse_id, $client_id)){
            //todo: log
            abort(409);
        }

        return response()->json(['success' => true, 'have_new_message' => $haveNewMessage]);
    }
}
