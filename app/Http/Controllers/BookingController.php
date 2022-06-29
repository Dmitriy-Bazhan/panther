<?php

namespace App\Http\Controllers;

use App\Http\Repositories\NurseRepository;
use App\Mail\ClientVerificationBookingMail;
use App\Mail\SendNurseNewBookingMail;
use App\Models\AdditionalInfo;
use App\Models\Booking;
use App\Models\BookingTime;
use App\Models\Lang;
use App\Models\Payment;
use App\Models\ProvideSupport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!request()->filled('nurse_user_id') || !is_numeric(request('nurse_user_id'))) {
            //todo:hmm
            abort(409);
        }

        if (!User::find(request('nurse_user_id'))) {
            //todo:hmm
            abort(409);
        }

        if (!request()->filled('one_time_or_regular') || !in_array(request('one_time_or_regular'), ['one', 'regular'])) {
            //todo:hmm
            abort(409);
        }

        if (request('one_time_or_regular') == 'one') {
            $rules = [
                'date' => 'required',
                'suggested_price_per_hour' => 'required|numeric|min:10',
                'time' => 'required',
                'total' => 'required|numeric|min:10',
                'time_interval' => 'required',
                'additional_email' => 'sometimes|nullable|email',
                'comment' => 'sometimes',
            ];

            $validator = Validator::make(request('booking'), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()]);
            }

            $booking = Booking::create([
                'nurse_user_id' => request('nurse_user_id'),
                'client_user_id' => auth()->id(),
                'suggested_price_per_hour' => request('booking')['suggested_price_per_hour'],
                'total' => request('booking')['total'],
                'one_time_or_regular' => 'one',
                'days' => json_encode([]),
                'weeks' => 0,
                'start_date' => Carbon::createFromDate(request('booking')['date'])->format('Y-m-d'),
                'finish_date' => Carbon::createFromDate(request('booking')['date'])->format('Y-m-d'),
                'additional_email' => request('booking')['additional_email'],
                'comment' => request('booking')['comment'],
                'client_fullname' => request('booking')['fullname'],
                'client_phone' => request('booking')['client_phone'],
            ]);
            $bookingId = $booking->id;

            foreach (request('booking')['time'] as $value) {
                BookingTime::create([
                    'booking_id' => $bookingId,
                    'time_interval' => $value['id'],
                    'time' => $value['val'],
                ]);
            }
        }

        if (request('one_time_or_regular') == 'regular') {
            $rules = [
                'date' => 'required',
                'suggested_price_per_hour' => 'required|numeric|min:10',
                'days.*' => 'required|in:0,1,2,3,4,5,6',
                'weeks' => 'required|min:1',
                'total' => 'required|numeric|min:10',
                'time' => 'required',
                'time_interval' => 'required',
                'additional_email' => 'sometimes|nullable|email',
                'comment' => 'sometimes',
            ];

            $validator = Validator::make(request('booking'), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()]);
            }

            $booking = Booking::create([
                'nurse_user_id' => request('nurse_user_id'),
                'client_user_id' => auth()->id(),
                'suggested_price_per_hour' => request('booking')['suggested_price_per_hour'],
                'total' => request('booking')['total'],
                'one_time_or_regular' => 'regular',
                'days' => json_encode(request('booking')['days']),
                'weeks' => request('booking')['weeks'],
                'start_date' => Carbon::createFromDate(request('booking')['date'])->format('Y-m-d'),
                'finish_date' => Carbon::createFromDate(request('booking')['date'])->addRealWeeks(request('booking')['weeks'])->format('Y-m-d'),
                'additional_email' => request('booking')['additional_email'],
                'comment' => request('booking')['comment'],
                'client_fullname' => request('booking')['fullname'],
                'client_phone' => request('booking')['client_phone'],
            ]);
            $bookingId = $booking->id;

            foreach (request('booking')['time'] as $value) {
                BookingTime::create([
                    'booking_id' => $bookingId,
                    'time_interval' => $value['id'],
                    'time' => $value['val'],
                ]);
            }
        }

        $nurse = User::find(request('nurse_user_id'));
        $client = auth()->user();

        if (env('MAIL_USE_QUEUE')) {
            Mail::mailer('smtp')->to($client->email)
                ->queue(new ClientVerificationBookingMail($booking, $nurse, $client));
        } else {
            Mail::mailer('smtp')->to($client->email)
                ->send(new ClientVerificationBookingMail($booking, $nurse, $client));
        }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $data = siteData();
        $nurses = $this->nurseRepo->search($id);
        $data['data']['nurse'] = $nurses->first();
        $data['data']['have_booking'] = false;

        if (Booking::where('client_user_id', auth()->id())->where('nurse_user_id', $id)->first()) {
            $data['data']['have_booking'] = true;
        }

        return view('main', $data);
    }

    public function clientVerificationBooking($bookingId, $clientId)
    {
        if (!is_numeric($bookingId) || !is_numeric($clientId)) {
            //todo::hmm
            abort(409);
        }

        if (!$booking = Booking::where('id', $bookingId)->where('client_user_id', $clientId)
            ->with('time', 'client', 'nurse', 'alternative')->first()) {
            return redirect('/booking-not-exists');
        }

        $nurse = $booking->nurse;
        $client = $booking->client;

        $booking->is_verification = 'yes';
        $booking->save();

        if (!$payment = Payment::where('booking_id', $booking->id)->first()) {
            Payment::create([
                'booking_id' => $booking->id,
                'client_user_id' => $booking->client->id,
                'nurse_user_id' => $booking->nurse->id,
                'date' => $booking->start_date,
                'sum' => $booking->total,
                'status' => 'wait',
            ]);
        }

        app()->setLocale($nurse->prefs->pref_lang);

        if (env('MAIL_USE_QUEUE')) {
            Mail::mailer('smtp')->to($nurse->email)
                ->queue(new SendNurseNewBookingMail($nurse, $client));
        } else {
            Mail::mailer('smtp')->to($nurse->email)
                ->send(new SendNurseNewBookingMail($nurse, $client));
        }

        return redirect('/booking-verify');
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
