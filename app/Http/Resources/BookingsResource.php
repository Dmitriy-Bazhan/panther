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
        return [
            'additional_email' => $this->additional_email,
            'alternative' => $this->alternative,
            'client_user_id' => $this->client_user_id ,
            'client' => $this->client,
            'comment' => $this->comment ,
            'created_at' => $this->created_at ,
            'days' => !is_null($this->days) ? json_decode($this->days, true): $this->days,
            'finish_date' => $this->finish_date ,
            'hourly_price' => $this->hourly_price ,
            'id' => $this->id ,
            'is_approved' => $this->is_approved ,
            'have_alternative' => $this->have_alternative ,
            'nurse_user_id' => $this->nurse_user_id ,
            'one_time_or_regular' => $this->one_time_or_regular ,
            'start_date' => $this->start_date ,
            'suggested_price_per_hour' => $this->suggested_price_per_hour ,
            'time' => $this->time ,
            'total' => $this->total ,
            'updated_at' => $this->updated_at ,
            'weeks' => $this->weeks ,
        ];
    }
}
