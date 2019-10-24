<?php

namespace App\Domains\Page\Http\Controllers\Api;

use App\Domains\Page\Models\Page;
use App\Http\Controllers\Controller;
use App\Domains\Page\Http\Resources\PageResource;
use App\Domains\Page\Http\Requests\UpdatePageRequest;

class UpdatePageController extends Controller
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
     * Update the given page
     *
     * @param  \App\Domains\Page\Http\Requests\UpdatePageRequest $request
     * @param  \App\Domains\Page\Models\Page $page
     * @return \App\Domains\Page\Http\Resources\PageResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdatePageRequest $request, Page $page): PageResource
    {
        $this->authorize('update', $page);

        $page->update($request->only('name', 'slug'));

        return new PageResource($page);
    }
}
