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
        $this->entity->work_time_pref = json_decode($this->entity->work_time_pref, true);

        return [
            'created_at' => $this->created_at,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'entity' => $this->entity,
            'entity_id' => $this->entity_id,
            'entity_type' => $this->entity_type,
            'first_name' => $this->first_name,
            'hear_about_us' => $this->hear_about_us,
            'hear_about_us_other' => $this->hear_about_us_other,
            'id' => $this->id,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'updated_at' => $this->updated_at,
            'zip_code' => $this->zip_code,
        ];

    }
}
