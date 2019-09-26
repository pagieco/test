<?php

namespace App\Http\Controllers\Api\Collection;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\CollectionField;
use App\Models\CollectionEntry;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionEntryResource;
use App\Http\Requests\CreateCollectionEntryRequest;

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
     * @param  \App\Http\Requests\CreateCollectionEntryRequest $request
     * @param  \App\Models\Collection $collection
     * @return \App\Http\Resources\CollectionEntryResource
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
     * @param  \App\Models\Collection $collection
     * @return array
     */
    protected function createValidatorData(Collection $collection): array
    {
        return (array) $collection->fields->mapWithKeys(function (CollectionField $field): array {
            $key = sprintf('fields.%s', $field->slug);

            return [$key => $field->validations];
        });
    }

    /**
     * Create a new collection-entry.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Collection $collection
     * @return \App\Models\CollectionEntry
     */
    protected function createEntry(Request $request, Collection $collection): CollectionEntry
    {
        $entry = new CollectionEntry([
            'entry_data' => $request->get('fields'),
        ]);

        $entry->collection()->associate($collection);
        $entry->project()->associate($collection->project);

        return tap($entry)->save();
    }
}
