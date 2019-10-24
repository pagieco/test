<?php

namespace App\Domains\Automation\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Automation\Models\Automation;
use App\Domains\Automation\Http\Resources\AutomationResource;

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
     * @param  \App\Domains\Automation\Models\Automation $automation
     * @return \App\Domains\Automation\Http\Resources\AutomationResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Automation $automation): AutomationResource
    {
        $this->authorize('view', $automation);

        return new AutomationResource($automation);
    }
}
