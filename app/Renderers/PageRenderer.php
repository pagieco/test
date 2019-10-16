<?php

namespace App\Renderers;

use Illuminate\View\View;

class PageRenderer extends ResourceRenderer implements Renderable
{
    public function render(): View
    {
        return view('render-targets/page-resource', [
            'resource' => $this->resourceInstance,
            'domain' => $this->resourceInstance->domain,
        ]);
    }
}
