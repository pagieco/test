<?php

namespace App\Http\Controllers\Api\AssetFolder;

use App\Models\AssetFolder;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetFolderResource;
use App\Http\Requests\CreateAssetFolderRequest;

class CreateAssetFoldersController extends Controller
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
     * Create a new asset folder from the request.
     *
     * @param  \App\Http\Requests\CreateAssetFolderRequest $request
     * @return \App\Http\Resources\AssetFolderResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreateAssetFolderRequest $request): AssetFolderResource
    {
        $this->authorize('create', AssetFolder::class);

        $folder = $request->user()
            ->currentProject()
            ->assetFolders()
            ->create($request->all());

        return new AssetFolderResource($folder);
    }
}
