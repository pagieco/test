<?php

namespace App\Domains\Page\Http\Controllers\Api;

use App\Domains\Page\Models\Page;
use App\Http\Controllers\Controller;
use App\Domains\Page\Http\Resources\PageResource;
use App\Domains\Page\Http\Requests\PublishPageRequest;

class PublishPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(PublishPageRequest $request, Page $page): PageResource
    {
        $this->authorize('publish', $page);

        $page->publish($request->dom, $request->css);

        return new PageResource($page);
    }
}
