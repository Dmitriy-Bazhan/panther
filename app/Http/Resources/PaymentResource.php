<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'created_at' => Carbon::createFromDate($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::createFromDate($this->updated_at)->format('Y-m-d'),
        ];
    }
}
