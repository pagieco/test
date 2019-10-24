<?php

namespace App\Domains\Form\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\Profile\Http\Resources\ProfileResource;

class FormSubmissionProfileRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return new ProfileResource($this);
    }
}
