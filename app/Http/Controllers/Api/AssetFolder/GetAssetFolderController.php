<?php

namespace App\Http\Controllers\Api\AssetFolder;

use App\Models\AssetFolder;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetFolderResource;

class GetAssetFolderController extends Controller
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
     * Show the given asset folder.
     *
     * @param  \App\Models\AssetFolder $assetFolder
     * @return \App\Http\Resources\AssetFolderResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(AssetFolder $assetFolder): AssetFolderResource
    {
        $this->authorize('view', $assetFolder);

        return new AssetFolderResource($assetFolder);
    }
}
