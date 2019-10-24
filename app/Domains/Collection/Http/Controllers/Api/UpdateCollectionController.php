<?php

namespace App\Domains\Collection\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Http\Resources\CollectionResource;
use App\Domains\Collection\Http\Requests\UpdateCollectionRequest;

class UpdateCollectionController extends Controller
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
     * Update the given collection.
     *
     * @param  \App\Domains\Collection\Http\Requests\UpdateCollectionRequest $request
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @return \App\Domains\Collection\Http\Resources\CollectionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateCollectionRequest $request, Collection $collection): CollectionResource
    {
        $this->authorize('update', $collection);

        $collection->update($request->all());

        return new CollectionResource($collection);
    }
}
