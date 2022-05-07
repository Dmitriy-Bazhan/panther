<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    /*
    * 0 weekdays_morning
    * 1 weekdays_afternoon
    * 2 weekdays_evening
    * 3 weekdays_overnight
    * 4 weekends_morning
    * 5 weekends_afternoon
    * 6 weekends_evening
    * 7 weekends_overnight
     *
     * "weekdays_morning" : "0",
        "weekdays_afternoon" : "0",
        "weekdays_evening" : "0",
        "weekdays_overnight" : "0",
        "weekends_morning" : "0",
        "weekends_afternoon" : "0",
        "weekends_evening" : "0",
        "weekends_overnight" : "0"
    */

    /*
      7-11 Uhr;
    • 11-14 Uhr;
    • 14-17 Uhr;
    • 17-21 Uhr
    */

    protected $attributes = [
        'work_time_pref' => '{
        "weekdays_7_11" : "0",
        "weekdays_11_14" : "0",
        "weekdays_14_17" : "0",
        "weekdays_17_21" : "0",
        "weekends_7_11" : "0",
        "weekends_11_14" : "0",
        "weekends_14_17" : "0",
        "weekends_17_21" : "0"
        }',
    ];


    protected $with = [
        'provideSupports',
        'languages',
        'files',
        'additionalInfo',
        'price',
        'typeOfLearning'
    ];

    public function users()
    {
        return $this->morphMany(User::class, 'entity');
    }

    public function user()
    {
        return $this->morphOne(User::class, 'entity');
    }

    public function languages()
    {
        return $this->hasMany('App\Models\NurseLang', 'nurse_id', 'id');
    }

    public function files()
    {
        return $this->hasMany('App\Models\NurseFile', 'nurse_id', 'id');
    }

    public function price(){
        return $this->hasOne('App\Models\NursePrice', 'nurse_id', 'id');
    }

    public function additionalInfo()
    {
        return $this->hasManyThrough(
            'App\Models\AdditionalInfo',
            'App\Models\AdditionalInfoAssigned',
            'nurse_id',
            'id',
            'id',
            'additional_info_id');
    }

    public function provideSupports()
    {
        return $this->hasManyThrough(
            'App\Models\ProvideSupport',
            'App\Models\ProvideSupportAssigned',
            'nurse_id',                                  //from ProvideSupportAssigned
            'id',                                     //from App\Models\ProvideSupport
            'id',                                       //from nurse
            'support_id');                        //from ProvideSupportAssigned
    }

    public function typeOfLearning() {
        return $this->hasOne('App\Models\TypesOfLearning', 'id', 'type_of_learning')
            ->with('data');
    }
}
