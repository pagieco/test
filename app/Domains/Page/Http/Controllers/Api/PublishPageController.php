<?php

namespace App\Domains\Page\Http\Controllers\Api;

use App\Domains\Page\Models\Page;
use App\Http\Controllers\Controller;
use App\Domains\Page\Http\Resources\PageResource;
use App\Domains\Page\Http\Requests\PublishPageRequest;

class PublishPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Publish the given page.
     *
     * @param  \App\Domains\Page\Http\Requests\PublishPageRequest $request
     * @param  \App\Domains\Page\Models\Page $page
     * @return \App\Domains\Page\Http\Resources\PageResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(PublishPageRequest $request, Page $page): PageResource
    {
        $this->authorize('publish', $page);

        $page->publish($request->dom, $request->css);

        return new PageResource($page);
    }
}
