<?php

namespace App\Domains\Collection\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectionEntriesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return CollectionEntryResource::collection($this->collection);
    }
}
