<?php

namespace App\Domains\Profile\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Profile\Models\Profile;
use App\Domains\Profile\Http\Resources\ProfileResource;
use App\Domains\Profile\Http\Requests\UpdateProfileRequest;

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
     * @param  \App\Domains\Profile\Http\Requests\UpdateProfileRequest $request
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @return \App\Domains\Profile\Http\Resources\ProfileResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateProfileRequest $request, Profile $profile): ProfileResource
    {
        $this->authorize('update', $profile);

        $profile->update($request->all());

        return new ProfileResource($profile);
    }
}
