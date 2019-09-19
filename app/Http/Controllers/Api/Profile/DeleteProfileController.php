<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Response;
use App\Models\Profile;
use App\Http\Controllers\Controller;

class DeleteProfileController extends Controller
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
     * Delete the given profile.
     *
     * @param  \App\Models\Profile $profile
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Profile $profile)
    {
        $this->authorize('delete', $profile);

        $profile->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
