<?php

namespace App\Domains\Collection\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Models\CollectionField;
use App\Domains\Collection\Models\CollectionEntry;
use App\Domains\Collection\Http\Resources\CollectionEntryResource;
use App\Domains\Collection\Http\Requests\CreateCollectionEntryRequest;

class CreateCollectionEntryController extends Controller
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
     * Create a new collection entry for the given collection.
     *
     * @param  \App\Domains\Collection\Http\Requests\CreateCollectionEntryRequest $request
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @return \App\Domains\Collection\Http\Resources\CollectionEntryResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreateCollectionEntryRequest $request, Collection $collection): CollectionEntryResource
    {
        $this->authorize('create-entry', $collection);

        $request->validate($this->createValidatorData($collection));

        $entry = $this->createEntry($request, $collection);

        return new CollectionEntryResource($entry);
    }

    /**
     * Create the validator data.
     *
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @return array
     */
    protected function createValidatorData(Collection $collection): array
    {
        return $collection->fields->mapWithKeys(function (CollectionField $field): array {
            $key = sprintf('entry_data.%s', $field->slug);

            return [$key => $field->validations];
        })->toArray();
    }

    /**
     * Create a new collection-entry.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @return \App\Domains\Collection\Models\CollectionEntry
     */
    protected function createEntry(Request $request, Collection $collection): CollectionEntry
    {
        $entry = new CollectionEntry($request->only('name', 'slug', 'entry_data'));

        $entry->collection()->associate($collection);
        $entry->project()->associate($collection->project);

        return tap($entry)->save();
    }
}
