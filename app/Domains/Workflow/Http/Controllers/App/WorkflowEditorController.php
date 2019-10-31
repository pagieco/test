<?php

namespace App\Domains\Workflow\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Domains\Workflow\Models\Workflow;

class WorkflowEditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Workflow $workflow)
    {
        return view('app.workflow-editor')->with([
            'project' => $workflow->project,
            'workflow' => $workflow,
        ]);
    }
}
