<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NurseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);

//        return [
//            'work_time_pref' => json_decode($this->work_time_pref, true),
//        ];
    }
}
