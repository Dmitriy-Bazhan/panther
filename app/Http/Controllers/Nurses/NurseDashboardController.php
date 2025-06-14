<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
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

    public function __construct(NurseRepository $nurseRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
    }

    public function index()
    {
        $data = siteData();

        $data['data']['have_not_approved_bookings'] = Booking::where('nurse_user_id', auth()->id())
            ->where('status', 'not_approved')
            ->where('is_verification', 'yes')
            ->first() !== null ? true : false;
        $data['data']['have_new_message'] = PrivateChat::where('nurse_user_id', auth()->id())
            ->where('status', 'unread')
            ->whereNotNull('client_sent')
            ->first() !== null ? true : false;
        $data['data']['last_unread_messages'] = PrivateChat::where('nurse_user_id', auth()->id())
            ->where('status', 'unread')
            ->where('client_sent', 'yes')
            ->orderByDesc('created_at')->get()->groupBy('client_user_id');
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
            $searchDate = Carbon::now()->format('Y-m-d');
        } else {
            $searchDate = Carbon::createFromDate($neededDate)->format('Y-m-d');
        }
        $firstDay = Carbon::createFromFormat('Y-m-d', $searchDate)
            ->firstOfMonth()
            ->format('Y-m-d');
        $lastDay = Carbon::createFromFormat('Y-m-d', $searchDate)
            ->endOfMonth()
            ->format('Y-m-d');

        $monthLength = Carbon::create($searchDate)->daysInMonth;
        $timeCalendar = [];
        for ($i = 0; $i < $monthLength; $i++){
            $current = Carbon::createFromFormat('Y-m-d', $firstDay)->addDays($i)->format('Y-m-d');
            $day = Carbon::createFromFormat('Y-m-d', $current)->dayName;
            $timeCalendar[$current] = [];
//            $timeCalendar[$current]['day'] = $day;
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
                        foreach ($times as $time){
                            $timeCalendar[$booking->start_date][$time] = "0";
                        }
                    }
                }

                if($booking->one_time_or_regular == 'regular'){
                    $weekWorkDays = json_decode($booking->days, true);
                    if($booking->weeks > 0) {
                        for($i = 0; $i <= $booking->weeks; $i++) {
                            $startWeekDate = Carbon::createFromFormat('Y-m-d', $booking->start_date)
                                ->addWeeks($i)->startOfWeek()->format('Y-m-d');
                            for ($d = 0; $d <=6; $d++){
                                $weekDay = Carbon::createFromFormat('Y-m-d', $startWeekDate)
                                    ->addDays($d)->format('Y-m-d');

                                $weekDayName = Carbon::createFromFormat('Y-m-d', $startWeekDate)
                                    ->addDays($d)->dayName;
                                if(in_array($weekDayName, $weekWorkDays) && $firstDay < $weekDay){
                                    $times = $booking->time->keyBy('time_interval')->keys()->toArray();
                                    foreach ($times as $time){
                                        $timeCalendar[$weekDay][$time] = "0";
                                    }
                                }
                                if($weekDay >= $lastDay){
                                    break 2;
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'id' => $nurseId,
            'date' => $neededDate,
            'time_calendar' => $timeCalendar
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
