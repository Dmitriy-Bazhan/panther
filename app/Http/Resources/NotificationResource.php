<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            "id" => $this->id,
            "creator_user_id" => $this->creator_user_id,
            'creator_name' => $this->creator_name,
            "creator_entity" => $this->creator_entity,
            "target_user_id" => $this->target_user_id,
            'target_user_name' => $this->target_user_name,
            "type" => $this->type,
            "status" => $this->status,
            "content" => $this->content,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
