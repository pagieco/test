<?php

namespace App\Domains\Collection\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Models\CollectionField;
use App\Domains\Collection\Models\CollectionEntry;
use App\Domains\Collection\Http\Resources\CollectionEntryResource;
use App\Domains\Collection\Http\Requests\UpdateCollectionEntryRequest;

class UpdateCollectionEntryController extends Controller
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
     * Update the given collection entry.
     *
     * @param  \App\Domains\Collection\Http\Requests\UpdateCollectionEntryRequest $request
     * @param  \App\Domains\Collection\Models\CollectionEntry $entry
     * @return \App\Domains\Collection\Http\Resources\CollectionEntryResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateCollectionEntryRequest $request, CollectionEntry $entry): CollectionEntryResource
    {
        $this->authorize('update-entry', [Collection::class, $entry]);

        $request->validate($this->createValidatorData($entry->collection));

        $entry->update($request->only('name', 'slug') + [
            'entry_data' => $request->entry_data + $entry->entry_data,
        ]);

        return new CollectionEntryResource($entry);
    }

    protected function createValidatorData(Collection $collection): array
    {
        return $collection->fields->mapWithKeys(function (CollectionField $field): array {
            $key = sprintf('entry_data.%s', $field->slug);

            return [$key => $field->validations];
        })->toArray();
    }
}
