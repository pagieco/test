<?php

namespace App\Http\Controllers\Api\Automation;

use App\Models\Automation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AutomationsResource;

class GetAutomationsController extends Controller
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
     * Return a list of automations from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AutomationsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): AutomationsResource
    {
        $this->authorize('list', Automation::class);

        $automations = $request->user()->currentProject()->automations;

        abort_if($automations->isEmpty(), Response::HTTP_NO_CONTENT);

        return new AutomationsResource($automations);
    }
}
