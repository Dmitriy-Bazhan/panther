<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\BookingTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class AddBookingsForTesting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:add-booking-for-testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(App::environment('local')){
            $status = ['not_approved','approved','in_process','ended'];


            //one time
            for($i = 0; $i < 25; $i++) {
                $start_date = Carbon::now()->subWeeks(rand(1, 10))->format('Y-m-d');
                $price = rand(20, 50);
                $booking = Booking::create([
                    'nurse_user_id' => 101,
                    'client_user_id' => 100,
                    'hourly_price' => $price,
                    'suggested_price_per_hour' => $price,
                    'status' => $status[rand(0,3)],
                    'is_verification' => 'yes',
                    'one_time_or_regular' => 'one',
                    'total' => $price * 3,
                    'start_date' => $start_date,
                    'finish_date' => $start_date,
                    'weeks' => 0,
                    'days' => json_encode([]),
                ]);

                BookingTime::create([
                    'booking_id' => $booking->id,
                    'time_interval' => 'weekdays_7_11',
                    'time' => '7:00 - 8:00',
                ]);

                BookingTime::create([
                    'booking_id' => $booking->id,
                    'time_interval' => 'weekdays_7_11',
                    'time' => '8:00 - 9:00',
                ]);

                BookingTime::create([
                    'booking_id' => $booking->id,
                    'time_interval' => 'weekdays_7_11',
                    'time' => '9:00 - 10:00',
                ]);
            }

            //regular
            for($i = 0; $i < 25; $i++) {
                $start_date = Carbon::now()->subWeeks(rand(1, 10))->format('Y-m-d');
                $price = rand(20, 50);
                $week = rand(1,8);
                $booking = Booking::create([
                    'nurse_user_id' => 101,
                    'client_user_id' => 100,
                    'hourly_price' => $price,
                    'suggested_price_per_hour' => $price,
                    'status' => $status[rand(0,3)],
                    'is_verification' => 'yes',
                    'one_time_or_regular' => 'regular',
                    'total' => $price * 3 * $week * 2,
                    'start_date' => $start_date,
                    'finish_date' => Carbon::createFromDate($start_date)->addWeeks($week)->format('Y-m-d'),
                    'weeks' => $week,
                    'days' => json_encode([1,2]),
                ]);

                BookingTime::create([
                    'booking_id' => $booking->id,
                    'time_interval' => 'weekdays_7_11',
                    'time' => '7:00 - 8:00',
                ]);

                BookingTime::create([
                    'booking_id' => $booking->id,
                    'time_interval' => 'weekdays_7_11',
                    'time' => '8:00 - 9:00',
                ]);

                BookingTime::create([
                    'booking_id' => $booking->id,
                    'time_interval' => 'weekdays_7_11',
                    'time' => '9:00 - 10:00',
                ]);
            }
        }

        return 0;
    }
}
