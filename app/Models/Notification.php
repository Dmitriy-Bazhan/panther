<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_user_id',
        'creator_entity',
        'target_user_id',
        'type',
        'status',
        'content',
        'resource_id',
    ];

    protected $appends = [
        'creator_name',
        'target_user_name'
    ];

    public function getCreatorNameAttribute()
    {
        $user = User::where('id', $this->creator_user_id)->select('first_name', 'last_name')->first();
        return $this->attributes['creator_name'] = $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1));
    }

    public function getTargetUserNameAttribute()
    {
        $user = User::where('id', $this->target_user_id)->select('first_name', 'last_name')->first();
        return $this->attributes['target_user_name'] = $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1));
    }
}
