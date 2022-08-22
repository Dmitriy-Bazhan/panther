<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Resources\NurseResource;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\Booking;
use App\Models\Lang;
use App\Models\PrivateChat;
use App\Models\ProvideSupport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Repositories\NurseRepository;

class NurseDashboardController extends Controller
{
    protected $nurseRepo;
    protected $chatRepo;

    public function __construct(NurseRepository $nurseRepo, ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
        $data = siteData();
        auth()->user()->entity->price;

        $bookings = Booking::where('nurse_user_id', auth()->id())->select('client_user_id','status')->get();
        auth()->user()->bokkings_count = $bookings->count();
        auth()->user()->all_clients = $bookings->keyBy('client_user_id')->count();
        auth()->user()->new_clients = $bookings->groupBy('client_user_id')->filter(function($value){
            $count_not_approved = $value->where('status', 'not_approved')->count();
            $count_else = $value->where('status', '!=' ,'not_approved')->count();
            if($count_not_approved > 0 && $count_else == 0){
                return true;
            }
        })->count();;

        auth()->user()->payments = 0;

        $data['data']['have_not_approved_bookings'] = Booking::where('nurse_user_id', auth()->id())
            ->where('status', 'not_approved')
            ->where('is_verification', 'yes')
            ->first() !== null ? true : false;
        $data['data']['have_new_message'] = PrivateChat::where('nurse_user_id', auth()->id())
            ->where('status', 'unread')
            ->whereNotNull('client_sent')
            ->first() !== null ? true : false;

        $data['data']['last_chats'] = $this->chatRepo->getNurseLastPrivateChats(5);

        $data['data']['count_of_unread_messages'] = PrivateChat::where('nurse_user_id', auth()->id())
            ->where('status', 'unread')
            ->where('client_sent', 'yes')
            ->count();

        return view('dashboard', $data);
    }

    public function getTimeCalendar()
    {
        $nurseId = request()->post('nurse_id');
        $neededDate = request()->post('needed_date');

        $nurse = User::where('id', $nurseId)->first();
        $bookings = Booking::where('nurse_user_id', $nurseId)->whereIn('status', ['approved', 'in_process'])->with('time')->get();

        $workTimePref = json_decode($nurse->entity->work_time_pref, true);

        if (is_null($neededDate)) {
            $searchDate = Carbon::now()->format('Y-m');
        } else {
            $searchDate = Carbon::createFromDate($neededDate)->format('Y-m');
        }
        $month = Carbon::createFromDate($neededDate)->format('m');

        $firstDay = Carbon::createFromDate($searchDate)->subWeek()
            ->format('Y-m-d');
        $lastDay = Carbon::createFromDate($searchDate)->addWeek()
            ->format('Y-m-d');

        $monthLength = Carbon::create($searchDate)->daysInMonth + 14;
        $timeCalendar = [];
        $time_bookings = [];
        for ($i = 0; $i < $monthLength; $i++){
            $current = Carbon::createFromDate($firstDay)->addDays($i)->format('Y-m-d');
            $day = Carbon::createFromDate( $current)->dayName;
            $timeCalendar[$current] = [];
            if(in_array($day, ['Saturday', 'Sunday'])){
                $timeCalendar[$current]['weekends_7_11'] = $workTimePref['weekends_7_11'];
                $timeCalendar[$current]['weekends_11_14'] = $workTimePref['weekends_11_14'];
                $timeCalendar[$current]['weekends_14_17'] = $workTimePref['weekends_14_17'];
                $timeCalendar[$current]['weekends_17_21'] = $workTimePref['weekends_17_21'];
            }else{
                $timeCalendar[$current]['weekdays_7_11'] = $workTimePref['weekdays_7_11'];
                $timeCalendar[$current]['weekdays_11_14'] = $workTimePref['weekdays_11_14'];
                $timeCalendar[$current]['weekdays_14_17'] = $workTimePref['weekdays_14_17'];
                $timeCalendar[$current]['weekdays_17_21'] = $workTimePref['weekdays_17_21'];
            }
        }

        if($bookings->count() > 0) {
            foreach ($bookings as $booking){
                if($booking->one_time_or_regular == 'one') {
                    if(key_exists($booking->start_date, $timeCalendar)){
                        $times = $booking->time->keyBy('time_interval')->keys()->toArray();
                        $time_bookings[$booking->start_date][] = $booking->id;
                        foreach ($times as $time){
                            $timeCalendar[$booking->start_date][$time] = "0";
                        }
                    }
                }

                if($booking->one_time_or_regular == 'regular'){
                    $weekWorkDays = json_decode($booking->days, true);
                    if($booking->weeks > 0) {
                        for($w = 0; $w <= $booking->weeks; $w++) {
                            $startWeekDate = Carbon::createFromDate($booking->start_date)
                                ->addWeeks($w)->format('Y-m-d');

                            for ($d = 0; $d <=6; $d++){
                                $weekDay = Carbon::createFromFormat('Y-m-d', $startWeekDate)
                                    ->addDays($d)->format('Y-m-d');

                                $weekDayName = Carbon::createFromFormat('Y-m-d', $startWeekDate)
                                    ->addDays($d)->dayOfWeek;;
                                if(in_array($weekDayName, $weekWorkDays)){
                                    $times = $booking->time->keyBy('time_interval')->keys()->toArray();
                                    $time_bookings[$weekDay][] = $booking->id;
                                    foreach ($times as $time){
                                        $timeCalendar[$weekDay][$time] = "0";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'time_calendar' => $timeCalendar,
            'time_bookings' => $time_bookings,
        ]);
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
        $nurses = $this->nurseRepo->search($id);
        $nurse = $nurses->first();

        return response()->json(['success' => true, 'user' => NurseResource::make($nurse)]);
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
