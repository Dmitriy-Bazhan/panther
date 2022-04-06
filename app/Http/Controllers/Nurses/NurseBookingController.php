<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Resources\BookingsResource;
use App\Models\AlternativeBooking;
use App\Models\AlternativeBookingTime;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NurseBookingController extends Controller
{
    public $chatRepo;

    public function __construct(ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
        $nurseId = 0;
        if (request()->filled('nurse_id') && is_numeric(request('nurse_id'))) {
            $nurseId = request('nurse_id');
        }

        if (!User::find($nurseId)) {
            //todo: hmmm
            abort(409);
        }

        $bookings = BookingsResource::collection(Booking::where('nurse_user_id', $nurseId)
            ->where('nurse_is_refuse_booking', 'no')
            ->with('time', 'client', 'alternative')
            ->get());
        return response()->json(['success' => true, 'bookings' => $bookings]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rules = [
            'alternative_days' => 'sometimes',
            'alternative_finish_date' => 'sometimes',
            'alternative_one_time_or_regular' => 'required|in:one,regular',
            'alternative_start_date' => 'required',
            'alternative_suggested_price_per_hour' => 'required|numeric',
            'alternative_time' => 'sometimes',
            'alternative_weeks' => 'sometimes',
            'booking_id' => 'required|numeric',
            'alternative_total' => 'required|numeric',
        ];

        $data = request('alternative');

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        Booking::where('id', $data['booking_id'])->update([
            'have_alternative' => 'yes',
            'agree_for_alternative' => 'no',
        ]);

        AlternativeBooking::where('booking_id', $data['booking_id'])->delete();

        $alternativeBooking = new AlternativeBooking();
        $alternativeBooking->booking_id = $data['booking_id'];
        $alternativeBooking->alternative_suggested_price_per_hour = $data['alternative_suggested_price_per_hour'];
        $alternativeBooking->total = $data['alternative_total'];
        $alternativeBooking->alternative_one_time_or_regular = $data['alternative_one_time_or_regular'];
        $alternativeBooking->alternative_start_date = $data['alternative_start_date'];
        $alternativeBooking->alternative_finish_date = $data['alternative_finish_date'];
        $alternativeBooking->alternative_weeks = $data['alternative_weeks'];
        $alternativeBooking->alternative_days = json_encode($data['alternative_days']);
        $alternativeBooking->comment = $data['comment'];
        $alternativeBooking->save();
        $alternativeBookingId = $alternativeBooking->id;

        foreach ($data['alternative_time']['time_interval'] as $key => $value) {
            $alternativeBookingTime = new AlternativeBookingTime();
            $alternativeBookingTime->alternative_booking_id = $alternativeBookingId;
            $alternativeBookingTime->alternative_time_interval = $key;
            $alternativeBookingTime->alternative_time = $data['alternative_time']['time'][$key];
            $alternativeBookingTime->save();

        }

        return response()->json(['success' => true]);
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
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        //
    }

    public function nurseRefuseBooking()
    {
        $id = request('booking')['id'];

        Booking::where('id', $id)->update(
            [
                'nurse_is_refuse_booking' => 'yes',
                'have_alternative' => 'no',
                'reason_of_refuse_booking' => request('booking')['reason_of_refuse_booking'],
        ]);

        AlternativeBooking::where('booking_id', $id)->delete();

    return response()->json(['success' => true]);
}

    public function getPrivateChat($client_id = null)
    {

        if (is_null($client_id) || !is_numeric($client_id)) {
            //todo: hmm
            abort(409);
        }

        $chat = $this->chatRepo->getNursePrivateChatsWithClients($client_id);
        return response()->json(['success' => true, 'chat' => $chat]);
    }
}
