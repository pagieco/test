<?php

namespace App\Http\Controllers\Api\Page;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Http\Requests\PublishPageRequest;

class PublishPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(PublishPageRequest $request, Page $page): PageResource
    {
        $this->authorize('publish', $page);

        $page->publish($request->only('dom', 'css'));

        return new PageResource($page);
    }
}
