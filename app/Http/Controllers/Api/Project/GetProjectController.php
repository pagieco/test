<?php

namespace App\Http\Controllers\Api\Project;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;

class GetProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Project $project): ProjectResource
    {
        $this->authorize('view', $project);

        return new ProjectResource($project);
    }
}
