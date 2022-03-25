<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HearAboutUs extends Model
{
    use HasFactory;

    public function data(){
        return $this->hasMany('App\Models\HearAboutUsData', 'near_about_us_id', 'id');
    }
}
