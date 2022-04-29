<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $hidden = [
        'updated_at'
    ];

    public function creator(){
        return $this->belongsTo('App\Models\User','creator_id', 'id');
    }
}
