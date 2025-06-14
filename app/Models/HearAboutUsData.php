<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HearAboutUsData extends Model
{
    use HasFactory;

    protected $fillable = [
        'data', 'id', 'lang', 'near_about_us_id',
    ];
}
