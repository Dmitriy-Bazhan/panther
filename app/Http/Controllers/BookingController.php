<?php

namespace App\Http\Controllers;

use App\Http\Repositories\NurseRepository;
use App\Models\AdditionalInfo;
use App\Models\Booking;
use App\Models\BookingTime;
use App\Models\ProvideSupport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public $nurseRepo;

    public function __construct(NurseRepository $nurseRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
    }

    public function index()
    {
//        $data = [];
//        if (auth()->check()) {
//            $data['data']['provider_supports'] = ProvideSupport::all();
//            $data['data']['additional_info'] = AdditionalInfo::with('data')->get();
//        }
//        return view('main', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if(!request()->filled('nurse_user_id') || !is_numeric(request('nurse_user_id'))){
            //todo:hmm
            abort(409);
        }

        if(!User::find(request('nurse_user_id'))){
            //todo:hmm
            abort(409);
        }

        if(!request()->filled('one_time_or_regular') || !in_array(request('one_time_or_regular'),['one_time', 'regular'])){
            //todo:hmm
            abort(409);
        }

        if(request('one_time_or_regular') == 'one_time') {
            $rules = [
                'date' => 'required',
                'suggested_price_per_hour' => 'required|numeric|min:10',
                'time' => 'required',
                'time_interval' => 'required'
            ];

            $validator = Validator::make(request('booking'), $rules);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()]);
            }

            $booking = new Booking();
            $booking->nurse_user_id = request('nurse_user_id');
            $booking->client_user_id = auth()->id();
            $booking->suggested_price_per_hour = request('booking')['suggested_price_per_hour'];
            $booking->one_time_or_regular = 'one_time';
            $booking->start_date = request('date');
            $booking->save();
            $bookingId = $booking->id;

            foreach (request('booking')['time_interval'] as $key => $value) {
                $bookingTime = new BookingTime();
                $bookingTime->booking_id = $bookingId;
                $bookingTime->time_interval = $key;
                $bookingTime->time = request('booking')['time'][$key];
                $bookingTime->save();

            }
        }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $data = [];
        if (auth()->check()) {
            $data['data']['provider_supports'] = ProvideSupport::all();
            $data['data']['additional_info'] = AdditionalInfo::with('data')->get();
        }

        $nurses = $this->nurseRepo->search($id);
        $data['data']['nurse'] = $nurses->first();
        $data['data']['have_booking'] = false;

        if(Booking::where('client_user_id', auth()->id())->where('nurse_user_id', $id)->first()){
            $data['data']['have_booking'] = true;
        }

        return view('main', $data);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        //
    }
}
