<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseWorkTimePref extends Model
{
    use HasFactory;

    /*
     * 1 weekdays_morning
     * 2 weekdays_afternoon
     * 3 weekdays_evening
     * 4 weekdays_overnight
     * 5 weekends_morning
     * 6 weekends_afternoon
     * 7 weekends_evening
     * 8 weekends_overnight
     */
}
