<?php

namespace App\Domains\Project\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectOwnerResource extends JsonResource
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
            'email' => $this->email,
            'picture' => asset($this->picture),
        ];
    }
}
