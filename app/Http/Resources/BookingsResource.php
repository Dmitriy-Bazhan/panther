<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!is_null($this->alternative ) && !is_null($this->alternative->alternative_days)){
            $this->alternative->alternative_days = json_decode($this->alternative->alternative_days, true);
        }

        return [
            'additional_email' => $this->additional_email,
            'alternative' => $this->alternative,
            'client_user_id' => $this->client_user_id ,
            'client' => $this->client,
            'nurse' => $this->nurse,
            'comment' => $this->comment ,
            'created_at' => $this->created_at ,
            'days' => !is_null($this->days) ? json_decode($this->days, true): $this->days,
            'finish_date' => $this->finish_date ,
            'hourly_price' => $this->hourly_price ,
            'id' => $this->id ,
            'status' => $this->status ,
            'have_alternative' => $this->have_alternative ,
            'agree_for_alternative' => $this->agree_for_alternative ,
            'nurse_user_id' => $this->nurse_user_id ,
            'one_time_or_regular' => $this->one_time_or_regular ,
            'start_date' => $this->start_date ,
            'suggested_price_per_hour' => $this->suggested_price_per_hour ,
            'time' => $this->time ,
            'total' => $this->total ,
            'updated_at' => $this->updated_at ,
            'weeks' => $this->weeks ,
            'reason_of_refuse_booking' => $this->reason_of_refuse_booking ,
            'nurse_is_refuse_booking' => $this->nurse_is_refuse_booking ,
            'is_verification' => $this->is_verification ,
        ];
    }
}
