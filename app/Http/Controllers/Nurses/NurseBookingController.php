<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Repositories\BookingRepository;
use App\Http\Repositories\ChatRepository;
use App\Http\Resources\BookingsResource;
use App\Models\AlternativeBooking;
use App\Models\AlternativeBookingTime;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NurseBookingController extends Controller
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
        $nurseId = 0;
        if (request()->filled('nurse_id') && is_numeric(request('nurse_id'))) {
            $nurseId = request('nurse_id');
        }

        if (!User::find($nurseId)) {
            //todo: hmmm
            Log::channel('app_logs')->error('Nurse with this id not exists in NurseBookingController::index');
            abort(409, 'Nurse with this id not exists');
        }

        request()->merge([
            'nurse_is_refuse_booking' => 'no',
            'is_verification' => 'yes'
        ]);

        $notApprovedBookings = BookingsResource::collection($this->bookingRepo->search(null, 'not_approved'))->response()->getData();
        $approvedBookings = BookingsResource::collection($this->bookingRepo->search(null, 'approved'))->response()->getData();
        $inProcessBookings = BookingsResource::collection($this->bookingRepo->search(null, 'in_process'))->response()->getData();
        $endedBookings = BookingsResource::collection($this->bookingRepo->search(null, 'ended'))->response()->getData();

        return response()->json([
            'success' => true,
            'notApprovedBookings' => $notApprovedBookings,
            'approvedBookings' => $approvedBookings,
            'inProcessBookings' => $inProcessBookings,
            'endedBookings' => $endedBookings,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'days' => 'sometimes',
            'finish_date' => 'sometimes',
            'one_time_or_regular' => 'required|in:one,regular',
            'start_date' => 'required',
            'suggested_price_per_hour' => 'required|numeric',
            'time' => 'sometimes',
            'weeks' => 'sometimes',
            'id' => 'required|numeric',
            'total' => 'required|numeric',
        ];

        $data = request('alternative');

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        Booking::where('id', $data['id'])->update([
            'have_alternative' => 'yes',
            'agree_for_alternative' => 'no',
        ]);

        AlternativeBooking::where('booking_id', $data['id'])->delete();

        if($data['one_time_or_regular'] === 'one'){
            $alternativeBooking = new AlternativeBooking();
            $alternativeBooking->booking_id = $data['id'];
            $alternativeBooking->alternative_suggested_price_per_hour = $data['suggested_price_per_hour'];
            $alternativeBooking->total = $data['total'];
            $alternativeBooking->alternative_one_time_or_regular = $data['one_time_or_regular'];
            $alternativeBooking->alternative_start_date = $data['start_date'];
            $alternativeBooking->alternative_finish_date = $data['start_date'];
            $alternativeBooking->alternative_weeks = 0;
            $alternativeBooking->alternative_days = json_encode([]);
            $alternativeBooking->comment = $data['comment'];
            $alternativeBooking->save();
            $alternativeBookingId = $alternativeBooking->id;

            foreach ($data['week_days_checked'] as $value) {
                $alternativeBookingTime = new AlternativeBookingTime();
                $alternativeBookingTime->alternative_booking_id = $alternativeBookingId;
                $alternativeBookingTime->alternative_time_interval = $value['id'];
                $alternativeBookingTime->alternative_time = $value['val'];
                $alternativeBookingTime->save();
            }

            foreach ($data['week_ends_checked'] as $value) {
                $alternativeBookingTime = new AlternativeBookingTime();
                $alternativeBookingTime->alternative_booking_id = $alternativeBookingId;
                $alternativeBookingTime->alternative_time_interval = $value['id'];
                $alternativeBookingTime->alternative_time = $value['val'];
                $alternativeBookingTime->save();
            }
        }

        if($data['one_time_or_regular'] === 'regular'){
            $alternativeBooking = new AlternativeBooking();
            $alternativeBooking->booking_id = $data['id'];
            $alternativeBooking->alternative_suggested_price_per_hour = $data['suggested_price_per_hour'];
            $alternativeBooking->total = $data['total'];
            $alternativeBooking->alternative_one_time_or_regular = $data['one_time_or_regular'];
            $alternativeBooking->alternative_start_date = $data['start_date'];
            $alternativeBooking->alternative_finish_date = $data['finish_date'];
            $alternativeBooking->alternative_weeks = $data['weeks'];
            $alternativeBooking->alternative_days = json_encode($data['days']);
            $alternativeBooking->comment = $data['comment'];
            $alternativeBooking->save();
            $alternativeBookingId = $alternativeBooking->id;

            if (in_array(1, $data['days']) || in_array(2, $data['days'])
                || in_array(3, $data['days']) || in_array(4, $data['days']) || in_array(5, $data['days'])) {
                foreach ($data['week_days_checked'] as $value) {
                    $alternativeBookingTime = new AlternativeBookingTime();
                    $alternativeBookingTime->alternative_booking_id = $alternativeBookingId;
                    $alternativeBookingTime->alternative_time_interval = $value['id'];
                    $alternativeBookingTime->alternative_time = $value['val'];
                    $alternativeBookingTime->save();

                }
            }

            if (in_array(0, $data['days']) || in_array(6, $data['days'])) {
                foreach ($data['week_ends_checked'] as $value) {
                    $alternativeBookingTime = new AlternativeBookingTime();
                    $alternativeBookingTime->alternative_booking_id = $alternativeBookingId;
                    $alternativeBookingTime->alternative_time_interval = $value['id'];
                    $alternativeBookingTime->alternative_time = $value['val'];
                    $alternativeBookingTime->save();

                }
            }
        }

        $booking = Booking::find( $data['id']);
        $content = 'Nurse make alternative for your booking from ' . $booking->start_date;
        NotificationController::createNotification($booking->client_user_id, 'booking', $content);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $bookings = $this->bookingRepo->search($id);
        $booking = BookingsResource::make($bookings->first());
        return response()->json(['success' => true, 'booking' => $booking]);
    }

    //nurse approve booking
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            //todo: hmm
            return abort(409);
        }

        if (!$booking = Booking::find($id)) {
            //todo: hmm
            return abort(409);
        }
        $booking->status = 'approved';
        $booking->hourly_price = $booking->suggested_price_per_hour;
        $booking->save();

        $content = 'Nurse approve your booking from ' . $booking->start_date;
        NotificationController::createNotification($booking->client_user_id, 'booking', $content);

        return response()->json(['success' => true]);
    }

    public function nurseRefuseBooking()
    {
        $id = request('booking')['id'];

        if (!is_numeric($id)) {
            return response()->json(['success' => false]);
        }

        if (!$booking = Booking::find($id)) {
            return response()->json(['success' => false]);
        }

        Booking::where('id', $id)->update(
            [
                'nurse_is_refuse_booking' => 'yes',
                'have_alternative' => 'no',
                'reason_of_refuse_booking' => request('booking')['reason_of_refuse_booking'],
            ]);

        if ($payment = Payment::where('booking_id', $id)->first()) {
            $payment->status = 'break';
            $payment->save();
        }

        AlternativeBooking::where('booking_id', $id)->delete();

        $content = 'Nurse refuse your booking from ' . $booking->start_date;
        NotificationController::createNotification($booking->client_user_id, 'booking', $content);

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
