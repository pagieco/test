<?php

namespace App\Domains\Email\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmailsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return EmailResource::collection($this->collection);
    }
}
