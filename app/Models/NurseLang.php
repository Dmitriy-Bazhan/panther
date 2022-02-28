<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_id','lang', 'level'
    ];
}
