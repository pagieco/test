<?php

namespace App\Domains\Domain\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DomainsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return DomainResource::collection($this->collection);
    }
}
