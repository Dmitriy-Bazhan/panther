<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_user_id',
        'nurse_user_id',
        'message',
        'user_name',
        'client_sent',
        'nurse_sent',
        'status',
    ];
}
