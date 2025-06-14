<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

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
//        'provideSupports',
//        'languages',
//        'files',
//        'additionalInfo',
//        'price',
//        'typeOfLearning'
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
        return $this->hasOne('App\Models\TypesOfLearning', 'id', 'type_of_learning');
    }
}
