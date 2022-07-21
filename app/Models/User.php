<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\Relation;
use Laravel\Cashier\Billable;
use Illuminate\Auth\Passwords\CanResetPassword;

Relation::morphMap([
    'admin' => 'App\Models\Admin',
    'nurse' => 'App\Models\Nurse',
    'client' => 'App\Models\Client',
]);

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable, CanResetPassword;

    protected $appends = ['full_name'];

    protected $with = [
        'entity',
        'prefs',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'zip_code',
        'entity_id',
        'entity_type',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'info_is_full', //needed only in order
        'change_info',
        'stripe_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //get a parent model of admin or client or nurse
    public function entity()
    {
        return $this->morphTo();
    }

    public function nurse()
    {
        return $this->hasOne('App\Models\Nurse', 'id', 'entity_id');
    }

    //check user is admin
    public function getIsAdminAttribute()
    {
        if ($this->entity instanceof Admin) {
            return true;
        } else {
            return false;
        }
    }

    //check user is nurse
    public function getIsNurseAttribute()
    {
        if ($this->entity instanceof Nurse) {
            return true;
        } else {
            return false;
        }
    }

    //check user is client
    public function getIsClientAttribute()
    {
        if ($this->entity instanceof Client) {
            return true;
        } else {
            return false;
        }
    }

    public function prefs()
    {
        return $this->hasOne('App\Models\UserPref', 'user_id', 'id');
    }

    public function rate() {
        return $this->hasMany('App\Models\Rate', 'user_id', 'id');
    }

    public function getFullNameAttribute() {
        return $this->attributes['full_name'] = $this->first_name . ' ' . ucfirst(substr($this->last_name, 0, 1));
    }

    public function canJoinRoom($roomID) {
        return true;
    }
}
