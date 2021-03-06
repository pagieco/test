<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\IdGenerator;
use App\Domains\Asset\Models\Asset;
use App\Http\Controllers\Controller;
use App\Domains\Asset\Models\AssetFolder;
use App\Domains\Asset\Jobs\CreateAssetThumbnail;
use App\Domains\Asset\Http\Resources\AssetResource;
use App\Domains\Asset\Http\Requests\UploadAssetRequest;

class UploadAssetController extends Controller
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
     * Upload the given asset.
     *
     * @param  \App\Domains\Asset\Http\Requests\UploadAssetRequest $request
     * @return \App\Domains\Asset\Http\Resources\AssetResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UploadAssetRequest $request)
    {
        $this->authorize('upload', Asset::class);

        $asset = $this->upload($request);

        return new AssetResource($asset);
    }

    /**
     * Upload the asset and dispatch the create thumbnail job.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\Asset\Models\Asset
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function upload(Request $request): Asset
    {
        $file = $request->file('asset');

        $folder = $request->has('folder_id')
            ? $this->authorizeForFolder($request)
            : null;

        $asset = Asset::upload($file, $request->user()->currentProject(), $folder);

        $this->dispatch(new CreateAssetThumbnail($asset));

        return $asset;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\Asset\Models\AssetFolder|null
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeForFolder(Request $request): ?AssetFolder
    {
        $id = IdGenerator::decode($request->folder_id)['local'];

        $folder = AssetFolder::findOrFail($id);

        $this->authorize('view', $folder);

        return $folder;
    }
}
