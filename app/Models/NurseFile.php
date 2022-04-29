<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_id', 'original_name', 'file_path', 'file_type', 'date','place_of_receipt',
                    'other_info', 'title', 'thumbnail_path'
    ];
}
