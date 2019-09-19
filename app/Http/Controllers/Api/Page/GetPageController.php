<?php

namespace App\Http\Controllers\Api\Page;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;

class GetPageController extends Controller
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
     * Show the given page.
     *
     * @param  \App\Models\Page $page
     * @return \App\Http\Resources\PageResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Page $page): PageResource
    {
        $this->authorize('view', $page);

        return new PageResource($page);
    }
}
