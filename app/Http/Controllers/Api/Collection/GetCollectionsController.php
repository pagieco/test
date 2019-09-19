<?php

namespace App\Http\Controllers\Api\Collection;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionsResource;

class GetCollectionsController extends Controller
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
     * Return a list of collections from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CollectionsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): CollectionsResource
    {
        $this->authorize('list', Collection::class);

        $collections = Collection::query()
            ->where('project_id',  $request->user()->current_project_id)
            ->get();

        abort_if($collections->isEmpty(), Response::HTTP_NO_CONTENT);

        return new CollectionsResource($collections);
    }
}
