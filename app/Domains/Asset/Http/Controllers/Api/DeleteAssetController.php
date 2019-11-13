<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use App\Http\Response;
use App\Domains\Asset\Models\Asset;
use App\Http\Controllers\Controller;

class DeleteAssetController extends Controller
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
     * Delete the given asset.
     *
     * @param  \App\Domains\Asset\Models\Asset $asset
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function __invoke(Asset $asset): void
    {
        $this->authorize('delete', $asset);

        $asset->unlink();

        abort(Response::HTTP_NO_CONTENT);
    }
}
