<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'agency_percent' => $this->agency_percent,
            'booking' => $this->booking,
            'booking_id' => $this->booking_id,
            'client_user_id' => $this->client_user_id,
            'created_at' => $this->created_at,
            'currency' => $this->currency,
            'date' => $this->date,
            'gateway' => $this->gateway,
            'id' => $this->id,
            'note' => $this->note,
            'nurse_user_id' => $this->nurse_user_id,
            'status' => $this->status,
            'sum' => $this->sum,
            'tax' => $this->tax,
            'method' => $this->method,
            'status_of_view' => $this->status_of_view,
            'updated_at' => $this->updated_at,
        ];
    }
}
