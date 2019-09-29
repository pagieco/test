<?php

namespace App\Http\Controllers\Api\Collection;

use App\Http\Response;
use App\Models\CollectionEntry;
use App\Http\Controllers\Controller;

class DeleteCollectionEntryController extends Controller
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
     * Delete the given collection entry.
     *
     * @param  \App\Models\CollectionEntry $entry
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CollectionEntry $entry): void
    {
        $this->authorize('delete-entry', $entry->collection);

        $entry->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
