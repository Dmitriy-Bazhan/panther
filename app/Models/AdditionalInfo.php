<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInfo extends Model
{
    use HasFactory;

    public function data() {
        return $this->hasOne('App\Models\AdditionalInfoData', 'additional_info_id', 'id')
            ->where('lang', auth()->user()->prefs->pref_lang);
    }
}
