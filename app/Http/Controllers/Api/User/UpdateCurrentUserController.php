<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateCurrentUserRequest;

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
     * @param  \App\Http\Requests\UpdateCurrentUserRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function __invoke(UpdateCurrentUserRequest $request): UserResource
    {
        $user = $request->user();

        $user->update($request->all());

        return new UserResource($user);
    }
}
