<?php

namespace App\Http\Controllers\Api\Collection;

use App\Http\Response;
use App\Models\Collection;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionEntriesResource;
use App\Models\Repositories\CollectionRepository;

class GetCollectionEntriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Collection $collection)
    {
        $this->authorize('list-entries', $collection);

        $entries = app(CollectionRepository::class)->filtered($collection);

        abort_if($entries->isEmpty(), Response::HTTP_NO_CONTENT);

        return new CollectionEntriesResource($entries);
    }
}
