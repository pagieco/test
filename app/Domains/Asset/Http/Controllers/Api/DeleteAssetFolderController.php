<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Asset\Models\AssetFolder;

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
     * @param  \App\Domains\Asset\Models\AssetFolder $assetFolder
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function __invoke(AssetFolder $assetFolder): void
    {
        $this->authorize('delete', $assetFolder);

        $assetFolder->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
