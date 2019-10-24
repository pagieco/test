<?php

namespace App\Domains\Automation\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AutomationsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return AutomationResource::collection($this->collection);
    }
}
