<?php

namespace App\Http\Controllers;

use App\Events\TestChatMessage;
use App\Http\Repositories\NurseRepository;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $nurseRepo;

    public function __construct(NurseRepository $nurseRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
    }

    public function index()
    {
//        $nurse = Nurse::whereJsonContains('work_time_pref->weekdays_afternoon', '1')
//            ->first();
//        dd($nurse);
//
//        dd('FFFFF');

        $id = null;
        request()->merge([
            'only_full_info' => true
        ]);

        $data['data'] = $this->nurseRepo->search();

        return view('test', $data);
    }

    public function testSetMessage(Request $request)
    {

        broadcast(new TestChatMessage($request->input('message'), $request->input('user_id'), $request->input('username')))->toOthers();

        return response()->json([], 200);

    }
}
