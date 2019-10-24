<?php

namespace App\Domains\Page\Http\Controllers\Api;

use App\Domains\Page\Models\Page;
use App\Http\Controllers\Controller;
use App\Domains\Page\Http\Resources\PageResource;

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
     * @param  \App\Domains\Page\Models\Page $page
     * @return \App\Domains\Page\Http\Resources\PageResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Page $page): PageResource
    {
        $this->authorize('view', $page);

        return new PageResource($page);
    }
}
