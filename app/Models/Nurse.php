<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $with = [
        'provideSupports',
        'languages'
    ];

    public function users()
    {
        return $this->morphMany(User::class, 'entity');
    }

    public function user()
    {
        return $this->morphOne(User::class, 'entity');
    }

    public function languages(){
        return $this->hasMany('App\Models\NurseLang', 'nurse_id', 'id');
    }

    public function provideSupports()
    {
        return $this->hasManyThrough(
            'App\Models\ProvideSupport',
            'App\Models\ProvideSupportAssigned',
            'nurse_id',                                  //from ProvideSupportAssigned
            'id',                                     //from App\Models\ProvideSupport
            'id',                                       //from User
            'support_id');                        //from ProvideSupportAssigned
    }
}
