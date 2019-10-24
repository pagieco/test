<?php

namespace App\Domains\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\User\Http\Resources\UserResource;
use App\Domains\User\Http\Requests\UpdateCurrentUserRequest;

class UpdateCurrentUserController extends Controller
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
     * Update the currently logged in user.
     *
     * @param  \App\Domains\User\Http\Requests\UpdateCurrentUserRequest $request
     * @return \App\Domains\User\Http\Resources\UserResource
     */
    public function __invoke(UpdateCurrentUserRequest $request): UserResource
    {
        $user = $request->user();

        $user->update($request->all());

        return new UserResource($user);
    }
}
