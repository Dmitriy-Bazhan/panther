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
use App\Models\User;
use Carbon\Carbon;
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

    public function getTimeCalendar()
    {
        $client_id = request()->post('client_id');
        $neededDate = request()->post('needed_date');

        $bookings = Booking::where('client_user_id', $client_id)->whereIn('status', ['approved', 'in_process'])->with('time')->get();

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
            $current = Carbon::createFromFormat('Y-m-d', $firstDay)->addDays($i)->format('Y-m-d');
            $day = Carbon::createFromFormat('Y-m-d', $current)->dayName;
            $timeCalendar[$current] = [];
            if(in_array($day, ['Saturday', 'Sunday'])){
                $timeCalendar[$current]['weekends_7_11'] = '1';
                $timeCalendar[$current]['weekends_11_14'] = '1';
                $timeCalendar[$current]['weekends_14_17'] = '1';
                $timeCalendar[$current]['weekends_17_21'] = '1';
            }else{
                $timeCalendar[$current]['weekdays_7_11'] = '1';
                $timeCalendar[$current]['weekdays_11_14'] = '1';
                $timeCalendar[$current]['weekdays_14_17'] = '1';
                $timeCalendar[$current]['weekdays_17_21'] = '1';
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
                            $startWeekDate = Carbon::createFromFormat('Y-m-d', $booking->start_date)
                                ->addWeeks($w)->format('Y-m-d');

                            for ($d = 0; $d <=6; $d++){
                                $weekDay = Carbon::createFromFormat('Y-m-d', $startWeekDate)
                                    ->addDays($d)->format('Y-m-d');

                                $weekDayName = Carbon::createFromFormat('Y-m-d', $startWeekDate)
                                    ->addDays($d)->dayOfWeek;;
                                if(in_array($weekDayName, $weekWorkDays) && $firstDay < $weekDay){
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
}
