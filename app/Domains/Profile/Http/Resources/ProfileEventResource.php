<?php

namespace App\Domains\Profile\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->external_id,
            'event_type' => $this->event_type,
            'data' => $this->data,
            'occurred_at' => $this->occurred_at,
        ];
    }
}
