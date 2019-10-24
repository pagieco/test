<?php

namespace App\Domains\Collection\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
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
            'name' => $this->name,
            'fields' => [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
