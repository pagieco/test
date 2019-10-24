<?php

namespace App\Domains\Collection\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Collection\Models\Collection;

class DeleteCollectionController extends Controller
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
     * Delete the given collection.
     *
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Collection $collection): void
    {
        $this->authorize('delete', $collection);

        $collection->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
