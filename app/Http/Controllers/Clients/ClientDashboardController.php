<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\Booking;
use App\Models\Lang;
use App\Models\PrivateChat;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    protected $chatRepo;

    public function __construct(ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
        $data = siteData();

        $bookings = Booking::where('client_user_id', auth()->id())->select('nurse_user_id','status')->get();
        auth()->user()->bokkings_count = $bookings->count();
        auth()->user()->all_nurses = $bookings->keyBy('nurse_user_id')->count();
        auth()->user()->new_nurses = $bookings->groupBy('nurse_user_id')->filter(function($value){
            $count_not_approved = $value->where('status', 'not_approved')->count();
            $count_else = $value->where('status', '!=' ,'not_approved')->count();
            if($count_not_approved > 0 && $count_else == 0){
                return true;
            }
        })->count();;

        auth()->user()->payments = 0;

        $data['data']['last_chats'] = $this->chatRepo->getClientLastPrivateChats(5);

        $data['data']['have_new_message'] = PrivateChat::where('client_user_id', auth()->id())
            ->where('status', 'unread')
            ->whereNotNull('nurse_sent')
            ->first() !== null ? true : false;
        $data['data']['last_unread_messages'] = PrivateChat::where('client_user_id', auth()->id())
            ->where('status', 'unread')
            ->where('nurse_sent', 'yes')
            ->orderByDesc('created_at')->get()->groupBy('nurse_user_id');
        $data['data']['count_of_unread_messages'] = PrivateChat::where('client_user_id', auth()->id())
            ->where('status', 'unread')
            ->where('nurse_sent', 'yes')
            ->count();

        return view('dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
