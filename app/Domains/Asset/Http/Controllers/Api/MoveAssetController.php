<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use App\Http\Response;
use Illuminate\Http\Request;
use App\Services\IdGenerator;
use App\Domains\Asset\Models\Asset;
use App\Http\Controllers\Controller;
use App\Domains\Asset\Models\AssetFolder;
use App\Domains\Asset\Http\Requests\MoveAssetRequest;

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
     * @param  \App\Domains\Asset\Http\Requests\MoveAssetRequest $request
     * @param  \App\Domains\Asset\Models\Asset $asset
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
     * @return \App\Domains\Asset\Models\AssetFolder
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeForFolder(Request $request): AssetFolder
    {
        $id = IdGenerator::decode($request->folder_id)['local'];

        $folder = AssetFolder::findOrFail($id);

        $this->authorize('view', $folder);

        return $folder;
    }
}
