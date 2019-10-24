<?php

namespace App\Domains\Collection\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Repositories\CollectionRepository;
use App\Domains\Collection\Http\Resources\CollectionEntriesResource;

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
