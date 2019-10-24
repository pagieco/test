<?php

namespace App\Domains\Collection\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Http\Resources\CollectionResource;

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
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @return \App\Domains\Collection\Http\Resources\CollectionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Collection $collection): CollectionResource
    {
        $this->authorize('view', $collection);

        return new CollectionResource($collection);
    }
}
