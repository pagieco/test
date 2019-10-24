<?php

namespace App\Domains\Collection\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Models\CollectionField;
use App\Domains\Collection\Http\Resources\CollectionResource;
use App\Domains\Collection\Http\Requests\CreateCollectionRequest;

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
     * @param  \App\Domains\Collection\Http\Requests\CreateCollectionRequest $request
     * @return \App\Domains\Collection\Http\Resources\CollectionResource
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
     * @return \App\Domains\Collection\Models\Collection
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
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @param  array $attributes
     * @return \App\Domains\Collection\Models\CollectionField
     */
    protected function createCollectionField(Collection $collection, array $attributes): CollectionField
    {
        $field = new CollectionField($attributes);

        $field->collection()->associate($collection);
        $field->project()->associate($collection->project);

        return tap($field)->save();
    }
}
