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
        'have_file',
        'original_file',
        'thumbnail_file',
        'chat_id',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function chat() {
        return $this->hasOne('App\Models\Chat', 'id', 'chat_id');
    }
}
