<?php

namespace App\Http\Controllers\Api\AssetFolder;

use App\Http\Response;
use App\Models\AssetFolder;
use App\Http\Controllers\Controller;

class DeleteAssetFolderController extends Controller
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
     * Delete the given asset-folder.
     *
     * @param  \App\Models\AssetFolder $assetFolder
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(AssetFolder $assetFolder): void
    {
        $this->authorize('delete', $assetFolder);

        $assetFolder->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
