<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvideSupport extends Model
{
    use HasFactory;

    protected $hidden = [
        'laravel_through_key', 'created_at', 'updated_at'
    ];
}
