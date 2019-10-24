<?php

namespace App\Domains\Workflow\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Workflow\Models\Workflow;

class DeleteWorkflowController extends Controller
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
     * Delete the given workflow.
     *
     * @param  \App\Domains\Workflow\Models\Workflow $workflow
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Workflow $workflow): void
    {
        $this->authorize('delete', $workflow);

        $workflow->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
