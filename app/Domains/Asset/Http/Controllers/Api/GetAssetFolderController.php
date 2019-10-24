<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Asset\Models\AssetFolder;
use App\Domains\Asset\Http\Resources\AssetFolderResource;

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
     * @param  \App\Domains\Asset\Models\AssetFolder $assetFolder
     * @return \App\Domains\Asset\Http\Resources\AssetFolderResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(AssetFolder $assetFolder): AssetFolderResource
    {
        $this->authorize('view', $assetFolder);

        return new AssetFolderResource($assetFolder);
    }
}
