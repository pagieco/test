<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Response;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileEventsResource;

class GetProfileEventsController extends Controller
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
     * Return a list of profile events for the given profile.
     *
     * @param  \App\Models\Profile $profile
     * @return \App\Http\Resources\ProfileEventsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Profile $profile): ProfileEventsResource
    {
        $this->authorize('list-events', $profile);

        $events = $profile->events;

        abort_if($events->isEmpty(), Response::HTTP_NO_CONTENT);

        return new ProfileEventsResource($events);
    }
}
