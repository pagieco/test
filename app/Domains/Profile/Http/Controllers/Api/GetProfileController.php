<?php

namespace App\Domains\Profile\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Profile\Models\Profile;
use App\Domains\Profile\Http\Resources\ProfileResource;

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
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @return \App\Domains\Profile\Http\Resources\ProfileResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Profile $profile): ProfileResource
    {
        $this->authorize('view', $profile);

        return new ProfileResource($profile);
    }
}
