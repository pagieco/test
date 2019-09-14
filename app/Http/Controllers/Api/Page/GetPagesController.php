<?php

namespace App\Http\Controllers\Api\Page;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PagesResource;

class GetPagesController extends Controller
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
     * Return a list of pages from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\PagesResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): PagesResource
    {
        $this->authorize('list', Page::class);

        $pages = $request->user()->currentProject()->pages;

        abort_if($pages->isEmpty(), Response::HTTP_NO_CONTENT);

        return new PagesResource($pages);
    }
}
