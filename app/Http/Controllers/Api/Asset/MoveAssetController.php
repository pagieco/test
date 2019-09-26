<?php

namespace App\Http\Controllers\Api\Asset;

use App\Models\Asset;
use App\Http\Response;
use App\Models\AssetFolder;
use Illuminate\Http\Request;
use App\Services\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\MoveAssetRequest;

class MoveAssetController extends Controller
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
     * @param  \App\Http\Requests\MoveAssetRequest $request
     * @param  \App\Models\Asset $asset
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(MoveAssetRequest $request, Asset $asset)
    {
        $this->authorize('move', $asset);

        $folder = $this->authorizeForFolder($request);

        $asset->moveTo($folder);

        return Response::created();
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \App\Models\AssetFolder
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeForFolder(Request $request): AssetFolder
    {
        $folder = AssetFolder::findOrFail(
            IdGenerator::decode($request->get('folder_id'))['local']
        );

        $this->authorize('view', $folder);

        return $folder;
    }
}
