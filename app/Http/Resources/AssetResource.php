<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'hash' => $this->hash,
            'hash_path' => $this->hash_path,
            'filename' => $this->filename,
            'original_filename' => $this->original_filename,
            'description' => $this->description,
            'extension' => $this->extension,
            'mimetype' => $this->mimetype,
            'filesize' => $this->filesize,
            'extra_attributes' => $this->extra_attributes,
            'path' => $this->path,
            'thumb_path' => $this->thumb_path,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
