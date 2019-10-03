<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfilesResource;

class GetProfilesController extends Controller
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
     * Return a list of profiles from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ProfilesResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): ProfilesResource
    {
        $this->authorize('list', Profile::class);

        $profiles = $request->user()->currentProject()
            ->profiles()
            ->orderByDesc('local_id')
            ->paginate(50);

        abort_if($profiles->isEmpty(), Response::HTTP_NO_CONTENT);

        return new ProfilesResource($profiles);
    }
}
