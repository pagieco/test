<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\UpdateProfileRequest;

class UpdateProfileController extends Controller
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
     * Update the given profile.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest $request
     * @param  \App\Models\Profile $profile
     * @return \App\Http\Resources\ProfileResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateProfileRequest $request, Profile $profile): ProfileResource
    {
        $this->authorize('update', $profile);

        $profile->update($request->all());

        return new ProfileResource($profile);
    }
}
