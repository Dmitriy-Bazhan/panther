<?php

namespace App\Http\Resources;

use App\Models\Feedback;
use Illuminate\Http\Resources\Json\JsonResource;

class NurseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->entity->work_time_pref = json_decode($this->entity->work_time_pref, true);

        $rate = $this->rate;
        $this->rate = new \stdClass();
        if (count($rate) > 0) {
            $this->rate->count = count($rate);

            $average = $rate->sum(function ($value) {
                    return $value->rate;
                }) / $this->rate->count;

            $this->rate->round = round ($average);
            $this->rate->real = round ($average , 2);
        }else{
            $this->rate->count = 0;
            $this->rate->round = 0;
            $this->rate->real = 0;
        }

        $this->feedback_rates = round(Feedback::where('target_user_id', $this->id)->avg('rate'));
//        $this->feedback_rates = Feedback::where('target_user_id', $this->id)->avg('rate');

        return [
            'created_at' => $this->created_at,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'entity' => NurseEntityResource::make($this->entity),
            'entity_id' => $this->entity_id,
            'entity_type' => $this->entity_type,
            'first_name' => $this->first_name,
            'hear_about_us' => $this->hear_about_us,
            'hear_about_us_other' => $this->hear_about_us_other,
            'id' => $this->id,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'updated_at' => $this->updated_at,
            'zip_code' => $this->zip_code,
            'rate' => $this->rate,
            'feedback_rates' => $this->feedback_rates,
            'banned' => $this->banned,
        ];

    }
}
