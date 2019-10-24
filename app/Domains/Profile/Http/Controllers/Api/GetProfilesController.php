<?php

namespace App\Domains\Profile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Profile\Models\Profile;
use App\Domains\Profile\Models\ProfileRepository;
use App\Domains\Profile\Http\Resources\ProfilesResource;

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
     * @return \App\Domains\Profile\Http\Resources\ProfilesResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): ProfilesResource
    {
        $this->authorize('list', Profile::class);

        $profiles = app(ProfileRepository::class)->all();

        abort_if($profiles->isEmpty(), Response::HTTP_NO_CONTENT);

        return new ProfilesResource($profiles);
    }
}
