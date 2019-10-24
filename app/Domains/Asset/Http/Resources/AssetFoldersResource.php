<?php

namespace App\Domains\Asset\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetFoldersResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return AssetFolderResource::collection($this->collection);
    }
}
