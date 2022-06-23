<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientSearchInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'for_whom' => $this->for_whom,
            'client_id' => $this->client_id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'age_range' => $this->age_range,
            'provider_supports' => json_decode($this->provider_supports, true),
            'disease' => json_decode($this->disease, true),
            'other_disease' => $this->other_disease,
            'degree_of_care_available' => $this->degree_of_care_available,
            'languages' => json_decode($this->languages, true),
            'do_you_need_help_moving' => $this->do_you_need_help_moving,
            'additional_transportation' => $this->additional_transportation,
            'memory' => $this->memory,
            'incontinence' => $this->incontinence,
            'preference_for_the_nurse' => $this->preference_for_the_nurse,
            'hearing' => $this->hearing,
            'vision' => $this->vision,
            'areas_help' => $this->areas_help,
            'other_areas' => $this->other_areas,
            'one_or_regular' => $this->one_or_regular,
            'one_time_date' => $this->one_time_date,
            'regular_time_start_date' => $this->regular_time_start_date,
            'regular_time_finish_date' => $this->regular_time_finish_date,
            'work_time_pref' => json_decode($this->work_time_pref, true),
        ];
    }
}
