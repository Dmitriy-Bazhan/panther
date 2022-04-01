<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Resources\BookingsResource;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\AlternativeBooking;
use App\Models\Booking;
use App\Models\BookingTime;
use App\Models\PrivateChat;
use App\Models\ProvideSupport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientBookingsController extends Controller
{
    public $chatRepo;

    public function __construct(ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
        $clientId = 0;
        if(request()->filled('client_id') && is_numeric(request('client_id'))){
            $clientId = request('client_id');
        }

        if(!User::find($clientId)){
            //todo: hmmm
            abort(409);
        }

        $bookings = BookingsResource::collection(Booking::where('client_user_id', $clientId)
            ->with('time', 'nurse', 'alternative.time')
            ->get());
        return response()->json(['success' => true, 'bookings' => $bookings]);
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

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        if(!is_numeric($id) || !Booking::find($id)){
            //todo:hmm
            abort(409);
        }

        $data = request('booking');

        if(!in_array($data['one_time_or_regular'], ['one', 'regular'])) {
            //todo:hmm
            abort(409);
        }

        if($data['one_time_or_regular'] == 'one') {
            $rules = [
                'start_date' => 'required',
                'suggested_price_per_hour' => 'required|numeric|min:10',
                'time' => 'required',
                'total' => 'required|numeric|min:10',
                'additional_email' => 'sometimes|nullable|email',
                'comment' => 'sometimes',
            ];

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()]);
            }


            Booking::where('id', $id)->update([
                'suggested_price_per_hour' => $data['suggested_price_per_hour'],
                'total' => $data['total'],
                'one_time_or_regular' => $data['one_time_or_regular'],
                'days' => json_encode([]),
                'weeks' => 1,
                'start_date' => $data['start_date'],
                'additional_email' => $data['additional_email'],
                'comment' => $data['comment'],
            ]);

            BookingTime::where('booking_id', $id)->delete();

            foreach ($data['new_time']['time_interval'] as $key => $value) {
                $bookingTime = new BookingTime();
                $bookingTime->booking_id = $id;
                $bookingTime->time_interval = $key;
                $bookingTime->time = $data['new_time']['time'][$key];
                $bookingTime->save();

            }
        }

        if($data['one_time_or_regular'] == 'regular') {
            $rules = [
                'start_date' => 'required',
                'suggested_price_per_hour' => 'required|numeric|min:10',
                'days.*' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'weeks' => 'required|min:1',
                'total' => 'required|numeric|min:10',
                'time' => 'required',
                'additional_email' => 'sometimes|nullable|email',
                'comment' => 'sometimes',
            ];

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()]);
            }

            Booking::where('id', $id)->update([
                'suggested_price_per_hour' => $data['suggested_price_per_hour'],
                'total' => $data['total'],
                'one_time_or_regular' => $data['one_time_or_regular'],
                'days' => json_encode($data['days']),
                'weeks' => $data['weeks'],
                'start_date' => $data['start_date'],
                'additional_email' => $data['additional_email'],
                'comment' => $data['comment'],
            ]);

            BookingTime::where('booking_id', $id)->delete();
            foreach ($data['new_time']['time_interval'] as $key => $value) {
                $bookingTime = new BookingTime();
                $bookingTime->booking_id = $id;
                $bookingTime->time_interval = $key;
                $bookingTime->time = $data['new_time']['time'][$key];
                $bookingTime->save();

            }
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        if(is_null($id) || !is_numeric($id)){
            //todo:hmm
            abort(409);
        }

        if(!Booking::where('id', $id)->delete()){
            //todo:hmm
            abort(409);
        }

        return response()->json(['success' => true ]);
    }

    public function agreeWithAlternative($id){

        if(!is_numeric($id) || !Booking::find($id)){
            //todo: hmm
            abort(409);
        }

        if(!$alternative = AlternativeBooking::where('booking_id', $id)->with('time')->first()){
            //todo: hmm
            abort(409);
        }

        Booking::where('id', $id)->update([
            'suggested_price_per_hour' => $alternative->alternative_suggested_price_per_hour,
            'total' => $alternative->total,
            'one_time_or_regular' => $alternative->alternative_one_time_or_regular,
            'days' => $alternative->alternative_days,
            'weeks' => $alternative->alternative_weeks,
            'start_date' => $alternative->alternative_start_date,
            'additional_email' => $alternative->alternative_additional_email,
            'comment' => $alternative->comment,
            'have_alternative' => 'no',
            'agree_for_alternative' => 'yes',
        ]);

        BookingTime::where('booking_id', $id)->delete();
        foreach ($alternative->time as $value) {
            $bookingTime = new BookingTime();
            $bookingTime->booking_id = $id;
            $bookingTime->time_interval = $value->alternative_time_interval;
            $bookingTime->time = $value->alternative_time;
            $bookingTime->save();

        }

        AlternativeBooking::where('booking_id', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function getPrivateChat($nurse_id = null){

        if(is_null($nurse_id) || !is_numeric($nurse_id)){
            //todo: hmm
            abort(409);
        }

        $chat = $this->chatRepo->getClientPrivateChatsWithNurse($nurse_id);
        return response()->json(['success'=> true, 'chat' => $chat]);
    }
}
