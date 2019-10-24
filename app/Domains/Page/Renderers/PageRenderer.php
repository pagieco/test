<?php

namespace App\Domains\Page\Renderers;

use Illuminate\View\View;
use App\Renderers\Renderable;
use App\Renderers\ResourceRenderer;

class PageRenderer extends ResourceRenderer implements Renderable
{
    public function render(): View
    {
        return view('render-targets/page-resource', [
            'resource' => $this->resource,
            'domain' => $this->resource->domain,
            'project' => $this->resource->project,
        ]);
    }
}
