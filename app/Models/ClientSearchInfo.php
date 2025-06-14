<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSearchInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'for_whom',
        'client_id',
        'name',
        'last_name',
        'age_range',
        'provider_supports',
        'disease',
        'other_disease',
        'degree_of_care_available',
        'languages',
        'do_you_need_help_moving',
        'additional_transportation',
        'memory',
        'incontinence',
        'preference_for_the_nurse',
        'hearing',
        'vision',
        'areas_help',
        'other_areas',
        'one_or_regular',
        'one_time_date',
        'regular_time_start_date',
        'regular_time_finish_date',
        'work_time_pref',
    ];
}
