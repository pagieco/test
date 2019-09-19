<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;

class GetProfileController extends Controller
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
     * Show the given profile.
     *
     * @param  \App\Models\Profile $profile
     * @return \App\Http\Resources\ProfileResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Profile $profile): ProfileResource
    {
        $this->authorize('view', $profile);

        return new ProfileResource($profile);
    }
}
