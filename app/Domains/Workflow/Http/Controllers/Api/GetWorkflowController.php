<?php

namespace App\Domains\Workflow\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Workflow\Models\Workflow;
use App\Domains\Workflow\Http\Resources\WorkflowResource;

class GetWorkflowController extends Controller
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
     * Show the given workflow.
     *
     * @param  \App\Domains\Workflow\Models\Workflow $workflow
     * @return \App\Domains\Workflow\Http\Resources\WorkflowResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Workflow $workflow): WorkflowResource
    {
        $this->authorize('view', $workflow);

        return new WorkflowResource($workflow);
    }
}
