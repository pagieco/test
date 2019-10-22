<?php

namespace App\Http\Controllers\Api\Collection;

use App\Models\Collection;
use App\Models\CollectionEntry;
use App\Models\CollectionField;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionEntryResource;
use App\Http\Requests\UpdateCollectionEntryRequest;

class UpdateCollectionEntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
