<?php

namespace App\Domains\Collection\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Collection\Models\CollectionEntry;

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
     * @param  \App\Domains\Collection\Models\CollectionEntry $entry
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
