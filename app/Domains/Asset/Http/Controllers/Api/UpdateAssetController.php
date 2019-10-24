<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use App\Domains\Asset\Models\Asset;
use App\Http\Controllers\Controller;
use App\Domains\Asset\Http\Resources\AssetResource;
use App\Domains\Asset\Http\Requests\UpdateAssetRequest;

class UpdateAssetController extends Controller
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
     * Update the given asset.
     *
     * @param  \App\Domains\Asset\Http\Requests\UpdateAssetRequest $request
     * @param  \App\Domains\Asset\Models\Asset $asset
     * @return \App\Domains\Asset\Http\Resources\AssetResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateAssetRequest $request, Asset $asset): AssetResource
    {
        $this->authorize('update', $asset);

        $asset->update($request->only('description', 'filename'));

        return new AssetResource($asset);
    }
}
