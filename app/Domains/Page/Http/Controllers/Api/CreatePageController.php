<?php

namespace App\Domains\Page\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Domains\Page\Models\Page;
use App\Http\Controllers\Controller;
use App\Domains\Page\Http\Resources\PageResource;
use App\Domains\Page\Http\Requests\CreatePageRequest;

class CreatePageController extends Controller
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
     * Create a new page from the request.
     *
     * @param  \App\Domains\Page\Http\Requests\CreatePageRequest $request
     * @return \App\Domains\Page\Http\Resources\PageResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreatePageRequest $request): PageResource
    {
        $this->authorize('create', Page::class);

        $page = $this->createPage($request);

        return new PageResource($page);
    }

    /**
     * Create a new page.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\Page\Models\Page
     */
    protected function createPage(Request $request): Page
    {
        $domain = $request->user()
            ->currentProject()
            ->domains()
            ->findOrFail($request->domain_id);

        $page = new Page($request->all());

        $page->domain()->associate($domain);
        $page->project()->associate($domain->project);

        return tap($page)->save();
    }
}
