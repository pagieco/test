<?php

namespace App\Domains\Profile\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Profile\Models\ProfileEvent;
use App\Domains\Profile\Http\Resources\ProfileEventResource;

class GetProfileEventController extends Controller
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
     * @param  \App\Domains\Profile\Models\ProfileEvent $event
     * @return \App\Domains\Profile\Http\Resources\ProfileEventResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(ProfileEvent $event): ProfileEventResource
    {
        abort_if(is_null($event->profile), Response::HTTP_NOT_FOUND);

        $this->authorize('view-event', $event->profile);

        return new ProfileEventResource($event);
    }
}
