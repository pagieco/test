<?php

namespace App\Domains\Workflow\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Workflow\Models\Workflow;
use App\Domains\Workflow\Http\Resources\WorkflowResource;
use App\Domains\Workflow\Http\Requests\CreateWorkflowRequest;

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
     * @param  \App\Domains\Workflow\Http\Requests\CreateWorkflowRequest $request
     * @return \App\Domains\Workflow\Http\Resources\WorkflowResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreateWorkflowRequest $request): WorkflowResource
    {
        $this->authorize('create', Workflow::class);
    }
}
