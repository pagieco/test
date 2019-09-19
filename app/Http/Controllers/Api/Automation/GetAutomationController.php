<?php

namespace App\Http\Controllers\Api\Automation;

use App\Models\Automation;
use App\Http\Controllers\Controller;
use App\Http\Resources\AutomationResource;

class GetAutomationController extends Controller
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
     * Show the given automation.
     *
     * @param  \App\Models\Automation $automation
     * @return \App\Http\Resources\AutomationResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Automation $automation): AutomationResource
    {
        $this->authorize('view', $automation);

        return new AutomationResource($automation);
    }
}
