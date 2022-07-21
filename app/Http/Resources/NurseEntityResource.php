<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NurseEntityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'additional_info' => $this->additionalInfo,
            'age' => $this->age,
            'available_care_range' => $this->available_care_range,
            'change_info' => $this->change_info,
            'count_completed_booking' => $this->count_completed_booking,
            'count_uncompleted_booking' => $this->count_uncompleted_booking,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'experience' => $this->experience,
            'files' => $this->files,
            'finish_date_to_work' => $this->finish_date_to_work,
            'gender' => $this->gender,
            'id' => $this->id,
            'info_is_full' => $this->info_is_full,
            'is_approved' => $this->is_approved,
            'languages' => $this->languages,
            'multiple_bookings' => $this->multiple_bookings,
            'one_or_regular' => $this->one_or_regular,
            'original_photo' => $this->original_photo,
            'pref_client_gender' => $this->pref_client_gender,
            'price' => $this->price,
            'provide_supports' => $this->provideSupports,
            'ready_to_work' => $this->ready_to_work,
            'start_date_ready_to_work' => $this->start_date_ready_to_work,
            'thumbnail_photo' => $this->thumbnail_photo,
            'type_of_learning' => $this->typeOfLearning,
            'updated_at' => $this->updated_at,
            'work_time_pref' => $this->work_time_pref,
        ];
    }
}
