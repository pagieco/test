<?php

namespace App\Domains\User\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProjectRelationshipResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'links' => [
                'switch' => route('switch-to-project', $this->id),
            ]
        ];
    }
}
