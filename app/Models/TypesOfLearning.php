<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesOfLearning extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function data() {
        return $this->hasOne('App\Models\TypesOfLearningData', 'type_of_learning_id', 'id');
    }

}
