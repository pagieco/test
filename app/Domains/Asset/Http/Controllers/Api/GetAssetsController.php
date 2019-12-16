<?php

namespace App\Domains\Asset\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Domains\Asset\Models\Asset;
use App\Http\Controllers\Controller;
use App\Domains\Asset\Http\Resources\AssetsResource;

class GetAssetsController extends Controller
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
     * Return a list of assets from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\Asset\Http\Resources\AssetsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): AssetsResource
    {
        $this->authorize('list', Asset::class);

        /** @var \Illuminate\Database\Eloquent\Collection $assets */
        $assets = $request->user()->currentProject()->assets;

        abort_if($assets->isEmpty(), Response::HTTP_NO_CONTENT);

        return new AssetsResource($assets);
    }
}
