<?php

namespace App\Domains\Profile\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Profile\Models\Profile;

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
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Profile $profile)
    {
        $this->authorize('delete', $profile);

        $profile->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
