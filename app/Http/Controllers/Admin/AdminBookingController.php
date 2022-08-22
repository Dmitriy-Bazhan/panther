<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BookingRepository;
use App\Http\Resources\BookingsResource;
use App\Models\Booking;
use App\Models\BookingTime;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminBookingController extends Controller
{
    public $bookingRepo;

    public function __construct(BookingRepository $bookingRepo)
    {
        parent::__construct();

        $this->bookingRepo = $bookingRepo;
    }

    public function index()
    {
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
        return response()->json(['success' => true]);
    }
}
