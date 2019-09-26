<?php

namespace App\Http\Controllers\Api\Collection;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\CollectionField;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Http\Requests\CreateCollectionRequest;

class CreateCollectionController extends Controller
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
     * Create a new collection from the given request.
     *
     * @param  \App\Http\Requests\CreateCollectionRequest $request
     * @return \App\Http\Resources\CollectionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreateCollectionRequest $request): CollectionResource
    {
        $this->authorize('create', Collection::class);

        $collection = $this->createCollection($request);

        foreach ($request->fields as $field) {
            $this->createCollectionField($collection, $field);
        }

        return new CollectionResource($collection);
    }

    /**
     * Create a new collection
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Models\Collection
     */
    protected function createCollection(Request $request): Collection
    {
        $collection = new Collection($request->all());

        $collection->project()->associate(
            $request->user()->currentProject()
        );

        return tap($collection)->save();
    }

    /**
     * Create a new collection field.
     *
     * @param  \App\Models\Collection $collection
     * @param  array $attributes
     * @return \App\Models\CollectionField
     */
    protected function createCollectionField(Collection $collection, array $attributes): CollectionField
    {
        $field = new CollectionField($attributes);

        $field->collection()->associate($collection);
        $field->project()->associate($collection->project);

        return tap($field)->save();
    }
}
