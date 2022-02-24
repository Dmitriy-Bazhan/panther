<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInfoAssigned extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_id', 'additional_info_id',
    ];
}
