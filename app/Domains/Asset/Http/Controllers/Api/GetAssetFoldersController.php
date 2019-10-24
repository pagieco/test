<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use App\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Asset\Models\AssetFolder;
use App\Domains\Asset\Http\Resources\AssetFoldersResource;

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
     * @return \App\Domains\Asset\Http\Resources\AssetFoldersResource
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
