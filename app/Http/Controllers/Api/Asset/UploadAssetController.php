<?php

namespace App\Http\Controllers\Api\Asset;

use App\Models\Asset;
use App\Models\AssetFolder;
use Illuminate\Http\Request;
use App\Jobs\CreateAssetThumbnail;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Http\Requests\UploadAssetRequest;

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
     * @param  \App\Http\Requests\UploadAssetRequest $request
     * @return \App\Http\Resources\AssetResource
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
     * @return \App\Models\Asset
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function upload(Request $request): Asset
    {
        $file = $request->file('asset');

        $folder = $this->authorizeForFolder($request);

        $asset = Asset::upload($file, $request->user()->currentProject(), $folder);

        $this->dispatch(new CreateAssetThumbnail($asset));

        return $asset;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \App\Models\AssetFolder|null
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeForFolder(Request $request): ?AssetFolder
    {
        $folder = AssetFolder::find($request->get('folder_id'));

        if (! is_null($folder)) {
            $this->authorize('view', $folder);
        }

        return $folder;
    }
}
