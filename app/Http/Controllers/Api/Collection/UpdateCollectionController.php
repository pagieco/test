<?php

namespace App\Http\Controllers\Api\Collection;

use App\Models\Collection;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Http\Requests\UpdateCollectionRequest;

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
     * @param  \App\Http\Requests\UpdateCollectionRequest $request
     * @param  \App\Models\Collection $collection
     * @return \App\Http\Resources\CollectionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateCollectionRequest $request, Collection $collection): CollectionResource
    {
        $this->authorize('update', $collection);

        $collection->update($request->all());

        return new CollectionResource($collection);
    }
}
