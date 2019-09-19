<?php

namespace App\Http\Controllers\Api\Workflow;

use App\Models\Workflow;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkflowResource;

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
     * @param  \App\Models\Workflow $workflow
     * @return \App\Http\Resources\WorkflowResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Workflow $workflow): WorkflowResource
    {
        $this->authorize('view', $workflow);

        return new WorkflowResource($workflow);
    }
}
