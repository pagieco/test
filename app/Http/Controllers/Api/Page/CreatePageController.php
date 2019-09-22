<?php

namespace App\Http\Controllers\Api\Page;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Http\Requests\CreatePageRequest;

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
     * @param  \App\Http\Requests\CreatePageRequest $request
     * @return \App\Http\Resources\PageResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreatePageRequest $request): PageResource
    {
        $this->authorize('create', Page::class);

        $page = $request->user()
            ->currentProject()
            ->pages()
            ->create($request->all());

        return new PageResource($page);
    }
}
