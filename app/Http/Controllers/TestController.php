<?php

namespace App\Http\Controllers;

use App\Events\TestChatMessage;
use App\Http\Repositories\NurseRepository;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\NurseResource;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\PrivateChat;
use App\Models\User;
use Carbon\Carbon;
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

        $notification = NotificationController::createNotification($target_user_id = 1, $type = 'booking', $content = 'TEst Test');
        dd($notification);

        $chatsUsersIds = Chat::select('id','nurse_user_id', 'client_user_id')->get()->toArray();
        foreach ($chatsUsersIds as $item){
            PrivateChat::where('nurse_user_id', $item['nurse_user_id'])
                ->where('client_user_id',  $item['client_user_id'])
                ->update([
                    'chat_id' => $item['id']
                ]);
        }

        dd('stop');
        $id = null;
        request()->merge([
            'only_full_info' => true
        ]);

        $data['data'] = $this->nurseRepo->search();

        return view('test', $data);
    }

    public function getNurseWorkCalendar($date = '2022-04-01')
    {
        $nurse = User::where('id', 101)->first();
        $bookings = Booking::where('nurse_user_id', 101)->whereIn('status', ['approved', 'in_process'])->with('time')->get();
        dump($bookings);

        $workTimePref = json_decode($nurse->entity->work_time_pref, true);

        if (is_null($date)) {
            $searchDate = Carbon::now()->format('Y-m-d');
        } else {
            $searchDate = Carbon::createFromDate($date)->format('Y-m-d');
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
            $timeCalendar[$current]['day'] = $day;
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

        dump($timeCalendar);
        dump($monthLength, $searchDate);
    }

    public function testSetMessage(Request $request)
    {
        broadcast(new TestChatMessage($request->input('message'), $request->input('user_id'), $request->input('username')));

        return response()->json(['success' => true], 200);

    }

    public function langArrTest()
    {
        return [
            'lang' => 'English',
            'email_wait_verify_text' => 'Thank you for registering, Shortly you will receive an email with the next steps. See you soon on PflegePanther!',
            'you_welcome' => 'Your tegistration has been completed. You can now log in and scarch for your nursc. Welcome on PflegePanther!',
            'society_and_care' => 'Society and care',
            'escort_and_transportation' => 'Escort and transportation',
            'food_and_drinks' => 'Food and drinks',
            'activity_and_exercise' => 'Activity and exercise',
            'housekeeping_and_laundry' => 'Housekeeping and laundry',
            'basic_care' => 'Basic care',
            'purchases_and_errands' => 'Purchases and errands',
            'technical_assistance' => 'Technical assistance',
            'welcome' => 'Welcome',
            'calendar' => 'Calendar',
            'unread_messages' => 'Unread messages',
            'overview' => 'Overview',
            'messages' => 'Messages',
            'ratings' => 'Ratings',
            'bookings' => 'Bookings',
            'payments' => 'Payments',
            'my_information' => 'My information',
            'help_and_service' => 'Help && service',
            'send' => 'Send',
            'mark_as_read' => 'Mark as read',
            'chat_have_unread_messages' => 'Chat have unread messages',
            'chat' => 'Chat',
            'store' => 'Store',
            'yes' => 'Yes',
            'no' => 'No',
            'hourly_payment' => 'Hourly payment',
            'weekend_surcharge' => 'Weekend surcharge',
            'weekend_surcharge_payment' => 'Weekend surcharge payment',
            'holiday_surcharge' => 'Holiday surcharge',
            'holiday_surcharge_payment' => 'Holiday surcharge payment',
            'fare_surcharge' => 'Fare surcharge',
            'fare_surcharge_payment' => 'Fare surcharge payment',
            'prices' => 'Prices',
            'name' => 'Name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'phone' => 'Phone',
            'zip_code' => 'Zip code',
            'gender' => 'Gender',
            'male' => 'Male',
            'female' => 'Female',
            'no_matter' => 'No matter',
            'age' => 'Age',
            'experience' => 'Experience',
            'languages' => 'Languages',
            'english' => 'English',
            'german' => 'German',
            'preference_client_gender' => 'Preference client gender',
            'available_care_range' => 'Available care range',
            'not_sure' => 'Not sure',
            'multiple_bookings' => 'Allow multiple meetings per day',
            'provide_supports' => 'Provide supports',
            'description' => 'Description',
            'additional_info' => 'Additional info',
            'time_calendar' => 'Time calendar',
            'weekdays' => 'Weekdays',
            'weekends' => 'Weekends',
            'mon_fri' => 'Mon-Fri',
            'sat_sun' => 'Sat-Sun',
            'morning' => 'Morning',
            'afternoon' => 'Afternoon',
            'evening' => 'Evening',
            'overnight' => 'Overnight',
            'criminal_record' => 'Criminal record',
            'documentation_of_training' => 'Documentation of training',
            'CPR_course' => 'CPR course',
            'references' => 'References',
            'update' => 'Update',
            'message' => 'Message',
            'price' => 'Price',
            'distance' => 'Distance',
            'send_to_bookings' => 'Send to bookings',
            'how_does_the_booking_process_work_description' => 'When you book a nurse on our site, you specify exactly what you want to book them for.\n' .
                '            That is, you specify your wishes in the areas in which Pflege Panther is active.\n' .
                '            Here you also have the option of specifying whether you prefer a female or a male nurse.\n' .
                '            With another click, your booking request is sent off. Our matching system then searches the database for nurses\n' .
                '            who offer exactly what you are looking for, allowing you to select an individual nurse.\n' .
                '            The matched nurse is informed about your request and asked to accept it. The first nurse who meets your\n' .
                '            requirements and accepts your assignment will contact you by phone. This is usually within 24 hours of your\n' .
                '            booking request.',
            'send_booking_message' => 'Congratulations! We forwarded your request to [name of selected nurse] and will get back ' .
                'to you within 24h',
            'caregiver_finder' => 'Caregiver finder',
            'for_whom' => 'Who are you looking for help for?',
            'to_me' => 'For me',
            'for_a_relative' => 'For a relative',
            'information_about_person' => 'Information about the person in need of care',
            'age_range' => 'Age range',
            'what_support_looking' => 'What kind of support are you looking for',
            'disease' => 'Disease',
            'other_disease' => 'Other disease',
            'is_degree_of_care' => 'Is the degree of care available',
            'language_skills' => 'Language skills',
            'do_you_need_help_moving' => 'Do you need help moving/walking?',
            'unknown' => 'Unknown',
            'additional_transportation' => 'Additional means of transportation?',
            'need_help_with_walking' => 'Need help with walking',
            'wheelchair' => 'Wheelchair',
            'crutches' => 'Crutches',
            'nothing' => 'Nothing',
            'memory' => 'Memory',
            'good' => 'Good',
            'minor_difficulties' => 'Minor difficulties',
            'significant_difficulties' => 'Significant difficulties',
            'incontinence' => 'Suffer from urinary incontinence?',
            'preference_for_the_nurse' => 'Is there a gender preference for the nurse?',
            'hearing' => 'Hearing',
            'weak' => 'Weak',
            'difficulties' => 'Difficulties',
            'essential' => 'Essential',
            'vision' => 'Vision',
            'areas_help' => 'Areas where help is needed',
            'dressing' => 'Dressing',
            'mobility' => 'Mobility',
            'hygiene' => 'Hygiene',
            'preparation_of_medicines' => 'Preparation of medicines',
            'skin_care' => 'Skin care',
            'other_areas' => 'Other areas',
            'one_time_or_regular' => 'One-time or regular',
            'where_should_help_be_provided' => 'Where should help be provided?',
            'hear_about_us_other' => 'Hear about us other',
            'hear_about_us' => 'Hear about us',
            'password_confirm' => 'Password confirm',
            'find' => 'Find',
            'password' => 'Password',
            'nurse_register' => 'Nurse register',
            'client_register' => 'Client register',
            'one_or_regular' => 'One or regular order',
            'regular' => 'Regular',
            'one' => 'One',
            'weekdays_7_11' => 'Weekdays 7-11',
            'weekdays_11_14' => 'Weekdays 11-14',
            'weekdays_14_17' => 'Weekdays 14-17',
            'weekdays_17_21' => 'Weekdays 17-21',
            'weekends_7_11' => 'Weekends 7-11',
            'weekends_11_14' => 'Weekends 11-14',
            'weekends_14_17' => 'Weekends 14-17',
            'weekends_17_21' => 'Weekends 17-21',
            'contact_detail' => 'Contact details',
            'needed_time' => 'Needed time',
            'suggested_price_per_hour' => 'Suggested price per hour',
            'you_have_booking_to_this_nurse' => 'You have booking to this nurse. Want make new?',
            'go_to_my_bookings' => 'Go to my bookings',
        ];
    }
}
