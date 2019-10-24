<?php

namespace App\Domains\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\User\Http\Resources\UserResource;

class GetCurrentUserController extends Controller
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
     * Show the currently logged in user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\User\Http\Resources\UserResource
     */
    public function __invoke(Request $request): UserResource
    {
        $user = $request->user();

        return new UserResource($user);
    }
}
