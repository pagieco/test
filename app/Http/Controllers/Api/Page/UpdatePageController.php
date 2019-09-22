<?php

namespace App\Http\Controllers\Api\Page;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Http\Requests\UpdatePageRequest;

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
     * @param  \App\Http\Requests\UpdatePageRequest $request
     * @param  \App\Models\Page $page
     * @return \App\Http\Resources\PageResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdatePageRequest $request, Page $page): PageResource
    {
        $this->authorize('update', $page);

        $page->update($request->only('name', 'slug'));

        return new PageResource($page);
    }
}
