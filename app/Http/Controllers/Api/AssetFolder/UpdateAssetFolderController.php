<?php

namespace App\Http\Controllers\Api\AssetFolder;

use App\Models\AssetFolder;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetFolderResource;
use App\Http\Requests\UpdateAssetFolderRequest;

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
     * @param  \App\Http\Requests\UpdateAssetFolderRequest $request
     * @param  \App\Models\AssetFolder $assetFolder
     * @return \App\Http\Resources\AssetFolderResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateAssetFolderRequest $request, AssetFolder $assetFolder): AssetFolderResource
    {
        $this->authorize('update', $assetFolder);

        $assetFolder->update($request->only('name', 'description'));

        return new AssetFolderResource($assetFolder);
    }
}
