<?php

namespace App\Console\Commands;

use App\Models\TimeInterval;
use Illuminate\Console\Command;

class SetDefaultTimeInterval extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:time_interval';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set default value in table time_intervals';

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
        TimeInterval::truncate();

        $arr = [
            "weekdays_7_11" => [
                'interval' => '7:00-11:00',
                'start' => 7,
                'end' => 11,
                'type' => 'weekdays',
                'value' => ['7:00-8:00', '8:00-9:00', '9:00-10:00', '10:00-11:00'],
            ],
            "weekdays_11_14" => [
                'interval' => '11:00-14:00',
                'start' => 11,
                'end' => 14,
                'type' => 'weekdays',
                'value' => ['11:00-12:00', '12:00-13:00', '13:00-14:00'],
            ],
            "weekdays_14_17" => [
                'interval' => '14:00-17:00',
                'start' => 14,
                'end' => 17,
                'type' => 'weekdays',
                'value' => ['14:00-15:00', '15:00-16:00', '16:00-17:00'],
            ],
            "weekdays_17_21" => [
                'interval' => '17:00-21:00',
                'start' => 17,
                'end' => 21,
                'type' => 'weekdays',
                'value' => ['17:00-18:00', '18:00-19:00', '19:00-20:00', '20:00-21:00'],
            ],
            "weekends_7_11" => [
                'interval' => '7:00-11:00',
                'start' => 7,
                'end' => 11,
                'type' => 'weekends',
                'value' => ['7:00-8:00', '8:00-9:00', '9:00-10:00', '10:00-11:00'],
            ],
            "weekends_11_14" => [
                'interval' => '11:00-14:00',
                'start' => 11,
                'end' => 14,
                'type' => 'weekends',
                'value' => ['11:00-12:00', '12:00-13:00', '13:00-14:00'],
            ],
            "weekends_14_17" => [
                'interval' => '14:00-17:00',
                'start' => 14,
                'end' => 17,
                'type' => 'weekends',
                'value' => ['14:00-15:00', '15:00-16:00', '16:00-17:00'],
            ],
            "weekends_17_21" => [
                'interval' => '17:00-21:00',
                'start' => 17,
                'end' => 21,
                'type' => 'weekends',
                'value' => ['17:00-18:00', '18:00-19:00', '19:00-20:00', '20:00-21:00'],
            ],
        ];

        foreach ($arr as $key => $item){
            $timeInterval = new TimeInterval();
            $timeInterval->id = $key;
            $timeInterval->interval = $item['interval'];
            $timeInterval->start = $item['start'];
            $timeInterval->end = $item['end'];
            $timeInterval->type = $item['type'];
            $timeInterval->value = json_encode($item['value']);
            $timeInterval->save();

        }

        return 0;
    }
}
