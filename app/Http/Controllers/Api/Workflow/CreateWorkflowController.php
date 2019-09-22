<?php

namespace App\Http\Controllers\Api\Workflow;

use App\Models\Workflow;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkflowResource;
use App\Http\Requests\CreateWorkflowRequest;

class CreateWorkflowController extends Controller
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
     * Create a new workflow.
     *
     * @param  \App\Http\Requests\CreateWorkflowRequest $request
     * @return \App\Http\Resources\WorkflowResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreateWorkflowRequest $request): WorkflowResource
    {
        $this->authorize('create', Workflow::class);
    }
}
