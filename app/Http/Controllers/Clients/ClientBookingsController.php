<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Repositories\BookingRepository;
use App\Http\Repositories\ChatRepository;
use App\Http\Resources\BookingsResource;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\AlternativeBooking;
use App\Models\Booking;
use App\Models\BookingTime;
use App\Models\Payment;
use App\Models\PrivateChat;
use App\Models\ProvideSupport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientBookingsController extends Controller
{
    public $chatRepo;
    public $bookingRepo;

    public function __construct(ChatRepository $chatRepo, BookingRepository $bookingRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
        $this->bookingRepo = $bookingRepo;
    }

    public function index()
    {
        if (request()->filled('client_id') && is_numeric(request('client_id'))) {
            if (!User::find(request('client_id'))) {
                //todo: hmmm
                abort(409);
            }
        }

        $status = request('status');
        $id = request()->filled('id') && is_numeric(request('id')) ? request('id') : null;

        if($status){
            $bookings = BookingsResource::collection($this->bookingRepo->search($id, $status))->response()->getData();
        }else{
            $bookings = BookingsResource::collection($this->bookingRepo->search($id))->response()->getData();
        }
        return response()->json([
            'success' => true,
            'booking' => $bookings,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!is_numeric($id) || !Booking::find($id)) {
            //todo:hmm
            abort(409);
        }

        $data = request('booking');

        if (!in_array($data['one_time_or_regular'], ['one', 'regular'])) {
            //todo:hmm
            abort(409);
        }

        if ($data['one_time_or_regular'] == 'one') {
            $rules = [
                'start_date' => 'required',
                'suggested_price_per_hour' => 'required|numeric|min:10',
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
                'weeks' => 0,
                'start_date' => $data['start_date'],
                'additional_email' => $data['additional_email'],
                'comment' => $data['comment'],
            ]);

            BookingTime::where('booking_id', $id)->delete();

            foreach ($data['week_days_checked'] as $value) {
                $bookingTime = new BookingTime();
                $bookingTime->booking_id = $id;
                $bookingTime->time_interval = $value['id'];
                $bookingTime->time = $value['val'];
                $bookingTime->save();
            }

            foreach ($data['week_ends_checked'] as $value) {
                $bookingTime = new BookingTime();
                $bookingTime->booking_id = $id;
                $bookingTime->time_interval = $value['id'];
                $bookingTime->time = $value['val'];
                $bookingTime->save();
            }

        }

        if ($data['one_time_or_regular'] == 'regular') {
            $rules = [
                'start_date' => 'required',
                'suggested_price_per_hour' => 'required|numeric|min:10',
                'days.*' => 'required|in:0,1,2,3,4,5,6',
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
            if (in_array(1, $data['days']) || in_array(2, $data['days'])
                || in_array(3, $data['days']) || in_array(4, $data['days']) || in_array(5, $data['days'])) {
                foreach ($data['week_days_checked'] as $value) {
                    $bookingTime = new BookingTime();
                    $bookingTime->booking_id = $id;
                    $bookingTime->time_interval = $value['id'];
                    $bookingTime->time = $value['val'];
                    $bookingTime->save();

                }
            }

            if (in_array(0, $data['days']) || in_array(6, $data['days'])) {
                foreach ($data['week_ends_checked'] as $value) {
                    $bookingTime = new BookingTime();
                    $bookingTime->booking_id = $id;
                    $bookingTime->time_interval = $value['id'];
                    $bookingTime->time = $value['val'];
                    $bookingTime->save();

                }
            }
        }

        Payment::where('booking_id', $id)->update([
            'sum' => $data['total']
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        if (is_null($id) || !is_numeric($id)) {
            //todo:hmm
            abort(409);
        }

        if (!Booking::where('id', $id)->delete()) {
            //todo:hmm
            abort(409);
        }

        Payment::where('booking_id', $id)->update(['status' => 'refuse']);
//        if (!Payment::where('booking_id', $id)->update(['status' => 'refuse'])) {
//            //todo:hmm
//            abort(409);
//        }

        return response()->json(['success' => true]);
    }

    public function sendBookingAgain($id)
    {
        if (!is_numeric($id) && !Booking::where('id', $id)->first()) {
            abort(409);
        }


        Booking::where('id', $id)->update([
            'nurse_is_refuse_booking' => 'no',
            'reason_of_refuse_booking' => null,
            'agree_for_alternative' => 'no',
            'have_alternative' => 'no',
        ]);

        return response()->json(['success' => true]);
    }

    public function agreeWithAlternative($id)
    {
        if (!is_numeric($id) || !Booking::find($id)) {
            //todo: hmm
            abort(409);
        }

        if (!$alternative = AlternativeBooking::where('booking_id', $id)->with('time')->first()) {
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

        Payment::where('booking_id', $id)->update([
            'sum' => $alternative->total
        ]);

        AlternativeBooking::where('booking_id', $id)->delete();

        $booking = Booking::find($id);
        $content = 'Client approve alternative for booking from ' . $booking->start_date;
        try {
            NotificationController::createNotification($booking->client_user_id, 'booking', $content, $booking->id);
        } catch (\Exception $exception) {

        }

        return response()->json(['success' => true]);
    }

    public function getPrivateChat($nurse_id = null)
    {
        if (is_null($nurse_id) || !is_numeric($nurse_id)) {
            //todo: hmm
            abort(409);
        }

        $chat = $this->chatRepo->getClientPrivateChatsWithNurse($nurse_id);
        return response()->json(['success' => true, 'chat' => $chat]);
    }

}
