<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Repositories\NurseRepository;
use App\Http\Resources\NurseResource;
use App\Models\Nurse;
use Illuminate\Http\Request;

class AdminNurseController extends Controller
{
    protected $nursesRepo;
    protected $chatRepo;

    public function __construct(NurseRepository $nursesRepo, ChatRepository $chatRepo)
    {
        parent::__construct();
        $this->nursesRepo = $nursesRepo;
        $this->chatRepo = $chatRepo;
    }

    public function approveNurse()
    {
        if (request()->filled('id') && is_numeric(request('id'))) {
            Nurse::where('id', request('id'))->update([
                'is_approved' => 'yes',
                'change_info' => 'no',
            ]);
        } else {
            abort(409);
        }

        return response()->json(['id' => request('id')]);
    }

    public function dismissNurse()
    {
        if (request()->filled('id') && is_numeric(request('id'))) {
            Nurse::where('id', request('id'))->update([
                'is_approved' => 'no',
            ]);
        } else {
            abort(409);
        }

        return response()->json(['id' => request('id')]);
    }

    public function getNurses()
    {
        $nurses = $this->nursesRepo->search();
        return NurseResource::collection($nurses);
    }

    public function getNurseChats($id) {
        $data = $this->chatRepo->getNursePrivateChats($id);
        return response()->json(['success' => true, 'chats' => $data['chats'], 'clients' => $data['clients'],
            'haveNewMessages' => $data['haveNewMessages']]);
    }
}
