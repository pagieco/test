<?php

namespace App\Renderers;

use Illuminate\Contracts\Support\Responsable;

abstract class ResourceRenderer
{
    protected $resource;

    public static function fromResource(Responsable $responsableResource)
    {
        $instance = new static;

        $instance->resource = $responsableResource;

        return $instance;
    }
}
