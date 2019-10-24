<?php

namespace App\Domains\Project\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Project\Models\Project;
use App\Domains\Project\Http\Resources\ProjectResource;

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
