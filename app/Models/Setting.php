<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at', 'updated_at', 'id'
    ];

    protected $fillable = [
        'listing_paginate',
        'site_email',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'regularity_of_email_about_new_messages',
    ];

    public static function __set_state(){
        //
    }

}
