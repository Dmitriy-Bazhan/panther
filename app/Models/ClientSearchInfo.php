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
        'language',
        'language_level',
        'do_you_need_help_moving',
        'additional_transportation',
        'memory',
        'incontinence',
        'preference_for_the_nurse',
        'hearing',
        'vision',
        'areas_help',
        'other_areas',
    ];
}
