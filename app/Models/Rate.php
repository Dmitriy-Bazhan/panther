<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate', 'user_id', 'creator_id',
    ];

    public function creator(){
        return $this->belongsTo('App\Models\User','creator_id', 'id')->without('prefs');
    }
}
