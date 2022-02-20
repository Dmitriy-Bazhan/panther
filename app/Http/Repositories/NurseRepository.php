<?php

namespace App\Http\Repositories;

use App\Models\Nurse;

class NurseRepository
{
    protected $nurse;

    public function __construct(Nurse $nurse)
    {
        $this->nurse = $nurse;
    }

    public function update() {

        return true;
    }

    public function uploadPhoto(){

        return true;
    }
}
