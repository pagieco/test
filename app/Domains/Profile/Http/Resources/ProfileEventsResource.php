<?php

namespace App\Domains\Profile\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfileEventsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ProfileEventResource::collection($this->collection);
    }
}
