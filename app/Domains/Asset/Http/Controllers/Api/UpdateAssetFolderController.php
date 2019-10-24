<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Asset\Models\AssetFolder;
use App\Domains\Asset\Http\Resources\AssetFolderResource;
use App\Domains\Asset\Http\Requests\UpdateAssetFolderRequest;

class UpdateAssetFolderController extends Controller
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
     * Update the given asset-folder.
     *
     * @param  \App\Domains\Asset\Http\Requests\UpdateAssetFolderRequest $request
     * @param  \App\Domains\Asset\Models\AssetFolder $assetFolder
     * @return \App\Domains\Asset\Http\Resources\AssetFolderResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateAssetFolderRequest $request, AssetFolder $assetFolder): AssetFolderResource
    {
        $this->authorize('update', $assetFolder);

        $assetFolder->update($request->only('name', 'description'));

        return new AssetFolderResource($assetFolder);
    }
}
