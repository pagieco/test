<?php

namespace App\Domains\Collection\Renderers;

use Illuminate\View\View;
use App\Renderers\Renderable;
use App\Renderers\ResourceRenderer;

class CollectionEntryRenderer extends ResourceRenderer implements Renderable
{
    public function render(): View
    {
        return view('render-targets/collection-entry-resource', [
            'resource' => $this->resource,
        ]);
    }
}
