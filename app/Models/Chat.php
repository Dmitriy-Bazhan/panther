<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_user_id',
        'nurse_user_id',
        'status',
        'delete_date',
    ];

    protected $hidden = [
        'updated_at'
    ];
}
