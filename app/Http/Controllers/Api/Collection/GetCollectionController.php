<?php

namespace App\Http\Controllers\Api\Collection;

use App\Models\Collection;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;

class GetCollectionController extends Controller
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
     * Show the given collection.
     *
     * @param  \App\Models\Collection $collection
     * @return \App\Http\Resources\CollectionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Collection $collection): CollectionResource
    {
        $this->authorize('view', $collection);

        return new CollectionResource($collection);
    }
}
