<?php

namespace App\Domains\Profile\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'profile_id' => $this->profile_id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country' => $this->country,
            'phone' => $this->phone,
            'timezone' => $this->timezone,
            'tags' => $this->tags,
            'custom_fields' => $this->custom_fields,
            'has_consented' => $this->has_consented,
            'consented_at' => $this->consented_at,
            'first_seen_at' => $this->first_seen_at,
            'last_seen_at' => $this->last_seen_at,
        ];
    }
}
