<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_user_id',
        'nurse_user_id',
        'type',
        'status',
        'complaint',
    ];

    public function client() {
        return $this->hasOne('App\Models\User', 'id', 'client_user_id');
    }

    public function nurse() {
        return $this->hasOne('App\Models\User', 'id', 'nurse_user_id');
    }
}
