<?php

namespace App\Domains\Project\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'owner' => new ProjectOwnerResource($this->owner),
            'name' => $this->name,
            'hash' => $this->hash,
            'used_storage' => $this->used_storage,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
