<?php

namespace App\Http\Controllers\Api\Asset;

use App\Models\Asset;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Http\Requests\UpdateAssetRequest;

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
     * @param  \App\Http\Requests\UpdateAssetRequest $request
     * @param  \App\Models\Asset $asset
     * @return \App\Http\Resources\AssetResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateAssetRequest $request, Asset $asset): AssetResource
    {
        $this->authorize('update', $asset);

        $asset->update($request->only('description', 'filename'));

        return new AssetResource($asset);
    }
}
