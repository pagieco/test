<?php

namespace App\Http\Controllers\Api\AssetFolder;

use App\Http\Response;
use App\Models\AssetFolder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetFoldersResource;

class GetAssetFoldersController extends Controller
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
     * Return a list of asset folders from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AssetFoldersResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): AssetFoldersResource
    {
        $this->authorize('list', AssetFolder::class);

        $folders = $request->user()->currentProject()->assetFolders;

        abort_if($folders->isEmpty(), Response::HTTP_NO_CONTENT);

        return new AssetFoldersResource($folders);
    }
}
