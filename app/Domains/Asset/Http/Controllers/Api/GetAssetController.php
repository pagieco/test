<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use App\Domains\Asset\Models\Asset;
use App\Http\Controllers\Controller;
use App\Domains\Asset\Http\Resources\AssetResource;

class GetAssetController extends Controller
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

    /**w
     * Show the given asset.
     *
     * @param  \App\Domains\Asset\Models\Asset $asset
     * @return \App\Domains\Asset\Http\Resources\AssetResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Asset $asset): AssetResource
    {
        $this->authorize('view', $asset);

        return new AssetResource($asset);
    }
}
