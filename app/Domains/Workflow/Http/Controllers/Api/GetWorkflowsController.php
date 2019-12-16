<?php

namespace App\Domains\Workflow\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Workflow\Models\Workflow;
use App\Domains\Workflow\Http\Resources\WorkflowsResource;

class GetWorkflowsController extends Controller
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
     * Return a list of workflows from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\Workflow\Http\Resources\WorkflowsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): WorkflowsResource
    {
        $this->authorize('list', Workflow::class);

        /** @var \Illuminate\Database\Eloquent\Collection $workflows */
        $workflows = $request->user()->currentProject()->workflows;

        abort_if($workflows->isEmpty(), Response::HTTP_NO_CONTENT);

        return new WorkflowsResource($workflows);
    }
}
